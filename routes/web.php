<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::view('/aviso-legal', 'legal.aviso-legal')->name('legal.aviso-legal');
Route::view('/politica-de-privacidad', 'legal.politica-de-privacidad')->name('legal.politica-de-privacidad');
Route::view('/politica-de-cookies', 'legal.politica-de-cookies')->name('legal.politica-de-cookies');
