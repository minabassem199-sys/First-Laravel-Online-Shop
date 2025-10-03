<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Models\Products;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes for public pages, user dashboard, admin panel, and product management.
|
*/

Route::get('/', function () {
    return view('welcome');
});


// عرض المنتجات (مفتوحة للجميع)
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{id}/details', [ProductsController::class, 'details'])->name('products.details');
Route::get('/contactus', [ProductsController::class, 'contactus'])->name('products.contactus');


// صفحة إضافة للسلة (تتطلب تسجيل دخول)
// 2. رابط لاستقبال البيانات من الفورم وإضافة المنتج فعلياً للسلة
Route::middleware('auth')->group(function(){
    Route::post('/add-to-cart', [ProductsController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ProductsController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/remove/{id}', [ProductsController::class, 'removeFromCart'])->name('cart.remove');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
});

// صفحات الأدمن (تتطلب تسجيل دخول)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/products/dashboard', [ProductsController::class, 'adminIndex'])->name('dashboard');
    Route::get('/admin/products/create', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');
});

// صفحات الملف الشخصي (خاصة بالمستخدم المسجل)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


require __DIR__.'/auth.php';
