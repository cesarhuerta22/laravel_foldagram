<?php

class Recipient extends Eloquent{
    protected $table = 'recipients';
    protected $guarded = array('id', 'created_at', 'updated_at');
    
    public function foldagram() {
        return $this->belongsTo('Foldagram');
    }
}
