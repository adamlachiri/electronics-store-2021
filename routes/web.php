<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// home
Route::get('/', [HomeController::class, "index"]);


// profiles
Route::get('/profile/edit', [ProfileController::class, "edit"]);
Route::get('/profile/security', [ProfileController::class, "security"]);
Route::get('/profile/{id}/orders', [ProfileController::class, "orders"]);
Route::get('/profile/{id}/favourites', [ProfileController::class, "favourites"]);
Route::get('/profile/{id}/payment_method', [ProfileController::class, "payment_method"]);
Route::post('/profile/change_password', [ProfileController::class, "change_password"]);
Route::put('/profile/{id}', [ProfileController::class, "update"]);


// admin
Route::get('/admin/security', [AdminController::class, "security"]);
Route::get('/admin/products', [AdminController::class, "products"]);
Route::post('/admin/search_product', [AdminController::class, "search_product"]);
Route::post('/admin/change_password', [AdminController::class, "change_password"]);
Route::get('/admin/create_fake_data', [AdminController::class, "create_fake_data"]);


// products
Route::get('/products/create', [ProductController::class, "create"])->middleware("admin");
Route::get('/products/{id}/edit', [ProductController::class, "edit"])->middleware("admin");
Route::put('/products/{id}', [ProductController::class, "update"])->middleware("admin");
Route::post('/products', [ProductController::class, "store"])->middleware("admin");

Route::get('/products', [ProductController::class, "index"]);
Route::get('/products/{id}', [ProductController::class, "show"]);


// categories
Route::put('/categories/{id}', [CategoryController::class, "update"]);
Route::get('/categories', [CategoryController::class, "index"]);
Route::post('/categories', [CategoryController::class, "store"]);
Route::delete('/categories/{id}', [CategoryController::class, "destroy"]);


// ads
Route::put('/ads/{id}', [AdController::class, "update"]);
Route::get('/ads', [AdController::class, "index"]);
Route::post('/ads', [AdController::class, "store"]);
Route::delete('/ads/{id}', [AdController::class, "destroy"]);


// favourites
Route::get('/favourites', [FavouriteController::class, "index"]);
Route::post('/favourites', [FavouriteController::class, "store"]);
Route::delete('/favourites/{id}', [FavouriteController::class, "destroy"]);

// cart
Route::get('/cart', [CartController::class, "index"]);
Route::post('/cart/confirm_cart', [CartController::class, "confirm_cart"])->middleware("auth");
Route::post('/cart', [CartController::class, "store"])->middleware("auth");
Route::delete('/cart/{id}', [CartController::class, "destroy"])->middleware("auth");

// order
Route::get('/order', [OrderController::class, "index"]);
Route::get('/order/shipping_address_form', [OrderController::class, "shipping_address_form"]);
Route::get('/order/payment_method_form', [OrderController::class, "payment_method_form"]);
Route::get('/order/confirmation', [OrderController::class, "confirmation"]);
Route::post('/order/confirm_password', [OrderController::class, "confirm_password"]);
Route::post('/order/shipping_address', [OrderController::class, "shipping_address"]);
Route::post('/order/payment_method', [OrderController::class, "payment_method"]);

// reviews
Route::post('/reviews', [ReviewController::class, "store"]);
Route::put('/reviews/{id}', [ReviewController::class, "update"]);


// auth
Auth::routes();

// storage link
Route::get("/storage_link", function () {
    Artisan::call("storage:link");
    return redirect("/");
});
