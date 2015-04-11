<?php

class PagesController extends BaseController {

	public function getRegister()
	{
		if(Sentry::check()) {
			return Redirect::route('myaccount');
		}
		return View::make('user.register')
		->with('title','Tha Fodagram - Register')
		->with('page_title','Register')
		->with('class','register');
	}

	public function postRegister()
	{
		$rules = array(
			'first_name' => 'required|min:2',
			'last_name' => 'required|min:2',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required|same:password'
		);

		$input = Input::all();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('register')
			->withInput(Input::except('password','password_confirmation'))
			->withErrors($validation);
		} else {
			$user = Sentry::createUser(array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'first_name' => Input::get('first_name'),
				'last_name' => Input::get('last_name'),
				'activated' => 1
			));

			return Redirect::route('/');
		}
	}

	public function getLogin()
	{
		if(Sentry::check()) {
			return Redirect::route('myaccount');
		}

		return View::make('pages.login')
		->with('title','The Foldagram - Login')
		->with('page_title','Login')
		->with('class','login');
	} 

	public function postLogin()
	{
		$rules = array(
			'email' => 'required|email|exists:users,email',
			'password' => 'required'
		);

		$input = Input::all();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('login')
			->withErrors($validation->errors()->first())
			->withInput();
		} else {
			try {
				$credenciales = array(
					'email' => Input::get('email'),
					'password' => Input::get('password')
				);

				$user = Sentry::authenticate($credenciales, false);
				return Redirect::route('myaccount'); 
			} catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
				return Redirect::route('login')
				-> withInput(Input::except('password'))
				->with('error','Login field is required.');
			} catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
				return Redirect::route('login')
				-> withInput(Input::except('password'))
				->with('error','Password field is required.');
			} catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
				return Redirect::route('login')
				-> withInput(Input::except('password'))
				->with('error','Wrong password, try again.');
			} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
				return Redirect::route('login')
				-> withInput(Input::except('password'))
				->with('error','User was not found.');
			} catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
				return Redirect::route('login')
				-> withInput(Input::except('password'))
				->with('error','User is not activated.');
			}
			
		}
	}

	public function myaccount()
	{
		if(!Sentry::check()) {
			return Redirect::route('login')
			->with('error', 'No se puede acceder a la cuenta!');
		}

		$user = Sentry::getUser();

		return View::make('pages.myaccount')
		->with('title', 'The Foladagram - My Account')
		->with('page_title', 'My Account')
		->with('class', 'myaccount')
		->with('user', $user);
	}

	public function postProfile()
	{
		$user = Sentry::getUser();
		$rules = array(
			'email' => 'required|email|unique:users,email,'.$user['id']
		);

		$input = Input::get();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('myaccount')
			->withInput()
			->withErrors($validation);
		}

		$user_data = array(
			'email' => Input::get('email'),
			'first_name' => Input::get('first_name'),
			'last_name' => Input::get('last_name')
		);

		if($user->update($user_data)) {
			return Redirect::route('myaccount')
			->with('success', 'Tu informacion ya ha sido actualizada satisfactoriamente!');
		} else {
			return Redirect::route('myaccount')
			->with('erro', 'Tu informacion no ha podido ser actualizada');
		}
	}

	public function postChangePassword()
	{
		$rules = array(
			'old_password' => 'required',
			'password' => 'required|different:old_password|confirmed',
			'password_confirmation' => 'required|same:password'
		);

		$input = Input::get();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('myaccount')
			->withInput()
			->withErrors($validation);
		}
		try {
			$user = Sentry::getUser();
			if($user->change_password(Input::get('password'),Input::get('old_password'))) {
				return Redirect::route('myaccount')
				->with('success', 'Tu password se ha actualizado satisfactoriamente');
			} else {
				return Redirect::route('myaccount')
				->with('error', 'Tu password no se ha podido actualizar!');
			}
		} catch (Exception $e){
			return Redirect::route('/')
			->withErrors(array('login' => $e->getMessage()));
		}
	}

	public function getLogout()
	{
		Sentry::logout();

		return Redirect::route('/')
		->with('success','Usted salio satisfactoriamente de su cuenta');
	}

	public function getCart()
	{
		$cart_contents = UserCreditOrders::all();

		return View::make('pages.cart')
		->with('cart_contents', $cart_contents)
		->with('title', 'The Foldagram - Cart')
		->with('page_title', 'Cart')
		->with('class', 'cart');
	}

	public function checkout()
	{
		$order = new Order;
		$cart_contents = UserCreditOrders::all();
		foreach ( $cart_contents as $item) {
			$order->qty = $item['qty'];
			$order->price = $item['price'];
		}

		$order->foldaram_id =Input::get('foldagram_id');
		$order->email = Input::get('email');
		$order->fullname = Input::get('fullname');
		$order->country = Input::get('country');
		$order->address_one = Input::get('address_one');
		$order->address_two = Input::get('address_two');
		$order->city = Input::get('city');
		$order->state = Input::get('state');
		$order->zipcode = Input::get('zipcode');

		$total_amount = Cart::total();

		$response = Stripe_Charge::create(array(
			"amount" =>$total_amount,
			"currency" => "usd",
			"card" => Input::get('stripeToken') ,
			"description" => "Foldagram Payment"
		));

		if($response->paid) {
			$order_data = Order::find($order->original['id']);
			$order_data->transection_id = $response->id;
			$order_data->status = 1;
			$order_data->save();

			$foldagram_data = Foldagram::find(Input::get('foldagram_id'));
			$foldagram_data->status = 2;
			$foldagram_data->user_id = $user;
			$foldagram_data->save();

			$foldagram_data->destroy();

			$userdata = Sentry::user(intval($user));
		}
	}

	public function getPurchaseCredit() 
	{
		$credit = Credits::all();

		return View::make("pages.purchase_credit")
		->with("title","The Foldagram - Purchase Credit")
		->with("page_title","Purchase Credit")
		->with('class','pcredit')
		->with('credit', $credit);
	}

	public function postAddToCredit()
	{
		$rules = array(
			'qty' => 'required',
			'price' => 'required'
		);

		$input = Input::all();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('purchase')
			->withInput()
			->withErrors($validation);
		} else {
			$create = UserCreditOrders::create(array(
				'qty' => Input::get('qty'),
				'price' => Input::get('price')
			));

			return Redirect::route('cart');
		}
	}
}