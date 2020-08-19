<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Angate extends Model
{
    protected $table = 'angate';
    protected $fillable = ['book_id', 'user_id', 'value'];
    
    public function Register(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function Book(){
    	return $this->belongsTo('App\Model\Books', 'book_id');
    }

}
