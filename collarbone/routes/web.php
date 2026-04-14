<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\HeroSlideController;
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

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/new-arrivals', [FrontendController::class, 'newArrivals'])->name('new_arrivals');
Route::get('/categories', [FrontendController::class, 'categories'])->name('categories');

// Admin Authentication Routes (Guest — no auth required)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Admin Routes (Protected with auth middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
    Route::get('/new-arrivals', [ProductController::class, 'newArrivals'])->name('new_arrivals');

    // Products CRUD
    Route::post('products/update-sort-order', [ProductController::class, 'updateSortOrder'])->name('products.update_sort_order');
    Route::resource('products', ProductController::class);

    // Product AJAX API
    Route::get('products/{product}/json', [ProductController::class, 'apiShow'])->name('products.api.show');
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle_status');
    Route::patch('products/{product}/toggle-new-arrival', [ProductController::class, 'toggleNewArrival'])->name('products.toggle_new_arrival');
    Route::patch('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle_featured');

    // Categories CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Testimonials CRUD
    Route::post('testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::patch('testimonials/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])->name('testimonials.toggle_status');
    Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Collections CRUD
    Route::post('collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::put('collections/{collection}', [CollectionController::class, 'update'])->name('collections.update');
    Route::patch('collections/{collection}/toggle-status', [CollectionController::class, 'toggleStatus'])->name('collections.toggle_status');
    Route::delete('collections/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');

    // Banners
    Route::put('banners/{page_name}', [BannerController::class, 'update'])->name('banners.update');

    // Hero Slides
    Route::resource('hero_slides', HeroSlideController::class)->except(['create', 'edit', 'show', 'index']);
    Route::patch('hero_slides/{heroSlide}/toggle-status', [HeroSlideController::class, 'toggleStatus'])->name('hero_slides.toggle_status');
});
