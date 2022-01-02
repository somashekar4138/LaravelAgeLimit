<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;


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


Route::get("/logout",function(){
    if(session()->has('fname')){
        session()->pull('fname');
        session()->pull('lname');
    }
    return redirect('login');
});

Route::group(['middleware'=>['CustomAuth']],function(){
    Route::get("/main",[userController::class,'main']);
    Route::get("/allusers",[userController::class,'allusers']);
    Route::get("/list",[userController::class,'List']);
    Route::get("/editprofile",[userController::class,'editprofile']);
    Route::get("/addpost",function () {
        return view('addpost');
    });
    Route::post("/news",[userController::class,'news']);
    Route::get("/allpost",[userController::class,'allpost']);
    Route::get("/sdelete/{id}",[userController::class,'sdelete']);
    Route::get("/restore/{id}",[userController::class,'restore']);
    Route::get("/edit/{id}",[userController::class,'edit']);
    Route::get("/block/{id}",[userController::class,'block']);
    Route::get("/unblock/{id}",[userController::class,'unblock']);
    Route::post("/update",[userController::class,'update']);
    Route::get("/deletedpost",[userController::class,'deletedpost']);
    Route::get("/adminadd",function () {
        return view('admin/adminadd');
    });
    Route::post("/adminnews",[userController::class,'adminnews']);
    Route::get("/adminpost",[userController::class,'adminpost']);
    Route::get("/publish/{id}",[userController::class,'publish']);
    Route::get("/unpublish/{id}",[userController::class,'unpublish']);


    
});

Route::group(['middleware'=>['CustomAuth2']],function(){
    Route::get('/', [userController::class,'welcome']);
    Route::get('/read/{id}', [userController::class,'read']);

    Route::get("/register",function () {
        return view('register');
    });
    Route::post("/register",[userController::class,'registerValidator']);
    Route::get("/login",function () {
        return view('login');
    });
    Route::post("/login",[userController::class,'loginValidator']);
});


