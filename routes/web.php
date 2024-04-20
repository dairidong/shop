<?php

use App\Livewire\Cart\CartPage;
use App\Livewire\Orders\CheckoutOrderFromCart;
use App\Livewire\Products\ProductList;
use App\Livewire\Products\ProductShow;
use App\Livewire\UserAddress\CreateUserAddress;
use App\Livewire\UserAddress\EditUserAddress;
use App\Livewire\UserAddress\UserAddressList;
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

    Route::middleware('verified')->group(function () {
        Route::view('profile', 'user.profile')
            ->name('profile');

        Route::view('update-password', 'user.update-password')
            ->name('user.update-password');

        Route::get('user_addresses', UserAddressList::class)->name('user_addresses.index');
        Route::get('user_addresses/create', CreateUserAddress::class)->name('user_addresses.create');
        Route::get('user_addresses/{userAddress}/edit', EditUserAddress::class)->name('user_addresses.edit');

        Route::get('/orders/create', CheckoutOrderFromCart::class)->name('orders.create');
    });

    Route::view('delete-user', 'user.delete-user')
        ->name('user.destroy');

    Route::get('cart', CartPage::class)->name('cart');
});

Route::get('products', ProductList::class)->name('products.index');
Route::get('products/{product}', ProductShow::class)->name('products.show');

require __DIR__.'/auth.php';
