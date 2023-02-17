<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon\Carbon;
class Quizes extends Model
{
    protected $table = 'quizes';
    protected $fillable = ['book_id', 'doq_quizid', 'register_id', 'register_visi_type', 'question', 'answer', 'app_page', 'app_range', 'active', 'published_date', 'reason'];

    // if active == 0 : register quiz
    // if active == 1: ready for admin
    // if active == 2: passed
    // if active == 3: not passed
    
    public function Register(){
        return $this->belongsTo('App\User', 'register_id');
    }
    public function RegisterShow(){
    	if($this->register_visi_type ==null||$this->register_visi_type ==3){
    		$return = '';
    	}elseif($this->register_visi_type == 2){
    		$return = $this->Register->username;
    	}elseif($this->register_visi_type == 1){
            if($this->Register->role == config('consts')['USER']['ROLE']['AUTHOR'])
                $return = $this->Register->fullname_nick();
            else
    		  $return = $this->Register->fullname();
    	}else{
            $return = '';
        }
        return $return;
    }

    public function Overseer(){
        return $this->belongsTo('App\User', 'overseer_id');
    }
    public function OverseerShow(){
        $return = $this->Overseer;
        if(!$return) $return = '';
        else  $return = $return->username;
        return  $return;
    }
    public function Book(){
    	return $this->belongsTo('App\Model\Books', 'book_id');
    }
    public function AppearPosition(){
        $return = config('consts')['QUIZ']['APP_RANGES'][$this->app_range].'<br>';
        if($this->app_page !== null)
		   $return .= "P".$this->app_page;
        else
           $return .= '<br>';
    		
    	return $return;
    }

}
