<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('frontendhome');
// });

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('home');


Route::get('/category-page', function () {
    return view('category');
});

Route::get('/product-detail', function () {
    return view('product_detail');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checkout', function () {
    return view('checkout');
});
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;

Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::resource('brands', App\Http\Controllers\BrandsController::class);
Route::resource('attributes', App\Http\Controllers\AttributeController::class);

Route::resource('attribute_values', App\Http\Controllers\AttributeValueController::class);
Route::resource('products', App\Http\Controllers\ProductController::class);

Route::post('products/get-subcategories', [ProductController::class, 'getSubcategories'])->name('products.getSubcategories');

Route::resource('products.images', ProductImageController::class)
->parameters([
    'images' => 'productImage' // Optional: Customize the URL parameter name
]);

Route::get('/hot-trends', [App\Http\Controllers\FrontController::class, 'hotTrends'])->name('hot-trends');
Route::get('/bestsellers', [App\Http\Controllers\FrontController::class, 'bestsellers'])->name('bestsellers');
Route::get('/featured-products', [App\Http\Controllers\FrontController::class, 'featuredProducts'])->name('featured-products');

Route::get('products/images/feature/{productId}/{imageId}', [ProductImageController::class, 'updateFeatureImage']);
// Route::get('/categories/{category}', [App\Http\Controllers\FrontController::class, 'category'])->name('category');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
