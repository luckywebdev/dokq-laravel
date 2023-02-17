<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersonbookHistory extends Model
{
    protected $table = 'person_book_history';
    protected $fillable = ['id','user_id','username','item','work_test','book_id','book_point', 'point', 'rank', 'title', 'writer', 'isbn', 'created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 本の登録 work_test:0 申請中 1 登録済 2 却下
		   
    */
    
}
