<?php

use App\Livewire;
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

        Route::get('user_addresses', Livewire\UserAddress\UserAddressList::class)->name('user_addresses.index');
        Route::get('user_addresses/create', Livewire\UserAddress\CreateUserAddress::class)->name('user_addresses.create');
        Route::get('user_addresses/{userAddress}/edit', Livewire\UserAddress\EditUserAddress::class)->name('user_addresses.edit');

        Route::get('orders/create', Livewire\Orders\CheckoutOrderFromCart::class)->name('orders.create');
        Route::get('orders/buy-now', Livewire\Orders\CheckoutOrder::class)->name('orders.buy_now');
        Route::get('orders', Livewire\Orders\OrderList::class)->name('orders.index');
        Route::get('orders/{order}', Livewire\Orders\OrderShow::class)
            ->name('orders.show')
            ->can('view', 'order');
    });

    Route::view('delete-user', 'user.delete-user')->name('user.destroy');

    Route::get('cart', Livewire\Cart\CartPage::class)->name('cart');
});

Route::get('products', Livewire\Products\ProductList::class)->name('products.index');
Route::get('products/{product}', Livewire\Products\ProductShow::class)->name('products.show');

require __DIR__.'/auth.php';
