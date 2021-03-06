<?php

use Illuminate\Http\Request;
use App\Contracts\Services\MediaInterface;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('image/{path}', ['as' => 'image' , function (Request $request, MediaInterface $service, $path) {
    $params = $request->all();

    return $service->getImageResponse($path, $params);
}])->where('path', '(.*?)');

Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', ['as'=>'home.index', 'uses'=>'HomeController@index']);
});

Route::group(['namespace' => 'Backend'], function () {
    Auth::routes();
    Route::group(['prefix' => 'backend', 'as' => 'backend.', 'middleware' => ['auth']], function () {
        Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
        Route::resource('user', 'UserController');
    });
});
