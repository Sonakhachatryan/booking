<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use View;


class AdminBaseController extends Controller
{
    protected  $admin;

    public function getAdmin()
    {
        $this->admin = Auth::guard('admin');
        
        View::share('admin', $this->admin->user());
        
        return $this->admin;
    }

}