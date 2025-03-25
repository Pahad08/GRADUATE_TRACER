<?php

use App\Livewire\TracerComponents\TrackingForm;
use Illuminate\Support\Facades\Route;

Route::get('/', TrackingForm::class);
// Route::get('/dashboard', TrackingForm::class);