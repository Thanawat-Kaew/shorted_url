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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/url/{short_url}', [App\Http\Controllers\ShortUrlController::class, 'shortUrl'])->name('name_domain.short_url');
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home', [App\Http\Controllers\HomeController::class, 'ajaxCenter'])->name('home.ajax_center.post');
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::post('/admin/edit', [App\Http\Controllers\AdminController::class, 'editUrl'])->name('admin.edit_url')->middleware('is_admin');
/*Route::get('/admin/update', [App\Http\Controllers\AdminController::class, 'updateUrl'])->name('admin.update_url')->middleware('is_admin');*/
Route::post('/admin/delete', [App\Http\Controllers\AdminController::class, 'deleteUrl'])->name('admin.delete_url')->middleware('is_admin');