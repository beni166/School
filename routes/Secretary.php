<?php

use App\Http\Controllers\Secretary\SecretaryController;
use Illuminate\Support\Facades\Route;


Route::group(['middelware' => ['auth', 'as', 'isSecretary'], 'prefix' => 'secretary', 'as', 'secretary.'], function () {
    Route::get('Dashboard', [SecretaryController::class, 'index'])->name('dashboard');
});
