<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Livewire\Product\Create;
use App\Livewire\Product\Index;
use App\Livewire\Product\Edit;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Search;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\ProductDetailController;
use App\Livewire\Pages\About;

use App\Livewire\Page\Blog;
use App\Livewire\Page\Carrier;

Route::get('/blog', Blog::class)->name('blog');
Route::get('/carrier', Carrier::class)->name('carrier');

/**
 * Public access
 */
Route::get('/', function () { return view('welcome'); })
    ->name('landing');
Route::get('/home', Home::class)->name('home');
Route::get('/products/{product}', ProductDetailController::class)
    ->name('products.show');
Route::get('/search', Search::class)->name('search');
Route::get('/about', About::class)->name('about');

/**
 * Manual implementation for authenticate
 */
Route::middleware('guest')->group( function () {
    Route::get( '/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',     [AuthController::class, 'login']);
    Route::get( '/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',  [AuthController::class, 'register']);
});

/**
 * Authenticated user
 */
Route::middleware('auth')->group( function () {
    Route::post('/logout',    [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin,seller')->prefix('dashboard')->group(function () {
        Route::get('/', \App\Livewire\Dashboard\Overview::class)->name('dashboard');
        Route::get('/products', Index::class)->name('products.index');
        Route::get('/products/create', Create::class)->name('products.create');
        Route::get('/products/{product}/edit', Edit::class)->name('products.edit');
        Route::get('/finance', \App\Livewire\Dashboard\Finance::class)->name('dashboard.finance');
    });
});
