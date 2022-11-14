<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Register_controller;
use App\Http\Controllers\Login_controller;
use App\Http\Controllers\Dashboard_controller;
use App\Http\Controllers\Pembukaan_seleksi_controller;
use App\Http\Controllers\Alternatif_controller;
use App\Http\Controllers\Aspek_controller;
use App\Http\Controllers\Kriteria_controller;
use App\Http\Controllers\Penilaian_controller;
use App\Http\Controllers\Hasil_controller;
use App\Http\Controllers\Profile_controller;
use App\Http\Controllers\HasilAspekController;
use App\Http\Controllers\Pendaftaran_controller;


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

Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard
Route::get('/', function () {
    return redirect('/dashboard');
})->middleware(['auth', 'verified']);
Route::resource('/dashboard', Dashboard_controller::class)->middleware(['auth', 'verified']);

// Pembukaan Seleksi
Route::resource('/pembukaans', Pembukaan_seleksi_controller::class)->middleware('admin');
Route::get('/pembukaans/{pembukaan:slug}', [Pembukaan_seleksi_controller::class, 'show']);
Route::get('/pembukaans/ganti-status/{id}', [Pembukaan_seleksi_controller::class, 'ganti_status']);
Route::get('/pembukaans/ganti-ket/{id}', [Pembukaan_seleksi_controller::class, 'ganti_ket']);
Route::get('/pembukaans/delete/{id}', [Pembukaan_seleksi_controller::class, 'delete']);

// Alternatif
Route::resource('/alternatifs', Alternatif_controller::class)->middleware('admin');
Route::get('/alternatifs/ganti-status/{id}', [Alternatif_controller::class, 'ganti_status']);

// Aspek
Route::resource('/aspeks', Aspek_controller::class)->middleware('admin');
Route::get('/aspeks/{aspek:slug}', [Aspek_controller::class, 'show']);
Route::get('/aspeks/ganti-status/{id}', [Aspek_controller::class, 'ganti_status']);

// Kriteria
Route::resource('/kriterias', Kriteria_controller::class)->middleware('admin');
Route::get('/kriterias/ganti-status/{id}', [Kriteria_controller::class, 'ganti_status']);

// Penilaian
Route::resource('/penilaians', Penilaian_controller::class)->middleware('admin');
Route::post('/penilaians/input', [Penilaian_controller::class, 'input'])->middleware('admin');

// Hasil
Route::resource('/hasils', Hasil_controller::class)->middleware('admin');
Route::post('/hasils/hitung', [Hasil_controller::class, 'hitung'])->middleware('admin');
Route::post('/exportPDF', [Hasil_controller::class, 'export'])->middleware('admin');
Route::post('/exportsPDF', [Hasil_controller::class, 'exports'])->middleware('admin');
Route::post('/selesaiHitung', [Hasil_controller::class, 'done'])->middleware('admin');

// Profile
Route::resource('/profiles', Profile_controller::class)->middleware('auth');

// Report Lampau
Route::resource('/reports', HasilAspekController::class)->middleware('admin');
Route::get('/reports/ganti-status/{id}', [HasilAspekController::class, 'ganti_status']);
Route::post('/reports/{pembukaan:slug}', [HasilAspekController::class, 'store'])->name('showing');


// Pendaftaran
Route::resource('/pendaftarans', Pendaftaran_controller::class)->middleware('auth');
Route::get('/seleksis', [Pendaftaran_controller::class, 'hasil'])->middleware('auth');






