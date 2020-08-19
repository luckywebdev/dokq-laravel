<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PwdHistory extends Model
{
    protected $table = 'history_password';
    protected $fillable = ['overseer_id', 'user_id', 'type'];

    // if type == 1 : Test start
    // if type == 2: Test end
    
    public function Overseer(){
        return $this->belongsTo('App\User', 'overseer_id');
    }

    public function User(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
