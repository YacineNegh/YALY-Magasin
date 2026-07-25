<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeliveryPriceController as AdminDeliveryPriceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PublicStore\HomeController;
use App\Http\Controllers\PublicStore\LocationController;
use App\Http\Controllers\PublicStore\OrderController;
use App\Http\Controllers\PublicStore\PageController;
use App\Http\Controllers\PublicStore\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/api/locations/wilayas', [LocationController::class, 'wilayas'])->name('locations.wilayas');
Route::get('/api/locations/wilayas/{wilaya}/communes', [LocationController::class, 'communes'])->name('locations.communes');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::redirect('/login', '/admin/login');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::redirect('/', '/admin/dashboard')->name('home');
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::patch('orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('orders/{order}/deliver', [AdminOrderController::class, 'deliver'])->name('orders.deliver');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('delivery-prices', [AdminDeliveryPriceController::class, 'index'])->name('delivery-prices.index');
    Route::put('delivery-prices', [AdminDeliveryPriceController::class, 'update'])->name('delivery-prices.update');
    Route::get('settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
