<?php

use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;

// use Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front-End
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{product_id}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class, 'getSize']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Users
Route::get('/user/delete/{user_id}', [HomeController::class, 'delete'])->name('delete');

// Category
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category/insert', [CategoryController::class, 'insert'])->name('category.insert');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'restore'])->name('category.restore');
Route::get('/category/force_delete/{category_id}', [CategoryController::class, 'force_delete'])->name('category.force_delete');
Route::post('/mark/delete', [CategoryController::class, 'mark_del'])->name('category.mark_del');
Route::post('/mark/restore', [CategoryController::class, 'mark_restore'])->name('category.mark_restore');


// Sub Category
Route::get('/subcategory', [SubcategoryController::class, 'index'])->name('subcategory.index');
Route::post('/subcategory/insert', [SubcategoryController::class, 'insert'])->name('subcategory.insert');
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'delete'])->name('subcategory.delete');


// Dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard']);

// Profile
Route::get('/profile', [ProfileController::class, 'profile'] )->name('profile');
Route::post('/name/change', [ProfileController::class, 'name_change'] )->name('name.change');
Route::post('/password/change', [ProfileController::class, 'password_change'] )->name('password.change');
Route::post('/photo/change', [ProfileController::class, 'profile_photo'] )->name('photo.change');


// Product
Route::get('/product', [ProductController::class, 'index'] )->name('product.index');
Route::post('/getCategory', [ProductController::class, 'getCategory']);
Route::post('/product/insert', [ProductController::class, 'insert']);
Route::get('/color', [InventoryController::class, 'color'] )->name('color');
Route::post('/color/insert', [InventoryController::class, 'insert'] );
Route::get('/size', [InventoryController::class, 'size'])->name('size');
Route::post('/size/insert', [InventoryController::class, 'size_insert'])->name('size');
Route::get('/inventory/{product_id}', [InventoryController::class, 'inventory'])->name('inventory');
Route::post('/inventory/insert', [InventoryController::class, 'inventory_insert']);
Route::get('/product/delete/{product_id}', [ProductController::class, 'delete']);


// Customer
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register']);
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login']);
Route::get('/customer/account', [AccountController::class, 'account'])->name('account');
Route::get('/customer/logout', [AccountController::class, 'customerlogout'])->name('customerlogout');


// Cart
Route::post('/cart/insert', [CartController::class, 'cart_insert']);
Route::get('/cart/delete/{cart_id}', [CartController::class, 'cart_delete'])->name('cart.delete');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update']);


// Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon.index');
Route::post('/coupon/insert', [CouponController::class, 'coupon_insert']);
Route::get('/coupon/delete/{coupon_id}', [CouponController::class, 'coupon_delete']);



// Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
