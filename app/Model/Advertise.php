<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Advertise extends Model
{
    protected $table = 'advertise';
    protected $fillable = ['id','top_page_left','top_page_right', 'mystudy_top', 'mystudy_bottom', 'book_page_top_left', 'book_page_top_right', 'book_page_bottom_right', 'search_page_top'];
}
