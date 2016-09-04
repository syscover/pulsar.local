<?php

Route::group(['middleware' => ['pulsar.navTools']], function () {

    Route::get('/',                                                                         ['as'=>'home',                      'uses'	=> '\App\Http\Controllers\WebFrontendController@home']);
    Route::get('/es',                                                                       ['as'=>'home-es',                   'uses'	=> '\App\Http\Controllers\WebFrontendController@home']);
    Route::get('/en',                                                                       ['as'=>'home-en',                   'uses'	=> '\App\Http\Controllers\WebFrontendController@home']);

    // CUSTOMER ACCOUNT
    // EN
    Route::get('/en/account/login',                                                         ['as'=>'getLogin-en',               'uses'	=> '\App\Http\Controllers\CustomerFrontendController@getLogin']);
    Route::get('/en/account/sing-in',                                                       ['as'=>'getSingIn-en',              'uses'	=> '\App\Http\Controllers\CustomerFrontendController@getSingIn']);
    Route::post('/en/account/sing-in',                                                      ['as'=>'postSingIn-en',             'uses'	=> '\App\Http\Controllers\CustomerFrontendController@postSingIn']);
    Route::put('/en/account/sing-in',                                                       ['as'=>'putSingIn-en',              'uses'	=> '\App\Http\Controllers\CustomerFrontendController@putSingIn']);

    // ES
    Route::get('/es/cuenta/login',                                                          ['as'=>'getLogin-es',               'uses'	=> '\App\Http\Controllers\CustomerFrontendController@getLogin']);
    Route::get('/es/cuenta/registro',                                                       ['as'=>'getSingIn-es',              'uses'	=> '\App\Http\Controllers\CustomerFrontendController@getSingIn']);
    Route::post('/es/cuenta/registro',                                                      ['as'=>'postSingIn-es',             'uses'	=> '\App\Http\Controllers\CustomerFrontendController@postSingIn']);
    Route::put('/es/cuenta/registro',                                                       ['as'=>'putSingIn-es',              'uses'	=> '\App\Http\Controllers\CustomerFrontendController@putSingIn']);

    Route::post('/en/account/login/',                                                       ['as' => 'postLogin',           'uses' => '\App\Http\Controllers\CustomerFrontendController@postLogin']);

    // SHOPPING CART
    // EN
    Route::get('/en/shopping/cart',                                                         ['as'=>'getShoppingCart-en',        'uses'	=> '\App\Http\Controllers\ShoppingCartController@getShoppingCart']);
    Route::match(['get', 'post'], '/en/shopping/cart/add/product/{slug}',                   ['as'=>'postShoppingCart-en',       'uses'	=> '\App\Http\Controllers\ShoppingCartController@postShoppingCart']);
    Route::match(['get', 'post'], '/en/shopping/cart/delete/product/{rowId}',               ['as'=>'deleteShoppingCart-en',     'uses'	=> '\App\Http\Controllers\ShoppingCartController@deleteShoppingCart']);
    Route::put('/en/shopping/cart/update',                                                  ['as'=>'putShoppingCart-en',        'uses'	=> '\App\Http\Controllers\ShoppingCartController@putShoppingCart']);
    Route::post('/en/shopping/cart/check/coupon/code',                                      ['as'=>'checkCouponCode-en',        'uses'	=> '\App\Http\Controllers\ShoppingCartController@checkCouponCode']);

    // ES
    Route::get('/es/carro/de/compra',                                                       ['as'=>'getShoppingCart-es',        'uses'	=> '\App\Http\Controllers\ShoppingCartController@getShoppingCart']);
    Route::match(['get', 'post'], '/es/carro/de/compra/anadir/producto/{slug}',             ['as'=>'postShoppingCart-es',       'uses'	=> '\App\Http\Controllers\ShoppingCartController@postShoppingCart']);
    Route::match(['get', 'post'], '/es/carro/de/compra/borrar/producto/{rowId}',            ['as'=>'deleteShoppingCart-es',     'uses'	=> '\App\Http\Controllers\ShoppingCartController@deleteShoppingCart']);
    Route::put('/es/carro/de/comprar/actualizar',                                           ['as'=>'putShoppingCart-es',        'uses'	=> '\App\Http\Controllers\ShoppingCartController@putShoppingCart']);
    Route::post('/es/carro/de/comprar/comprueba/codigo/cupon',                              ['as'=>'checkCouponCode-es',        'uses'	=> '\App\Http\Controllers\ShoppingCartController@checkCouponCode']);

    // FACTURA DIRECTA
    // EN
    Route::get('/en/factura/directa/clients',                                               ['as'=>'facturaDirectaClients-en',  'uses'	=> '\App\Http\Controllers\FacturaDirectaController@getClients']);

    // ES
    Route::get('/es/factura/directa/clientes',                                              ['as'=>'facturaDirectaClients-es',  'uses'	=> '\App\Http\Controllers\FacturaDirectaController@getClients']);
});

// Route with pulsar.taxRule, this instance taxCountry and taxCustomerClass from data customer loged,
// necessary to show tax products according to the customer.
Route::group(['middleware' => ['pulsar.navTools', 'pulsar.taxRule']], function () {

    // MARKET ROUTES
    // EN
    Route::get('/en/product/list',                                                          ['as'=>'productList-en',            'uses'	=> '\App\Http\Controllers\MarketFrontendController@getProductsList']);
    Route::get('/en/product/{category}/{slug}',                                             ['as'=>'product-en',                'uses'	=> '\App\Http\Controllers\MarketFrontendController@getProduct']);

    // ES
    Route::get('/es/producto/listado',                                                      ['as'=>'productList-es',            'uses'	=> '\App\Http\Controllers\MarketFrontendController@getProductsList']);
    Route::get('/es/producto/{category}/{slug}',                                            ['as'=>'product-es',                'uses'	=> '\App\Http\Controllers\MarketFrontendController@getProduct']);
});

Route::group(['middleware' => ['pulsar.navTools', 'pulsar.web.auth:crm']], function() {

    // CUSTOMER ACCOUNT
    // EN
    Route::match(['get', 'post'], '/en/account',                                            ['as'=>'account-en',                'uses'	=> '\App\Http\Controllers\CustomerFrontendController@account']);
    Route::match(['get', 'post'], '/en/account/logout',                                     ['as'=>'logout-en',                 'uses'	=> '\App\Http\Controllers\CustomerFrontendController@logout']);

    // ES
    Route::match(['get', 'post'], '/es/cuenta',                                             ['as'=>'account-es',                'uses'	=> '\App\Http\Controllers\CustomerFrontendController@account']);
    Route::match(['get', 'post'], '/es/cuenta/logout',                                      ['as'=>'logout-es',                 'uses'	=> '\App\Http\Controllers\CustomerFrontendController@logout']);

    // CHECKOUT
    // EN
    Route::get('/en/checkout/shipping',                                                     ['as'=>'getCheckout01-en',          'uses'	=> '\App\Http\Controllers\MarketFrontendController@getCheckout01']);
    Route::post('/en/checkout/shipping',                                                    ['as'=>'postCheckout01-en',         'uses'	=> '\App\Http\Controllers\MarketFrontendController@postCheckout01']);
    Route::get('/en/checkout/invoice',                                                      ['as'=>'getCheckout02-en',          'uses'	=> '\App\Http\Controllers\MarketFrontendController@getCheckout02']);
    Route::post('/en/checkout/invoice',                                                     ['as'=>'postCheckout02-en',         'uses'	=> '\App\Http\Controllers\MarketFrontendController@postCheckout02']);
    Route::get('/en/checkout/payment',                                                      ['as'=>'getCheckout03-en',          'uses'	=> '\App\Http\Controllers\MarketFrontendController@getCheckout03']);
    Route::post('/en/checkout/payment',                                                     ['as'=>'postCheckout03-en',         'uses'	=> '\App\Http\Controllers\MarketFrontendController@postCheckout03']);

    // ES
    Route::get('/es/realizar/pedido/envio',                                                 ['as'=>'getCheckout01-es',          'uses'	=> '\App\Http\Controllers\MarketFrontendController@getCheckout01']);
    Route::post('/es/realizar/pedido/envio',                                                ['as'=>'postCheckout01-es',         'uses'	=> '\App\Http\Controllers\MarketFrontendController@postCheckout01']);
    Route::get('/es/realizar/pedido/factura',                                               ['as'=>'getCheckout02-es',          'uses'	=> '\App\Http\Controllers\MarketFrontendController@getCheckout02']);
    Route::post('/es/realizar/pedido/factura',                                              ['as'=>'postCheckout02-es',         'uses'	=> '\App\Http\Controllers\MarketFrontendController@postCheckout02']);
    Route::get('/es/realizar/pedido/pago',                                                  ['as'=>'getCheckout03-es',          'uses'	=> '\App\Http\Controllers\MarketFrontendController@getCheckout03']);
    Route::post('/es/realizar/pedido/pago',                                                 ['as'=>'postCheckout03-es',         'uses'	=> '\App\Http\Controllers\MarketFrontendController@postCheckout03']);
});

Route::group(['middleware' => ['noCsrWeb']], function() {

    /* REDSYS */
    Route::get('/redsys/payment/response/successful',                                       ['as' => 'redsysPaymentResponseSuccessful',     'uses'	=> '\App\Http\Controllers\MarketFrontendController@redsysPaymentResponseSuccessful']);
    Route::get('/redsys/payment/response/failure',                                          ['as' => 'redsysPaymentResponseFailure',        'uses'	=> '\App\Http\Controllers\MarketFrontendController@redsysPaymentResponseFailure']);

    /* GOOGLE SEARCH ENGINE */
    Route::get('/search/engine',                                                            ['as' => 'searchEngine',              function(){ return view('www.content.google_search_engine');}]);

    /* REDSYS */
    Route::post('/redsys/payment/response',                                                 ['as'=>'redsysPaymentResponse',     'uses'	=> '\App\Http\Controllers\MarketFrontendController@redsysPaymentResponse']);
});

/* PAYPAL */
Route::post('/paypal/payment/response/successful',                                          ['as' => 'payPalPaymentResponseSuccessful',     'uses'	=> '\App\Http\Controllers\MarketFrontendController@payPalPaymentResponseSuccessful']);
Route::get('/paypal/payment/response/failure',                                              ['as' => 'payPalPaymentResponseFailure',        'uses'	=> '\App\Http\Controllers\MarketFrontendController@payPalPaymentResponseFailure']);