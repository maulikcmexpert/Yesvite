<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\TransactionDataTable;
use Yajra\DataTables\DataTables;
use App\Models\{
    User,
    UserSubscription,
    Coin_transactions
};

use Carbon\Carbon;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,TransactionDataTable $DataTable)
    {

        // dd(decrypt($request['user_id']));
        $userId = $request->user_id; // Decrypt the user ID from the request
        $title = 'Coin Transaction';
        $page = 'admin.transaction.list';
        // $js = 'admin.user.userjs';
        return $DataTable->render('admin.includes.layout', compact('title', 'page','userId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $title = 'Add Coin';
        $userId = decrypt($request->user_id); // Decrypt the user ID from the request

        dd($userId);
        $page = 'admin.transaction.add';
        $js = 'admin.transaction.transactionjs';
                return view('admin.includes.layout', compact(
                    'title',
                    'page',
                    'js','userId'
                ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $coins=$request->input('credit_coin');
        $user_id=$request->input('user_id');

        $user = User::where('id',$user_id)->first();
        if($user){
            $total_coin = $user->coins + $coins;
            User::where('id',$user_id)->update(['coins'=>$total_coin]);
            $subscription=UserSubscription::where('user_id',$user_id);

            $coin_transaction = new Coin_transactions();
            $coin_transaction->user_id = $user_id;
            $coin_transaction->user_subscription_id = $subscription->id;
            $coin_transaction->status = '0';
            $coin_transaction->type = 'credit';
            $coin_transaction->coins = $coins;
            $coin_transaction->current_balance = $total_coin;
            $coin_transaction->description = $coins.' Credits Bulk Credits';
            $coin_transaction->endDate = Carbon::now()->addYears(5)->toDateString();
            $coin_transaction->save();

            $cryptId=encrypt($user->id);
            return redirect()->route('transcation.index',['user_id' => $cryptId])
            ->with('success', 'Coins Credited Successfully');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
