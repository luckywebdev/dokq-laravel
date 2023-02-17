<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PersonadminHistory extends Model
{
    protected $table = 'person_admin_history';
    protected $fillable = ['id','user_id','username','item','work_test','book_id','title','writer','bookregister_name','content','period','access_num','login_num','test_num','success_num','readybook_num','successbook_num','quiz_num','successquiz_num','org_num','users_num',  'created_at', 'updated_at'];
    public $timestamps = false;

   /*item:0 協会　 0 ログイン 1 ログアウト 2 読Q本認定 3 候補本却下 4 監修者決定 5 監修者却下 6 帯文削除 7 合格取消
		 		 8 アカウント凍結 9 協会トップ画面保存 10 著者監修者交代 11 推薦図書加算係数 12 有効期限変更 13 メール送信 14 お問合せ返信
		 		 15 本のデータ削除 16 会員データ削除
    */
   
    
}
