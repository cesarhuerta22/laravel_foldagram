<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => '/', function(){
    return View::make('home')->
        with('title', 'The Foldagram')->with('class', 'home');
}));

Route::get('/about', array('as' => 'about', function(){
    return View::make('about')->
        with('title', 'About Foldagram')->with('class', 'about');
}));

Route::post('/subscribe', array('as' => 'post_subscribe', function(){
    $input = Input::all();
    $rules = array('email' => 'required|email');
    
    $validation = Validator::make($input, $rules);
    
    if($validation->passes()){
        Subscribe::create($input);
        return Redirect::to('/')
            ->with('success', 'Thanks for signing UpFoldagram');
    }
    
    return Redirect::to('/')
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
}));

Route::post('create', array('as' => 'create', 'uses' => 'FoldagramsController@postCreate'));
Route::get('remove/{id}/{identifier}', 
    array('as' => 'remove', 'uses' => 'FoldagramsController@removeAddress'));

Route::get('register', array('as' => 'register', 'uses' => 'PagesController@getRegister'));
Route::post('register', array('as' => 'register_post', 'uses' => 'PagesController@postRegister'));

Route::get('login', array('as' => 'login', 'uses' => 'PagesController@getLogin'));
Route::post('login', array('as' => 'login_post', 'uses' => 'PagesController@postLogin'));
Route::get('logout', array('as' => 'logout', 'uses' => 'PagesController@getLogout'));

Route::get('myaccount', array('as' => 'myaccount', 'uses' => 'PagesController@myaccount'));
Route::post('myaccount/profile', array('as' => 'profile_post', 'uses' => 'PagesController@postProfile'));
Route::post('myaccount/changepass', array('as' => 'changepass_post', 'uses' => 'PagesController@postChangePassword'));

Route::get('cart', array('as' => 'cart', 'uses' => 'PagesController@getCart'));

Route::get('purchase/credit', array('as' => 'purchase', 'uses' => 'PagesController@getPurchaseCredit'));
Route::post('purchase/credit', array('as' => 'addtocredit', 'uses' => 'PagesController@postAddToCredit'));

Route::get('creategroup', array('as' => 'create_group', function(){
    try
    {
        $group = Sentry::createGroup(array(
            'name' => 'Administration',
            'permissions' => array(
                'read' => 1,
                'write' => 1
            )
        ));
    } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
        echo 'Name Field is required';
    } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
        echo 'Group already exists';
    }
}));

Route::get('checkgroup', array('as' => 'check_group', function(){
    try
    {
        $group = Sentry::findGroupByName('Administration');
    } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
        echo 'Group was not found';
    }
}));

Route::get('createadminuser', array('as' => 'create_admin_user', function(){
    try
    {
        $adminGroup = Sentry::findGroupByName('Administration');
        $user = Sentry::createUser(array(
            'email' => 'administrador@gmail.com',
            'password' => '123456'
        ));
        $user->addGroup($adminGroup);

    } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
        echo 'Password fields is required';
    } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
        echo 'User with this login already exists';
    } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
        echo 'Group was not found';
    }
}));

Route::get('admin/login', array('as' => 'admin_login', 'uses' => 'AdminController@getLogin'));

Route::post('admin/login', array('as' => 'admin_login_post', 'uses' => 'AdminController@postLogin'));

Route::group(array('before' => 'administration'), function() {
    Route::get('admin/orders', array('as' => 'orders', 'uses' => 'AdminController@getIndexOrders'));
    Route::get('admin/addcredit', array('as' => 'add_credit', 'uses' => 'AdminController@getAddCredit'));
    Route::post('admin/addcredit', array('as' => 'add_credit_post', 'uses' => 'AdminController@postAddCredit'));
    Route::get('admin/user', array('as' => 'user', 'uses' => 'AdminController@getIndexUser'));
    Route::get('admin/user/edit/{id}', array('as' => 'user_edit', 'uses' => 'AdminController@getUserEdit'));
    Route::post('admin/user/edit', array('as' => 'user_edit_post', 'uses' => 'AdminController@postUserEdit'));
    Route::get('admin/usercredit', array('as' => 'user_credit', 'uses' => 'CreditController@getUserCredit'));
    Route::post('admin/usercredit', array('as' => 'user_credit_post', 'uses' => 'CreditController@postUserCredit'));
    Route::get('admin/credit', array('as' => 'credit', 'uses' => 'CreditController@getIndex'));
    Route::get('admin/order/recipients/{id}', array('as' => 'order_recipient', 'uses' => 'AdminController@getRecipient'));

    Route::get('admin/order/details/{id}', array('as' => 'order_detail', 'uses' => 'AdminController@getDetail'));

    Route::get('admin/order/update/{id}', array('as' => 'order_update', 'uses' => 'AdminController@getUpdate'));
    Route::post('admin/order/update', array('as' => 'order_update_post', 'uses' => 'AdminController@postUpdate'));

    Route::get('admin/order/delete/{id}', array('as' => 'order_delete', 'uses' => 'AdminController@getDelete'));

    Route::get('admin/order/exported', array('as'=> 'order_exported', 'uses' => 'AdminController@getExported'));
});



