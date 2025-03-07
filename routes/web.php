<?php

use App\Http\Controllers\EstimateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/estimate/pdf/{document:uuid}', EstimateController::class)->name('estimate.pdf');
