<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Requests;
use App\Models\Admin;
use App\Models\Country;
use App\Models\City;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class RestaurantController extends AdminBaseController
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('admin:restaurant');
    }

    public function getContactDetails()
    {
        $restaurant = getRestaurant();

        return view('restaurant.contactDetails',compact('restaurant'));
    }

    public function postContactDetails(Request $request)
    {
        $restaurant = getRestaurant();
        
        $this->validate($request,[
            'address' => 'required',
            'email' => 'required|email|unique:restaurants,email,' . $restaurant->id,
            'phone' => 'required'
        ]);
        
        $restaurant->update($request->except('_token'));

        return back()->with('success', 'Contact details updated successfully.');

    }
    
    public function getLocation()
    {
        $restaurant = getRestaurant();

        $countries = Country::all();

        $cities = City::where('country_id' , $restaurant->country_id)->get();

        
        return view('restaurant.location',compact('restaurant','countries','cities'));
    }

    public function postLocation(Request $request)
    {
        $restaurant = getRestaurant();

        $this->validate($request,[
            'longitude' => 'required',
            'latitude' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        if($restaurant->update($request->except('_token')));
            return back()->with('success', 'Location details updated successfully.');

        return back()->withErrors('Something went wrong.');

    }
    
    public function getCity(Request $request)
    {
        $cities = City::where('country_id' , $request->country_id)->get();

        return response()->json($cities);
    }
    
    public function getImages()
    {
        $admin = $this->getAdmin()->user();

        $restaurant = Restaurant::where('admin_id', $admin->id)->first();

        $restaurant->images = Image::where(['imageable_id' => $restaurant->id,'imageable_type' => 'restaurant' ])
            ->paginate(2);
        

        return view('restaurant.images',compact('restaurant'));
    }

    public function changeAvatar(Request $request)
    {
        if(!isset($request->avatar))
            return back();
        $this->validate($request,[
            'avatar' => 'image',
        ]);
        $restaurant = $this->getRestaurant();

        if(isset($request->avatar))
        {
            $destinationPath = 'images/restaurants'; // upload path
            $extension = $request->avatar->getClientOriginalExtension(); // getting image extension
            $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
            $request->avatar->move($destinationPath, $fileName);


            if ( $restaurant->avatar!=="" && file_exists($destinationPath . "/" . $restaurant->avatar)) {
                unlink($destinationPath . "/" . $restaurant->avatar);
            }

            $requestData['avatar'] = $fileName;
        }

        $restaurant->update($requestData);

        return back()->with('success','Logo updated successfully.');
    }

    public function addImage(Request $request)
    {
        $this->validate($request,[
            'fileselect.*' => 'image'
        ]);

        $restaurant = $this->getRestaurant();

        $destinationPath = 'images/restaurants'; // upload path
        foreach($request->fileselect as $file) {
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = strtotime(Carbon::now()) . '.' . $extension; // renameing image
            $file->move($destinationPath, $fileName);
            Image::create([
                'url' => $fileName,
                'imageable_id' =>  $restaurant->id,
                'imageable_type' =>  'restaurant',
            ]);
        }

        return back()->with('success','Files uploaded successfully.');
    }

    public function removeImage($id, Request $request)
    {
        Image::destroy($id);
        return back()->with('success','Image remove successfully.');
    }

    public function getRestaurant()
    {
        $admin = $this->getAdmin()->user();

        $restaurant = Restaurant::where('admin_id', $admin->id)->first();

        return $restaurant;
    }
}