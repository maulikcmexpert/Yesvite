<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use libphonenumber\PhoneNumberUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as Exception;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function index()
    {

        $id = decrypt(session()->get('user')['id']);
        $title = 'Profile';
        $page = 'front.profile';
        $js = ['profile'];
        $user = User::findOrFail($id);
        $user['profile'] = ($user->profile != null) ? asset('public/storage/profile/' . $user->profile) : asset('public/storage/profile/no_profile.png');
        $user['bg_profile'] = ($user->bg_profile != null) ? asset('public/storage/bg_profile/' . $user->bg_profileprofile) : asset('public/assets/front/image/Frame 1000005835.png');
        $date = Carbon::parse($user->created_at);
        $formatted_date = $date->format('F, Y');
        $formattedNumber = phone($user->phone_number, 'US');
        $user['phone_number'] = $formattedNumber;

        $user['join_date'] = $formatted_date;

        return view('layout', compact(
            'title',
            'page',
            'user',
            'js'
        ));
    }

    public function update(Request $request, string $id)
    {
        $id = decrypt($id);

        try {
            dd($request);
            DB::beginTransaction();
            $userUpdate = User::where('id', $id)->first();

            $userUpdate->firstname = $request->firstname;

            $userUpdate->lastname = $request->lastname;
            $userUpdate->gender = ($request->gender != "") ? $request->gender : $userUpdate->gender;
            $userUpdate->birth_date = ($request->birth_date != "") ? $request->birth_date : $userUpdate->birth_date;
            $userUpdate->country_code = ($request->country_code != "") ? $request->country_code : $userUpdate->country_code;
            $userUpdate->phone_number = ($request->phone_number != "") ? $request->phone_number : $userUpdate->phone_number;
            $userUpdate->about_me = ($request->about_me != "") ? $request->about_me : $userUpdate->about_me;
            $userUpdate->zip_code = ($request->zip_code != "") ? $request->zip_code : $userUpdate->zip_code;
            // if ($userUpdate->account_type == '1') {
            //     $validator = Validator::make($request, [
            //         'company_name' => 'required',
            //     ]);
            //     $userUpdate->company_name = $request->company_name;
            // }
            $userUpdate->address = ($request->address != "") ? $request->address : $userUpdate->address;
            $userUpdate->address_2 = (isset($request->address_2)  && $request->address_2 != "") ? $request->address_2 : $userUpdate->address_2;
            $userUpdate->city = ($request->city != "") ? $request->city : $userUpdate->city;
            $userUpdate->state = ($request->state != "") ? $request->state : $userUpdate->state;
            $userUpdate->save();
            DB::commit();

            return response()->json(['status' => 1, 'message' => "Changes Saved!"]);
            return  redirect()->route('profile')->with('success', 'Changes Saved!');
        } catch (QueryException $e) {
            DB::Rollback();
            return response()->json(['status' => 0, 'message' => "db error"]);
        } catch (Exception  $e) {
            return response()->json(['status' => 0, 'message' => 'something went wrong']);
        }
    }
}
