<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Notices extends Model
{
    protected $table = 'notices';
    
    protected $fillable = ['content', 'created_at','updated_at'];

    public function scopeNotice($query, $id){
    	return $query->where( function ($q) use ($id) {
			$q->where('id', '=', $id);
    	});
    }

    public function scopeNoticesByLimit($query, $limit) {
    	return $query->orderBy('created_at', 'desc')
            ->take($limit);
    }
}
