<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class ReportGraphBackup extends Model
{
    protected $table = 'reportgraph_backup';
    protected $fillable = ['id','user_id','backup_date','flag','area', 'period', 'persons', 'dq_point', 'my_rank', 'created_at', 'updated_at'];
    public $timestamps = false;
    /*
    flag //0 other person 1 myself
    area //0 クラス 1 学年 2 市内 3 県内 4 国内 
    period //0 四半期（3カ月間） 1 年度（1年間） 2 生涯
    my_rank // if flag is 1, view 1位/13人
    */
}
