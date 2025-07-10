<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::view('/login', 'login')->name('web.login');
Route::view('/quotation', 'quotation')->name('web.quotation');
