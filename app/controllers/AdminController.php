<?php

class AdminController extends BaseController {

	public function getLogin()
	{
		if(Sentry::check()){
			return Redirect::route('orders');
		}
		return View::make('layouts.login')
		->with('title', 'Foldagram - Admin');
	}

	public function postLogin()
	{
		$rules = array(
			'username' => 'required|email',
			'password' => 'required'
		);

		$input = Input::get();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('admin_login')
			->withErrors($validation)
			->withInput()
			->with('title', 'The Foldagram - Admin');
		}

		try
		{
			$credenciales = array(
				'email' => Input::get('username'),
				'password' => Input::get('password')
			);

			$user = Sentry::authenticate($credenciales, false);
			if(Sentry::check()) {
				$admin = Sentry::findGroupByName('Administration');
				if($user->inGroup($admin)) {
					return Redirect::route('orders');
				} else {
					return Redirect::route('admin_login')->withInput();
				}
			}
		} catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
	     	return Redirect::route('admin_login', $id)
	     	->withInput()
	     	->with('message', 'Password field is required');
	    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
	    	return Redirect::route('admin_login', $id)
	    	->withInput()
	    	->with('message', 'User is not found in database');
	    }
	}

	public function getIndexOrders()
	{
		$orders = DB::table('users')
		->rightJoin('foldagrams', 'users.id', '=', 'foldagrams.user_id')
		->orderBy('foldagrams.created_at','DESC')
		->groupBy('foldagrams.id')
		->get();

		return View::make('admin.manage_orders')
		->with('title','Foldagram - Admin')
		->with("page_title","Manage Order")
		->with('orders',$orders)
		->with('class','orders');
	}

	public function getRecipient($id)
	{
		$reff = DB::table('recipients')->where('foldagram_id', '=', $id)->get();

		return View::make('admin.view_recipient')
		->with('title', 'Foldagram - Admin')
		->with('page_title', 'List of Recipient')
		->with('reff', $reff);
	}

	public function getDetail($id)
	{
		$order_detail = UserCreditOrders::where('transection_id', '=', $id)->first();

		return View::make('admin.view_order_detail')
		->with('title', 'Foldagram - Admin')
		->with('page_title', 'List of Recipient')
		->with('order_detail', $order_detail);
	}

	public function getUpdate($id)
	{
		if(!empty($id)) {

			$foldagram = Foldagram::find($id);

			return View::make('admin.update_status')
			->with('title', 'Foldagram - Admin')
			->with('page_title', 'List of Recipient')
			->with('foldagram', $foldagram);
		} else {
			return Redirect::route('orders');
		}
	}

	public function postUpdate()
	{
		$foldagram = Foldagram::find(Input::get('id'));
		$foldagram->status = Input::get('status');

		if($foldagram->save()) {
			return Redirect::route('orders')
			->with('success', 'Foldagram order has been atatus update successfully');
		}
	}

	public function getDelete($id)
	{
		if(!empty($id)) {

			$foldagram = Foldagram::find($id)->delete();
			$recipient = Recipient::where('foldagram_id', '=', $id)->delete();
			$usercreditorders = UserCreditOrders::where('transection_id', '=', $id)->delete();

			if($foldagram) {
				return Redirect::route('orders')
				->with('success','Foldagram order has been deleted successfully.');
			} else {
				return Redirect::route('orders')
				->with('error','Order not deleted, please try again.');
			}
		} else {
			return Redirect::route('orders')
			->with('error','Order not deleted, please try again.');
		}
	}

	public function getExported()
	{
		$output = Foldagram::all();

		$file = fopen('dummy/path/file.csv', 'w');
		foreach ($output as $row) {
			fputcsv($file, explode(',',$row));
		}
		fclose($file);

		return Redirect::route('orders');
	}

	public function getAddCredit()
	{
		return View::make('admin.add_credit')
		->with('title', 'Foldagram - Admin')
		->with('page_title', 'Add Price');
	}

	public function postAddCredit()
	{
		$rules = array(
			'rfrom' => 'required|email',
			'rto' => 'required|numeric',
			'price' => 'required|numeric'
		);

		$input = Input::all();
		$validation = Validator::make($input, $rules);

		if($validation->passes()) {		
			$credit = new Credits();

			$credit->rfrom = Input::get('rfrom');
			$credit->rto = Input::get('rto');
			$credit->price = Input::get('price');

			if($credit->save()) {
				return Redirect::route('orders')
				->with('success','Price has been added successfully');
			} else {
				return Redirect::route('add_credit');
			}
		} else {
			return Redirect::route('add_credit');
		}
	}

	public function getIndexUser()
	{
		$users = DB::table('users')->paginate(5);
		$pager = $users->links();

		return View::make('admin.manage_users')
		->with('title', 'Foldagram - Admin')
		->with('page_title', 'Manage User')
		->with('users', $users)
		->with('pager', $pager);
	}

	public function getUserEdit($id)
	{
		$user = Sentry::findUserById($id);

		return View::make('admin.user_edit')
		->with('title', 'Foldagram - Admin')
		->with('page_title', 'User Edit')
		->with('user', $user);
	}

	public function postUserEdit()
	{
		$user = Sentry::getUser();
		$rules = array(
			'email' => 'required|email|unique:users,email,'.$user['id']
		);

		$input = Input::all();
		$validation = Validator::make($input, $rules);

		if($validation->fails()) {
			return Redirect::route('user_edit', $user->id)
			->withInput()
			->withErrors($validation);
		}

		$user_data = array(
			'email' => Input::get('email'),
			'first_name' => Input::get('first_name'),
			'last_name' => Input::get('last_name')
		);

		if($user->update($user_data)) {
			return Redirect::route('user')
			->with('success', 'Tu informacion ya ha sido actualizada satisfactoriamente!');
		} else {
			return Redirect::route('user')
			->with('erro', 'Tu informacion no ha podido ser actualizada');
		}
	}
}