<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class AlertMail extends Model
{
    protected $table = 'alert_mail';
    protected $fillable = ['id','sendmail_date','created_date'];
    public $timestamps = false;

    //get all groups
    static function SendalertMail($time){
        return  DB::table('alert_mail')->where('sendmail_date', '<', $time);
    }
}
