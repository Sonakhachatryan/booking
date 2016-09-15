<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use Session;

class UsersController extends AdminBaseController
{
    public function __construct()
    {
        $this->middleware('admin:superadmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->getAdmin();

        $users = User::paginate(25);
        $blocked = false;
        return view('admin.users.index', compact('users','blocked'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->getAdmin();

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $this->getAdmin();

        $requestData = $request->all();

        User::create($requestData);

        Session::flash('flash_message', 'User added!');

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this->getAdmin();

        $user = User::withTrashed()->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->getAdmin();

        $user = User::withTrashed()->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required',
        ]);

        $users = User::where(['email' => $request->email,'provider' => $request->provider == "" ? NULL : $request->provider])->get();

        if(count($users)>1) {
            return back()->withErrors(['email' => 'Email has already beeen taken.']);
        }
        if(count($users)==1 && $users[0]['id'] != $id) {
            return back()->withErrors(['email' => 'Email has already beeen taken.','old_email'=> $request->all()]);
//            session('old',['email'=>$request->email]);
            return back()->withErrors(['email' => 'Email has already beeen taken.']);
        }

        $user = User::withTrashed()->findOrFail($id);
        $requestData = $request->except('avatar');

        if(isset($request->avatar))
        {
            $destinationPath = 'images/users'; // upload path
            $extension = $request->avatar->getClientOriginalExtension(); // getting image extension
            $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
            $request->avatar->move($destinationPath, $fileName); // uploading file to given path
            $requestData['avatar'] = $fileName;
            if (file_exists($destinationPath . "/" . $user->avatar)) {
                unlink($destinationPath . "/" . $user->avatar);
            }
        }


        $user->update($requestData);

        return back()->with('success', 'User updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->getAdmin();

        User::withTrashed()->where('id', $id)->forceDelete();

        return redirect('admin/users')->with('success', 'User successfully deleted.');
    }

    public function block($id)
    {
        $this->getAdmin();

        User::destroy($id);

        return redirect()->back()->with('success', 'User successfully blocked.');
    }

    public function blockedUsers()
    {
        $this->getAdmin();

        $users = User::onlyTrashed()->paginate(25);
        $blocked = true;
        return view('admin.users.index', compact('users','blocked'));
    }

    public function activate($id)
    {   $this->getAdmin();
        
        User::onlyTrashed()->where('id', $id)->restore();

        return back()->with('success', 'User successfully activated.');
    }

}
