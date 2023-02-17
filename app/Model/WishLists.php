<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class WishLists extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['user_id', 'book_id','finished_date'];
    
    public function Book(){
    	return $this->belongsTo('App\Model\Books','book_id');
    }

    public function isTestPassed() {
        return UserQuiz::where("type", 2)->where("status", 3)->where("user_id", $this->user_id)->where("book_id", $this->book_id)->count();
    }

    static function wishBooks($userId) {
        return DB::table("wishlists as a")
            ->join("books as b", "b.id", "=", DB::raw('a.book_id and b.active <> 7'))
            ->select("b.*", "a.is_public")
            ->where('a.user_id', $userId)
            ->orderby('a.updated_at','desc')
            ->get();
    }
}
