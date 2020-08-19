<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersonworkHistory extends Model
{
    protected $table = 'person_work_history';
    protected $fillable = ['id','user_id','username','item','work_test','user_type','age','address1','address2','org_username','content', 'device','pay_point','period','created_at', 'updated_at'];
     public $timestamps = false;

    /*item:0 会員履歴  work_test:0 ログイン 1 ログアウト 2 入会初ログイン 3 退会ログアウト 4 準会員へ 5 正会員へ復活
								  6 基本情報更新 7 顔登録 8 顔認証成功 9 顔認証失敗 10 会費支払い 11 読書認定書
    */
    public function fullname(){
        return $this->firstname . ' ' . $this->lastname;
    }
    public function fullname_nick(){
        return $this->firstname_nick . ' ' . $this->lastname_nick;
    }
    public function isAuthor(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["AUTHOR"]);
    }

}
