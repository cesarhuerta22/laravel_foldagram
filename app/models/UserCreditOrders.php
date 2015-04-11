<?php

class UserCreditOrders Extends Eloquent {

	protected $table = 'usercreditorders';
	protected $guarded = array('id', 'created_at', 'updated_at');

	public function users(){
		return $this->belongsTo('User','user_id');
	}

	public function foldagrams(){
		return $this->belongsTo('Foldagram','transection_id');
	}
}