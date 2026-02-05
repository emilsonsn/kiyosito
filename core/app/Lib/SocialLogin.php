<?php

namespace App\Lib;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserLogin;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Socialite;

class SocialLogin
{
    private $provider;
    private $fromApi;
    private $originalProvider;

    public function __construct($provider,$fromApi = false)
    {
        $this->provider = $provider;
	$this->fromApi = $fromApi;
	$this->originalProvider = $provider;
        \Log::info('__construct (before):', ['provider' => $this->originalProvider]);

	$this->configuration();
        \Log::info('__construct (after):', ['provider' => $this->originalProvider]);
    }
    
    /*
    public function redirectDriver()
    {   
	 // Log request data
        \Log::info('redirectDriver (before):', ['provider' => $this->provider]);
        $provider      = $this->provider;
        $provider    = $this->fromApi && $provider == 'linkedin' ? 'linkedin-openid' : $provider;

        \Log::info('redirectDriver (after):', ['provider' => $provider]);

        return Socialite::driver($provider)->redirect();
    }
    */

    public function redirectDriver()
    {
        \Log::info('redirectDriver (before):', ['provider' => $this->provider]);
        $provider = in_array($this->provider, ['linkedin', 'linkedin-openid'])
            ? 'linkedin-openid'
            : $this->provider;
        \Log::info('redirectDriver (after):', ['provider' => $provider]);
        return Socialite::driver($provider)->redirect();
    }

    
    /*

    private function configuration()
    {
        // Log initial provider and fromApi flag
        \Log::info('SocialLogin configuration started', [
            'provider' => $this->provider,
            'fromApi' => $this->fromApi,
        ]);
    
        // Use 'linkedin' for retrieving credentials if the provider is 'linkedin-openid'
        $originalProvider = ($this->provider === 'linkedin-openid') ? 'linkedin' : $this->provider;
        \Log::info('Original provider used for config lookup', ['originalProvider' => $originalProvider]);
    
        $configuration = gs('socialite_credentials')->{$originalProvider};
        \Log::info('Configuration retrieved', ['configuration' => $configuration]);
    
        $providerForSocialite = ($this->fromApi && $originalProvider === 'linkedin')
            ? 'linkedin-openid'
            : $originalProvider;
    
        \Log::info('Provider for Socialite set as', ['providerForSocialite' => $providerForSocialite]);
    
        $callbackUrl = route('user.social.login.callback', $providerForSocialite);
        \Log::info('Generated callback URL', ['callbackUrl' => $callbackUrl]);
    
        Config::set('services.' . $providerForSocialite, [
            'client_id'     => $configuration->client_id,
            'client_secret' => $configuration->client_secret,
            'redirect'      => $callbackUrl,
        ]);
    }
    */

    private function configuration()
    {
        \Log::info('SocialLogin configuration started', [
            'provider' => $this->provider,
            'fromApi'  => $this->fromApi,
        ]);
    
        // For LinkedIn, regardless of whether you pass "linkedin" or "linkedin-openid",
        // use the key "linkedin" for retrieving credentials.
        $originalProvider = (in_array($this->provider, ['linkedin', 'linkedin-openid']))
            ? 'linkedin'
            : $this->provider;
        \Log::info('Original provider used for config lookup', ['originalProvider' => $originalProvider]);
    
        $configuration = gs('socialite_credentials')->{$originalProvider};
        \Log::info('Configuration retrieved', ['configuration' => $configuration]);
    
        // For Socialite, always use "linkedin-openid" if the original provider is LinkedIn.
        $providerForSocialite = in_array($this->provider, ['linkedin', 'linkedin-openid'])
            ? 'linkedin-openid'
            : $originalProvider;
        \Log::info('Provider for Socialite set as', ['providerForSocialite' => $providerForSocialite]);
    
        $callbackUrl = route('user.social.login.callback', $providerForSocialite);
        \Log::info('Generated callback URL', ['callbackUrl' => $callbackUrl]);
    
        Config::set('services.' . $providerForSocialite, [
            'client_id'     => $configuration->client_id,
            'client_secret' => $configuration->client_secret,
            'redirect'      => $callbackUrl,
        ]);
    }

    public function login()
    {
        // $provider      = $this->provider;
        // $provider    = $this->fromApi && $provider == 'linkedin' ? 'linkedin-openid' : $provider;
        
        // If provider is LinkedIn (or linkedin-openid), force using "linkedin-openid"
        $provider = (in_array($this->provider, ['linkedin', 'linkedin-openid']))
        ? 'linkedin-openid'
        : $this->provider;

        $driver     = Socialite::driver($provider);
        if ($this->fromApi) {
            try {
                $user = (object)$driver->userFromToken(request()->token)->user;
            } catch (\Throwable $th) {
                throw new Exception('Something went wrong');
            }
        }else{
            $user = $driver->user();
        }

        if($provider == 'linkedin-openid') {
            $user->id = $user->sub;
        }

        $userData = User::where('provider_id', $user->id)->first();

        if (!$userData) {
            if (!gs('registration')) {
                throw new Exception('New account registration is currently disabled');
            }
            $emailExists = User::where('email', @$user->email)->exists();
            if ($emailExists) {
                throw new Exception('Email already exists');
            }

            $userData = $this->createUser($user, $this->provider);
        }
        if ($this->fromApi) {
            $tokenResult = $userData->createToken('auth_token')->plainTextToken;
            $this->loginLog($userData);
            return [
                'user'         => $userData,
                'access_token' => $tokenResult,
                'token_type'   => 'Bearer',
            ];
        }
        Auth::login($userData);
        $this->loginLog($userData);
        $redirection = Intended::getRedirection();
        return $redirection ? $redirection : to_route('user.home');
    }

    private function createUser($user, $provider)
    {
        $general  = gs();
        $password = getTrx(8);

        $firstName = null;
        $lastName = null;

        if (@$user->first_name) {
            $firstName = $user->first_name;
        }
        if (@$user->last_name) {
            $lastName = $user->last_name;
        }

        if ((!$firstName || !$lastName) && @$user->name) {
            $firstName = preg_replace('/\W\w+\s*(\W*)$/', '$1', $user->name);
            $pieces    = explode(' ', $user->name);
            $lastName  = array_pop($pieces);
        }

        $referBy = session()->get('reference');
        if ($referBy) {
            $referUser = User::where('username', $referBy)->first();
        } else {
            $referUser = null;
        }

        $newUser = new User();
        $newUser->provider_id = $user->id;

        $newUser->email = $user->email;

        $newUser->password = Hash::make($password);
        $newUser->firstname = $firstName;
        $newUser->lastname = $lastName;
        $user->ref_by    = $referUser ? $referUser->id : 0;

        $newUser->status = Status::VERIFIED;
        $newUser->kv = $general->kv ? Status::NO : Status::YES;
        $newUser->ev = Status::VERIFIED;
        $newUser->sv = gs('sv') ? Status::UNVERIFIED : Status::VERIFIED;
        $newUser->ts = Status::DISABLE;
        $newUser->tv = Status::VERIFIED;
        $newUser->provider = $provider;
        $newUser->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $newUser->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $newUser->id);
        $adminNotification->save();

        $user = User::find($newUser->id);

        return $user;
    }

    private function loginLog($user)
    {
        //Login Log Create
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',', $info['long']);
            $userLogin->latitude =  @implode(',', $info['lat']);
            $userLogin->city =  @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();
    }
}
