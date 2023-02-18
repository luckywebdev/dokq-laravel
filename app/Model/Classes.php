<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;


class Classes extends Model
{
    protected $table = 'classes';
    //protected $fillable = ['id','class_number','type', 'member_counts', 'group_id','year', 'grade', 'teacher_id', 'vice_teacher_id'];
    protected $fillable = ['id','class_number','type', 'member_counts', 'group_id','year', 'grade', 'teacher_id', 'active'];
    public $timestamps = false;

    public function group(){
        return $this->belongsTo('App\User', 'group_id')->where('role', config('consts')['USER']['ROLE']["GROUP"]);
    }

    public function school(){
        return $this->belongsTo('App\User', 'group_id');
    }

    public function fullTitle() {
        if($this->grade == 0)
            return $this->group->group_name . $this->class_number . "学級";
        else
            return $this->group->group_name . $this->grade . "年";
    }
    public function getTotalCounts(){
        return $this->sum('member_counts');
    }
    //teacher of class
    public function TeacherOfClass(){
        return $this->belongsTo('App\User','teacher_id')->whereIn('role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]]);
    }
    //vice_teacher of class
    //public function ViceTeacherOfClass(){
    //    return $this->belongsTo('App\User','vice_teacher_id') ->where('role', 5);
    //}
    public function scopeRecentClasses($query, $teacherid){
    	return $query->where('teacher_id', '=',$teacherid)->orderBy(DB::raw("year desc, grade desc, class_number"), 'asc')->limit(5);
    }
    public function Pupils(){
        return $this->hasMany('App\User','org_id')->where('role', config('consts')['USER']['ROLE']['PUPIL'])->where('active', 1);
    }
    //get active classes of the school
    public function scopeActiveClasses($query, $schoolid){
        return DB::table("classes")->where("group_id", $schoolid)->whereNotNull('teacher_id')
            ->orderBy('year','desc');

        // return $query->where( function ($query) use ($schoolid) {
        //             $query->where('group_id', '=', $schoolid)
        //             ->whereNotNull('teacher_id');
        //         })->orderBy('year', 'desc');
    }
     //get active classes of the school
    public function scopeActiveClassesAll($query, $schoolid){
        return DB::table("classes")->where("group_id", $schoolid)
            ->orderBy('year','desc');

        // return $query->where( function ($query) use ($schoolid) {
        //             $query->where('group_id', '=', $schoolid)
        //             ->whereNotNull('teacher_id');
        //         })->orderBy('year', 'desc');
    }

    //get active classes of the school
    public function scopeGetSchoolByGroupId($query, $schoolid){
        return DB::table("users")->where("id", $schoolid)->first();

    }
    //get active classes of pupil for editing
    public function scopeGetClassesForEditing($query, $pupilclass){
       
         return $query->select("classes.id","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                        ->leftJoin('users as a','classes.teacher_id','=','a.id')
                        ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                    ->where( function ($query1) use ($pupilclass) {
                        $current_season = $this->CurrentSeaon_Pupil(now());
                        $query1->where('classes.grade', $pupilclass->grade)
                               ->where('classes.group_id', $pupilclass->group_id)
                               ->where('classes.year', '=', $current_season['year']);
                        })
                    ->orWhere( function ($query2) use ($pupilclass) {
                        $current_season = $this->CurrentSeaon_Pupil(now());
                        $query2->where('classes.grade', $pupilclass->grade)
                               ->where('classes.group_id', $pupilclass->group_id)
                               ->where('classes.year', $current_season['year']);
                        })
                    ->where('classes.active', '=', 1)
                    ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                    ->orderBy(DB::raw("classes.grade asc, classes.year"), 'asc');

       
    }

    public function scopeClassListbyLibrarian($query, $qq, $current_season_year){
        return $query->select("classes.id","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                        ->whereIn('classes.group_id',$qq)
                        ->leftJoin('users as a','classes.teacher_id','=','a.id')
                        ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.active=1 and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                        ->where('classes.active','=',1)
                        ->where('classes.year', $current_season_year)
                        ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                        ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                        ->get();
    }
    public function CurrentSeaon_Pupil($date){
        //$current_season = [];
        if ($date >= Carbon::create((Date("Y")), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 6, 30,23,59,59)){
            $current_season['fromyear'] = Date('Y');
            $current_season['fromM'] = 4;
            $current_season['fromD'] = 1; 
            $current_season['toyear'] = Date('Y');
            $current_season['toM'] = 6;
            $current_season['toD'] = 30;
            $current_season['from'] = (Date('Y')) . '年春期' . '4月1日';
            $current_season['to'] = Date('Y') . '年' . '6月30日';
            $current_season['term'] = 0; // this year spring
            $current_season['season'] = '春期';
            $current_season['year'] = (Date('Y'));
            $current_season['from_num'] = (Date('Y')) . '.' . '4.1';
            $current_season['to_num'] = Date('Y') . '.' . '6.30';
            $current_season['begin_season']=Carbon::create((Date("Y")), 4, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")), 6, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y');
            $current_season['end_thisyear'] = Date('Y')+1;
        }else if ($date >= Carbon::create((Date("Y")), 7, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 9, 30,23,59,59)){
            $current_season['fromyear'] = Date('Y');
            $current_season['fromM'] = 7;
            $current_season['fromD'] = 1; 
            $current_season['toyear'] = Date('Y');
            $current_season['toM'] = 9;
            $current_season['toD'] = 30;
            $current_season['from'] = (Date('Y')) . '年夏期' . '7月1日';
            $current_season['to'] = Date('Y') . '年' . '9月30日';
            $current_season['term'] = 1; // this year summer
            $current_season['season'] = '夏期';
            $current_season['year'] = (Date('Y'));
            $current_season['from_num'] = (Date('Y')) . '.' . '7.1';
            $current_season['to_num'] = Date('Y') . '.' . '9.30';
            $current_season['begin_season']=Carbon::create((Date("Y")), 7, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")), 9, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y');
            $current_season['end_thisyear'] = Date('Y')+1;
        } else if ($date >= Carbon::create((Date("Y")), 10, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 12, 31,23,59,59)){
            $current_season['fromyear'] = Date('Y');
            $current_season['fromM'] = 10;
            $current_season['fromD'] = 1; 
            $current_season['toyear'] = Date('Y');
            $current_season['toM'] = 12;
            $current_season['toD'] = 31;
            $current_season['from'] = (Date('Y')) . '年秋期' . '10月1日';
            $current_season['to'] = Date('Y') . '年' . '12月31日';
            $current_season['term'] = 2; // this year autumn
            $current_season['season'] = '秋期';
            $current_season['year'] = (Date('Y'));
            $current_season['from_num'] = (Date('Y')) . '.' . '10.1';
            $current_season['to_num'] = Date('Y') . '.' . '12.31';
            $current_season['begin_season']=Carbon::create((Date("Y")), 10, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")), 12, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y');
            $current_season['end_thisyear'] = Date('Y')+1;
        } else if ($date >= Carbon::create((Date("Y")), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 3, 31,23,59,59)){
            $current_season['fromyear'] = Date('Y');
            $current_season['fromM'] = 1;
            $current_season['fromD'] = 1; 
            $current_season['toyear'] = Date('Y');
            $current_season['toM'] = 3;
            $current_season['toD'] = 31;
            $current_season['from'] = (Date('Y')) . '年冬期' . '1月1日';
            $current_season['to'] = Date('Y') . '年' . '3月31日';
            $current_season['term'] = 3; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y')) . '.' . '1.1';
            $current_season['to_num'] = Date('Y') . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y")), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
            $current_season['end_thisyear'] = Date('Y');
        }/* else if ($date >= Carbon::create((Date("Y")), 12, 21,0,0,0)){
            $current_season['fromyear'] = Date('Y');
            $current_season['fromM'] = 12;
            $current_season['fromD'] = 21; 
            $current_season['toyear'] = Date('Y')+1;
            $current_season['toM'] = 3;
            $current_season['toD'] = 20;
            $current_season['from'] = (Date('Y')) . '年冬期' . '12月21日';
            $current_season['to'] = (Date('Y') + 1) . '年' . '3月20日';
            $current_season['term'] = 4; // this year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y'));
            $current_season['from_num'] = (Date('Y')) . '.' . '12.21';
            $current_season['to_num'] = (Date('Y') + 1) . '.' . '3.20';
            $current_season['begin_season']= Carbon::create((Date("Y")), 12, 21,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")+1), 3, 20,23,59,59);
            $current_season['begin_thisyear'] = Date('Y');
            $current_season['end_thisyear'] = Date('Y')+1;
        }*/ 

        return $current_season;
    }

}
