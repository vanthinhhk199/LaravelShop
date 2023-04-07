<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\RatingController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\DetailController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Cart;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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



Route::get('view-category/{slug}', [FrontendController::class, 'viewcategory']);

Route::get('product/{id}', [DetailController::class, 'show']);

Route::post('load_more_cmt/{prod_id}', [DetailController::class, 'load_more_cmt']);

Route::get('pagination/paginate-prod', [FrontendController::class, 'pagination']);

Route::get('search', [SearchController::class, 'searchProduct']);

Route::get('load-cart-data', [CartController::class, 'cartloadbyajax']);
Route::get('load-wishlist-count', [WishlistController::class, 'wishlistcount']);

Route::post('add-to-cart', [CartController::class, 'addProduct']);
Route::delete('delete-from-cart', [CartController::class, 'deletefromcart']);
Route::post('update-to-cart', [CartController::class, 'updatetocart']);

Route::post('add-to-wishlist', [WishlistController::class, 'add']);
Route::delete('remove-wishlist-item', [WishlistController::class, 'deleteitem']);

Route::get('cart', [CartController::class, 'viewcart']);

Route::get('clear-cart',[CartController::class, 'clearcart']);

Route::get('/sort-by',[FrontendController::class, 'sort_by'])->name('sort.by');


Route::middleware(['auth'])->group(function(){
    Route::get('checkout', [CheckoutController::class, 'index']);
    Route::post('place-order', [CheckoutController::class, 'placeorder']);

    Route::get('my-orders', [UserController::class, 'index']);
    Route::get('view-order/{id}', [UserController::class, 'view']);

    Route::get('wishlist', [WishlistController::class, 'index']);

    Route::post('add-rating', [RatingController::class, 'add']);

    Route::post('add-review', [DetailController::class, 'store'])->name('add-review');

});

Route::middleware(['auth', 'isAdmin'])->group(function(){
    Route::get('/dashboard', 'Admin\FrontendController@index');
    Route::get('categories', 'Admin\CategoryController@index');
    Route::get('add-category', 'Admin\CategoryController@add');
    Route::post('insert-category', 'Admin\CategoryController@insert');
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    Route::put('update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('add-products', [ProductController::class, 'add']);
    Route::post('insert-product', [ProductController::class, 'insert']);
    Route::get('edit-products/{id}', [ProductController::class, 'edit']);
    Route::put('update-products/{id}', [ProductController::class, 'update']);
    Route::delete('delete-products/{id}', [ProductController::class, 'destroy']);


    Route::get('orders', [OrderController::class, 'index']);
    Route::get('admin/view-order/{id}',[OrderController::class, 'view']);
    Route::put('update-order/{id}', [OrderController::class,'updateorder']);
    Route::get('order-history', [OrderController::class, 'orderhistory']);

    Route::get('users', [DashboardController::class, 'users']);
    Route::get('view-user/{id}', [DashboardController::class, 'viewuser']);



});
Route::get('/', [FrontendController::class, 'index']);

//kiểm tra tài khoản đã xác minh chưa
Auth::routes(['verify' => true]);
Route::middleware(['verified'])->group(function(){
    Route::get('/login', [LoginController::class, 'authenticated']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
});

?>

