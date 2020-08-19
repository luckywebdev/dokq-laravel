<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class CertiBackup extends Model
{
    protected $table = 'certi_backup';
    protected $fillable = ['id','user_id','username','index','passcode','backup_date', 'settlement_date', 'level','sum_point','booktest_success', 'created_at', 'updated_at'];
    public $timestamps = false;

    
}
