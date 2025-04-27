<?php

use App\Livewire\Admin\Admin;
use App\Livewire\Admin\Graduates;
use App\Livewire\TracerComponents\TrackingForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Questions;
use App\Livewire\Admin\ViewGraduate;
use App\Livewire\Auth\Login;

Route::get('/', TrackingForm::class);
Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', Admin::class)->name('dashboard');
    Route::get('/questions', Questions::class);
    Route::get('/graduates', Graduates::class);
    Route::get('/view_graduate/{encrypt_id}', ViewGraduate::class);
});
