<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class AdminController extends AdminBaseController
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('user:admin');
    }

    public function index()
    {
        $this->getAdmin();
        
        if(auth('admin')->check())
           return view('admin.home');
    }
}