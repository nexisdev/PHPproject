<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileV1Controller extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $user->load(['kyc']);

        return view('profile.index', ['user' => $user]);
    }

    public function update(Request $request) {

        $validateData = $request->validate([
            'wallet_address' => 'sometimes|string|max:255',
        ]);

        $user = auth()->user();
        $user->wallet_address = $validateData['wallet_address'];
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    public function showChangePassword()
    {
        $user = auth()->user();
        $user->load(['kyc']);

        return view('profile.change-password', ['user' => $user]);
    }

    public function updateChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['error' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with(['success' => 'Password changed successfully']);
    }

    public function enable2FA()
    {
        if(auth()->user()->is_two_factor_auth_enabled) {
            return redirect()->route('profile.index')->with(['error' => '2FA is already enabled']);
        }

        $google2fa = app('pragmarx.google2fa');

        $secret = $google2fa->generateSecretKey();

        $qeCodeImage = $google2fa->getQRCodeInline( config('app.name'), auth()->user()->email, $secret );

        return view('profile/enable-2fa', [
            'qr_code_image' => $qeCodeImage,
            'secret' => $secret,
        ]);
    }

    public function confirmEnable2FA(Request $request)
    {
        if(auth()->user()->is_two_factor_auth_enabled) {
            return redirect()->route('profile.index')->with(['error' => '2FA is already enabled']);
        }

        $request->validate([
            'secret' => 'required',
            'one_time_password' => 'required|digits:6',
        ]);

        $google2fa = app('pragmarx.google2fa');
        $user = auth()->user();

        if($google2fa->verifyGoogle2FA(
            $request->get('secret'),
            $request->get('one_time_password')
        )) {
            $user->google2fa_secret = $request->get('secret');
            $user->save();
            $request->session()->put('two_factor_auth', true);
            return redirect()->route('profile.index')->with(['success' => 'You have successfully enabled 2FA']);
        } else {
            return redirect()->back()->with(['error' => 'Invalid verification code']);
        }
    }

    public function disable2FA(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
            'password' => 'required|current_password',
        ]);

        $google2fa = app('pragmarx.google2fa');

        if($google2fa->verifyGoogle2FA(
            auth()->user()->google2fa_secret,
            $request->get('one_time_password')
        )) {
            auth()->user()->google2fa_secret = null;
            auth()->user()->save();
            return redirect()->route('profile.index')->with(['success' => 'You have successfully disabled 2FA']);
        } else {
            return redirect()->back()->with(['error' => 'Invalid verification code']);
        }
    }
}
