<?php

use App\Livewire\Admin\ExperienceManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'site.home')->name('home');
Route::view('/nosotros', 'site.nosotros')->name('nosotros');
Route::view('/servicios', 'site.servicios')->name('servicios');
Route::view('/noticias', 'site.noticias')->name('noticias');
Route::view('/ad50', 'site.ad50')->name('ad50');
Route::view('/black', 'site.black')->name('black');
Route::permanentRedirect('/adblack', '/black');

Route::livewire('/admin', ExperienceManager::class)->name('admin');
