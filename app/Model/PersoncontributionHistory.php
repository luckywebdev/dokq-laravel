<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersoncontributionHistory extends Model
{
    protected $table = 'person_contribution_history';
    protected $fillable = ['id','user_id','username','item','work_test','age','book_id','title','writer','content','bookregister_name','ok_content','created_at','updated_at'];
    public $timestamps = false;

    /*item:0 投稿  work_test:0 帯文 1 いいね！ 2 問合せ 3 いいね！削除
    */
    
}
