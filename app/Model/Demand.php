<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Demand extends Model
{
	protected $table = 'overseer_demand';
	protected $fillable = ['book_id', 'overseer_id', 'reason', 'status'];

    public function Book() {
        return $this->belongsTo('App\Model\Books', 'book_id');
    }

    public function User() {
        return $this->belongsTo('App\User', 'overseer_id');
    }

    public function demandList($bookId) {
        return $this->where('book_id', $bookId) ->get();
    }

    public function scopeSearchOne($query, $bookId, $userId){
        return $query->where( function ($query1) use ($bookId, $userId) {
            $query1->where('book_id', '=', $bookId)->where("overseer_id", $userId);
        });
    }
}
