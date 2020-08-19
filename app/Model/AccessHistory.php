<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AccessHistory extends Model
{
    protected $table = 'history_access';
    protected $fillable = ['user_id', 'device'];

}
