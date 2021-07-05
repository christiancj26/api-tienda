<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Buyers*/
Route::get('/user', function () {
    return response()->json(request()->user());
})->middleware('auth:api');

Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show', 'update']]);
Route::resource('buyers.sales', 'Buyer\BuyerSaleController', ['only' => ['index','store']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);
Route::resource('buyers.sales.notifications', 'Buyer\BuyerSaleNotificationController', ['only' => ['index']]);

/*Sales*/
Route::resource('sales', 'Sale\SaleController', ['only' => ['index','show', 'update']]);
Route::resource('sales.transactions', 'Sale\SaleTransactionController', ['only' => ['index']]);
Route::delete('sales/{id}/restores', 'Sale\SaleRestoreController@restore');
Route::get('sales-by-status', 'Sale\SaleController@byStatus');
Route::resource('sales.invoices', 'Sale\SaleInvoiceController', ['only' => ['index','show']]);
Route::resource('sales.receipts', 'Sale\SaleReceiptController', ['only' => ['index','show']]);
Route::get('sales/{id}/receipt/pdf', 'Sale\SaleReceiptController@getLinkPdf')->name('sales.receipts.pdf');


/*Categories*/
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
Route::resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);
Route::get('categories-group-products', 'Category\CategoryController@groupProducts');
/*types*/
Route::resource('types', 'Type\TypeController', ['only' => ['index', 'show']]);
/*Sizes*/
Route::resource('sizes', 'Size\SizeController', ['only' => ['index', 'show']]);
/*brands*/
Route::resource('brands', 'Brand\BrandController', ['only' => ['index', 'show']]);
/*Products*/
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show', 'ramdon']]);
Route::get('products-ramdon', 'Product\ProductController@ramdon');
Route::resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);
Route::resource('products.sales.transactions', 'Product\ProductSaleTransactionController', ['only' => ['store']]);
Route::resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
Route::resource('products.categories', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy']]);
Route::get('products-best-seller', 'Product\ProductController@show_best_seller');
/*Transactions*/
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);

/*Sellers*/
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]);
/*Users*/
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('users.profiles', 'User\UserProfileController', ['only' => ['index', 'store']]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');

/*Profiles*/
Route::resource('profiles', 'Profile\ProfileController', ['except' => ['create', 'edit']]);

/*gastos de envio*/
Route::resource('shipping-cost', 'ShippingCost\shippingCostController', ['omly' => ['index']]);

//notificaciones
Route::get('notifications', 'Notification\NotificationController@index');
Route::get('notifications/{id}', 'Notification\NotificationController@read');
Route::get('unread-notifications', 'Notification\NotificationController@unreadNotifications');



Route::post('/login', 'AuthController@login');
Route::post('/login-client', 'AuthController@loginClient');
Route::post('/admin-login', 'AuthController@adminLogin');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
