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

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('products','ProductController');

Auth::routes();
//Login Via Facebook Authentication
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/email/verify-email/{token}', 'UserController@confirmEmail');
Route::post('/email/confirm-email', 'UserController@postConfirmEmail')->name('user.confirm.email.submit');

Route::prefix('user')->group(function (){

	//User Pages
	// Route::get('/profile/{id}', 'UserController@profile');
	// Route::get('/create_profile', 'UserController@createProfile');
	// Route::get('/profile/{id}/edit', 'UserController@editProfile');
	Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');
	// Route::post('/profile', 'UserController@saveProfile');
	// Route::put('/profile/{id}', ['as' => 'profile.update', 'uses' => 'UserController@updateProfile']);

	Route::get('/lists', 'UserController@lists');
	Route::get('/update-rank/{id}', 'UserController@updateRank');
	Route::post('/assignrank', 'UserController@postAssignRank');
	
	Route::get('/register-member', 'UserController@registrationMemberForm');
	Route::post('/register-member', 'UserController@registerMember');

    Route::get('/mykad-status-index', 'UserController@mykadStatusIndex');
    Route::get('/show-mykad-status/{id}', 'UserController@showMykadStatus');
    Route::put('/update-mykad-status', 'UserController@updateMykadStatus');
	
	Route::post('/logout', 'Auth\LoginController@userLogout')->name('users.logout');
	Route::get('/{id}/edit', 'UserController@edit')->name('user.edit');
  	Route::put('/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
  	Route::get('/', 'UserController@index');
});

Route::prefix('admin')->group(function (){
	//Login & Logout routes
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

	//Password reset routes
	Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');


	Route::get('/register-member', 'AdminController@registrationMemberForm');
  	Route::post('/register-member', 'AdminController@registerMember');

  	Route::get('admin/firstTimePurchaseRegistration', 'AdminController@firstTimePurchaseRegistration');

  Route::get('/register-staff', 'AdminController@registrationStaffForm');
  Route::post('/register-staff', 'AdminController@registerStaff');

	//Admin Panel Pages Route 
	// Route::get('/profile/{id}', 'AdminController@profile');
	// Route::get('/create-profile', 'AdminController@createProfile');
	// Route::get('/profile/{id}/edit', 'AdminController@editProfile');
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
	// Route::post('/profile', 'AdminController@saveProfile');
	// Route::put('/profile/{id}', ['as' => 'profile.update', 'uses' => 'AdminController@updateProfile']);
	Route::get('{id}/edit', 'AdminController@edit');
	Route::put('/update/{id}', 'AdminController@update')->name('admin.update');
	// Route::put('/update/{id}', ['as' => 'admin.update', 'uses' => 'AdminController@update']);
	Route::get('/assignrole', 'AdminController@assignRole');
	Route::post('/assignrole', 'AdminController@postAssignRole')->name('admin.assign.role');
	Route::get('/revokerole/{id}', 'AdminController@revokeRole');
	Route::post('/revokerole', 'AdminController@postRevokeRole');
	Route::get('/lists', 'AdminController@index');
});

//Route::resource('accounts', 'AccountController');
Route::get('mywallet', 'WalletController@mywallet');

//UserTree Route
Route::get('/referrals/hierarchy/{id}', 'ReferralController@getHierarchy');
Route::get('/referrals/my-downline', 'ReferralController@getDownline');
Route::get('/register-member', 'UserController@registrationMemberForm');
Route::get('/change-email', 'UserController@changeEmail');
Route::post('/change-email', 'UserController@postChangeEmail');
//Route::get('/user', 'UserController@index');

/*
======================================================================================
 Wallet  
======================================================================================
*/
Route::get('wallet/mywallet', 'WalletController@mywallet');
/*
======================================================================================
 End Wallet  
======================================================================================
*/

/*
======================================================================================
 Product
======================================================================================
*/
Route::resource('products', 'ProductController');
// Route::get('products', 'ProductController@index');
// Route::get('products/{id}/edit', 'ProductController@edit');
// Route::delete('products')
/*
======================================================================================
 End Product
======================================================================================
*/

/*
======================================================================================
 Shop 
======================================================================================
*/
Route::get('shop/skg-mall', 'ShopController@skgMall');
Route::get('shop/agents', 'ShopController@agentsStoreList');
Route::get('shop/agent-store/{id}', 'ShopController@agentStore');

Route::post('shop/addToCart', 'ShopController@addToCart');
Route::put('shop/cart/update/{id}', 'ShopController@updateCart')->name('update.cart');
Route::get('shop/cart', 'ShopController@cart');
Route::get('shop/cart/{id}', 'ShopController@agentStoreCart');
Route::get('shop/checkout', 'ShopController@checkout');
Route::get('shop/emptyCart', 'ShopController@emptyCart');


/*
======================================================================================
 End Shop  
======================================================================================
*/

/*
======================================================================================
 Payments
======================================================================================
*/
//Courier Page
Route::get('payments', 'OrderController@index');
Route::post('payments/options', 'PaymentController@options');
Route::get('payments/cash', 'PaymentController@cash');
Route::post('payments/postPayCash', 'PaymentController@postPayCash');
Route::get('payments/paypal', 'PaymentController@paypal');
Route::get('payments/credit_debit_card', 'PaymentController@creditDebitCard');
Route::get('payments/ewallet', 'PaymentController@ewallet');

//Route::put('shop/{id}', ['as' => 'shop.update', 'uses' => 'ShopController@update']);


/*
======================================================================================
 End Payments
========================================

/*
======================================================================================
 Invoices  
======================================================================================
*/

Route::get('invoices/my-customer-invoices/{id}', 'InvoiceController@getAllCustomerInvoices');
Route::get('invoices/my-customer/{id}', 'InvoiceController@showCustomerInvoice');
Route::get('invoices/my-invoices', 'InvoiceController@myInvoices');
Route::get('invoices/{id}', 'InvoiceController@show');
Route::get('invoices', 'InvoiceController@index');
//Route::put('shop/{id}', ['as' => 'shop.update', 'uses' => 'ShopController@update']);

/*
======================================================================================
 End Invoices  
======================================================================================
*/

/*
======================================================================================
Vendor
======================================================================================
*/
Route::get('suppliers', 'SupplierController@index');
Route::get('suppliers/create', 'SupplierController@create');
Route::get('suppliers/{id}/personnels-list', 'SupplierController@getPersonnels');
Route::get('suppliers/{id}/addPersonnel', 'SupplierController@addPersonnel');
Route::post('suppliers/addPersonnel', 'SupplierController@postAddPersonnel');
Route::post('suppliers', 'SupplierController@store');
Route::put('suppliers/{id}', ['as' => 'suppliers.update', 'uses' => 'SupplierController@update']);
Route::put('suppliers/personnel/{id}', ['as' => 'suppliers.personnel.update', 'uses' => 'SupplierController@updatePersonnel']);
/*
======================================================================================
End Vendor
======================================================================================
*/

/*
======================================================================================
 Orders  
======================================================================================
*/
//Courier Page
Route::get('orders/process/{id}', 'OrderController@processOrder');
Route::get('orders/my-orders', 'OrderController@myOrders');
Route::post('orders/postProcessOrder', 'OrderController@postProcessOrder');
Route::get('orders/{id}', 'OrderController@show');
Route::get('orders', 'OrderController@index');
//Route::put('shop/{id}', ['as' => 'shop.update', 'uses' => 'ShopController@update']);


/*
======================================================================================
 End Orders  
======================================================================================
*/

/*
======================================================================================
 Bonus
======================================================================================
*/
Route::get('bonus', 'BonusController@index');
Route::get('bonus/bonus-types', 'BonusController@bonusType');
Route::get('bonus/add-bonus-types', 'BonusController@addBonusType');
Route::get('bonus/history', 'BonusController@history');
Route::get('bonus/my-bonus-history/{id}', 'BonusController@my_bonus_history');
Route::get('bonus/show-bonus-summary/{id}', 'BonusController@showBonusSummary');
Route::get('bonus/{id}/edit-bonus-type', 'BonusController@editBonusType');
Route::put('bonus_types/{id}', ['as' => 'bonus_types.update', 'uses' => 'BonusController@updateBonusType']);

Route::get('bonus/statement/{id}', 'BonusController@bonusStatement');
Route::get('bonus/details/{id}', 'BonusController@bonusDetails');
Route::get('bonus/calculate-end-month-bonus', 'BonusController@calculate_end_month_bonus');
/*
======================================================================================
 End Bonus
======================================================================================
*/



/*
======================================================================================
 Profile
======================================================================================
*/
Route::get('profile/create', 'ProfileController@create');
Route::get('profile/{id}/edit', 'ProfileController@edit');
Route::get('user/profile/{id}', 'ProfileController@show');
Route::get('admin/profile/{id}', 'ProfileController@showAdmin');


Route::get('profile/upload-avatar', 'ProfileController@uploadAvatar');
Route::post('profile/upload-avatar', 'ProfileController@postUploadAvatar');

Route::get('profile/upload-ic', 'ProfileController@uploadIc');
Route::post('profile/upload-ic', 'ProfileController@postUploadIc')->name('upload.ic.post');
Route::get('profile/ic-status-index', 'ProfileController@icStatusIndex');
Route::get('profile/show-ic/{id}', 'ProfileController@showIcStatus');
Route::put('profile/update-ic-status', 'ProfileController@updateIcStatus')->name('profile.update-ic-status');
Route::put('profile/{id}', 'ProfileController@update')->name('profile.update');
Route::post('profile', 'ProfileController@store');

/*
======================================================================================
 End Profile
======================================================================================
*/

/*
======================================================================================
 Reports
======================================================================================
*/
Route::get('reports/members', 'ReportController@members')->name('members.report');
Route::get('reports/sales/bymonth/{month}/{year}', 'ReportController@salesByMonthYear');
Route::get('reports/sales', 'ReportController@sales')->name('sales.report');
Route::get('reports/bonuses', 'ReportController@bonuses')->name('bonuses.report');
Route::get('reports/stocks', 'ReportController@stocks')->name('stocks.report');
/*
======================================================================================
 End Reports
======================================================================================
*/

/*
======================================================================================
 Reports
======================================================================================
*/
Route::get('banks', 'BankController@index');
Route::get('banks/create', 'BankController@create')->name('banks.create');
Route::get('banks/{id}/edit', 'BankController@edit');
Route::post('bank', 'BankController@store');
Route::put('banks/{id}', 'BankController@update');

/*
======================================================================================
 End Reports
======================================================================================
*/
