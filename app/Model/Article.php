<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "articles";

    protected $fillable = ['book_id', 'content', 'register_id', 'register_visi_type', 'junior_visible'];
    //junior_visible: 0 active 1 delete
    public function Votes() {
    	return $this->hasMany('App\Model\Vote', 'article_id');
    }

    public function VotesMine($userId) {
        return $this->hasMany('App\Model\Vote', 'article_id')->where("voter_id", $userId)->count();
    }
    
    public function User() {
    	return $this->belongsTo('App\User', 'register_id');
    }
}
