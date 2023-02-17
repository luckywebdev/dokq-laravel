<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class OrgworkHistory extends Model
{
    protected $table = 'org_work_history';
    protected $fillable = ['id','user_id','username','group_id','group_name','item','work_test','objuser_name','class', 'content', 'newyear',  'point',  'pupil_numbers', 'teacher_numbers', 'created_at', 'updated_at'];
    public $timestamps = false;

    /*item: 0 ログイン ログアウト work_test:0 ログイン 1 ログアウト
		   1 団体試験監督    0 団体試験監督開始（ｐｗ入力） 1 団体試験監督合格（ｐｗ入力）
		   2 児童生徒情報   0 生徒 入学 1 生徒情報更新 2 連絡帳へ送信 3 生徒 合格取消 4 生徒 転校･削除 5 生徒 転入 6 '' 7 生徒 卒業
		   3 教職員情報     0 教員 異動転出・削除 1 教員 異動転入 2 教員 新登録
		   4 お知らせ         0 お知らせ送信 1 お知らせ削除
		   5 団体基本情報   0 団体人事更新 1 団体情報更新
		   6 支払い        0 支払い
    */
    
}
