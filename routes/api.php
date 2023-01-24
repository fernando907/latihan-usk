<?php

use App\Http\Controllers\API\UserController;
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

Route::post('login', [App\Http\Controllers\API\APIUserController::class, 'login']);

Route::get('kategori', [App\Http\Controllers\API\APIKategoriController::class, 'get']);
Route::get('kategori/{id}', [App\Http\Controllers\API\APIKategoriController::class, 'get']);
Route::post('kategori', [App\Http\Controllers\API\APIKategoriController::class, 'store']);
Route::put('kategori/{id}', [App\Http\Controllers\API\APIKategoriController::class, 'update']);
Route::delete('kategori/{id}', [App\Http\Controllers\API\APIKategoriController::class, 'destroy']);

Route::get('user', [App\Http\Controllers\API\APIUserController::class, 'get']);
Route::get('user/{id}', [App\Http\Controllers\API\APIUserController::class, 'get']);
Route::post('user', [App\Http\Controllers\API\APIUserController::class, 'store_user']);
Route::post('admin', [App\Http\Controllers\API\APIUserController::class, 'store_admin']);
Route::put('user/{id}', [App\Http\Controllers\API\APIUserController::class, 'update']);
Route::put('admin/{id}', [App\Http\Controllers\API\APIUserController::class, 'updateAdmin']);
Route::delete('user/{id}', [App\Http\Controllers\API\APIUserController::class, 'destroy']);
Route::delete('admin/{id}', [App\Http\Controllers\API\APIUserController::class, 'destroyAdmin']);

Route::get('buku', [App\Http\Controllers\API\APIBukuController::class, 'get']);
Route::get('buku/{id}', [App\Http\Controllers\API\APIBukuController::class, 'get']);
Route::post('buku', [App\Http\Controllers\API\APIBukuController::class, 'store']);
Route::put('buku/{id}', [App\Http\Controllers\API\APIBukuController::class, 'update']);
Route::delete('buku/{id}', [App\Http\Controllers\API\APIBukuController::class, 'destroy']);

Route::get('peminjaman', [App\Http\Controllers\API\APIPeminjamanController::class, 'get']);
Route::get('peminjaman/{id}', [App\Http\Controllers\API\APIPeminjamanController::class, 'get']);
Route::post('peminjaman', [App\Http\Controllers\API\APIPeminjamanController::class, 'store']);
Route::put('peminjaman/{id}', [App\Http\Controllers\API\APIPeminjamanController::class, 'update']);
Route::delete('peminjaman/{id}', [App\Http\Controllers\API\APIPeminjamanController::class, 'destroy']);

Route::get('penerbit', [App\Http\Controllers\API\APIPenerbitController::class, 'get']);
Route::get('penerbit/{id}', [App\Http\Controllers\API\APIPenerbitController::class, 'get']);
Route::post('penerbit', [App\Http\Controllers\API\APIPenerbitController::class, 'store']);
Route::put('penerbit/{id}', [App\Http\Controllers\API\APIPenerbitController::class, 'update']);
Route::delete('penerbit/{id}', [App\Http\Controllers\API\APIPenerbitController::class, 'destroy']);

Route::get('pesan', [App\Http\Controllers\API\APIPesanController::class, 'get']);
Route::get('pesan/{id}', [App\Http\Controllers\API\APIPesanController::class, 'get']);
Route::post('pesan', [App\Http\Controllers\API\APIPesanController::class, 'store']);
Route::put('pesan/{id}', [App\Http\Controllers\API\APIPesanController::class, 'update']);
Route::delete('pesan/{id}', [App\Http\Controllers\API\APIPesanController::class, 'destroy']);

Route::get('pemberitahuan', [App\Http\Controllers\API\APIPemberitahuanController::class, 'get']);
Route::get('pemberitahuan/{id}', [App\Http\Controllers\API\APIPemberitahuanController::class, 'get']);
Route::post('pemberitahuan', [App\Http\Controllers\API\APIPemberitahuanController::class, 'store']);
Route::put('pemberitahuan/{id}', [App\Http\Controllers\API\APIPemberitahuanController::class, 'update']);
Route::delete('pemberitahuan/{id}', [App\Http\Controllers\API\APIPemberitahuanController::class, 'destroy']);

Route::get('identitas', [App\Http\Controllers\API\APIIdentitasController::class, 'get']);
Route::get('identitas/{id}', [App\Http\Controllers\API\APIIdentitasController::class, 'get']);
Route::post('identitas', [App\Http\Controllers\API\APIIdentitasController::class, 'store']);
Route::put('identitas/{id}', [App\Http\Controllers\API\APIIdentitasController::class, 'update']);
Route::delete('identitas/{id}', [App\Http\Controllers\API\APIIdentitasController::class, 'destroy']);
