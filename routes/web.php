<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes(['register' => false]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function (){
    Route::impersonate();
});

Route::group(['middleware' => ['role:'.Acl::ROLE_SUPERADMIN, 'auth'], 'prefix' => 'superadmin'], function (){

    /*
     * User
     */
    Route::resource('/users', \App\Http\Controllers\SuperAdmin\UserAdminController::class, ['as' => 'superadmin']);
    Route::get('/users/list/table', [\App\Http\Controllers\SuperAdmin\UserAdminController::class, 'listDataTable'])->name('superadmin.users.datatable');
    Route::post('/users/delete', [\App\Http\Controllers\SuperAdmin\UserAdminController::class, 'delete'])->name('superadmin.users.delete');

    Route::resource('/poi', \App\Http\Controllers\PoiController::class, ['as' => 'company']);
    Route::post('/poi/delete', [\App\Http\Controllers\PoiController::class, 'delete'])->name('company.poi.delete');
    Route::get('/poi/list/table', [\App\Http\Controllers\PoiController::class, 'listDataTable'])->name('company.poi.datatable');


});



/*
 * User
 */
Route::resource('/users', \App\Http\Controllers\UserController::class);
Route::get('/users/list/table', [\App\Http\Controllers\UserController::class, 'listDataTable'])->name('users.datatable');
Route::post('/users/delete', [\App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');

/*
 * Role
 */
Route::resource('/roles', \App\Http\Controllers\RoleController::class);
Route::post('/roles/delete', [\App\Http\Controllers\RoleController::class, 'delete'])->name('roles.delete');
Route::get('/roles/list/table', [\App\Http\Controllers\RoleController::class, 'listDataTable'])->name('roles.datatable');

Route::get('/map', [\App\Http\Controllers\MapController::class, 'index'])->name('company.map.index');
Route::get('/map/pois', [\App\Http\Controllers\MapController::class, 'pois'])->name('company.map.pois');

