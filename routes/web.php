<?php

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



Route::get('/', 'FrontController@index');

//產品頁面
Route::get('/products', 'FrontController@products');

Route::get('/productType/{id}', 'FrontController@products_type');
Route::get('/products/{id}', 'FrontController@products_detail');

//新聞頁面
Route::get('/news', 'FrontController@news');
Route::get('/news/{id}', 'FrontController@news_detail');

//購物車
Route::post('/addCart', 'CartController@addProductToCar'); //加入購物車ajax

Route::get('/cart', 'CartController@cart'); //結帳頁 - 更改數量
Route::post('/changeProductQty','CartController@changeProductQty'); //修改產品數量ajax
Route::post('/deleteProductInCart','CartController@deleteProductInCart'); //刪除在購物車的特定產品ajax

Route::get('cart_check_out','CartController@cart_check_out'); //結帳頁 - 填寫收件人資訊頁
Route::post('/send_check_out','CartController@send_check_out');

Route::get('/cart_success/{MerchantTradeNo}','CartController@cart_success');

Route::prefix('cart_ecpay')->group(function(){

    //當消費者付款完成後，綠界會將付款結果參數以幕後(Server POST)回傳到該網址。
    Route::post('notify', 'CartController@notifyUrl')->name('notify');

    //付款完成後，綠界會將付款結果參數以幕前(Client POST)回傳到該網址
    Route::post('return', 'CartController@returnUrl')->name('return');
});

// Auth::routes(['register' => false,'reset' => false,'verify' => false]);
Auth::routes();

//admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::get('/','AdminController@index');
    Route::post('/ajax_upload_img','AdminController@ajax_upload_img');
    Route::post('/ajax_delete_img','AdminController@ajax_delete_img');
    Route::post('/ajax_delete_product_imgs','AdminController@ajax_delete_product_imgs');
    Route::post('/ajax_sort_product_imgs','AdminController@ajax_sort_product_imgs');

    Route::get('product_type', 'ProductTypeController@index');
    Route::get('product_type/create', 'ProductTypeController@create');
    Route::post('product_type/store', 'ProductTypeController@store');
    Route::get('product_type/edit/{id}', 'ProductTypeController@edit');
    Route::post('product_type/update/{id}', 'ProductTypeController@update');
    Route::post('product_type/destroy/{id}', 'ProductTypeController@destroy');

    Route::get('product', 'ProductController@index');
    Route::get('product/create', 'ProductController@create');
    Route::post('product/store', 'ProductController@store');
    Route::get('product/edit/{id}', 'ProductController@edit');
    Route::post('product/update/{id}', 'ProductController@update');
    Route::post('product/destroy/{id}', 'ProductController@destroy');

    Route::get('news', 'NewsController@index');
    Route::get('news/create', 'NewsController@create');
    Route::post('news/store', 'NewsController@store');
    Route::get('news/edit/{id}', 'NewsController@edit');
    Route::post('news/update/{id}', 'NewsController@update');
    Route::post('news/destroy/{id}', 'NewsController@destroy');

    //訂單管理
    Route::get('order', 'OrderController@index'); //訂單總覽
    Route::get('order/show/{order_id}', 'OrderController@show'); //訂單詳細
    Route::post('order/changeStatus/{order_id}', 'OrderController@changeStatus'); //更改訂單狀態

    Route::get('order/select/{status}', 'OrderController@select'); //篩選訂單
    Route::post('order/destroy/{order_id}', 'OrderController@destroy'); //刪除訂單
});
