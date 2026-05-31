<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\VinController;
use Illuminate\Support\Facades\Route;

// Anasayfa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hakkımızda
Route::get('/hakkimizda', [AboutController::class, 'index'])->name('about');

// Breeze'in yönlendirdiği /dashboard — role'e göre redirect
Route::get('/dashboard', function () {
    return auth()->user()->hasRole('admin')
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

// VIN Sorgulama (herkese açık)
Route::post('/api/vin-decode', [VinController::class, 'decode'])->name('vin.decode');

// Kategori alt kategori API (herkese açık)
Route::get('/api/categories/{parentId}/children', [CategoryApiController::class, 'children'])->name('api.categories.children');

// Ürünler (herkese açık)
Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/urunler/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Giriş gerektiren sayfalar
Route::middleware(['auth'])->group(function () {
    // Profil
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/pasif', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sepet
    Route::get('/sepet', [CartController::class, 'index'])->name('cart.index');
    Route::post('/sepet/ekle', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/sepet/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/sepet/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Siparişler
    Route::get('/siparisler', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/siparisler/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/siparis-ver', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/siparisler/{order}/iptal', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/siparisler/{order}/teslim-alindi', [OrderController::class, 'confirmReceived'])->name('orders.confirmReceived');
});

// Admin panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/panel', [DashboardController::class, 'index'])->name('dashboard');

    // Ürün yönetimi
    Route::delete('/urunler/{urunler}/galeri/{index}', [AdminProductController::class, 'deleteGalleryImage'])->name('products.deleteGalleryImage');
    Route::resource('urunler', AdminProductController::class)->names([
        'index'   => 'products.index',
        'create'  => 'products.create',
        'store'   => 'products.store',
        'show'    => 'products.show',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy',
    ]);

    // Sipariş yönetimi
    Route::get('/siparisler', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/siparisler/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/siparisler/{order}/ilerlet', [AdminOrderController::class, 'advance'])->name('orders.advance');

    // Kullanıcı yönetimi
    Route::get('/kullanicilar', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/kullanicilar/{user}/bakiye', [AdminUserController::class, 'addBalance'])->name('users.addBalance');
    Route::patch('/kullanicilar/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::post('/kullanicilar/{user}/toggle-aktif', [AdminUserController::class, 'toggleActive'])->name('users.toggleActive');
    Route::delete('/kullanicilar/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Slider yönetimi
    Route::resource('sliderlar', AdminSliderController::class)->parameters(['sliderlar' => 'slider'])->names([
        'index'   => 'sliders.index',
        'create'  => 'sliders.create',
        'store'   => 'sliders.store',
        'edit'    => 'sliders.edit',
        'update'  => 'sliders.update',
        'destroy' => 'sliders.destroy',
    ]);
});

require __DIR__.'/auth.php';
