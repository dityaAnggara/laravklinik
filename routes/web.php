<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Beranda;
use App\Livewire\Usert;
use App\Livewire\Pasien;
use App\Livewire\Obat;
use App\Livewire\Checkup;


Auth::routes(['register' => false]);
Route::get('/', function () {
    return view('auth/login');
});

//Auth::routes();

Route::get('/home', Beranda::class)->middleware('auth')->name('home');
Route::get('/user', Usert::class)->middleware('auth')->name('user');
Route::get('/pasien', Pasien::class)->middleware('auth')->name('pasien');
Route::get('/obat', Obat::class)->middleware('auth')->name('obat');
Route::get('/checkup', Checkup::class)->middleware('auth')->name('checkup');
