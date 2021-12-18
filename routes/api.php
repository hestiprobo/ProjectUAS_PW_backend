<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VerificationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

//posting
Route::get('/posting/list', [App\Http\Controllers\ApiController::class, 'tampilkanpostingan']);
Route::get('/posting/view/{id}', [App\Http\Controllers\ApiController::class, 'tampilkanpostinganbyid']);
Route::post('/posting/tambah', [App\Http\Controllers\ApiController::class, 'tambahpostingan']);
Route::put('/posting/edit/{id}', [App\Http\Controllers\ApiController::class, 'editpostingan']);
Route::delete('/posting/hapus/{id}', [App\Http\Controllers\ApiController::class, 'hapuspostingan']);
// end posting

//komentar
Route::get('/komentar/list', [App\Http\Controllers\ApiController::class, 'viewkomentar']);
Route::get('/komentar/{id}', [App\Http\Controllers\ApiController::class, 'viewkomentarbyid']);
Route::post('/komentar/kirim', [App\Http\Controllers\ApiController::class, 'kirimkomentar']);
Route::put('/komentar/edit/{id}', [App\Http\Controllers\ApiController::class, 'editkomentar']);
Route::delete('/komentar/hapus/{id}', [App\Http\Controllers\ApiController::class, 'hapuskomentar']);
//endkomentar

//marketplaces
Route::get('/marketplaces/list', [App\Http\Controllers\ApiController::class, 'viewmarketplaces']);
Route::get('/marketplaces/view/{id}', [App\Http\Controllers\ApiController::class, 'viewmarketplacesbyid']);
Route::post('/marketplaces/tambah', [App\Http\Controllers\ApiController::class, 'tambahmarketplaces']);
Route::put('/marketplaces/edit/{id}', [App\Http\Controllers\ApiController::class, 'editmarketplaces']);
Route::delete('/marketplaces/hapus/{id}', [App\Http\Controllers\ApiController::class, 'hapusmarketplaces']);
//end marketplace

//komentar marketplaces
Route::get('/marketplaces/komentar/list', [App\Http\Controllers\ApiController::class, 'viewkomentarmarketplaces']);
Route::get('/marketplaces/komentar/view/{id}', [App\Http\Controllers\ApiController::class, 'viewkomentarmarketplacesbyid']);
Route::post('/marketplaces/komentar/tambah', [App\Http\Controllers\ApiController::class, 'tambahkomentarmarketplaces']);
Route::put('/marketplaces/komentar/edit/{id}', [App\Http\Controllers\ApiController::class, 'editkomentarmarketplaces']);
Route::delete('/marketplaces/komentar/hapus/{id}', [App\Http\Controllers\ApiController::class, 'hapuskomentarmarketplaces']);


// manajemen user
Route::get('/manajemenuser/list', [App\Http\Controllers\ApiController::class, 'viewmanajemen']);
Route::get('/manajemenuser/view/{id}', [App\Http\Controllers\ApiController::class, 'viewmanajemenbyid']);
Route::delete('/manajemenuser/hapus/{id}', [App\Http\Controllers\ApiController::class, 'hapususer']);


// profil
Route::put('/profil/update/{id}', [App\Http\Controllers\ApiController::class, 'editprofil']);
