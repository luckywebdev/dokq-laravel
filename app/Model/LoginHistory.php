<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $table = 'history_login';
    protected $fillable = ['user_id', 'device'];

    public function User(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
