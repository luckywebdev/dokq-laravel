<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersonquizHistory extends Model
{
    protected $table = 'person_quiz_history';
    protected $fillable = ['id','user_id','username','item','work_test','age','book_id','title','writer','quiz_id', 'doq_quizid', 'quiz_point', 'point', 'rank','content', 'device', 'created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 本の登録とクイズ作成 work_test:0 本の申請 1 読Q本認定 2 読Q本却下 3 クイズ送信 4 クイズ認定完了 5 クイズ認定却下 6 クイズ削除
    */
    
}
