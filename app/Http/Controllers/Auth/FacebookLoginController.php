<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\User;

class FacebookLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('login', ['except' => 'logout']);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/facebook');
        }

        if ($authUser = User::where('username',$user->id)->first())
          return $this->login($authUser);
        
        session(['social_user' => $user]);

        return view('auth.getEmail');
    }

    public function getEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
        ]);


        $user = session('social_user');
        session()->forget('social_user');
        $user->email = $request->email;

        $authUser = User::create([
            'username' => $user->id,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'provider' => 'facebook'
        ]);

       return $this->login($authUser);

    }

    public function login($authUser)
    {
        auth('user')->login($authUser, true);

        return Redirect::to('home');
    }

}
