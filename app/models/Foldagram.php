<?php

class Foldagram extends Eloquent{
    protected $table = 'foldagrams';
    protected $guarded = array('id', 'created_at', 'updated_at');


    public function recipients() {
        return $this->hasMany('Recipient');
    }
}