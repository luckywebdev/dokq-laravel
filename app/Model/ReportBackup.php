<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class ReportBackup extends Model
{
    protected $table = 'report_backup';
    protected $fillable = ['id','user_id','role','type','backup_date','degree','target_percent', 'threemonth_point',  'success_point', 'bookregister_point', 'quizregister_point', 'all_point', 'remain_point', 'test_point', 'testcity_rank', 'testprovince_rank', 'testcountry_rank', 'quiz_point', 'quizcity_rank', 'quizprovince_rank', 'quizcountry_rank', 'booktest_success', 'bookconfirm_success', 'quizconfirm_success', 'threemonth_name1', 'threemonth_name2', 'threemonth_name3', 'threemonth_name4', 'threemonth_name5', 'threemonth_name6', 'threemonth_name7', 'threemonth_name8', 'mythreemonth_point1', 'mythreemonth_point2', 'mythreemonth_point3', 'mythreemonth_point4', 'mythreemonth_point5', 'mythreemonth_point6', 'mythreemonth_point7', 'mythreemonth_point8', 'threemonth_point1', 'threemonth_point2', 'threemonth_point3', 'threemonth_point4', 'threemonth_point5', 'threemonth_point6', 'threemonth_point7', 'threemonth_point8', 'created_at', 'updated_at'];
    public $timestamps = false;

    
}
