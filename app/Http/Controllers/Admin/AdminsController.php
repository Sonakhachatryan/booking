<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;

use App\Models\Admin;
use Illuminate\Http\Request;
use Session;

class AdminsController extends AdminBaseController
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
        $admins = Admin::where('role','!=',$this->admin->user()->role)->paginate(25);
        $blocked = false;
        return view('admin.admins.index', compact('admins','blocked'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->getAdmin();

        return view('admin.admins.create');
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
        
        $requestData = $request->all();
        
        Admin::create($requestData);

        Session::flash('flash_message', 'Admin added!');

        return redirect('admin/admins');
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
        
        $editing_admin = Admin::withTrashed()->findOrFail($id);

        return view('admin.admins.show', compact('editing_admin'));
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
        
        $editing_admin = Admin::withTrashed()->findOrFail($id);

        return view('admin.admins.edit', compact('editing_admin'));
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
        
        $requestData = $request->all();
        
        $admin = Admin::findOrFail($id);
        $admin->update($requestData);

        Session::flash('flash_message', 'Admin updated!');

        return redirect('admin/admins');
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
        Admin::destroy($id);

        Session::flash('flash_message', 'Admin deleted!');

        return redirect('admin/admins');
    }

    public function block($id)
    {
        $this->getAdmin();
        
        Admin::destroy($id);

        return redirect()->back()->with('success', 'Admin successfully blocked.');
    }

    public function blockedAdmins()
    {
        $this->getAdmin();
        $admins = Admin::onlyTrashed()->paginate(25);
        $blocked = true;
        return view('admin.admins.index', compact('admins','blocked'));
    }

    public function activate($id)
    {
        $this->getAdmin();
        
        Admin::onlyTrashed()->where('id', $id)->restore();

        return back()->with('success', 'Admin successfully activated.');
    }
}
