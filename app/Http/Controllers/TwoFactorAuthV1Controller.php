<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorAuthV1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.two-factor-auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric|digits:6',
        ]);

        $google2fa = app('pragmarx.google2fa');

        if($google2fa->verifyGoogle2FA(
            auth()->user()->google2fa_secret,
            $request->get('one_time_password')
        )) {
            $request->session()->put('two_factor_auth', true);
            return redirect()->to(auth()->user()->hasRole('Admin') ? '/admin' : '/user');
        }

        return redirect()->back()->with('error', 'Invalid code');
    }
}
