<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\customerController;
use App\Http\Controllers\Api\earthcontroller;
use App\Http\Controllers\Api\searchcontroller;
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

Route::post('customer/register',[customerController::class, 'registercustomer']);
Route::post('customer/login',[customerController::class, 'logincustomer']);

Route::group( ['prefix' => 'customer','middleware' => ['auth:customer-api','scopes:customer'] ],function(){
   Route::get('/profile',[customerController::class, 'profile']);
   Route::get('/logout',[customerController::class, 'logoutcustomer']);
   Route::post('/addphoto',[earthcontroller::class, 'addphoto']);//انشاء عقار

   Route::post('/create',[earthcontroller::class, 'createproperty']);//انشاء عقار
   Route::get('/list',[earthcontroller::class, 'listproperty']);//عرض العقارات
   Route::post('/single-property/{id}',[earthcontroller::class, 'single_property']);// معلومات عقار 
   Route::post('/update-property/{id}',[earthcontroller::class, 'update_property']);
   Route::delete('/delet-property/{id}',[earthcontroller::class, 'delete_property']);//حذف عقار
   Route::get('/typeproperty/{Category_id}',[searchcontroller::class, 'indexByCategory']);//بحث حسب نوع العقار
   Route::get('/search_location/{location}',[searchcontroller::class, 'search_location']);//بحث عن عقار حسب الموقع
   Route::post('/reviews', [searchcontroller::class, 'store']);//لاضافة تعليقات وتقييمات
   Route::get('/show_review/{id}', [searchcontroller::class, 'show_review']);//لعرض تعليقات وتقييمات

});
/*
Route::post('/chats', [ChatController::class, 'storechat']);
Route::get('/chats', [ChatController::class, 'indexchat']);
Route::post('/reviews', [searchcontroller::class, 'store']);
Route::post('/socket', [SocketController::class, 'handleSocketRequest']);
*/