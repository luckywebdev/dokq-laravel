<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Messages extends Model
{
    protected $table = 'messages';
    
    protected $fillable = ['type', 'from_id', 'to_id', 'content','post','created_at','updated_at','name','email','del_flag','search_flag','search_username','search_name','search_address1','search_address2','search_gender','search_rank','search_usertype','search_year'];
    //messages which teacher receives
    public function scopeTeacherMessages($query, $org_id){
    	return $query->where( function ($q) use ($org_id) {
			$q->where('type', '=', 1)->where('from_id', '=', $org_id);
    	})->orWhere(function ($q) use ($org_id) {
    		$q->where('type', '=', 0)->where('to_id', '=', $org_id);
    	})->orWhere(function($q){
            $q->where('to_id', '=', 0);
        })->orWhere(function($q){
            $q->where('to_id', Auth::id());
        })->orderBy('created_at', 'desc');
    }
    //yonQ -> to School
    public function scopeSchoolMessages($query, $id){
    	return $query->where( function ($q) use ($id) {
			 $q->where('type', '=', 0)->where('to_id', '=', $id);    	   
           })->orWhere(function($q){
                $q->where('to_id', '=', Auth::id());
           })
           ->orwhere( function ($q1) use ($id) {
                $q1->where('from_id','=',$id)
                    ->Where('to_id','=',1);
             })
            ->orderBy('created_at', 'desc');
    }
    //messages to admins by KSC
    public function scopeAdminMessages($query, $id){
        return $query->where( function ($q) use ($id) {
             $q->where('type', '=', 0)->where('to_id', '=', $id);
           })->orWhere(function($q){
                $q->where('to_id', '=', 0);
           })->orWhere(function($q){
                $q->where('to_id', '=', Auth::id());
           })->orderBy('created_at', 'desc');
    }
    
    public function scopeMyMessages($query, $id=null){
        if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        return $query
                    ->where( function ($q) use ($id) {
                        $q->where('messages.to_id','like','%,'.$id.',%')
                            ->orWhere('messages.to_id','=',$id)
                            ->orWhere('messages.to_id','like', $id.',%')
                            ->orWhere('messages.to_id','like','%,'.$id);
                     })
                    ->orwhere( function ($q1) use ($id) {
                        $q1->where('messages.from_id','=',$id)
                            ->Where('messages.to_id','=',1);
                     })
                     ->orderBy('messages.created_at','desc');
    }
    public function scopeMyMessagestop($query, $id=null){
        if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        return $query
                    ->select('messages.content', 'messages.to_id', 'messages.from_id', 'messages.created_at')
                    ->where( function ($q) use ($id) {
                        $q->where('messages.to_id','like','%,'.$id.',%')
                            ->orWhere('messages.to_id','=',$id)
                            ->orWhere('messages.to_id','like', $id.',%')
                            ->orWhere('messages.to_id','like','%,'.$id);
                     })
                    ->orwhere( function ($q1) use ($id) {
                        $q1->where('messages.from_id','=',$id)
                            ->Where('messages.to_id','=',1);
                     })
                     ->groupBy('messages.content')
                     ->orderBy('messages.created_at','desc');
    }

    public function getUserMessageSend($id=null){
        $user = User::find($id);
        return $user;
    }

}
