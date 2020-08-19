<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersonbooksearchHistory extends Model
{
    protected $table = 'person_booksearch_history';
    protected $fillable = ['id','user_id','username','item','work_test','age','address1','address2','book_id','title','writer','jangru','content', 'device','action','created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 読Q本の検索 work_test:0 書籍名から 1 著者から 2 良さそうな推薦図書から 3 良さそうな/ジャンル 
   								4 良さそうな/新読Q本 5 良さそうな/順位順 
   								6 帯文のキーワードから 7 空くから 8 ISBNから  
    */
    
}
