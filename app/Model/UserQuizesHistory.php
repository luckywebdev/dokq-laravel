<?php

namespace App\Model;

use Carbon\Carbon;

//use Symfony\Component\Console\Helper\ProgressBar;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class UserQuizesHistory extends Model
{
    protected $table = 'userquizes_history';
    protected $fillable = ['id','user_id','book_id','status','org_id','created_date','test_num','passed_test_time','type','finished_date','point','published_date','quiz_id','doq_quizid','is_public'];
    public $timestamps = false;
//      if type = 0: register book
//          if status = 0: registered yourself
//          if status = 1: passed
//          if status = 2: not passed
//          if status = 3: passed to admin
//          if status = 4: delete to admin    
//      if type = 1: register quiz
//          if status = 0: registered yourself
//          if status = 1: passed
//          if status = 2: not passed
//          if status = 3: passed to admin
//          if status = 4: delete to admin   
// created_date:  finished_date:認定日 published_date:登録日
//      if type = 2 : 受検
//    if status = 0: 1 password ready
//    if status = 1: do process
//    if status = 2: 2 password ready
//    if status = 3: completed passed
//    if status = 4: not passed
//    if status = 5: logout
//    if status = 6: delete to admin

    public function Book(){
        return $this->belongsTo('App\Model\Books','book_id','id');
    }

    public function User(){
        return $this->belongsTo('App\User', 'user_id','id');
    }
    public function Org_User(){
        return $this->belongsTo('App\User', 'org_id','id');
    }

    public function Quiz(){
        return $this->belongsTo('App\Model\Quizes','quiz_id','id');
    }

    public function Overseer(){
        return $this->belongsTo('App\User','org_id','id');
    }

    static function testQuizes($id = null){

        if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        
        $userQuizes = DB::table('userquizes_history')
            ->select('userquizes_history.*')
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where('userquizes_history.user_id', $id)
            ->where('userquizes_history.type', 2);

        return $userQuizes;
    }

    static function testOverseer($id = null){

        if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        
        $userQuizes = DB::table('userquizes_history')
            ->select('userquizes_history.*')
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where('userquizes_history.org_id', $id)
            ->where('userquizes_history.type', 2);

        return $userQuizes;
    }

    static function testOverseers($id = null){

        if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        
        $userQuizes = DB::table('userquizes_history')
            ->select('userquizes_history.*')
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where('userquizes_history.org_id', $id)
            ->where('userquizes_history.type', 2)
            ->groupby('userquizes_history.user_id');

        return $userQuizes;
    }

    public function scopeRecentTest($query){
        return $query->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where( function ($q) {
                $q->where('created_date', '>',date_sub(now(),date_interval_create_from_date_string("7 days")));
            })->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 0)->where( function ($q2) {
                       $q2->where('userquizes_history.status', '=', 1)->orWhere('userquizes_history.status', '=', 2);
                    });
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 1)->where( function ($q2) {
                        $q2->where('userquizes_history.status', '=', 1)->orWhere('userquizes_history.status', '=', 2);
                    });
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 2)->where( function ($q2) {
                        $q2->where('userquizes_history.status', '=', 3)->orWhere('userquizes_history.status', '=', 4);
                    });
                });
            });
    }

    public function scopeRecentUserQuiz($query, $user_id){
    //select * from `user_quizes` 
    //where (`created_date` > 2018-07-29 09:08:47) and ((`type` = 0 and (`status` = 1 or `status` = 2)) or (`type` = 1 and (`status` = 1 or `status` = 2)) or (`type1` = 2 and (`status` = 3 or `status` = 4)))  
       
        return $query->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where( function ($q) use ($user_id) {
                $q->where('userquizes_history.user_id', '=',$user_id);
            })->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 0)->where( function ($q2) {
                       $q2->where('userquizes_history.status', '=', 1)->orWhere('userquizes_history.status', '=', 2);
                    });
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 1)->where( function ($q2) {
                        $q2->where('userquizes_history.status', '=', 1)->orWhere('userquizes_history.status', '=', 2);
                    });
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 2)->where( function ($q2) {
                        $q2->where('userquizes_history.status', '=', 3)->orWhere('userquizes_history.status', '=', 4);
                    });
                });
            })
            ->orderby('userquizes_history.created_date', "desc");
    }
    public function scopeQuartUserQuiz($query, $user_id,$fromDateY, $fromDatem, $fromDated, $toDateY, $toDatem, $toDated){
        
      return  $query->selectRaw("userquizes_history.*,  MAX(finished_date) as finished_date1, SUM(userquizes_history.point) as cur_point")
             ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
             ->leftJoin('users','users.id','=','userquizes_history.user_id')
             ->where('userquizes_history.user_id', '=',$user_id)
            ->where( function ($q) use ($fromDateY, $fromDatem, $fromDated, $toDateY, $toDatem, $toDated) {
                $q->whereBetween('created_date',  array(Carbon::create($fromDateY, $fromDatem, $fromDated,0,0,0), Carbon::create($toDateY, $toDatem, $toDated,23,59,59)));
            })->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 0)->where('userquizes_history.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 1)->where('userquizes_history.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 2)->where('userquizes_history.status', '=', 3);
                });
            })
            //->groupby("userquizes_history.user_id")
            ->orderby('userquizes_history.finished_date', "desc");
       
    }

    public function scopeCurrentYearUserQuiz($query, $user_id, $current_season, $role){
        
        if($role == config('consts')['USER']['ROLE']['PUPIL']){
            return $query->selectRaw("userquizes_history.*,SUM(userquizes_history.point) as cur_point")
                 ->leftJoin('users','users.id','=','userquizes_history.user_id')
                 ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                 ->where('userquizes_history.user_id', '=',$user_id)
                ->whereBetween('created_date', array(Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0), Carbon::create($current_season['end_thisyear'],3, 31,23,59,59)))
                ->where( function ($q) {
                    $q->Where(function ($q1) {
                        $q1->where('userquizes_history.type', '=', 0)->where('userquizes_history.status', '=', 1);                    
                    })->orWhere(function ($q1) {
                        $q1->where('userquizes_history.type', '=', 1)->where('userquizes_history.status', '=', 1);
                    })->orWhere(function ($q1) {
                        $q1->where('userquizes_history.type', '=', 2)->where('userquizes_history.status', '=', 3);
                    });
                })
                 ->orderby('created_date', "desc");
        }else{
            return $query->selectRaw("userquizes_history.*,SUM(userquizes_history.point) as cur_point")
                 ->leftJoin('users','users.id','=','userquizes_history.user_id')
                 ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                 ->where('userquizes_history.user_id', '=',$user_id)
                ->whereBetween('created_date', array(Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0), Carbon::create($current_season['end_thisyear'],3, 31,23,59,59)))
                ->where( function ($q) {
                    $q->Where(function ($q1) {
                        $q1->where('userquizes_history.type', '=', 0)->where('userquizes_history.status', '=', 1);                    
                    })->orWhere(function ($q1) {
                        $q1->where('userquizes_history.type', '=', 1)->where('userquizes_history.status', '=', 1);
                    })->orWhere(function ($q1) {
                        $q1->where('userquizes_history.type', '=', 2)->where('userquizes_history.status', '=', 3);
                    });
                })
                 ->orderby('created_date', "desc");
        }
    }

    public function scopeAllPointUserQuiz($query, $user_id){
        
        return $query->selectRaw("userquizes_history.*,SUM(userquizes_history.point) as cur_point")
             ->leftJoin('users','users.id','=','userquizes_history.user_id')
             ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
             ->where('userquizes_history.user_id', '=',$user_id)
            ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 0)->where('userquizes_history.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 1)->where('userquizes_history.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 2)->where('userquizes_history.status', '=', 3);
                });
            })
             ->orderby('created_date', "desc");
             
    }
    
    static function AllUserQuizes(){
        //読Qトップ --> マイ書斎  --> クイズ作成量&本の登録量 順位 --> 現在まで累計
        $userQuizes = DB::table('userquizes_history')
            ->select('userquizes_history.*')
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where('userquizes_history.user_id', Auth::id())
            ->where('userquizes_history.type', 1)
            ->where('userquizes_history.status', 1)
            ->groupby('userquizes_history.book_id');

        return $userQuizes;
    }
    static function SumPoint($term, $current_season,$role){    	
    /*select  users.id as userid, IFNULL(sum(userquizes_history.point),0) as sumpoint
        from `users` 
        left join `userquizes_history` on `userquizes_history`.`user_id` = `users`.`id` and ((`userquizes_history`.`type` = 0 and `userquizes_history`.`status` = 1) or (`userquizes_history`.`type` = 1 and `user_quizes`.`status` = 1) 
        or (`userquizes_history`.`type` = 2 and `userquizes_history`.`status` = 3)) 
        where `users`.`active` = 1 
        and `users`.`role` = 9 
        group by `users`.`id` order by `sumpoint` desc*/
        $users = DB::table('users as u')
            ->select( DB::raw ('IFNULL(sum(userquizes_history.point),0) as sumpoint'), DB::raw('u.id as userid'))
            ->leftjoin('userquizes_history', 'userquizes_history.user_id', DB::raw('u.id and ((userquizes_history.type = 0 and userquizes_history.status = 1) or (userquizes_history.type = 1 and userquizes_history.status = 1) 
or (userquizes_history.type = 2 and userquizes_history.status = 3))'))
            ->leftJoin('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->whereIn('u.active', [1,2,3,4])
            ->groupby('u.id')
            ->orderby('sumpoint','desc');
        if($role == config('consts')['USER']['ROLE']['PUPIL']){
            $users = $users->where('u.role','=',config('consts')['USER']['ROLE']['PUPIL']);
        }
       
        if($term == 0)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 1)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 2)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 3)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 4)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 5)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 6)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term== 7)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 8)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 9)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 10)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 11)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 12)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 13)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 14)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 15)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 16)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 17)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 18)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 19)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 20)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 21)//calc the point of this year
            if($role == config('consts')['USER']['ROLE']['PUPIL'])
                $users = $users->whereBetween('userquizes_history.finished_date',array(Carbon::create($current_season['begin_thisyear'], 4, 1,0,0,0), Carbon::create($current_season['end_thisyear'], 3, 31,23,59,59)));
            else
                $users = $users->whereBetween('userquizes_history.finished_date',array(Carbon::create($current_season['begin_thisyear'], 1, 1,0,0,0), Carbon::create($current_season['end_thisyear'], 12, 31,23,59,59)));
        elseif($term == 22)//calc the point of last year
            if($role == config('consts')['USER']['ROLE']['PUPIL'])
                $users = $users->whereBetween('userquizes_history.finished_date',array(Carbon::create($current_season['begin_thisyear']-1, 4, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1, 3, 31,23,59,59)));
            else
                $users = $users->whereBetween('userquizes_history.finished_date',array(Carbon::create($current_season['begin_thisyear']-1, 1, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1, 12, 31,23,59,59)));
        
        return $users;
    }
    static function SumQuizPoint($term,$current_season,$role){
     /*select  u.id as userid, IFNULL(sum(userquizes_history.point),0) as sumpoint
from `users as u` 
left join `userquizes_history` on `userquizes_history`.`user_id` = `users`.`id` and ((`userquizes_history`.`type` = 0 and `userquizes_history`.`status` = 1) or (`userquizes_history`.`type` = 1 and `userquizes_history`.`status` = 1)) 
where `u`.`active` = 1 
and `u`.`role` = 9 
group by `u`.`id` order by `sumpoint` desc*/
         $users = DB::table('users as u')
            ->select( DB::raw ('IFNULL(sum(userquizes_history.point),0) as sumpoint'), DB::raw('u.id as userid'))
            ->leftjoin('userquizes_history', 'userquizes_history.user_id', DB::raw('u.id and ((userquizes_history.type = 0 and userquizes_history.status = 1) or (userquizes_history.type = 1 and userquizes_history.status = 1))'))
            ->leftJoin('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7')) 
            ->whereIn('u.active', [1,2,3,4])
            ->groupby('u.id')
            ->orderby('sumpoint','desc');
        if($role == config('consts')['USER']['ROLE']['PUPIL']){
            $users = $users->where('u.role','=',config('consts')['USER']['ROLE']['PUPIL']);
        }
       
        if($term == 0)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 1)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 2)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 3)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 4)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 5)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 6)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term== 7)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 8)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 9)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 10)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 11)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 12)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 13)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 14)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 15)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 16)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 17)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 18)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 19)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 20)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 21)//calc the point of this year
            if($role == config('consts')['USER']['ROLE']['PUPIL'])
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear'], 4, 1,0,0,0), Carbon::create($current_season['end_thisyear'], 3, 31,23,59,59)));
            else
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear'], 1, 1,0,0,0), Carbon::create($current_season['end_thisyear'], 12, 31,23,59,59)));
        elseif($term == 22)//calc the point of last year
            if($role == config('consts')['USER']['ROLE']['PUPIL'])
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear']-1, 4, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1, 3, 31,23,59,59)));
            else
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear']-1, 1, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1, 12, 31,23,59,59)));
        
        return $users;
    }
    static function classranking($term, $season){
        //select sum(user_quizes.point) as sumpoint, users.id from user_quizes join users on user_quizes.user_id = users.id group by user_quizes.user_id order by sumpoint
        $users = UserQuiz::SumPoint($term,$season, config('consts')['USER']['ROLE']['PUPIL'])->where('u.org_id','=',Auth::user()->org_id)->where('u.active',1);
        return $users;
    }

    static function classranking1($term, $season, $org_id){
        //select sum(user_quizes.point) as sumpoint, users.id from user_quizes join users on user_quizes.user_id = users.id group by user_quizes.user_id order by sumpoint
        $users = UserQuiz::SumPoint($term,$season, config('consts')['USER']['ROLE']['PUPIL'])->where('u.org_id','=',$org_id)->where('u.active',1);
        return $users;
    }
    static function AllowedBooksRecord($term, $current_season){
        $query = DB::table('userquizes_history')->select('books.*', DB::raw('books.id as bookid'), 'userquizes_history.point', 'users.*')
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->join('users', 'userquizes_history.user_id', 'users.id')
            ->groupby('userquizes_history.book_id')
            ->where('userquizes_history.user_id', Auth::id())
            ->where('userquizes_history.status', 1)
            ->where('userquizes_history.type', 0)
            ->orderby('books.qc_date', 'desc');
        if($term == 0)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 1)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 2)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 3)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 4)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 5)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 6)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term== 7)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 8)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 9)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 10)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 11)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 12)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 13)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 14)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 15)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 16)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 17)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 18)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 19)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 20)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        
        return $query;
    
    }

    static function TotalPoint($id = null){

        if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        $totalPoint = DB::table('userquizes_history')->select(DB::raw ('sum(userquizes_history.point) as sumpoint'))
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where('userquizes_history.user_id', Auth::id())
           ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 0)->where('userquizes_history.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 1)->where('userquizes_history.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('userquizes_history.type', '=', 2)->where('userquizes_history.status', '=', 3);
                });
            })->groupby('user_id')->first();
        if (!isset($totalPoint) || $totalPoint == null) return 0;
        return round($totalPoint->sumpoint, 2);
    }

    static function AllowedQuizesRecord($term, $current_season){
        $query = DB::table('userquizes_history')->select('userquizes_history.*', DB::raw('books.id as bookid'), 'books.title', 'books.firstname_nick', 'books.lastname_nick')
            ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->where('userquizes_history.user_id', Auth::id())
            ->where('userquizes_history.status', 1)
            ->where('userquizes_history.type', 1)
            ->orderby('userquizes_history.finished_date', 'desc');
        if($term == 0)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 1)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 2)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 3)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 4)
            $query = $query->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 5)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 6)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term== 7)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 8)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 9)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 10)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 11)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 12)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 13)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 14)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 15)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 16)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 17)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 18)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 19)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 20)
            $query = $query->whereBetween('user_quizes.created_date',array($current_season['begin_season'], $current_season['end_season']));
        
        return $query;
    }

    static function SumPoint1($term, $current_season, $role){
        //select sum(user_quizes.point) as sumpoint, u.id from user_quizes join users on user_quizes.user_id = users.id group by user_quizes.user_id order by sumpoint
        $users = DB::table('users as u')
            ->select( DB::raw ('IFNULL(sum(user_quizes.point),0) as sumpoint'), DB::raw('u.id as userid'))
            ->leftjoin('userquizes_history', 'userquizes_history.user_id', DB::raw('u.id and ((userquizes_history.type = 0 and userquizes_history.status = 1) or (userquizes_history.type = 1 and userquizes_history.status = 1) 
or (userquizes_history.type = 2 and userquizes_history.status = 3))'))
            ->leftJoin('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->groupby('u.id')
            ->orderby('sumpoint','desc');

        if($role == config('consts')['USER']['ROLE']['PUPIL']){
            $users = $users->where('u.role','=',config('consts')['USER']['ROLE']['PUPIL']);
        }
        if($term == 0)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 1)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 2)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 3)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 4)
            $users = $users->whereBetween('userquizes_history.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 5)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 6)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term== 7)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 8)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 9)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 10)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 11)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 12)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 13)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 14)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 15)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 16)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 17)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 18)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 19)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 20)
            $users = $users->whereBetween('userquizes_history.created_date',array($current_season['begin_season'], $current_season['end_season']));
        elseif($term == 21)//calc the point of this year
            if($role == config('consts')['USER']['ROLE']['PUPIL'])
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear'], 4, 1,0,0,0), Carbon::create($current_season['end_thisyear'], 3, 31,23,59,59)));
            else
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear'], 1, 1,0,0,0), Carbon::create($current_season['end_thisyear'], 12, 31,23,59,59)));
        elseif($term == 22)//calc the point of last year
            if($role == config('consts')['USER']['ROLE']['PUPIL'])
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear']-1, 4, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1, 3, 31,23,59,59)));
            else
                $users = $users->whereBetween('userquizes_history.created_date',array(Carbon::create($current_season['begin_thisyear']-1, 1, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1, 12, 31,23,59,59)));
        
        return $users;
    }
    static function graderanking($term,$season){
        $users = UserQuiz::SumPoint($term, $season, config('consts')['USER']['ROLE']['PUPIL'])
            ->join('classes', 'u.org_id','=','classes.id')
            ->where('u.role',config('consts')['USER']['ROLE']['PUPIL'])
            ->where('u.active',1)
            ->where('classes.group_id', Auth::user()->PupilsClass->group_id)
            ->where('classes.grade', Auth::user()->PupilsClass->grade);
        return $users;

    }
    static function graderanking1($term, $season, $group_id, $grade){
        $users = UserQuiz::SumPoint($term, $season, config('consts')['USER']['ROLE']['PUPIL'])
            ->join('classes', 'u.org_id','=','classes.id')
            ->where('u.role',config('consts')['USER']['ROLE']['PUPIL'])
            ->where('u.active',1)
            ->where('classes.group_id', $group_id)
            ->where('classes.grade', $grade);
        return $users;

    }
    static function cityranking($term, $season, $role, $rankingage, $user, $grade=null){
        $users = UserQuiz::SumPoint($term, $season,$role)
            ->where('u.address2',$user->address2)
            ->where('u.address1',$user->address1);
        $today = now();
        switch ($rankingage) {
            case 1:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-13), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-12), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                }
                break;
            case 2:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-16), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-13), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-15), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-12), 3, 31), "Y-m-d")));
                }
                break;
            case 3:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 4:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 5:
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-16), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-15), 3, 31), "Y-m-d")));
                break;
            case 6:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                
                break;
            case 7:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;
            case 8:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;
            case 9:
               $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;
            case 10:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case 11:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case 12:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
        }
        return $users;
    }
    static function cityquizranking($term, $season, $grade, $rankingage, $user){
        $users = UserQuiz::SumQuizPoint($term, $season,$user->role)
            ->where('u.address2',$user->address2)
            ->where('u.address1',$user->address1);
        
        $today = now();
        
        switch ($rankingage) {
            case 1:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-13), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-12), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                }
                break;
            case 2:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-16), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-13), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-15), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-12), 3, 31), "Y-m-d")));
                }
                break;
            case 3:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 4:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 5:
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-16), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-15), 3, 31), "Y-m-d")));
                break;
            case 6:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                
                break;
            case 7:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;
            case 8:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;
            case 9:
               $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;
            case 10:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case 11:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case 12:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
        }
        return $users;
    }

    static function provinceranking($term,$season,$role,$rankingage, $user, $grade=null){
        $users = UserQuiz::SumPoint($term,$season, $role)
            ->where('u.address1',$user->address1);
        $today = now();
        switch ($rankingage) {
            case 1:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-13), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-12), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                }
                break;
            case 2:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-16), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-13), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-15), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-12), 3, 31), "Y-m-d")));
                }
                break;
            case 3:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 4:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 5:
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-16), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-15), 3, 31), "Y-m-d")));
                break;
            case 6:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                
                break;
            case 7:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;
            case 8:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;
            case 9:
               $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;
            case 10:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case 11:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case 12:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
        }
     
        return $users;
    }
    static function provincequizranking($term,$season,$grade,$rankingage, $user){
        $users = UserQuiz::SumQuizPoint($term,$season,$user->role)
            ->where('u.address1',$user->address1);
        $today = now();
        switch ($rankingage) {
            case 1:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-13), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-12), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                }
                break;
            case 2:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-16), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-13), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-15), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-12), 3, 31), "Y-m-d")));
                }
                break;
            case 3:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 4:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 5:
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-16), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-15), 3, 31), "Y-m-d")));
                break;
            case 6:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                
                break;
            case 7:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;
            case 8:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;
            case 9:
               $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;
            case 10:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case 11:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case 12:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
        }
     
        return $users;
    }
    static function nationranking($term,$season, $role,$rankingage, $user, $grade=null){
        $users = UserQuiz::SumPoint($term,$season, $role);
        $today = now();
        switch ($rankingage) {
            case 1:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-13), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-12), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                }
                break;
            case 2:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-16), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-13), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-15), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-12), 3, 31), "Y-m-d")));
                }
                break;
            case 3:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 4:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 5:
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-16), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-15), 3, 31), "Y-m-d")));
                break;
            case 6:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                
                break;
            case 7:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;
            case 8:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;
            case 9:
               $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;
            case 10:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case 11:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case 12:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
        }
        return $users;
    }
    static function nationquizranking($term, $season, $grade=null,$rankingage, $user){
        $users = UserQuiz::SumQuizPoint($term,$season, $user->role);
        $today = now();
        switch ($rankingage) {
            case 1:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-13), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-12), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate(Date("Y"), 3, 31), "Y-m-d")));
                }
                break;
            case 2:
                if($grade !== null){
                    //select sum(user_quizes.point) as sumpoint, u.id as userid from `users` as `u` left join `user_quizes` on `u`.`id` = `user_quizes`.`user_id` where ((`user_quizes`.`type` = 0 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 1 and `user_quizes`.`status` = 1) or (`user_quizes`.`type` = 2 and `user_quizes`.`status` = 3)) and `u`.`active` = 1 and `user_quizes`.`created_date` between 2019-04-01 00:00:00 and 2019-06-30 23:59:59 and `u`.`address2` = '' and `u`.`address1` = '' and `birthday` between 2000-01-01 and 2004-03-31 group by `u`.`id` order by `sumpoint` desc
                    $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                }else{
                    if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-16), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-13), 3, 31), "Y-m-d")));
                    else
                        $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-15), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-12), 3, 31), "Y-m-d")));
                }
                break;
            case 3:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 4:
                $users = $users->join('classes','classes.id','=','u.org_id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))
                                ->where('u.role', config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null) $users = $users->where('classes.grade','=',$grade);
                break;
            case 5:
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-16), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-15), 3, 31), "Y-m-d")));
                break;
            case 6:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                
                break;
            case 7:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;
            case 8:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;
            case 9:
               $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;
            case 10:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case 11:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case 12:
                $users = $users->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
        }
        return $users;
    }
    static function CurPoint($user_id,$role){   
        
        $users = DB::table('users as u')
            ->select( DB::raw ('IFNULL(sum(userquizes_history.point),0) as sumpoint'), DB::raw('u.id as userid'))
            ->leftjoin('userquizes_history', 'userquizes_history.user_id', DB::raw('u.id and ((userquizes_history.type = 0 and userquizes_history.status = 1) or (userquizes_history.type = 1 and userquizes_history.status = 1) 
or (userquizes_history.type = 2 and userquizes_history.status = 3))'))
            ->leftJoin('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
            ->groupby('u.id')
            ->orderby('sumpoint','desc');
        if($role == config('consts')['USER']['ROLE']['PUPIL']){
            $users = $users->where('u.role','=',config('consts')['USER']['ROLE']['PUPIL']);
        }
        if(isset($user_id)){
            $users = $users->where('u.id','=',$user_id);
        }
        return $users;
    }
}