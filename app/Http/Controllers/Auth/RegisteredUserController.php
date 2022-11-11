<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserRegistered;
use App\Helpers\ModuleHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
         $userData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (ModuleHelper::isActive('Referral')) {
            $userData['referral_hash'] = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
        }

        if ($request->cookie('ref')) {
            if ($user = User::where('referral_hash', $request->cookie('ref'))->first()) {
                $userData['referred_by'] = $user?->id;
                Cookie::queue(Cookie::forget('ref'));
            }
        }

        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        $user->assignRole('Unverified');

        event(new Registered($user));
        event(new NewUserRegistered($user)); // Notifications for Admins.

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
