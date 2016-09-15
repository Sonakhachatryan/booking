<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
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

    public function login(Request $request)
    {
        $this->validateLoginRequest($request);

        $role = $request->role;

        $remember = $request->remember ? true : false;

        if(!auth($role)->check())
        {
            $role == 'admin' ? $username = 'email' : $username = 'username';
            $attempt = auth($role)->attempt([$username => $request->$username, 'password' => $request->password],$remember);

            if( $attempt )
            {
                session(['role' => $role]);
                $role == 'admin' ? $rdrUrl = 'admin/home' : $rdrUrl ='/home';
                return redirect($rdrUrl);
            }
            else
            {
                return back();
            }
        }
        else
        {
            return back();
        }
    }

    public function showAdminLoginForm()
    {
        if(auth('admin')->check())
            return redirect('admin/home');
        return view('admin.login');
    }

    public function showLoginForm()
    {
        if(auth('user')->check())
            return redirect('/home');
        return view('auth.login');
    }

    public function validateLoginRequest(Request $request)
    {
        $role = $request->role;
        if($role == 'admin')
            return $this->validate($request,[
                'email' =>'required|email',
                'password' => 'required'
            ]);
        else
            return $this->validate($request,[
                'username' =>'required',
                'password' => 'required'
            ]);
    }


    public function logout(Request $request)
    {
        $role = $request->role;
        auth($role)->logout();
        $request->session()->forget($role);
        $rdrUri = $role == 'admin' ? 'admin/login' : '/' ;
        return redirect($rdrUri);
    }


}
