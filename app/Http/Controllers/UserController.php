<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{

    public $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getContactDetalis()
    {
        return view('user.contactDetalis');
    }


    public function postContactDetalis(Request $request)
    {

        $this->validate($request,[
            'email' => 'required|email|max:255|unique:users,email,' . $request->email .',id,provider,' . auth()->user()->provider,
        ]);

        $requestData = $request->all();

        auth('user')->user()->update($requestData);

        Session::flash('success', 'Contact detalis updated!');

        return back();
    }
}
