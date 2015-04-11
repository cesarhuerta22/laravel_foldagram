<?php

class CreditController extends BaseController {

	public function getUserCredit()
	{
		$users = Sentry::getUser()->all();

		$userarray = array();
		foreach($users as $value) {
			$userarray[$value['id']] = $value['email'];
		}

		return View::make('admin.user_credit')
		->with('title', 'Foldagram - Admin')
		->with('page_title', 'Give User Credit')
		->with('users', $userarray);
	}

	public function postUserCredit()
	{
		$user = Sentry::findUserById(Input::get('user_email'));

		$credit = new Credits();

		$credit->rfrom = $user->email;
		$credit->rto = Input::get('rto');
		$credit->price = Input::get('price');

		if($credit->save()) {
			return Redirect::route('orders')
			->with('success','User credit has been update successfully!');
		} else {
			return Redirect::route('user_credit');
		}
	}
}