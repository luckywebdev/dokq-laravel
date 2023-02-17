<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Categories extends Model
{
	protected $table = 'categories';
	protected $fillable = ['name', 'limit'];

	public $timestamps = false;

    public function books(){
    	return $this->belongsToMany('App\Model\Books', 'book_category', 'category_id', 'book_id');
    }
}
