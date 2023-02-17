<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon\Carbon;
class BookCategory extends Model
{
    protected $table="book_category";
    protected $fillable = array(
    	'book_id', 
    	'category_id'
    );
	

   
}
