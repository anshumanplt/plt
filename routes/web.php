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

use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\InstagramController;

Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class ,'login'])->name('admin.login.submit');
    // Add other admin routes as needed
});

Route::middleware('auth:admin')->group(function () {

    Route::get('products/imports', [ProductController::class, 'importProduct'])->name('products.import');
    Route::post('products/imports', [ProductController::class, 'getcsvfile'])->name('products.import.upload.csv');


    // Route::get('dashboard', 'AdminDashboardController@index')->name('admin.dashboard');
    // Add other admin routes that require authentication

    Route::get('product-attributes/index/{sku}', [ProductAttributeController::class, 'index'])->name('product-attributes.index');

    Route::get('product-attributes/create/{id}', [ProductAttributeController::class, 'create'])->name('product-attributes.create');

    Route::post('product-attributes/store', [ProductAttributeController::class, 'store'])->name('product-attributes.store');

    Route::put('product-attributes/update/{id}', [ProductAttributeController::class, 'update'])->name('product-attributes.update');

    Route::get('product-attributes/show-images/{sku}/{productid}', [ProductAttributeController::class, 'showProductImages'])->name('product-attributes.showImages');

    Route::get('product-attributes/delete-images/{id}', [ProductAttributeController::class, 'deleteProductImages'])->name('product-attributes.deleteProductImages');

    Route::get('/get-attribute-values', [ProductAttributeController::class, 'getAttributeValues'])->name('get-attribute-values');

    Route::get('product-attributes/createAllvariation/{id}', [ProductAttributeController::class, 'createAllvariation'])->name('product-attributes.createAllvariation');

    Route::post('product-attributes/generatevariation', [ProductAttributeController::class, 'generatevariation'])->name('product-attributes.generatevariation');

    Route::get('product-attributes/create-selected-attribute/{id}', [ProductAttributeController::class, 'generatefinalvariationonselection'])->name('product-attributes.generatefinalvariationonselection');

    Route::get('product-attributes/select-attribute-value-for-product/{id}', [ProductAttributeController::class, 'selectattributeforproduct'])->name('product-attributes.selectattributeforproduct');

    // Add Admin Users

    // Route::resource('admin-users', [AdminUserController::class]);
    Route::get('admin-users', [AdminUserController::class, 'index'])->name('admin-users.index');
    Route::get('admin-users/create', [AdminUserController::class, 'create'])->name('admin-users.create');
    Route::post('admin-users/store', [AdminUserController::class, 'store'])->name('admin-users.store');
    Route::get('admin-users/show/{id}', [AdminUserController::class, 'show'])->name('admin-users.show');
    Route::get('admin-users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin-users.edit');
    Route::put('admin-users/update/{id}', [AdminUserController::class, 'update'])->name('admin-users.update');
    Route::post('admin-users/destroy/{id}', [AdminUserController::class, 'destroy'])->name('admin-users.destroy');

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
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admindashboard');

    Route::get('admin/orders', [OrderController::class, 'getallorders'])->name('allorders');
    Route::get('admin/orders/{order}', [OrderController::class, 'showadmin'])->name('admin.orders.show');
    Route::put('admin/orders/updatestatus/{order}', [OrderController::class, 'updatestatus'])->name('admin.orders.updatestatus');

    Route::get('admin/settings/homepage', [SettingController::class, 'homepage'])->name('admin.settings.homepage');
    Route::post('admin/settings/homepage/update', [SettingController::class, 'homepageupdate'])->name('admin.settings.homepage.update');
    Route::post('admin/settings/homepage/add-banner', [SettingController::class, 'addhomepagebanner'])->name('admin.settings.homepage.addbanner');
    Route::delete('admin/settings/homepage/delete-banner/{id}', [SettingController::class, 'bannerdestroy'])->name('admin.settings.homepage.removebanner');

    Route::post('admin/settings/promotional/slider', [SettingController::class, 'promotionalslider'])->name('admin.settings.promotional.slider');
    Route::get('admin/settings/promotional/slider/delete/{id}', [SettingController::class, 'promotionalsliderdelete'])->name('admin.settings.promotional.slider.delete');

    Route::post('admin/settings/promotional/banner', [SettingController::class, 'promotionalbanner'])->name('admin.settings.promotional.banner');
    Route::post('admin/settings/discount/banner', [SettingController::class, 'discountbanner'])->name('admin.settings.discount.banner');
});

Route::middleware(['auth'])->group(function () {
    // Add product to wishlist
    Route::get('/wishlist/add/{productId}', [WishlistController::class, 'addToWishlist'])
        ->name('wishlist.add');

    // Remove product from wishlist
    Route::get('/wishlist/remove/{wishlistId}', [WishlistController::class, 'removeFromWishlist'])
        ->name('wishlist.remove');

    Route::get('/wishlist', [WishlistController::class, 'index'])
    ->name('wishlist.index');

   

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/add-address', [CheckoutController::class, 'addAddress'])
        ->name('checkout.addAddress');

    // Place order
    Route::post('/orders/place-order', [OrderController::class, 'placeOrder'])->name('orders.place-order');
    // End place order

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    // Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    // Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // Route::put('/orders/{order}/update-state', [OrderController::class, 'updateState'])->name('orders.update-state');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    // Route::put('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');

    Route::get('/my-account', [OrderController::class, 'myaccount']);

});


// Route::get('/category/create-slug', [App\Http\Controllers\CategoryController::class,'create_slug']);

Route::get('/make-shipping-order', [OrderController::class, 'makeshippingorder'])->name('make.shipping.order');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
// Route::post('/payment/process/{orderid}', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/payment/fail', [PaymentController::class, 'paymentFail'])->name('payment.fail');

Route::get('/payment/process/{orderid}', [RazorpayController::class, 'createOrder'])->name('payment.process');
// Route::prefix('myaccount')->middleware('auth')->group(function () {
//     Route::get('dashboard', 'MyAccountController@dashboard')->name('myaccount.dashboard');
//     Route::get('orders', 'MyAccountController@orders')->name('myaccount.orders');
//     Route::get('profile', 'MyAccountController@profile')->name('myaccount.profile');
//     // Add more routes as needed
// });









Route::get('get-states/{country_id}', [StateController::class, 'getStates']);
Route::get('get-cities/{state_id}', [CityController::class, 'getCities']);
// Route::post('addresses/{id}/set-default', [CheckoutController::class, 'setDefaultAddress'])->name('addresses.set-default');
Route::post('addresses/set-default', [CheckoutController::class, 'setDefaultAddress'])->name('addresses.set-default');

Route::post('/notifyme', [App\Http\Controllers\FrontController::class, 'notifyme'])->name('notifyme');

Route::get('/search', [App\Http\Controllers\FrontController::class, 'search'])->name('search');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');
    
// Route::post('/ajaxcart/add/{product?}/{sku?}', [CartController::class, 'add'])
//     ->name('ajaxcart.add');

Route::get('/cart/add/{product?}/{sku?}', [CartController::class, 'add'])
    ->name('cart.add');

Route::put('/cart/update/{product}/{sku?}', [CartController::class, 'update'])
    ->name('cart.update');

Route::get('/cart/remove/{sku}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('home');
Route::get('/category/{slug}', [App\Http\Controllers\FrontController::class, 'category']);
Route::get('/product-detail/{slug}/{sku?}', [App\Http\Controllers\FrontController::class, 'product']);


// Static Pages

Route::get('/about-us', [App\Http\Controllers\FrontController::class, 'aboutus'])->name('aboutus');
Route::get('/contact-us', [App\Http\Controllers\FrontController::class, 'contactus'])->name('contactus');
Route::get('/privacy-policy', [App\Http\Controllers\FrontController::class, 'privacypolicy'])->name('privacypolicy');
Route::get('/terms-condition', [App\Http\Controllers\FrontController::class, 'termscondition'])->name('termscondition');
Route::get('/shipping-policy', [App\Http\Controllers\FrontController::class, 'shippingpolicy'])->name('shippingpolicy');
Route::get('/payment-policy', [App\Http\Controllers\FrontController::class, 'paymentpolicy'])->name('paymentpolicy');
Route::get('/dispute-resolution', [App\Http\Controllers\FrontController::class, 'disputeresolution'])->name('disputeresolution');
Route::get('/genuine-quality-product', [App\Http\Controllers\FrontController::class, 'genuinequalityproduct'])->name('genuinequalityproduct');
Route::post('/newsletter', [App\Http\Controllers\FrontController::class, 'newsletter'])->name('newsletter');

Route::get('instagram', [InstagramController::class, 'index']);
// End Static Pages

Route::get('/category-page', function () {
    return view('category');
});




// Route::get('/categories/{category}', [App\Http\Controllers\FrontController::class, 'category'])->name('category');





Auth::routes();


