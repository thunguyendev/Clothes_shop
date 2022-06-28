<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;


use App\Http\Controllers\AjaxBOOKCRUDController;


Route::get('/', [TestController::class, 'index']);

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



Route::get('/', 'App\Http\Controllers\TestController@index')->name('show-product');
Route::get('/show-product', function () {
    return view('pages.product');
});

Route::get('/home', 'App\Http\Controllers\TestController@index')->name('home');
Route::get('/admin', 'App\Http\Controllers\TestController@admin')->name('admin1');
Route::get('/admin1', function () {
    return view('welcome');
});


Route::get('/test/{_id?}', [TestController::class, 'form'])->name('test.form');
Route::post('/test/save', [TestController::class, 'postAddProduct'])->name('create_cloth');
// Route::get('/test/update/{_id}', [TestController::class, 'update'])->name('update_cloth');



Route::get('/test/update/{_id}', [TestController::class, 'editCloth']);
Route::post('/admin-edit', [TestController::class, 'postEditProduct']);
Route::get('/test/delete/{_id}',[TestController::class, 'delete'])->name('delete_cloth');
Route::get('KhoaHoc/Laravel', function(){
    echo "<h1>xin chao Thu</h1>";
});

Route::get('HoTen/{ten}', function($ten){
    return $ten;

})->where(['ten' => '[0-9a-zA-Z]{5,7}']);


//dinh danh route
Route::get('Hello', ['as'=>'Hi', function(){
    echo 'Da doi ten';
}]);

Route::get('chao' , function(){
    return "jk";
})->name('bye');

Route::get('goiten', function(){
    return redirect()->route('bye');
});

//nhóm route

Route::group(['prefix'=>'myGroup'], function(){
    Route::get('user1', function(){
        echo 'User1';
    });
    Route::get('user2', function(){
        echo 'User2';
    });
});

Route::get('goiController/{ten?}', 'App\Http\Controllers\MyController@XinChao');



//Ajax
Route::delete('/cloth/{_id}', [TestController::class, 'deleteCloth']);


Route::get('ajax-cloth-crud', [AjaxBOOKCRUDController::class, 'index']);
Route::post('add-update-clothes', [AjaxBOOKCRUDController::class, 'store']);
Route::post('edit-clothes', [AjaxBOOKCRUDController::class, 'edit']);
Route::post('delete-clothes', [AjaxBOOKCRUDController::class, 'destroy']);