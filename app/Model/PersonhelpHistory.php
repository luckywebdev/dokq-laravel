<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class PersonhelpHistory extends Model
{
    protected $table = 'person_help_history';
    protected $fillable = ['id','user_id','username','item','work_test','user_type','age','address1','address2','org_username', 'device', 'created_at', 'updated_at'];
     public $timestamps = false;

    /*item : '読Qの特長', '読Ｑの使い方', 'ポイントの仕組みと取得目標', '監修者紹介', '受検問題サンプル', '顔認証について', 'サイトマップ', '法人概要', '会員種類の説明と利用規約', '会費・料金について', '個人情報保護方針', 'お問合せ', 'よくある質問'
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
