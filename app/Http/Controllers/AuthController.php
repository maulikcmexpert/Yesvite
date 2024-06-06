<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Cookie;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'auth/login';
        $title = "Login";
        $js = ['login'];

        return view('layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function checkLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ], [
            'email.required' => 'Please enter Email',
            'email.email' => 'Please enter a valid Email',
            'password.required' => 'Please enter a Password',
            'password.min' => 'Password must be at least 8 characters',
        ]);


        $remember = $request->has('remember'); // Check if "Remember Me" checkbox is checked

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::guard('web')->user();

            $sessionArray = [
                'id' => encrypt($user->id),
                'username' => $user->firstname . ' ' . $user->lastname,
                'profile' => ($user->profile != NULL || $user->profile != "") ? asset('public/storage/profile/' . $user->profile) : asset('public/storage/profile/no_profile.png')
            ];
            Session::put(['user' => $sessionArray]);
            if (Session::has('user')) {

                if ($remember) {
                    Cookie::queue('email', $user->email, 120);
                    Cookie::queue('password', $user->password, 120);
                } else {

                    Cookie::forget('email');
                    Cookie::forget('password');
                }
                toastr()->success('Logged in successfully!');
                return redirect()->route('home');
            } else {
                toastr()->error('Invalid credentials!');
                return  Redirect::to('login');
            }
        }
        toastr()->error('Email or Passqword invalid');
        return  Redirect::to('login');
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
