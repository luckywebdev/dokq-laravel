<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersontestoverseeHistory extends Model
{
    protected $table = 'person_testoversee_history';
    protected $fillable = ['id','user_id','username','item','work_test','age','address1','address2','book_id','title','writer','test_username','overseer_num', 'device', 'created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 試験監督 work_test:0 開始顔認証 1 合格顔認証 2 検定中止
    */
    
}
