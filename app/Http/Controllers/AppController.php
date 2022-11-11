<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zilab\Referral\Entities\ReferralTraffic;
use Stevebauman\Location\Facades\Location;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $response = redirect()->to('/login');

        if ($ref = $request->get('ref')) {

            $ip = $request->ip();
            $country = Location::get($ip);

            ReferralTraffic::create([
                'referral_hash' => $ref,
                'ip' => $ip,
                'country' => $country ? $country->countryCode : null,
            ]);

            $response->withCookie(cookie('ref', $ref, 60 * 24 * 30));
        }

        return $response;
    }
}
