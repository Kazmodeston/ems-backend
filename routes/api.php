<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/employee","employeeController@createEmployee");

Route::get("/employee/api_token={token}","employeeController@getAllEmployee");

Route::get("/employee",function(Request $request){
    $error_message = array("message"=>"Unable to make a request");
return response()->json($error_message);
});

Route::get("/employee/api_token",function(Request $request){
    $error_message = array("message"=>"Unable to make a request");
return response()->json($error_message);
});

Route::get("/employee/api_token=",function(Request $request){
    $error_message = array("message"=>"Unable to make a request");
return response()->json($error_message);
});

Route::put("/employee/api_token={token}/id={id}","employeeController@updateEmployee");

Route::delete("/employee/api_token={token}/id={id}","employeeController@deleteEmployee");

Route::get("/employee/api_token={token}/id={id}","employeeController@getEmployeeById");