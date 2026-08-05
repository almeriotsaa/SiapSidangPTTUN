<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest.home');
});

Route::get('/jadwal', function () {
    return view('guest.jadwal');
});

Route::get('/kontak', function () {
    return view('guest.kontak');
});

Route::get('/tentang', function () {
    return view('guest.tentang');
});