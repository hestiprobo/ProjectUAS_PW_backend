<?php

use Illuminate\Support\Facades\Mail;
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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/verifikasi', function () {
//     return view('verifikasiemail');
// });

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// user
Route::get('/user/komentar/{id}', [App\Http\Controllers\KomentarController::class, 'viewkomentar']);
Route::post('/user/komentar/kirim', [App\Http\Controllers\KomentarController::class, 'kirimkomentar']);
Route::get('/user/komentar/hapus/{id}/{id_user}', [App\Http\Controllers\KomentarController::class, 'hapuskomentar']);
Route::post('/user/komentar/edit', [App\Http\Controllers\KomentarController::class, 'editkomentar']);

Route::get('/user/posting/hapus/{id}', [App\Http\Controllers\PostingController::class, 'hapusdata']);
Route::post('/user/posting/edit', [App\Http\Controllers\PostingController::class, 'editdata']);
Route::post('/user/posting/tambah', [App\Http\Controllers\PostingController::class, 'tambahdata']);

Route::get('/user/profil/{id}', [App\Http\Controllers\ProfilController::class, 'viewprofil']);
Route::post('/user/profil/edit', [App\Http\Controllers\ProfilController::class, 'editprofil']);
Route::post('/user/profil/upload', [App\Http\Controllers\ProfilController::class, 'uploadfoto']);

Route::get('/user/marketplaces', [App\Http\Controllers\MarketplacesController::class, 'view']);
Route::post('/user/marketplaces/tambah', [App\Http\Controllers\MarketplacesController::class, 'tambah']);
Route::get('/user/marketplaces/hapus/{id}', [App\Http\Controllers\MarketplacesController::class, 'hapus']);
Route::post('/user/marketplaces/edit', [App\Http\Controllers\MarketplacesController::class, 'edit']);

Route::get('/user/marketplaces/komentar/{id}', [App\Http\Controllers\MarketplacesController::class, 'viewkomentar']);
Route::post('/user/marketplaces/komentar/tambah', [App\Http\Controllers\MarketplacesController::class, 'tambahkomentar']);
Route::post('/user/marketplaces/komentar/edit', [App\Http\Controllers\MarketplacesController::class, 'editkomentar']);
Route::get('/user/marketplaces/komentar/hapus/{id}', [App\Http\Controllers\MarketplacesController::class, 'hapuskomentar']);


//admin
Route::get('/admin/beranda', [App\Http\Controllers\AdminController::class, 'view']);
Route::get('/admin/posting/hapus/{id}', [App\Http\Controllers\AdminController::class, 'hapusdata']);
Route::post('/admin/posting/edit', [App\Http\Controllers\AdminController::class, 'editdata']);

Route::get('/admin/manajemenuser', [App\Http\Controllers\AdminController::class, 'viewmanajemen']);
Route::get('/admin/manajemenuser/hapus/{id}', [App\Http\Controllers\AdminController::class, 'hapususer']);

Route::get('/admin/komentar/{id}', [App\Http\Controllers\AdminController::class, 'viewkomentar']);
Route::post('/admin/komentar/kirim', [App\Http\Controllers\AdminController::class, 'kirimkomentar']);
Route::get('/admin/komentar/hapus/{id}/{id_user}', [App\Http\Controllers\AdminController::class, 'hapuskomentar']);
Route::post('/admin/komentar/edit', [App\Http\Controllers\AdminController::class, 'editkomentar']);

Route::get('/admin/marketplaces', [App\Http\Controllers\AdminController::class, 'viewmarketplaces']);
Route::post('/admin/marketplaces/tambah', [App\Http\Controllers\AdminController::class, 'tambahmarketplaces']);
Route::post('/admin/marketplaces/edit', [App\Http\Controllers\AdminController::class, 'editmarketplaces']);
Route::get('/admin/marketplaces/hapus/{id}', [App\Http\Controllers\AdminController::class, 'hapusmarketplaces']);

Route::get('/admin/marketplaces/komentar/{id}', [App\Http\Controllers\AdminController::class, 'komentarmarketplaces']);
Route::post('/admin/marketplaces/komentar/tambah', [App\Http\Controllers\AdminController::class, 'tambahkomentarmarketplaces']);
Route::get('/admin/marketplaces/komentar/hapus/{id}', [App\Http\Controllers\AdminController::class, 'hapuskomentarmarketplaces']);
Route::post('/admin/marketplaces/komentar/edit', [App\Http\Controllers\AdminController::class, 'editkomentarmarketplaces']);
