<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('services', 'services')->name('services');
Route::view('about', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');

Route::group(
    ['controller' => SubmissionController::class, 'prefix' => 'submission', 'as' => 'submission.'],
    function (Registrar $route) {
        $route->post('', 'store')->name('store');
    }
);
