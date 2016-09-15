<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use Carbon\Carbon;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Session;

class RestaurantsController extends AdminBaseController
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
        $restaurants = Restaurant::paginate(25);
        $blocked = false;
        return view('admin.restaurants.index', compact('restaurants','blocked'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->getAdmin();
        return view('admin.restaurants.create');
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

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:restaurants',
            'avatar' => 'required|image',
        ]);

        $destinationPath = 'images/restaurants'; // upload path
        $extension = $request->avatar->getClientOriginalExtension(); // getting image extension
        $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
        $request->avatar->move($destinationPath, $fileName); // uploading file to gi

        $requestData = $request->except('avatar');
        $requestData['avatar'] = $fileName;

        $restaurant = Restaurant::create($requestData);
        if (!$restaurant) {
            if (file_exists($destinationPath . "/" . $fileName)) {
                unlink($destinationPath . "/" . $fileName);
            }
            return back()->withErrors('Something went wrong.');
        }

        return redirect('admin/restaurants')->with('success','Cinema added!');

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
        $restaurant = Restaurant::withTrashed()->findOrFail($id);

        return view('admin.restaurants.show', compact('restaurant'));
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
        $restaurant = Restaurant::withTrashed()->findOrFail($id);

        return view('admin.restaurants.edit', compact('restaurant'));
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
        $this->getAdmin();
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:restaurants,email,' . $id,
            'avatar' => 'image',
        ]);

        $requestData = $request->all();
        
        $restaurant = Restaurant::findOrFail($id);
        if(isset($request->avatar))
        {
            $destinationPath = 'images/restaurants'; // upload path
            $extension = $request->avatar->getClientOriginalExtension(); // getting image extension
            $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
            $request->avatar->move($destinationPath, $fileName);

            if (file_exists($destinationPath . "/" . $restaurant->avatar)) {
                unlink($destinationPath . "/" . $restaurant->avatar);
            }

            $requestData['avatar'] = $fileName;
        }

        $restaurant->update($requestData);

        Session::flash('success', 'Restaurant updated!');

        return back();
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

        restaurant::withTrashed()->where('id', $id)->forceDelete();

        return redirect('admin/restaurants')->with('success', 'Restaurant successfully deleted.');
    }

    public function block($id)
    {
        $this->getAdmin();
        Restaurant::destroy($id);

        return redirect()->back()->with('success', 'Restaurant successfully blocked.');
    }

    public function blockedRestaurants()
    {
        $this->getAdmin();
        $restaurants = Restaurant::onlyTrashed()->paginate(25);
        $blocked = true;
        return view('admin.restaurants.index', compact('restaurants','blocked'));
    }

    public function activate($id)
    {
        $this->getAdmin();
        
        Restaurant::onlyTrashed()->where('id', $id)->restore();

        return back()->with('success', 'Restaurant successfully activated.');
    }
}
