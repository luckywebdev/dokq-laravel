<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersonoverseerHistory extends Model
{
    protected $table = 'person_overseer_history';
    protected $fillable = ['id','user_id','username','item','work_test','age','book_id','title', 'writer', 'quiz_id', 'doq_quizid', 'bookregister_name', 'content', 'device','created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 監修者 work_test:0 クイズ承認 1 クイズ追加 2 クイズ編集済 3 監修希望送信 4 監修決定 5 監修落選 6 著者と監修交代 7 クイズ削除
    */
    
}
