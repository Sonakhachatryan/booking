<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class CinemasController extends AdminBaseController
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
        $cinemas = Cinema::paginate(25);
        $blocked = false;
        return view('admin.cinemas.index', compact('cinemas','blocked'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cinemas.create');
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
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:restaurants',
            'avatar' => 'required|image',
        ]);

        $destinationPath = 'images/cinemas'; // upload path
        $extension = $request->avatar->getClientOriginalExtension(); // getting image extension
        $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
        $request->avatar->move($destinationPath, $fileName); // uploading file to gi
        
        $requestData = $request->except('avatar');
        $requestData['avatar'] = $fileName;

        $cinema = Cinema::create($requestData);
        if (!$cinema) {
            if (file_exists($destinationPath . "/" . $fileName)) {
                unlink($destinationPath . "/" . $fileName);
            }
            return back()->withErrors('Something went wrong.');
        }

        return redirect('admin/cinemas')->with('success','Cinema added!');
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
        $cinema = Cinema::withTrashed()->findOrFail($id);

        return view('admin.cinemas.show', compact('cinema'));
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
        $cinema = Cinema::withTrashed()->findOrFail($id);

        return view('admin.cinemas.edit', compact('cinema'));
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
            'name' => 'required',
            'email' => 'required|email|unique:cinemas,email,' . $id,
            'avatar' => 'image',
        ]);
        
        $requestData = $request->except('avatar');
        $cinema = Cinema::findOrFail($id);

        if(isset($request->avatar))
        {
            $destinationPath = 'images/cinemas'; // upload path
            $extension = $request->avatar->getClientOriginalExtension(); // getting image extension
            $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
            $request->avatar->move($destinationPath, $fileName);

            if (file_exists($destinationPath . "/" . $cinema->avatar)) {
                unlink($destinationPath . "/" . $cinema->avatar);
            }

            $requestData['avatar'] = $fileName;
        }
        $cinema->update($requestData);

        Session::flash('success', 'Cinema updated!');

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
        Cinema::withTrashed()->where('id', $id)->forceDelete();

        return redirect('admin/cinemas')->with('success', 'Cinema successfully deleted.');
    }

    public function block($id)
    {
        Cinema::destroy($id);

        return redirect()->back()->with('success', 'Cinema successfully blocked.');
    }

    public function blockedCinemas()
    {
        $cinemas = Cinema::onlyTrashed()->paginate(25);
        $blocked = true;
        return view('admin.cinemas.index', compact('cinemas','blocked'));
    }

    public function activate($id)
    {
        Cinema::onlyTrashed()->where('id', $id)->restore();

        return back()->with('success', 'Cinema successfully activated.');
    }

}
