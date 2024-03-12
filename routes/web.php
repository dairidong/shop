<?php

use App\Livewire\Products\ProductList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'dashboard')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('profile', 'user.profile')
        ->middleware('verified')
        ->name('profile');

    Route::view('update-password', 'user.update-password')
        ->name('user.update-password');

    Route::view('delete-user', 'user.delete-user')
        ->name('user.destroy');
});

Route::get('products', ProductList::class)->name('products.index');

require __DIR__.'/auth.php';
