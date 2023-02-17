<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersontestHistory extends Model
{
    protected $table = 'person_test_history';
    protected $fillable = ['id','user_id','username','item','work_test','age','address1','address2','book_id','title','writer','quiz_id', 'doq_quizid', 'quiz_order', 'testoversee_id','testoversee_username', 'tested_time', 'tested_point', 'tested_short_point', 'point', 'rank', 'thisyear_point', 'created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 クイズ受検 work_test:0 回答開始 1 誤答 2 正答 3 合格 4 不合格1度目 5 不合格2度目 6...
    */
    public function quizanswerrights($quiz_id){
        return DB::table("person_test_history")->where('quiz_id',$quiz_id)->where('item', 0)->where('work_test', 2);
    }
    public function quizanswerwrongs(){
        return $this->hasMany('App\PersontestHistory','quiz_id')->where('item', 0)->where('work_test', 1);
    }
    public function quizanswers(){
        return $this->hasMany('App\PersontestHistory','quiz_id')->where('item', 0)->where('work_test', 1)->orwhere('work_test', 2);
    }
    public function quizanswershorts(){
        return $this->hasMany('App\PersontestHistory','quiz_id')->where('item', 0)->where('work_test', 3);
    }
}
