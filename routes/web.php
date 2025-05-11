<?php

use App\Livewire\Admin\Admin;
use App\Livewire\Admin\Graduates;
use App\Livewire\Admin\HEI;
use App\Livewire\Admin\HEIList;
use App\Livewire\TracerComponents\TrackingForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Questions;
use App\Livewire\Admin\ViewGraduate;
use App\Livewire\Auth\Login;
use App\Livewire\Hei\Graduates as HeiGraduates;
use App\Livewire\Hei\Hei as HEIAcc;
use App\Livewire\HEi\ViewGraduate as HEiViewGraduate;

Route::get('/', TrackingForm::class);
Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['onlyadmin'])->group(function () {
        Route::get('/admin', Admin::class)->name('dashboard');
        Route::get('/questions', Questions::class);
        Route::get('/graduates', Graduates::class);
        Route::get('/view_graduate/{encrypt_id}', ViewGraduate::class);
        Route::get('/hei', HEI::class);
        Route::get('/hei_list', HEIList::class);
    });

    Route::get('/home', HEIAcc::class);
    Route::get('/view_graduates', HeiGraduates::class);
    Route::get('/graduate/{encrypt_id}', HEiViewGraduate::class);
});