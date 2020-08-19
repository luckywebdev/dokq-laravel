<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';
    protected $fillable = ['id', 'article_id', 'voter_id','voter_visi_type' ,'status'];

    public function User() {
    	return $this->belongsTo('App\User', 'voter_id');
    }
}
