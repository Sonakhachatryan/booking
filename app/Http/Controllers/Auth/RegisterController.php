<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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
        $this->middleware('login');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users,email,NULL,id,provider,NULL',
            'password' => 'required|min:6',
            'avatar' => 'required|image',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $destinationPath = 'images/users'; // upload path
        $extension = $data['avatar']->getClientOriginalExtension(); // getting image extension
        $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
        $data['avatar']->move($destinationPath, $fileName); // uploading file to given path
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => $fileName,
        ]);
        
        if (!$user) {
            if (file_exists($destinationPath . "/" . $fileName)) {
                unlink($destinationPath . "/" . $fileName);
            }
            return false;
        }
        
        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user =  $this->create($request->all());
        auth('user')->login($user);
        return redirect($this->redirectPath());
    }
}
