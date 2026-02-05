<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Lib\SocialLogin;

class SocialiteController extends Controller
{

    public function socialLogin($provider)
    {	
	\Log::info('socialLogin:', ['provider' => $provider]);
        $socialLogin = new SocialLogin($provider);
        return $socialLogin->redirectDriver();
    }


    public function callback($provider)
    {	    
	\Log::info('Callback received', ['provider' => $provider, 'query' => request()->all()]);

        $socialLogin = new SocialLogin($provider);
        try {
            return $socialLogin->login();
        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return to_route('home')->withNotify($notify);
        }
    }
}
