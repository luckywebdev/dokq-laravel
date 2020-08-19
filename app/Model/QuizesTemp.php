<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuizesTemp extends Model
{
    protected $table = 'quizes_temp';
    protected $fillable = ['book_id', 'user_id', 'idx', 'quiz_id'];
   
    public function Register(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function Book(){
    	return $this->belongsTo('App\Model\Books', 'book_id');
    }
    public function Quiz(){
        return $this->belongsTo('App\Model\Quizes', 'quiz_id');
    }

}
