<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('hhhh',function(){
    return view('restaurant.upload');
});
Route::get('aaa', function () {
    dd(bcrypt('user123456'));
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/facebook', 'Auth\FacebookLoginController@redirectToProvider');
Route::post('/auth/facebook/getEmial', 'Auth\FacebookLoginController@getEmail');
Route::get('auth/facebook/callback', 'Auth\FacebookLoginController@handleProviderCallback');

Route::get('auth/google', 'Auth\GoogleLoginController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\GoogleLoginController@handleProviderCallback');

Route::get('admin/login', 'Auth\LoginController@showAdminLoginForm' );
Route::get('admin/register', 'Admin\RegisterController@showRegistrationForm' );
Route::post('admin/register', 'Admin\RegisterController@register' );

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('user/contact-details','UserController@getContactDetalis');
Route::post('user/contact-details','UserController@postContactDetalis');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function(){

    Route::get('/home', 'AdminController@index');
    Route::get('/', 'AdminController@index');

    Route::get('/users/blocked','UsersController@blockedUsers');
    Route::get('/users/block/{id}','UsersController@block');
    Route::get('/users/activate/{id}','UsersController@activate');
    Route::resource('users', 'UsersController');

    Route::get('/restaurants/blocked','RestaurantsController@blockedRestaurants');
    Route::get('/restaurants/block/{id}','RestaurantsController@block');
    Route::get('/restaurants/activate/{id}','RestaurantsController@activate');
    Route::resource('restaurants', 'RestaurantsController');

    Route::get('/cinemas/blocked','CinemasController@blockedCinemas');
    Route::get('/cinemas/block/{id}','CinemasController@block');
    Route::get('/cinemas/activate/{id}','CinemasController@activate');
    Route::resource('cinemas', 'CinemasController');

    Route::get('/admins/blocked','AdminsController@blockedAdmins');
    Route::get('/admins/block/{id}','AdminsController@block');
    Route::get('/admins/activate/{id}','AdminsController@activate');
    Route::resource('admins', 'AdminsController');

});

Route::group(['prefix' => 'admin/restaurant', 'namespace' => 'Admin\Restaurant'], function(){

    Route::get('contact-details', 'RestaurantController@getContactDetails');
    Route::post('contact-details', 'RestaurantController@postContactDetails');

    Route::get('location', 'RestaurantController@getLocation');
    Route::post('location/getCity', 'RestaurantController@getCity' );
    Route::post('location', 'RestaurantController@postLocation' );
    
    Route::get('images','RestaurantController@getImages');
    Route::post('avatar','RestaurantController@changeAvatar');
    Route::post('images/add','RestaurantController@addImage');
    Route::get('image/remove/{id}','RestaurantController@removeImage');
});



