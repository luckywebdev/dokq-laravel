<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Auth;
use View;
use DB;
use App\User;
use App\Model\Classes;
use App\Model\Messages;
use App\Model\TeacherHistory;
use App\Model\PersonadminHistory;
use App\Model\PersoncontributionHistory;
use App\Model\PersontestoverseeHistory;
use App\Model\PersonbooksearchHistory;
use App\Model\PersonoverseerHistory;
use App\Model\PersonquizHistory;
use App\Model\PersontestHistory;
use App\Model\PersonworkHistory;
use App\Model\OrgworkHistory;
use Carbon\Carbon;

class GroupController extends Controller
{
    public $page_info = [
        'side' =>'basic_info',
        'subside' =>'basic_info',
        'top' =>'home',
        'subtop' =>'home',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
    }

    public function editGroup(Request $request, $id = null){
        
       if(Auth::user()->isGroup()){
            $user = User::find(Auth::id());
        }else{
            $user = Auth::user()->School;
        }        
        $result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 8));           
        //$date=date_create($user->created_at);
        //date_add($date,date_interval_create_from_date_string("1 years"));
        //$date = date_format($date,"Y/m/d");
        $view = view('group.basic_info')
            ->with('page_info', $this->page_info)
            ->withUser($user);
        
        return $view;
    }

    public function editGroup1(Request $request, $id = null){

        if(!isset($id) || $id == null) {
           if(Auth::user()->isGroup()){
                $user = User::find(Auth::id());
            }else{
                $user = Auth::user()->School;
            }
        }
        else
            $user = User::find($id);
        $result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 8));           
        //$date=date_create($user->created_at);
        //date_add($date,date_interval_create_from_date_string("1 years"));
        //$date = date_format($date,"Y/m/d");
        $view = view('group.basic_info1')
            ->with('page_info', $this->page_info)
            ->withUser($user);
        if(isset($id) && $id !== null)
            $view = $view->withId($id);
        return $view;
    }

    //2.2a school school change page
    public function changedata(Request $request){
        $message = config('consts')['MESSAGES']['GROUP_INFO_CHANGED'];
        $user = User::find($request->input('id'));
        $user->update($request->all());

        if(!is_null($request->input('address1'))){
            $user->address1 = $request->input('address1');
        }
        if(!is_null($request->input('address2'))){
            $user->address2= $request->input('address2');
        }
        if(!is_null($request->input('address3'))){
            $user->address3 = $request->input('address3');
        }
        if(!is_null($request->input('address4'))){
            $user->address4 = $request->input('address4');
        }
        if(!is_null($request->input('address5'))){
            $user->address5 = $request->input('address5');
        }               
        if(!is_null($request->input('phone'))){
            $user->phone = $request->input('phone');
        }
        if(!is_null($request->input('email'))){
            $user->email = $request->input('email');
        }
        if(!is_null($request->input('teacher'))){
            $user->teacher = $request->input('teacher');
        }
        if(!is_null($request->input('repname'))){
            $user->repname = $request->input('repname');
        }
        $user->save();

        return Redirect::back()->withMessage($message);
    }

    //teacher search page 2.2b
    public function searchTeacher(Request $request){
        $this->page_info['side'] = 'teacher_set';
        $this->page_info['subside'] = 'search';
        $this->page_info['top'] = 'teacher_set';
        $this->page_info['subtop'] = 'search';

        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }
        /*$result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 2));*/
        
        /*
        $members = [];
                if ($request->input('year') !== null && $request->input('year') != ""){
            $classes = Classes::where('year', '=', $request->input('year'))->get();

            $teacher_ids = $classes->map(function($class){
                return $class->teacher_id;
            })->toArray();
            $vice_teacher_ids = $classes->map(function($class){
                return $class->vice_teacher_id;
            })->toArray();

            $member_ids = array_unique(array_merge($teacher_ids, $vice_teacher_ids));
            $members = User::whereIn('id',$member_ids)->get();
        }
        if ($request->input('firstname') !== null && $request->input('firstname') != ""){
            $members = User::whereIn('id',$member_ids)->where('firstname','like','%'.$request->input('firstname').'%')->get();
            $member_ids = $members->map(function($member){
                return $member->id;
            })->toArray();
        }
        if ($request->input('lastname') !== null && $request->input('lastname') != ""){
            $members = User::whereIn('id',$member_ids)->where('lastname','like','%'.$request->input('lastname').'%')->get();
            $member_ids = $members->map(function($member){
                return $member->id;
            })->toArray();
        }
        if ($request->input('birthday') !== null && $request->input('birthday') != ""){
            $birthday = $request->input('birthday');
            $members = User::whereIn('id',$member_ids)->where('birthday','like','%'.substr($birthday,0,4).'-'.substr($birthday,4,2).'-'.substr($birthday,6,2).'%')->get();
        }*/
        //print_r(DB::raw('(select `users`.*, `a`.`year` from `users` left join `classes` as `a` on `users`.`id` = `a`.`teacher_id` 
        //        left join `classes` as `b` on `users`.`id` = `b`.`vice_teacher_id` where `users`.`role` = 4 and `a`.`year` = 2018)'));

        $members = [];
        $name_search = 0;
        $years = "";
        if ( $request->input('searchflag') == null ){
            $searchflag = 0;
           // $years = Date("Y");
        }
        else{
            $searchflag = 1;
             /*$members = DB::table("users")
                  ->select('users.*','a.year')
                  ->leftJoin('classes as a','users.id','=','a.teacher_id')
                  //->leftJoin('classes as b','users.id','=','b.vice_teacher_id')
                  ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]]);*/
            if($request->input('name_search') !== null && $request->input('name_search') != ""){
                $name_search = 1;
                $members = DB::table("users")
                ->select('users.*')
                ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                  config('consts')['USER']['ROLE']["LIBRARIAN"],
                  config('consts')['USER']['ROLE']["REPRESEN"],
                  config('consts')['USER']['ROLE']["ITMANAGER"],
                  config('consts')['USER']['ROLE']["OTHER"]])
                ->where('username', '=', $request->input('name_search'))
                ->where( function ($q) {
                    $q->Where(function ($q1)  {
                        $q1->where('active', 1);             
                    })->orWhere(function ($q1) {
                        $q1->Where('active', 2);
                    });
                });
            }
            else{
                $name_search = 0;
                $members = DB::table("users")
                ->select('users.*')
                ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                  config('consts')['USER']['ROLE']["LIBRARIAN"],
                  config('consts')['USER']['ROLE']["REPRESEN"],
                  config('consts')['USER']['ROLE']["ITMANAGER"],
                  config('consts')['USER']['ROLE']["OTHER"]])
                ->where( function ($q) use ($group) {
                    $q->Where(function ($q1)  use ($group)  {
                        $q1->where('active', 1)
                        ->where('org_id', $group->id);             
                    })->orWhere(function ($q1) {
                        $q1->Where('active', 2);
                    });
                });
            }
            
            //if ($request->input('year') !== null && $request->input('year') != "")
            //    $members =  $members->where('created_at', '>=', Carbon::create($request->input('year'), 1, 1,0,0,0));

            if ($request->input('firstname') !== null && $request->input('firstname') != "")
                $members = $members->where('firstname','like','%'.$request->input('firstname').'%');
            
            if ($request->input('lastname') !== null && $request->input('lastname') != "")
                $members = $members->where('lastname','like','%'.$request->input('lastname').'%');

            if ($request->input('birthday') !== null && $request->input('birthday') != ""){
                $birthday = $request->input('birthday');
                $members = $members->where('birthday','like','%'.substr($birthday,0,4).'-'.substr($birthday,4,2).'-'.substr($birthday,6,2).'%');
            }
            $members = $members->distinct()->get();
            //$years = $request->input('year');

        }

        return view('group.teacher_set.teacher_search')
            ->withMembers($members)
            ->with('page_info', $this->page_info)
            ->withGroup($group)
            ->with('name_search', $name_search)
            ->withSearchflag($searchflag);
    }

    public function dosearchteacher(Request $request){
        if(Auth::user()->isGroup()) {
            $group = User::find(Auth::id());
        } else if(Auth::user()->isSchoolMember()) {
            $group = Auth::user()->School;
        }

        if ($request->input('year')!==null && $request->input('year') != ""){
            $classes = Classes::where('year', '=', $request->input('year'))->where('group_id', '=' , $group->id)->get();

            $teacher_ids = $classes->map(function($class){
                return $class->teacher_id;
            })->toArray();
            //$vice_teacher_ids = $classes->map(function($class){
            //    return $class->vice_teacher_id;
           // })->toArray();

            //$member_ids = array_unique(array_merge($teacher_ids, $vice_teacher_ids));
            $member_ids = $teacher_ids;
            $members = User::whereIn('id',$member_ids)->get();
        }
        if ($request->input('firstname')!==null && $request->input('firstname') != ""){
            $members = User::whereIn('id',$member_ids)->where('firstname','like','%'.$request->input('firstname').'%')->get();
            $member_ids = $members->map(function($member){
                return $member->id;
            })->toArray();
        }
        if ($request->input('lastname')!==null && $request->input('lastname') != ""){
            $members = User::whereIn('id',$member_ids)->where('lastname','like','%'.$request->input('lastname').'%')->get();
            $member_ids = $members->map(function($member){
                return $member->id;
            })->toArray();
        }
        if ($request->input('birthday')!==null && $request->input('birthday') != ""){
            $birthday = $request->input('birthday');
            $members = User::whereIn('id',$member_ids)->where('birthday','like','%'.substr($birthday,0,4).'-'.substr($birthday,4,2).'-'.substr($birthday,6,2).'%')->get();
        }
    }

    public function ViewGroupRank($type, Request $request){
        if($request->has("id") && $request->input('id') !== null && $request->input('id') != '') //from pupil mypage
            $other_id = $request->input('id');
        else
            $other_id = Auth::id();
        /*$result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 8));*/
        $this->page_info['side'] = 'rank';
        $this->page_info['top'] = 'rank';
        $current_season = GroupController::CurrentSeaon_Pupil(now());
        $year = $current_season['year'];
        /*$user = DB::table('users')
                   ->select('*')
                   ->where('id', '=', Auth::id())
                   ->first();*/
        $user = User::find($other_id);
        $id = $user->id;
        if($user->role == config('consts')['USER']['ROLE']['GROUP']){
            // $id = $user->org_id;
            $schoolUser =$user;
        }elseif($user->role == config('consts')['USER']['ROLE']['TEACHER'] || $user->role == config('consts')['USER']['ROLE']['REPRESEN']  || $user->role == config('consts')['USER']['ROLE']['ITMANAGER']  || $user->role == config('consts')['USER']['ROLE']['OTHER']){
            $id = $user->org_id;
            $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
        }elseif($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
            $id = $user->org_id;
            $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
        }elseif($user->role == config('consts')['USER']['ROLE']['PUPIL']){
            $class = $user->ClassOfPupil;
            $id = $class->group_id;
            $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
        }
        
        if ($type == 1) {
            
            $this->page_info['subside'] = 'class_rank';
            $this->page_info['subtop'] = 'class_rank';
            $selclasstop = $request->session()->get('selclasstop');

            ///////////////class rank
           /*$tmp_classes = DB::table('classes')
                           ->select('*')
                           ->where('year', '=', DB::raw('YEAR(NOW())'))
                           ->get(); */
            $classes = [];
            /*$cnt = 0;
            for ($i = 1; $i < 7; $i ++) {
                for ($j = 1; $j < 20; $j ++)
                    if ($tmp_classes->where('grade', $i)->where('class_number', $j)->first())
                        $classes[$cnt++] = $tmp_classes->where('grade', $i)->where('class_number', $j)->first();
            }*/
            if($user->role == config('consts')['USER']['ROLE']['TEACHER']){
                $classes = $user->ClassesOfTeacher($current_season)->get();
            }elseif($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $groups = $user->GroupOfLibrarian;
                $classes = []; 
               
                $group_ary = array();
                foreach ($groups as $key => $group) {
                    array_push($group_ary, $group->group_id);
                }
                
                $classes = DB::table('classes')
                        ->select("classes.*", DB::raw("a.group_name as group_name"), DB::raw("concat(b.firstname, ' ', b.lastname) as teacher_name"))
                        ->leftJoin('users as b','classes.teacher_id','=','b.id')
                        ->leftJoin('users as a','classes.group_id','=','a.id')
                        ->whereIn('classes.group_id', $group_ary)
                        ->where('classes.member_counts','>',0)
                        ->where('classes.active','=','1')
                        ->where('classes.year','=', $current_season['year'])
                        ->orderBy(DB::raw("classes.group_id asc, classes.grade asc, classes.class_number"), 'asc')
                        ->get();
            }elseif($user->role == config('consts')['USER']['ROLE']['PUPIL']){
                //$classes = $user->ClassOfPupil;
                $classes = DB::table('classes')
                    //->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("concat(b.firstname, ' ', b.lastname) as vice_teacher_name"))
                    ->select("classes.*", DB::raw("concat(b.firstname, ' ', b.lastname) as teacher_name"))
                    ->leftJoin('users as a','classes.id','=','a.org_id')
                    ->leftJoin('users as b','classes.teacher_id','=','b.id')
                    ->where('a.id', $other_id)
                    ->where('classes.member_counts','>',0)
                    ->where('classes.active','=','1')
                    ->where('classes.year','=', $current_season['year'])
                    ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                    ->get();
            }else{
                $classes = DB::table('classes')
                    //->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("concat(b.firstname, ' ', b.lastname) as vice_teacher_name"))
                    ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"))
                    ->leftJoin('users as a','classes.teacher_id','=','a.id')
                    ->where('classes.group_id', $id)
                    ->where('classes.member_counts','>',0)
                    ->where('classes.active','=','1')
                    ->where('classes.year','=', $current_season['year'])
                    ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                    ->get();
            }
           /* $class_infos = array();
            for ($i = 0; $i < count($classes); $i ++) {
                $class_infos[$i]['grade'] = $classes[$i]->grade;
                $class_infos[$i]['class_number'] = $classes[$i]->class_number;
                $class_infos[$i]['teacher_name'] = $classes[$i]->teacher_name;
                $class_infos[$i]['member_counts'] = $classes[$i]->member_counts;
                $class_infos[$i]['id'] = $classes[$i]->id;

            }*/

            if (count($classes) == 0) {
                $class_id = -1;
                $class_selected['id'] = -1;
            } else {
                if ($request->has('class_id')) {
                    $class_id = $request->input('class_id');
                    $class_selected['id'] = $request->input('class_id');
                } else {
                    $class_id = $classes[0]->id;
                    $class_selected['id'] = $classes[0]->id;
                    
                    if($request->session()->has("selclasstop")){
                        $class_id = $request->session()->get("selclasstop");
                        $class_selected['id'] = $request->session()->get("selclasstop");
                        $request->session()->remove("selclasstop");
                    }
                }
                    
            }
            $avg_point['year'] = GroupController::Calc_avg($class_id, 'year', $current_season);
            $avg_point['spring'] = GroupController::Calc_avg($class_id, 'spring', $current_season);
            $avg_point['summer'] = GroupController::Calc_avg($class_id, 'summer', $current_season);
            $avg_point['autumn'] = GroupController::Calc_avg($class_id, 'autumn', $current_season);
            $avg_point['winter'] = GroupController::Calc_avg($class_id, 'winter', $current_season);
            $avg_point['all'] = GroupController::Calc_avg($class_id, 'all', $current_season);

            $rank_grade['year'] = GroupController::Class_Rank_grade($class_id, 'year', $current_season);
            $rank_grade['spring'] = GroupController::Class_Rank_grade($class_id, 'spring', $current_season);
            $rank_grade['summer'] = GroupController::Class_Rank_grade($class_id, 'summer', $current_season);
            $rank_grade['autumn'] = GroupController::Class_Rank_grade($class_id, 'autumn', $current_season);
            $rank_grade['winter'] = GroupController::Class_Rank_grade($class_id, 'winter', $current_season);
            $rank_grade['all'] = GroupController::Class_Rank_grade($class_id, 'all', $current_season);

            $rank_city['year'] = GroupController::Class_Rank_city($class_id, 'year', $current_season);
            $rank_city['spring'] = GroupController::Class_Rank_city($class_id, 'spring', $current_season);
            $rank_city['summer'] = GroupController::Class_Rank_city($class_id, 'summer', $current_season);
            $rank_city['autumn'] = GroupController::Class_Rank_city($class_id, 'autumn', $current_season);
            $rank_city['winter'] = GroupController::Class_Rank_city($class_id, 'winter', $current_season);
            $rank_city['all'] = GroupController::Class_Rank_city($class_id, 'all', $current_season);

            $rank_province['year'] = GroupController::Class_Rank_province($class_id, 'year', $current_season);
            $rank_province['spring'] = GroupController::Class_Rank_province($class_id, 'spring', $current_season);
            $rank_province['summer'] = GroupController::Class_Rank_province($class_id, 'summer', $current_season);
            $rank_province['autumn'] = GroupController::Class_Rank_province($class_id, 'autumn', $current_season);
            $rank_province['winter'] = GroupController::Class_Rank_province($class_id, 'winter', $current_season);
            $rank_province['all'] = GroupController::Class_Rank_province($class_id, 'all', $current_season);

            $rank_overall['year'] = GroupController::Class_Rank_overall($class_id, 'year', $current_season);
            $rank_overall['spring'] = GroupController::Class_Rank_overall($class_id, 'spring', $current_season);
            $rank_overall['summer'] = GroupController::Class_Rank_overall($class_id, 'summer', $current_season);
            $rank_overall['autumn'] = GroupController::Class_Rank_overall($class_id, 'autumn', $current_season);
            $rank_overall['winter'] = GroupController::Class_Rank_overall($class_id, 'winter', $current_season);
            $rank_overall['all'] = GroupController::Class_Rank_overall($class_id, 'all', $current_season);

            return view('group.rank.class_rank')
                ->with('page_info', $this->page_info)
                ->with('avg_point', $avg_point)
                ->with('classes', $classes)
                ->with('current_season', $current_season)
                ->with('class_selected', $class_selected)
                ->with('rank_grade', $rank_grade)
                ->with('rank_city', $rank_city)
                ->with('rank_province', $rank_province)
                ->with('rank_overall', $rank_overall)
                ->with('other_id', $other_id)
                ->with('user', $user)
                ->with('selclasstop', $selclasstop);
        } elseif ($type == 2) {
            
            ///////////grade rank
            $cnt = 0; $grades = [];
            /*for ($i = 0; $i <= 6; $i ++){
                $classes = Classes::where('group_id', $id)
                    ->where('grade', $i)->where('year', Date('Y'))->get();
                if (count($classes) > 0) $grades[$cnt ++] = $i;
            }*/

            if($user->role == config('consts')['USER']['ROLE']['GROUP']){
                $grades = $user->GradesOfGroup($current_season)->get();
            }elseif($user->role == config('consts')['USER']['ROLE']['TEACHER']){
                $grades = $user->GradesOfTeacher($current_season)->get();
            }elseif($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $groups = $user->GroupOfLibrarian;
                $classes = []; 
               
                $group_ary = array();
                foreach ($groups as $key => $group) {
                    array_push($group_ary, $group->group_id);
                }
                
                $grades = DB::table('classes')
                        ->select("classes.*", DB::raw("a.group_name as group_name"))
                        ->leftJoin('users as a','classes.group_id','=','a.id')
                        ->whereIn('classes.group_id', $group_ary)
                        ->whereNotNull('class_number')
                        ->where('classes.active','=','1')
                        ->where('classes.year', $current_season['year'])
                        ->groupBy(DB::raw("classes.group_id, classes.grade, classes.year"))
                        ->orderBy(DB::raw("classes.group_id asc, classes.grade"), 'asc')
                        ->get();
            }elseif($user->role == config('consts')['USER']['ROLE']['PUPIL']){
                
                $grades = DB::table('classes')
                        ->select("classes.*")
                        ->where('id', $user->org_id)
                        ->whereNotNull('class_number')
                        ->where('classes.active','=','1')
                        ->where('classes.year', $current_season['year'])
                        ->groupby(DB::raw("classes.grade, classes.year"))
                        ->orderBy(DB::raw("classes.group_id asc, classes.grade"), 'asc')
                        ->get();
            }else{
                $grades = DB::table('classes')
                    ->select("classes.*")
                    ->where('group_id', $id)
                    ->whereNotNull('class_number')
                    ->where('classes.active','=','1')
                    ->where('classes.year', $current_season['year'])
                    ->groupby(DB::raw("classes.grade, classes.year"))
                    ->orderBy(DB::raw("classes.group_id asc, classes.grade"), 'asc')
                    ->get();
            }

            if (count($grades) == 0){
                $grade = -1;
                $selected_grade['id'] = -1;
                $year = $year;
                $id = -1;
            }
            else{
                if ($request->has('grade')){
                    $grade = $request->input('grade');
                    $selected_grade['id'] = $request->input('ids');
                    $year = $request->input('sel_year');
                    $group_id =  $request->input('group_id');
                    $id = $request->input('group_id');
                }
                else{
                    $grade = $grades[0]->grade;
                    $selected_grade['id'] = 1;
                    $year = $grades[0]->year;
                    $id = $grades[0]->group_id;

                    if($request->session()->has("selclasstop")){
                        $selclasstop = $request->session()->get("selclasstop");
                        $selclass = Classes::find($selclasstop);
                        $grade = $selclass->grade;

                        foreach ($grades as $key => $value) {
                            if($value->grade == $grade){
                                $selected_grade['id'] = $key+1;
                                break;
                            }
                        }
                        
                        $year = $selclass->year;
                        $id =  $selclass->group_id;

                        $request->session()->remove("selclasstop");
                    }
                }
            }

            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
            }

            $grade_avg_point['year'] = GroupController::Calc_grade_avg($id, $grade, 'year', $year, $current_season);
            $grade_avg_point['spring'] = GroupController::Calc_grade_avg($id, $grade, 'spring', $year, $current_season);
            $grade_avg_point['summer'] = GroupController::Calc_grade_avg($id, $grade, 'summer', $year, $current_season);
            $grade_avg_point['autumn'] = GroupController::Calc_grade_avg($id, $grade, 'autumn', $year, $current_season);
            $grade_avg_point['winter'] = GroupController::Calc_grade_avg($id, $grade, 'winter', $year, $current_season);
            $grade_avg_point['all'] = GroupController::Calc_grade_avg($id, $grade, 'all', $year, $current_season);

            $grade_rank_city['year'] = GroupController::Grade_rank($id, $grade, 'year', $year, 'city');
            $grade_rank_city['spring'] = GroupController::Grade_rank($id, $grade, 'spring', $year, 'city');
            $grade_rank_city['summer'] = GroupController::Grade_rank($id, $grade, 'summer', $year, 'city');
            $grade_rank_city['autumn'] = GroupController::Grade_rank($id, $grade, 'autumn', $year, 'city');
            $grade_rank_city['winter'] = GroupController::Grade_rank($id, $grade, 'winter', $year, 'city');
            $grade_rank_city['all'] = GroupController::Grade_rank($id, $grade, 'all', $year, 'city');

            $grade_rank_province['year'] = GroupController::Grade_rank($id, $grade, 'year', $year, 'province');
            $grade_rank_province['spring'] = GroupController::Grade_rank($id, $grade, 'spring', $year, 'province');
            $grade_rank_province['summer'] = GroupController::Grade_rank($id, $grade, 'summer', $year, 'province');
            $grade_rank_province['autumn'] = GroupController::Grade_rank($id, $grade, 'autumn', $year, 'province');
            $grade_rank_province['winter'] = GroupController::Grade_rank($id, $grade, 'winter', $year, 'province');
            $grade_rank_province['all'] = GroupController::Grade_rank($id, $grade, 'all', $year, 'province');

            $grade_rank_overall['year'] = GroupController::Grade_rank($id, $grade, 'year', $year, 'overall');
            $grade_rank_overall['spring'] = GroupController::Grade_rank($id, $grade, 'spring', $year, 'overall');
            $grade_rank_overall['summer'] = GroupController::Grade_rank($id, $grade, 'summer', $year, 'overall');
            $grade_rank_overall['autumn'] = GroupController::Grade_rank($id, $grade, 'autumn', $year, 'overall');
            $grade_rank_overall['winter'] = GroupController::Grade_rank($id, $grade, 'winter', $year, 'overall');
            $grade_rank_overall['all'] = GroupController::Grade_rank($id, $grade, 'all', $year, 'overall');

            $this->page_info['subside'] = 'school_rank';
            $this->page_info['subtop'] = 'school_rank';
            $view = view('group.rank.school_rank')
                ->with('page_info', $this->page_info)
                ->with('grades', $grades)
                ->with('current_season', $current_season)
                ->with('selected_grade', $selected_grade)
                ->with('grade_avg_point', $grade_avg_point)
                ->with('grade_rank_city', $grade_rank_city)
                ->with('grade_rank_province', $grade_rank_province)
                ->with('grade_rank_overall', $grade_rank_overall)
                ->with('other_id', $other_id)
                ->with('user', $user);
            if(isset($schoolUser) && $schoolUser->group_name !== null)
                $view = $view->with('schoolName', $schoolUser->group_name);
            return $view;
        } elseif ($type == 3) {
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $groups = $user->SchoolOfLibrarian;

                if (count($groups) == 0){
                    $group = -1;
                    $selected_group['id'] = -1;
                    $id = -1;
                }
                else{
                    if ($request->has('group_id')){
                        $id =  $request->input('group_id');
                    }
                    else{
                        $id = $groups[0]->group_id;
                    }
                }
                $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
            }

            ///////////////school rank
            $school_avg_point['year'] = GroupController::Calc_school_avg($id, 'year');
            $school_avg_point['spring'] = GroupController::Calc_school_avg($id, 'spring');
            $school_avg_point['summer'] = GroupController::Calc_school_avg($id, 'summer');
            $school_avg_point['autumn'] = GroupController::Calc_school_avg($id, 'autumn');
            $school_avg_point['winter'] = GroupController::Calc_school_avg($id, 'winter');
            $school_avg_point['year-1'] = GroupController::Calc_school_avg($id, 'year-1');
            $school_avg_point['year-2'] = GroupController::Calc_school_avg($id, 'year-2');
            $school_avg_point['all'] = GroupController::Calc_school_avg($id, 'all');

            $school_rank_city['year'] = GroupController::School_rank($id, $schoolUser, 'year', 'city');
            $school_rank_city['spring'] = GroupController::School_rank($id, $schoolUser, 'spring', 'city');
            $school_rank_city['summer'] = GroupController::School_rank($id, $schoolUser, 'summer', 'city');
            $school_rank_city['autumn'] = GroupController::School_rank($id, $schoolUser, 'autumn', 'city');
            $school_rank_city['winter'] = GroupController::School_rank($id, $schoolUser, 'winter', 'city');
            $school_rank_city['year-1'] = GroupController::School_rank($id, $schoolUser, 'year-1', 'city');
            $school_rank_city['year-2'] = GroupController::School_rank($id, $schoolUser, 'year-2', 'city');
            $school_rank_city['all'] = GroupController::School_rank($id, $schoolUser, 'all', 'city');

            $school_rank_province['year'] = GroupController::School_rank($id, $schoolUser, 'year', 'province');
            $school_rank_province['spring'] = GroupController::School_rank($id, $schoolUser, 'spring', 'province');
            $school_rank_province['summer'] = GroupController::School_rank($id, $schoolUser, 'summer', 'province');
            $school_rank_province['autumn'] = GroupController::School_rank($id, $schoolUser, 'autumn', 'province');
            $school_rank_province['winter'] = GroupController::School_rank($id, $schoolUser, 'winter', 'province');
            $school_rank_province['year-1'] = GroupController::School_rank($id, $schoolUser, 'year-1', 'province');
            $school_rank_province['year-2'] = GroupController::School_rank($id, $schoolUser, 'year-2', 'province');
            $school_rank_province['all'] = GroupController::School_rank($id, $schoolUser, 'all', 'province');

            $school_rank_overall['year'] = GroupController::School_rank($id, $schoolUser, 'year', 'overall');
            $school_rank_overall['spring'] = GroupController::School_rank($id, $schoolUser, 'spring', 'overall');
            $school_rank_overall['summer'] = GroupController::School_rank($id, $schoolUser, 'summer', 'overall');
            $school_rank_overall['autumn'] = GroupController::School_rank($id, $schoolUser, 'autumn', 'overall');
            $school_rank_overall['winter'] = GroupController::School_rank($id, $schoolUser, 'winter', 'overall');
            $school_rank_overall['year-1'] = GroupController::School_rank($id, $schoolUser, 'year-1', 'overall');
            $school_rank_overall['year-2'] = GroupController::School_rank($id, $schoolUser, 'year-2', 'overall');
            $school_rank_overall['all'] = GroupController::School_rank($id, $schoolUser, 'all', 'overall');

            $this->page_info['subside'] = 'country_rank';
            $this->page_info['subtop'] = 'country_rank';
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                return view('group.rank.country_rank')
                    ->with('page_info', $this->page_info)
                    ->with('groups', $groups)
                    ->with('current_season', $current_season)
                    ->with('group_id', $id)
                    ->with('school_avg_point', $school_avg_point)
                    ->with('school_rank_city', $school_rank_city)
                    ->with('school_rank_province', $school_rank_province)
                    ->with('school_rank_overall', $school_rank_overall)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }else{
                return view('group.rank.country_rank')
                    ->with('page_info', $this->page_info)
                    ->with('group_id', $id)
                    ->with('current_season', $current_season)
                    ->with('school_avg_point', $school_avg_point)
                    ->with('school_rank_city', $school_rank_city)
                    ->with('school_rank_province', $school_rank_province)
                    ->with('school_rank_overall', $school_rank_overall)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }   
        } elseif ($type == 4) {
           
            //////////////Last Year 5 Top Schools
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $groups = $user->SchoolOfLibrarian;

                if (count($groups) == 0){
                    $group = -1;
                    $selected_group['id'] = -1;
                    $id = -1;
                }
                else{
                    if ($request->has('group_id')){
                        $id =  $request->input('group_id');
                    }
                    else{
                        $id = $groups[0]->group_id;
                    }
                }
                $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
            }
            if(isset($schoolUser) && $schoolUser !== null && ($schoolUser->group_type == 0 || $schoolUser->group_type == 1)){ //'小学校', '中学校' 
                $cityTopSchools[0] = GroupController::TopSchools_Primary($schoolUser, 'city', 'year-1');
                $provinceTopSchools[0] = GroupController::TopSchools_Primary($schoolUser, 'province', 'year-1');
                $overallTopSchools[0] = GroupController::TopSchools_Primary($schoolUser, 'overall', 'year-1');
                $cityTopSchools[1] = GroupController::TopSchools_Middle($schoolUser, 'city', 'year-1');
                $provinceTopSchools[1] = GroupController::TopSchools_Middle($schoolUser, 'province', 'year-1');
                $overallTopSchools[1] = GroupController::TopSchools_Middle($schoolUser, 'overall', 'year-1');
            }
            else{
                $cityTopSchools = GroupController::TopSchools($schoolUser, 'city', 'year-1');
                $provinceTopSchools = GroupController::TopSchools($schoolUser, 'province', 'year-1');
                $overallTopSchools = GroupController::TopSchools($schoolUser, 'overall', 'year-1');
            }
            

            $this->page_info['subside'] = 'before_best';
            $this->page_info['subtop'] = 'before_best';
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                return view('group.rank.before_best')
                ->with('page_info', $this->page_info)
                ->with('current_season', $current_season)
                ->with('schoolUser', $schoolUser)
                ->with('groups', $groups)
                ->with('group_id', $id)
                ->with('cityTopSchools', $cityTopSchools)
                ->with('provinceTopSchools', $provinceTopSchools)
                ->with('overallTopSchools', $overallTopSchools)
                ->with('other_id', $other_id)
                ->with('user', $user);
            }else{
                return view('group.rank.before_best')
                    ->with('page_info', $this->page_info)
                    ->with('current_season', $current_season)
                    ->with('schoolUser', $schoolUser)
                    ->with('cityTopSchools', $cityTopSchools)
                    ->with('provinceTopSchools', $provinceTopSchools)
                    ->with('overallTopSchools', $overallTopSchools)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }
        } elseif ($type == 5) {
            
            ////////////////Two years before 5 Top Schools
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $groups = $user->SchoolOfLibrarian;

                if (count($groups) == 0){
                    $group = -1;
                    $selected_group['id'] = -1;
                }
                else{
                    if ($request->has('group_id')){
                        $id =  $request->input('group_id');
                    }
                    else{
                        $id = $groups[0]->group_id;
                    }
                }
                $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
            }
            if($schoolUser->group_type == 0 || $schoolUser->group_type == 1){
                $cityTopSchools[0] = GroupController::TopSchools_Primary($schoolUser, 'city', 'year-2');
                $provinceTopSchools[0] = GroupController::TopSchools_Primary($schoolUser, 'province', 'year-2');
                $overallTopSchools[0] = GroupController::TopSchools_Primary($schoolUser, 'overall', 'year-2');
                $cityTopSchools[1] = GroupController::TopSchools_Middle($schoolUser, 'city', 'year-2');
                $provinceTopSchools[1] = GroupController::TopSchools_Middle($schoolUser, 'province', 'year-2');
                $overallTopSchools[1] = GroupController::TopSchools_Middle($schoolUser, 'overall', 'year-2');
            }else{
                $cityTopSchools = GroupController::TopSchools($schoolUser, 'city', 'year-2');
                $provinceTopSchools = GroupController::TopSchools($schoolUser, 'province', 'year-2');
                $overallTopSchools = GroupController::TopSchools($schoolUser, 'overall', 'year-2');
            }

            $this->page_info['subside'] = '2before_best';
            $this->page_info['subtop'] = '2before_best';
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                return view('group.rank.2before_best')
                    ->with('page_info', $this->page_info)
                    ->with('current_season', $current_season)
                    ->with('schoolUser', $schoolUser)
                    ->with('groups', $groups)
                    ->with('group_id', $id)
                    ->with('cityTopSchools', $cityTopSchools)
                    ->with('provinceTopSchools', $provinceTopSchools)
                    ->with('overallTopSchools', $overallTopSchools)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }else{
                return view('group.rank.2before_best')
                    ->with('page_info', $this->page_info)
                    ->with('current_season', $current_season)
                    ->with('schoolUser', $schoolUser)
                    ->with('cityTopSchools', $cityTopSchools)
                    ->with('provinceTopSchools', $provinceTopSchools)
                    ->with('overallTopSchools', $overallTopSchools)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }
        } elseif ($type == 6) {
            ////////////////7 Top Schools in last 5 years
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                $groups = $user->SchoolOfLibrarian;

                if (count($groups) == 0){
                    $group = -1;
                    $selected_group['id'] = -1;
                }
                else{
                    if ($request->has('group_id')){
                        $id =  $request->input('group_id');
                    }
                    else{
                        $id = $groups[0]->group_id;
                    }
                }
                $schoolUser =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $id)
                           ->first();
            }

            if($schoolUser->group_type == 0 || $schoolUser->group_type == 1){
                $cityTopSchools_1[0] = GroupController::TopSchools_7_Primary($schoolUser, 'city', 'year-1');
                $cityTopSchools_2[0] = GroupController::TopSchools_7_Primary($schoolUser, 'city', 'year-2');
                $cityTopSchools_3[0] = GroupController::TopSchools_7_Primary($schoolUser, 'city', 'year-3');
                $cityTopSchools_4[0] = GroupController::TopSchools_7_Primary($schoolUser, 'city', 'year-4');
                $cityTopSchools_5[0] = GroupController::TopSchools_7_Primary($schoolUser, 'city', 'year-5');

                $provinceTopSchools_1[0] = GroupController::TopSchools_7_Primary($schoolUser, 'province', 'year-1');
                $provinceTopSchools_2[0] = GroupController::TopSchools_7_Primary($schoolUser, 'province', 'year-2');
                $provinceTopSchools_3[0] = GroupController::TopSchools_7_Primary($schoolUser, 'province', 'year-3');
                $provinceTopSchools_4[0] = GroupController::TopSchools_7_Primary($schoolUser, 'province', 'year-4');
                $provinceTopSchools_5[0] = GroupController::TopSchools_7_Primary($schoolUser, 'province', 'year-5');

                $overallTopSchools_1[0] = GroupController::TopSchools_7_Primary($schoolUser, 'overall', 'year-1');
                $overallTopSchools_2[0] = GroupController::TopSchools_7_Primary($schoolUser, 'overall', 'year-2');
                $overallTopSchools_3[0] = GroupController::TopSchools_7_Primary($schoolUser, 'overall', 'year-3');
                $overallTopSchools_4[0] = GroupController::TopSchools_7_Primary($schoolUser, 'overall', 'year-4');
                $overallTopSchools_5[0] = GroupController::TopSchools_7_Primary($schoolUser, 'overall', 'year-5');

                $cityTopSchools_1[1] = GroupController::TopSchools_7_Middle($schoolUser, 'city', 'year-1');
                $cityTopSchools_2[1] = GroupController::TopSchools_7_Middle($schoolUser, 'city', 'year-2');
                $cityTopSchools_3[1] = GroupController::TopSchools_7_Middle($schoolUser, 'city', 'year-3');
                $cityTopSchools_4[1] = GroupController::TopSchools_7_Middle($schoolUser, 'city', 'year-4');
                $cityTopSchools_5[1] = GroupController::TopSchools_7_Middle($schoolUser, 'city', 'year-5');

                $provinceTopSchools_1[1] = GroupController::TopSchools_7_Middle($schoolUser, 'province', 'year-1');
                $provinceTopSchools_2[1] = GroupController::TopSchools_7_Middle($schoolUser, 'province', 'year-2');
                $provinceTopSchools_3[1] = GroupController::TopSchools_7_Middle($schoolUser, 'province', 'year-3');
                $provinceTopSchools_4[1] = GroupController::TopSchools_7_Middle($schoolUser, 'province', 'year-4');
                $provinceTopSchools_5[1] = GroupController::TopSchools_7_Middle($schoolUser, 'province', 'year-5');

                $overallTopSchools_1[1] = GroupController::TopSchools_7_Middle($schoolUser, 'overall', 'year-1');
                $overallTopSchools_2[1] = GroupController::TopSchools_7_Middle($schoolUser, 'overall', 'year-2');
                $overallTopSchools_3[1] = GroupController::TopSchools_7_Middle($schoolUser, 'overall', 'year-3');
                $overallTopSchools_4[1] = GroupController::TopSchools_7_Middle($schoolUser, 'overall', 'year-4');
                $overallTopSchools_5[1] = GroupController::TopSchools_7_Middle($schoolUser, 'overall', 'year-5');
            }else{
                $cityTopSchools_1 = GroupController::TopSchools_7($schoolUser, 'city', 'year-1');
                $cityTopSchools_2 = GroupController::TopSchools_7($schoolUser, 'city', 'year-2');
                $cityTopSchools_3 = GroupController::TopSchools_7($schoolUser, 'city', 'year-3');
                $cityTopSchools_4 = GroupController::TopSchools_7($schoolUser, 'city', 'year-4');
                $cityTopSchools_5 = GroupController::TopSchools_7($schoolUser, 'city', 'year-5');

                $provinceTopSchools_1 = GroupController::TopSchools_7($schoolUser, 'province', 'year-1');
                $provinceTopSchools_2 = GroupController::TopSchools_7($schoolUser, 'province', 'year-2');
                $provinceTopSchools_3 = GroupController::TopSchools_7($schoolUser, 'province', 'year-3');
                $provinceTopSchools_4 = GroupController::TopSchools_7($schoolUser, 'province', 'year-4');
                $provinceTopSchools_5 = GroupController::TopSchools_7($schoolUser, 'province', 'year-5');

                $overallTopSchools_1 = GroupController::TopSchools_7($schoolUser, 'overall', 'year-1');
                $overallTopSchools_2 = GroupController::TopSchools_7($schoolUser, 'overall', 'year-2');
                $overallTopSchools_3 = GroupController::TopSchools_7($schoolUser, 'overall', 'year-3');
                $overallTopSchools_4 = GroupController::TopSchools_7($schoolUser, 'overall', 'year-4');
                $overallTopSchools_5 = GroupController::TopSchools_7($schoolUser, 'overall', 'year-5');
            }
            

            $this->page_info['subside'] = 'recent_best';
            $this->page_info['subtop'] = 'recent_best';
            if($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']){
                return view('group.rank.recent_best')
                    ->with('page_info', $this->page_info)
                    ->with('current_season', $current_season)
                    ->with('schoolUser', $schoolUser)
                    ->with('groups', $groups)
                    ->with('group_id', $id)
                    ->with('cityTopSchools_1', $cityTopSchools_1)
                    ->with('cityTopSchools_2', $cityTopSchools_2)
                    ->with('cityTopSchools_3', $cityTopSchools_3)
                    ->with('cityTopSchools_4', $cityTopSchools_4)
                    ->with('cityTopSchools_5', $cityTopSchools_5)
                    ->with('provinceTopSchools_1', $provinceTopSchools_1)
                    ->with('provinceTopSchools_2', $provinceTopSchools_2)
                    ->with('provinceTopSchools_3', $provinceTopSchools_3)
                    ->with('provinceTopSchools_4', $provinceTopSchools_4)
                    ->with('provinceTopSchools_5', $provinceTopSchools_5)
                    ->with('overallTopSchools_1', $overallTopSchools_1)
                    ->with('overallTopSchools_2', $overallTopSchools_2)
                    ->with('overallTopSchools_3', $overallTopSchools_3)
                    ->with('overallTopSchools_4', $overallTopSchools_4)
                    ->with('overallTopSchools_5', $overallTopSchools_5)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }else{
                return view('group.rank.recent_best')
                    ->with('page_info', $this->page_info)
                    ->with('current_season', $current_season)
                    ->with('schoolUser', $schoolUser)
                    ->with('cityTopSchools_1', $cityTopSchools_1)
                    ->with('cityTopSchools_2', $cityTopSchools_2)
                    ->with('cityTopSchools_3', $cityTopSchools_3)
                    ->with('cityTopSchools_4', $cityTopSchools_4)
                    ->with('cityTopSchools_5', $cityTopSchools_5)
                    ->with('provinceTopSchools_1', $provinceTopSchools_1)
                    ->with('provinceTopSchools_2', $provinceTopSchools_2)
                    ->with('provinceTopSchools_3', $provinceTopSchools_3)
                    ->with('provinceTopSchools_4', $provinceTopSchools_4)
                    ->with('provinceTopSchools_5', $provinceTopSchools_5)
                    ->with('overallTopSchools_1', $overallTopSchools_1)
                    ->with('overallTopSchools_2', $overallTopSchools_2)
                    ->with('overallTopSchools_3', $overallTopSchools_3)
                    ->with('overallTopSchools_4', $overallTopSchools_4)
                    ->with('overallTopSchools_5', $overallTopSchools_5)
                    ->with('other_id', $other_id)
                    ->with('user', $user);
            }
        }
    }

    /* Calculate class average point and rank classes according to the range*/
    private function Calc_avg($class_id, $period, $current_season) {
        $startAt = ''; $endAt = '';
        if ($period == 'year') {
            $startAt = Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear'],3, 31,23,59,59);
        } else if ($period == 'spring'){
            $startAt = Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],6, 30,23,59,59);
        } else if ($period == 'summer'){
            $startAt = Carbon::create($current_season['begin_thisyear'],7, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],9, 30,23,59,59);
        } else if ($period == 'autumn'){
            $startAt = Carbon::create($current_season['begin_thisyear'],10, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],12, 31,23,59,59);
        } else if ($period == 'winter'){
            $startAt = Carbon::create($current_season['end_thisyear'],1, 1,0,0,0);
            $endAt = Carbon::create($current_season['end_thisyear'],3, 31,23,59,59);
        }

       /* select c.group_id, c.grade, c.class_number, sum(b.point) as sumpoint 
from `classes` as `c` 
left join `users` as `a` on `a`.`org_id` = `c`.`id` 
left join `user_quizes` as `b` on `a`.`id` = `b`.`user_id`
where `a`.`role` = 9 and ((`b`.`type` = 0 and `b`.`status` = 1) or (`b`.`type` = 1 and `b`.`status` = 1) or (`b`.`type` = 2 and `b`.`status` = 3)) 
group by c.group_id, c.grade, c.class_number 
order by sumpoint desc */

        $avgYear = DB::table("classes as c")
            ->select(DB::raw("c.group_id, c.grade, c.class_number, sum(b.point) as sumpoint ,ROUND(sum(b.point) / COUNT(a.id), 2) as avgpoint"))
            ->leftJoin("users AS a", "a.org_id","=","c.id")
            ->leftJoin("user_quizes AS b", "a.id","=","b.user_id")
            ->where("a.role", "=", config('consts')['USER']['ROLE']['PUPIL'])
            ->where("c.id", "=", $class_id)
            ->where("c.active", "=", 1)
            ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('b.type', '=', 0)->where('b.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('b.type', '=', 1)->where('b.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('b.type', '=', 2)->where('b.status', '=', 3);
                });
            })
            ->groupBy(DB::raw("c.group_id, c.grade, c.class_number"))
            ->orderBy("avgpoint", 'desc');
        if ($period != 'all') {
            $avgYear = $avgYear->where('b.created_date','>=', $startAt)
            ->where('b.created_date','<=', $endAt);
        }
        $avgYear = $avgYear->first();   
        return $avgYear ? $avgYear->avgpoint : 0;
    }

    static function Calc_sum($class_id, $period, $year, $current_season) {
        $startAt = ''; $endAt = '';
        if ($period == 'year') {
            $startAt = Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear'],3, 31,23,59,59);
        } else if ($period == 'spring'){
            $startAt = Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],6, 30,23,59,59);
        } else if ($period == 'summer'){
            $startAt = Carbon::create($current_season['begin_thisyear'],7, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],9, 30,23,59,59);
        } else if ($period == 'autumn'){
            $startAt = Carbon::create($current_season['begin_thisyear'],10, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],12, 31,23,59,59);
        } else if ($period == 'winter'){
            $startAt = Carbon::create($current_season['begin_thisyear'],1, 1,0,0,0);
            $endAt = Carbon::create($current_season['begin_thisyear'],3, 31,23,59,59);
        } else if ($period == 'year-1'){
            $startAt = Carbon::create($current_season['begin_thisyear']-1,4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear']-1,3, 31,23,59,59);
        } else if ($period == 'year-2') {
            $startAt = Carbon::create($current_season['begin_thisyear']-2,4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear']-2,3, 31,23,59,59);
        } else if ($period == 'year-3') {
            $startAt = Carbon::create($current_season['begin_thisyear']-3,4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear']-3,3, 31,23,59,59);
        } else if ($period == 'year-4') {
            $startAt = Carbon::create($current_season['begin_thisyear']-4,4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear']-4,3, 31,23,59,59);
        } else if ($period == 'year-5') {
            $startAt = Carbon::create($current_season['begin_thisyear']-5,4, 1,0,0,0);
            $endAt =  Carbon::create($current_season['end_thisyear']-5,3, 31,23,59,59);
        }

       /* select c.group_id, c.grade, c.class_number, sum(b.point) as sumpoint 
from `classes` as `c` 
left join `users` as `a` on `a`.`org_id` = `c`.`id` 
left join `user_quizes` as `b` on `a`.`id` = `b`.`user_id`
where `a`.`role` = 9 and ((`b`.`type` = 0 and `b`.`status` = 1) or (`b`.`type` = 1 and `b`.`status` = 1) or (`b`.`type` = 2 and `b`.`status` = 3)) 
group by c.group_id, c.grade, c.class_number 
order by sumpoint desc */

        $avgYear = DB::table("classes as c")
            ->select(DB::raw("c.group_id, c.grade, c.class_number, sum(b.point) as sumpoint , count(a.id) as pupils, ROUND(sum(b.point) / COUNT(a.id), 2) as avgpoint"))
            ->leftJoin("users AS a", "a.org_id","=","c.id")
            ->leftJoin("user_quizes AS b", "a.id","=","b.user_id")
            ->where("a.role", "=", config('consts')['USER']['ROLE']['PUPIL'])
            ->where("c.id", "=", $class_id)
            ->where("c.year", "=", $year)
            ->where("c.active", "=", 1)
            ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('b.type', '=', 0)->where('b.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('b.type', '=', 1)->where('b.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('b.type', '=', 2)->where('b.status', '=', 3);
                });
            })
            ->groupBy(DB::raw("c.group_id, c.grade, c.year, c.class_number"))
            ->orderBy("avgpoint", 'desc');
        if ($period != 'all') {
            $avgYear = $avgYear->where('b.created_date','>=', $startAt)
            ->where('b.created_date','<=', $endAt);
        }
        $avgYear = $avgYear->first();   
        return $avgYear ? floor($avgYear->sumpoint*100)/100 : 0;
    }

    static function Calc_pupils($class_id, $period, $year) {
        

        $avgYear = DB::table("classes as c")
            ->select(DB::raw("c.group_id, c.grade,  count(a.id) as pupils"))
            ->leftJoin("users AS a", "a.org_id","=","c.id")
            ->where("a.role", "=", config('consts')['USER']['ROLE']['PUPIL'])
            ->where("c.id", "=", $class_id)
            ->where("c.active", "=", 1)
            ->groupBy(DB::raw("c.group_id, c.grade, c.class_number"));
       
        $avgYear = $avgYear->first();   
        return $avgYear ? $avgYear->pupils : 0;
    }

    private function Class_Rank_grade($class_id, $period, $current_season){
        if ($class_id == -1) return "";
        $classes = Classes::where('group_id', Classes::find($class_id)->group_id)
            ->where('grade', Classes::find($class_id)->grade)
            ->whereNotNull('class_number')
            ->where('year', '=', Classes::find($class_id)->year)
            ->where("active", "=", 1)->get();
        $current_sum = GroupController::Calc_avg($class_id, $period, $current_season);
        $rank = 0;


        for ($i = 0; $i < count($classes); $i++){

            if ($class_id == $classes[$i]->id) continue;

            if ($current_sum >= (GroupController::Calc_avg($classes[$i]->id, $period, $current_season))) $rank++;
        }

        return (count($classes) - $rank) . "/" . count($classes);
    }

    private function Class_Rank_city($class_id, $period, $current_season){

        if ($class_id == -1) return "";
        $selClass = Classes::find($class_id); 
        $pupils = $selClass->Pupils;
        $allClasses = Classes::where("grade", $selClass->grade)
                        ->whereNotNull('class_number')
                        ->where('year', '=', $selClass->year)
                        ->where("active", "=", 1)
                        ->get(); 
       
        $classes = []; $j = 0; 
        for ($i = 0; $i < count($allClasses); $i++){
            //if ($allClasses[$i]->year == $year){

               /* if (User::find(Classes::find($class_id)->group_id)->address1 ==
                    User::find($allClasses[$i]->group_id)->address1 &&
                    User::find(Classes::find($class_id)->group_id)->address2 ==
                    User::find($allClasses[$i]->group_id)->address2){
                    $classes[$j++] = $allClasses[$i];
                }*/

               $users1 =DB::table('users')
                        ->select('users.*')
                         ->where('classes.id','=',$class_id)
                         ->join('classes','users.id','=','classes.group_id')
                         ->first();

                $users2 =DB::table('users')
                        ->select('users.*')
                         ->where('id','=', $allClasses[$i]->group_id)
                         ->where('active','=', 1)
                         ->first();
                $address1 = ''; $address2 = ''; $gaddress1 = ''; $gaddress2 = '';
                if((is_array($users1) || is_object($users1)) && !is_null($users1)){
                    if(count(get_object_vars($users1)) > 0){
                        $address1 =  $users1->address1;
                        $address2 =  $users1->address2;
                    }
                }
                if(is_array($users2) || is_object($users2)){
                    if(count(get_object_vars($users2)) > 0){
                        $gaddress1 =  $users2->address1;
                        $gaddress2 =  $users2->address2;
                    }
                }
                if($address1 == $gaddress1 && $address2 == $gaddress2)
                    $classes[$j++] = $allClasses[$i];
            //}
        }

        $current_sum = GroupController::Calc_avg($class_id, $period, $current_season);  $rank = 0;
        for ($i = 0; $i < count($classes); $i++){
            if ($class_id == $classes[$i]->id) continue;
            if ($current_sum >= (GroupController::Calc_avg($classes[$i]->id, $period, $current_season))) $rank++;
        }

        return (count($classes) - $rank) . "/" . count($classes);
    }

    private function Class_Rank_province($class_id, $period, $current_season){

        if ($class_id == -1) return "";
        $selClass = Classes::find($class_id);
        $pupils = $selClass->Pupils;
        $allClasses = Classes::where("grade", $selClass->grade)
                        ->where("type", $selClass->type)->whereNotNull('class_number')->where('year', '=', $selClass->year)->where("active", "=", 1)->get();
        $classes = [];
        $j = 0;

        for ($i = 0; $i < count($allClasses); $i++){
            //if ($allClasses[$i]->year == $year){

                /*if (User::find(Classes::find($class_id)->group_id)->address1 ==
                    User::find($allClasses[$i]->group_id)->address1){
                    $classes[$j++] = $allClasses[$i];
                }*/

                $users1 =DB::table('users')
                        ->select('users.*')
                         ->where('classes.id','=',$class_id)
                         ->join('classes','users.id','=','classes.group_id')
                         ->first();

                $users2 =DB::table('users')
                        ->select('users.*')
                         ->where('id','=', $allClasses[$i]->group_id)
                         ->where('active','=', 1)
                         ->first();
                $address1 = ''; $gaddress1 = '';
                if($users1 != null && count(get_object_vars($users1)) > 0)
                    $address1 =  $users1->address1;
                
                if($users2 != null && count(get_object_vars($users2)) > 0)
                    $gaddress1 =  $users2->address1;
                   
                if($address1 == $gaddress1)
                    $classes[$j++] = $allClasses[$i];
            //}

        }

        $current_sum = GroupController::Calc_avg($class_id, $period, $current_season);  $rank = 0;

        for ($i = 0; $i < count($classes); $i++){
            if ($class_id == $classes[$i]->id) continue;

            if ($current_sum >= (GroupController::Calc_avg($classes[$i]->id, $period, $current_season))) $rank++;
        }

        return (count($classes) - $rank) . "/" . count($classes);
    }


    private function Class_Rank_overall($class_id, $period, $current_season){

        if ($class_id == -1) return "";
        $selClass = Classes::find($class_id);
        $allClasses = Classes::where("grade", $selClass->grade)
                        ->where("type", $selClass->type)->whereNotNull('class_number')->where('year', '=', $selClass->year)->where("active", "=", 1)->get();

        $current_sum = GroupController::Calc_avg($class_id, $period, $current_season);  $rank = 0;

        for ($i = 0; $i < count($allClasses); $i++){

            if ($class_id == $allClasses[$i]->id) continue;

            if ($current_sum >= (GroupController::Calc_avg($allClasses[$i]->id, $period, $current_season))) $rank++;
        }

        return (count($allClasses) - $rank) . "/" . count($allClasses);
    }

    /* Calculate grade average point and rank grades according to the range*/
    private function Calc_grade_avg($groupId, $grade, $period, $year, $current_season){

        if ($grade == -1) return "";
        $classes = Classes::where('group_id', $groupId)
            ->where('grade', $grade)
            ->where('year', $year)->whereNotNull('class_number')->where("active", "=", 1)->get();

        $sum = 0; $grade_pupils = 0;
       
        for ($i = 0; $i < count($classes); $i++){
            
            $sum += GroupController::Calc_sum($classes[$i]->id, $period, $year, $current_season);
            $grade_pupils += GroupController::Calc_pupils($classes[$i]->id, $period, $year);
        }
      
        if (count($classes) == 0) return 0;
        elseif($grade_pupils == 0) return 0;
        return round($sum / $grade_pupils, 2);
    }

    private function Grade_rank($groupId, $grade, $period, $year, $range){

        if ($grade == -1) return "";
        if ($range == 'city'){
            $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                ->where('address1', User::find($groupId)->address1)
                ->where('address2', User::find($groupId)->address2)
                ->where('group_type', User::find($groupId)->group_type)
                ->where('active', 1)
                ->get();
        }
        else if ($range == 'province'){
            $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                ->where('address1', User::find($groupId)->address1)
                ->where('group_type', User::find($groupId)->group_type)
                ->where('active', 1)->get();
        }
        else if ($range == 'overall'){
            $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
            ->where('group_type', User::find($groupId)->group_type)
            ->where('active', 1)->get();
        }

        $current_season = GroupController::CurrentSeaon_Pupil(now());
        $current_sum = GroupController::Calc_grade_avg($groupId, $grade, $period, $year, $current_season);

        $rank = 0; $grades_num = 0;

        for ($i = 0; $i < count($groups); $i ++){
            //for ($j = 0; $j < 7; $j ++){
                $tmp_classes = Classes::where('group_id', $groups[$i]->id)->where('grade', $grade)->where('year', $year)->where('active', 1)->get();
                
                if (count($tmp_classes) > 0){
                    //if ($tmp_classes[0]->year != $year) continue;
                    $grades_num ++;
                    if ($groups[$i]->id == $groupId) continue;
                    //if ($groups[$i]->id == $groupId && $grade == $j) continue;
                    if ($current_sum >= GroupController::Calc_grade_avg($groups[$i]->id, $grade, $period, $year, $current_season)) $rank ++;
                }
            //}
        }

        return ($grades_num - $rank) . "/" . $grades_num;

    }

    /* Calculate school average point and rank schools according to the range*/
    static function Calc_school_avg($groupId, $period ){

        // $classes = array();
        // if($groupId !== null && $groupId != -1 &&  User::find($groupId))
        //     $classes = User::find($groupId)->classes;
        // if (count($classes) == 0) return 0;

        // $k = 0;
        // for ($i = 0; $i < count($classes); $i ++){
        //     for ($j = 0; $j < count($classes[$i]->Pupils); $j ++) 
        //         $pupils[$k++] = $classes[$i]->Pupils[$j];
        // }

        // if ($k == 0) return 0;
        // $sum = 0;
        // $current_season = GroupController::CurrentSeaon_Pupil1(now());
        // for ($i = 0; $i < count($pupils); $i++){

        //     if ($period == 'year'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear'],4,1,$current_season['end_thisyear'],3,31);
        //     }
        //     else if ($period == 'spring'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear'],4,1,$current_season['begin_thisyear'],6,30);
        //     }
        //     else if ($period == 'summer'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear'],7,1,$current_season['begin_thisyear'],9,30);
        //     }
        //     else if ($period == 'autumn'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear'],10,1,$current_season['begin_thisyear'],12,31);
        //     }
        //     else if ($period == 'winter'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear'],1,1,$current_season['begin_thisyear'],3,31);
        //     }
        //     else if ($period == 'all'){
        //         $quizes = $pupils[$i]->SuccessPoints;
        //     }
        //     else if ($period == 'year-1'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear']-1,4,1,$current_season['end_thisyear']-1,3,31);
        //     }
        //     else if ($period == 'year-2'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear']-2,4,1,$current_season['end_thisyear']-2,3,31);
        //     }
        //     else if ($period == 'year-3'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear']-3,4,1,$current_season['end_thisyear']-3,3,31);
        //     }
        //     else if ($period == 'year-4'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear']-4,4,1,$current_season['end_thisyear']-4,3,31);
        //     }
        //     else if ($period == 'year-5'){
        //         $quizes = $pupils[$i]->SuccessQuizPoints1($current_season['begin_thisyear']-5,4,1,$current_season['end_thisyear']-5,3,31);
        //     }
        //     if (count(get_object_vars($quizes)) == 0) continue;
        //     $sum += $quizes->sum('user_quizes.point'); 
        // }

        // if (count($pupils) == 0) $sum = 0;
        // else $sum /= count($pupils);

        // return round($sum, 2);

        $current_season = GroupController::CurrentSeaon_Pupil1(now());
        $year = $current_season['begin_thisyear'];
        $classes = Classes::where('group_id', $groupId)
            ->where('year', $year)->whereNotNull('class_number')->where("active", "=", 1)->get();

        $sum = 0; $grade_pupils = 0;
       
        for ($i = 0; $i < count($classes); $i++){
            
            $sum += GroupController::Calc_sum($classes[$i]->id, $period, $year, $current_season);
            $grade_pupils += GroupController::Calc_pupils($classes[$i]->id, $period, $year);
        }
      
        if (count($classes) == 0) return 0;
        elseif($grade_pupils == 0) return 0;
        return round($sum / $grade_pupils, 2);

    }

    static function School_rank($groupId, $schoolUser, $period, $range){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        $current_sum = GroupController::Calc_school_avg($groupId, $period);
        $rank = 0;
        for ($i = 0; $i < count($groups); $i ++){
            if ($groups[$i]->id == $groupId) continue;
            if ($current_sum >= GroupController::Calc_school_avg($groups[$i]->id, $period)) $rank ++;
        }
        return (count($groups) - $rank) . "/" . count($groups);
    }
    static function School_rank1($groupId, $schoolUser, $period, $range){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        $current_sum = GroupController::Calc_school_avg($groupId, $period);
        $rank = 0;
        for ($i = 0; $i < count($groups); $i ++){
            if ($groups[$i]->id == $groupId) continue;
            if ($current_sum >= GroupController::Calc_school_avg($groups[$i]->id, $period)) $rank ++;
        }
        return (count($groups) - $rank) . ":" . count($groups);
    }

    /* Calculate Top Schools */
    private function TopSchools($schoolUser, $range, $delta){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }
        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }
        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('group_type', $schoolUser->group_type)
                    ->where('active', 1)
                    ->get();
        }

        for ($i = 0; $i < count($groups); $i ++){
            $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $delta);
        }

        for ($i = 0; $i < count($groups); $i ++){
            for ($j = $i + 1; $j < count($groups); $j ++){
                if ($group_sums[$j] > $group_sums[$i]){
                    $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
                    $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
                }
            }
        }
        $rank = 1;
        $top_schools = array();
        for ($i = 0; $i < count($groups); $i ++){
            if ($i == 5) break;
            $top_schools[$i]['name'] = $groups[$i]->group_name;
            $top_schools[$i]['point'] = $group_sums[$i];

            if($i != 0 && $group_sums[$i-1] > $group_sums[$i]) $rank++;
            $top_schools[$i]['rank'] = $rank;
        }

        return $top_schools;
    }

    /* Calculate Top primary Schools */
    private function TopSchools_Primary($schoolUser, $range, $delta){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)
                    ->where('group_type', 0)
                    ->where('active', 1)
                    ->get();
        }
        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('group_type', 0)
                    ->where('active', 1)
                    ->get();
        }
        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('group_type', 0)
                    ->where('active', 1)
                    ->get();
        }

        for ($i = 0; $i < count($groups); $i ++){
            $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $delta);
        }

        for ($i = 0; $i < count($groups); $i ++){
            for ($j = $i + 1; $j < count($groups); $j ++){
                if ($group_sums[$j] > $group_sums[$i]){
                    $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
                    $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
                }
            }
        }
        $rank = 1;
        $top_schools = array();
        for ($i = 0; $i < count($groups); $i ++){
            if ($i == 5) break;
            $top_schools[$i]['name'] = $groups[$i]->group_name;
            $top_schools[$i]['point'] = $group_sums[$i];

            if($i != 0 && $group_sums[$i-1] > $group_sums[$i]) $rank++;
            $top_schools[$i]['rank'] = $rank;
        }

        return $top_schools;
    }

    /* Calculate Top middle Schools */
    private function TopSchools_Middle($schoolUser, $range, $delta){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)
                    ->where('group_type', 1)
                    ->where('active', 1)
                    ->get();
        }
        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('address1', $schoolUser->address1)
                    ->where('group_type', 1)
                    ->where('active', 1)
                    ->get();
        }
        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])
                    ->where('group_type', 1)
                    ->where('active', 1)
                    ->get();
        }

        for ($i = 0; $i < count($groups); $i ++){
            $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $delta);
        }

        for ($i = 0; $i < count($groups); $i ++){
            for ($j = $i + 1; $j < count($groups); $j ++){
                if ($group_sums[$j] > $group_sums[$i]){
                    $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
                    $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
                }
            }
        }
        $rank = 1;
        $top_schools = array();
        for ($i = 0; $i < count($groups); $i ++){
            if ($i == 5) break;
            $top_schools[$i]['name'] = $groups[$i]->group_name;
            $top_schools[$i]['point'] = $group_sums[$i];

            if($i != 0 && $group_sums[$i-1] > $group_sums[$i]) $rank++;
            $top_schools[$i]['rank'] = $rank;
        }

        return $top_schools;
    }

    private function TopSchools_7($schoolUser, $range, $period){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)->where('group_type', $schoolUser->group_type)->get();
        }
        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('address1', $schoolUser->address1)->where('group_type', $schoolUser->group_type)->get();
        }
        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('group_type', $schoolUser->group_type)->get();
        }

        for ($i = 0; $i < count($groups); $i ++){
            $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $period);
        }

        for ($i = 0; $i < count($groups); $i ++){
            for ($j = $i + 1; $j < count($groups); $j ++){
                if ($group_sums[$j] > $group_sums[$i]){
                    $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
                    $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
                }
            }
        }
        $top_schools = array();
        for ($i = 0; $i < count($groups); $i ++){
            if ($i == 7) break;
            $top_schools[$i]['name'] = $groups[$i]->group_name;
        }

        return $top_schools;
    }

    private function TopSchools_7_Primary($schoolUser, $range, $period){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)->where('group_type', 0)->get();
        }
        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('address1', $schoolUser->address1)->where('group_type', 0)->get();
        }
        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('group_type', 0)->get();
        }

        for ($i = 0; $i < count($groups); $i ++){
            $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $period);
        }

        for ($i = 0; $i < count($groups); $i ++){
            for ($j = $i + 1; $j < count($groups); $j ++){
                if ($group_sums[$j] > $group_sums[$i]){
                    $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
                    $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
                }
            }
        }
        $top_schools = array();
        for ($i = 0; $i < count($groups); $i ++){
            if ($i == 7) break;
            $top_schools[$i]['name'] = $groups[$i]->group_name;
        }

        return $top_schools;
    }

    private function TopSchools_7_Middle($schoolUser, $range, $period){
        $groups = array();
        if ($range == 'city'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('address1', $schoolUser->address1)
                    ->where('address2', $schoolUser->address2)->where('group_type', 1)->get();
        }
        else if ($range == 'province'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('address1', $schoolUser->address1)->where('group_type', 1)->get();
        }
        else if ($range == 'overall'){
            if(isset($schoolUser) && $schoolUser !== null)
                $groups = User::where('role', config('consts')['USER']['ROLE']['GROUP'])->where('group_type', 1)->get();
        }

        for ($i = 0; $i < count($groups); $i ++){
            $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $period);
        }

        for ($i = 0; $i < count($groups); $i ++){
            for ($j = $i + 1; $j < count($groups); $j ++){
                if ($group_sums[$j] > $group_sums[$i]){
                    $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
                    $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
                }
            }
        }
        $top_schools = array();
        for ($i = 0; $i < count($groups); $i ++){
            if ($i == 7) break;
            $top_schools[$i]['name'] = $groups[$i]->group_name;
        }

        return $top_schools;
    }
    //render register class and teacher in charge2.2e
    public function reg_class(Request $request){
        $this->page_info['side'] = 'teacher_set';
        $this->page_info['subside'] = 'reg_class';
        $this->page_info['top'] = 'teacher_set';
        $this->page_info['subtop'] = 'reg_class';

        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }
        $members = User::where('org_id', '=', $group->id)->where('active','=','1')
                    ->whereIn('role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]])->get();
        /*$result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 4));*/
        if($request->session()->has("message"))    
            $request->session()->flash('status', $request->session()->get("message"));

        $current_season = GroupController::CurrentSeaon_Pupil(now());
        $retview = view('group.teacher_set.reg_class')
            ->with('page_info', $this->page_info)
            ->withGroup($group)
            ->withMembers($members)
            ->with('current_season',$current_season);

        if($request->session()->has("year")) 
              $retview =  $retview->with('year', $request->session()->get("year"));
        return $retview;
    }
    public function doreg_class(Request $request){
        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }
        else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }

        $class = Classes::where('group_id','=',$group->id)
            ->where('year','=',$request->input('year'))
            ->where('grade','=',$request->input('grade'))
            ->where('class_number','=',$request->input('class_number'))
            ->where('active','=',1)
            ->first();
        $teacher_class = Classes::where("teacher_id", $request->input("teacher_id"))
                                    ->where("group_id", $group->id) 
                                    ->whereNull('class_number')
                                    ->first();
        if($teacher_class && $class){
            $teacher_class->year = $request->input('year');
            $teacher_class->grade = $request->input('grade');
            $teacher_class->class_number = $request->input('class_number');
            $teacher_class->group_id = $group->id;
            $teacher_class->member_counts = $request->input('member_counts');
            $teacher_class->type = $group->group_type;
            $teacher_class->save();
                        
            $class->delete();
        }else{ 
            if($class){
                $class->member_counts = $request->input("member_counts");
                if($request->has("teacher_id")){
                    $class->teacher_id = $request->input("teacher_id");
                }
                $class->save();
                $teacher_class = $class;
            }else{
                $teacher_class = Classes::where("teacher_id", $request->input("teacher_id"))
                                        ->where("group_id", $group->id) 
                                        ->whereNull('class_number')
                                        ->where('year', $request->input('year'))
                                        ->first();
                if($teacher_class){
                    $teacher_class->year = $request->input('year');
                    $teacher_class->grade = $request->input('grade');
                    $teacher_class->class_number = $request->input('class_number');
                    $teacher_class->group_id = $group->id;
                    $teacher_class->member_counts = $request->input('member_counts');
                    $teacher_class->type = $group->group_type;
                    $teacher_class->save();

                    
                }else{
                    $class = new Classes();
                    $class->year = $request->input('year');
                    $class->grade = $request->input('grade');
                    $class->class_number = $request->input('class_number');
                    if($request->has('teacher_id')){
                        $class->teacher_id = $request->input('teacher_id');
                    }
                    $class->group_id = $group->id;
                    $class->member_counts = $request->input('member_counts');
                    $class->type = $group->group_type;
                    $class->save();

                    $teacher_class = $class;
                }
            }
        }

        $teacher = User::find($request->input('teacher_id'));

        $teacherHistories = TeacherHistory::where('group_id', $group->id)
                                            ->where('teacher_id',$teacher->id)
                                            ->where('year','=',$request->input('year'))
                                            ->whereNull('class_id')
                                            ->orderby('id', 'desc')->first();

        
        if(isset($teacherHistories) && $teacherHistories->count() > 0){
            $teacherHistory = $teacherHistories;

        }else{
            $teacherHistories = TeacherHistory::where('class_id',$class->id)
                                            ->where('group_id', $group->id)
                                            ->where('teacher_id',$teacher_class->teacher_id)
                                            ->where('year','=',$request->input('year'))
                                            ->orderby('id', 'desc')->first();
            if(isset($teacherHistories) && $teacherHistories->count() > 0)
                $teacherHistory = $teacherHistories;
            else                               
                $teacherHistory = new TeacherHistory();
            
        }

        $teacherHistory->teacher_id = $teacher_class->teacher_id;
        $teacherHistory->group_id = $group->id; 
        $teacherHistory->group_name = $group->group_name;
        $teacherHistory->teacher_role = $teacher->role;
        $teacherHistory->grade = $teacher_class->grade;
        $teacherHistory->class_number = $teacher_class->class_number;
        $teacherHistory->class_id = $teacher_class->id;
        $teacherHistory->year = $request->input('year');
        $teacherHistory->member_counts = $request->input("member_counts");
        $teacherHistory->created_at = date_format(now(), 'Y-m-d');
        $teacherHistory->save();

        $message = config('consts')['MESSAGES']['REGISTER_SAVED'];
        return Redirect::back()->withMessage($message)->with('year', $request->input('year'));
    }
    //edit class and teacher in charge 2.2f
    public function edit_class(Request $request){
        $this->page_info['side'] = 'teacher_set';
        $this->page_info['subside'] = 'edit_class';
        $this->page_info['top'] = 'teacher_set';
        $this->page_info['subtop'] = 'edit_class';
        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }
        $current_season = GroupController::CurrentSeaon_Pupil(now());
        $members = User::where('org_id', '=', $group->id)->where('active','=','1')
                    ->whereIn('role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]])->get();

        //$selclass = array();
        if($request->session()->has("selclasstop")){
            $selclasstop = $request->session()->get("selclasstop");
            $selclass = Classes::find($selclasstop);
            $grade = $selclass->grade;
            $year = $selclass->year;
           
            $class_number = $selclass->id;
            $request->session()->remove("selclasstop");
        }else{
            if($request->has('year'))    
                $year = $request->input('year');
            else
                $year = $current_season['year'];

            if($request->has('grade'))    
                $grade = $request->input('grade');
            else
                $grade = 1 ; //$grade = 0　ない 
            $class_number = $request->input("class_number");

            if($request->has('obj_flag')){
                if($request->input('obj_flag') == 1){
                    $grade = 1;
                    $class_number = null;
                }else if($request->input('obj_flag') == 2){
                    $class_number = null;
                }
            }
        }
        
        $classnumbers = Classes::where('group_id','=',$group->id)
                                ->where('year','=',$year)
                                ->where('grade','=',$grade)
                                ->where('active','=','1')
                                ->orderby('class_number', 'asc')
                                ->get();
        if(isset($class_number) && $class_number !== null)
            $selClass = Classes::find($class_number);
        else{
            if(count($classnumbers) > 0)
                $selClass = $classnumbers[0];
            else
                $selClass = array();
        }

       
        $retview = view('group.teacher_set.edit_class')
            ->with('page_info', $this->page_info)
            ->with('selclass', $selClass)
            ->withClassnumbers($classnumbers)
            ->with('members', $members)
            ->with('group', $group)
            ->with('grade', $grade)
            ->with('year', $year)
            ->with('current_season',$current_season);

        return $retview;
    }

    public function doedit_class(Request $request){
        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }
        else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }
        $btnflag = $request->input('btnflag');
        $rule = array(
            'year' => 'required|max:4|min:4',
            'grade' => 'required',
            'class_number' => 'required|max:4',
            'member_counts' => 'required'
        );
        if(isset($btnflag) && $btnflag != 2){
            $rule['teacher_id'] = 'required';
        }
        $messages = array(
            'required' => config('consts')['MESSAGES']['REQUIRED'],
            
        );
        $validator = Validator::make($request->all(), $rule, $messages);
        if ($validator->fails()){

            return Redirect::back()->withErrors($validator)
                    ->withInput();
        }
        $class = Classes::where('group_id','=',$group->id)
                            ->where('grade','=',$request->input('grade'))
                            ->where('id','=',$request->input('class_number'))
                            ->where('active','=','1')
                            ->where('year','=',$request->input('year'))
                            ->first();

        if(isset($class))
            $class->member_counts = $request->input('member_counts');

        $message = config('consts')['MESSAGES']['REGISTER_SAVED'];
        if(isset($btnflag)){
            if($btnflag == 1){
                if($class->teacher_id != $request->input("teacher_id")){
                    $teacher = User::find($request->input('teacher_id'));

                    $teacherHistories = TeacherHistory::where('group_id', $group->id)
                                                        ->where('teacher_id',$teacher->id)
                                                        ->where('year','=',$request->input('year'))
                                                        ->whereNull('class_id')
                                                        ->orderby('id', 'desc')->first();

                    
                    if(isset($teacherHistories) && $teacherHistories->count() > 0){
                        $teacherHistory = $teacherHistories;

                    }else{
                        $teacherHistories = TeacherHistory::where('class_id',$class->id)
                                                        ->where('group_id', $group->id)
                                                        ->where('teacher_id',$class->teacher_id)
                                                        ->where('year','=',$request->input('year'))
                                                        ->orderby('id', 'desc')->first();
                        if(isset($teacherHistories) && $teacherHistories->count() > 0)
                            $teacherHistory = $teacherHistories;
                        else                               
                            $teacherHistory = new TeacherHistory();
                    }

                    $teacherHistory->teacher_id = $class->teacher_id;
                    $teacherHistory->group_id = $group->id; 
                    $teacherHistory->group_name = $group->group_name;
                    $teacherHistory->teacher_role = $teacher->role;
                    $teacherHistory->grade = $class->grade;
                    $teacherHistory->class_number = $class->class_number;
                    $teacherHistory->class_id = $class->id;
                    $teacherHistory->year = $request->input('year');
                    $teacherHistory->member_counts = $request->input("member_counts");
                    $teacherHistory->created_at = date_format(now(), 'Y-m-d');
                    $teacherHistory->save();
                }
                $class->teacher_id = $request->input('teacher_id');
            }
            elseif($btnflag == 2){

                $pupils = User::searchPupilByClass($class->id)->get();
                foreach ($pupils as $key => $pupil) {

                    $personworkHistory = new PersonworkHistory();
                    $personworkHistory->user_id = $pupil->id;
                    $personworkHistory->username = $pupil->username;
                    $personworkHistory->item = 0;
                    $personworkHistory->work_test = 4;
                    if($pupil->isSchoolMember()){
                        $personworkHistory->user_type = '教職員';
                        if(!$pupil->isLibrarian())
                            $personworkHistory->org_username = $pupil->School->username;
                    }else if($pupil->isAuthor())
                        $personworkHistory->user_type = '著者';
                    else if($pupil->isOverseer())
                        $personworkHistory->user_type = '監修者';
                    else if($pupil->isPupil()){
                        $personworkHistory->user_type = '生徒';
                        $personworkHistory->org_username = $pupil->ClassOfPupil->school->username;
                    }else
                        $personworkHistory->user_type = '一般';
                    $personworkHistory->content = '団体で学級削除';
                    $personworkHistory->age = $pupil->age();
                    $personworkHistory->address1 = $pupil->address1;
                    $personworkHistory->address2 = $pupil->address2;
                    $personworkHistory->save();

                    $classes = $pupil->ClassOfPupil;
                            
                    $pupil_history = new PupilHistory();
                    $pupil_history->pupil_id = $pupil->id;
                    $pupil_history->group_name = '準会員';
                    
                    $classname = "";
                    if($classes->grade != 0)
                       $classname .= $classes->grade."-"; 
                    $classname .= $classes->class_number." "; 
                    if($classes->TeacherOfClass !== null)
                       $classname .= $classes->TeacherOfClass->fullname()." ";
                    $classname .= "学級/".$classes->year."年度";
                    $pupil_history->grade = $classes->grade;
                    $pupil_history->class_number = $classes->class_number;
                    if($classes->TeacherOfClass !== null)
                        $pupil_history->teacher_name = $classes->TeacherOfClass->fullname();
                    $pupil_history->class = $classname;
                    $pupil_history->class_id = $classes->id;
                    $pupil_history->created_at = date_format(now(), "Y-m-d");
                    $pupil_history->save();

                    $pupil->active = 2;
                    $pupil->save(); 
                }

                /*if($class->teacher_id !== null){ //before teacher history
                    $teacherHistory = TeacherHistory::where('class_id',$class->id)->where('teacher_id',$class->teacher_id)->orderby('id', 'desc')->first();
                    if(isset($teacherHistory) && $teacherHistory->count() > 0){
                        $teacherHistory->member_counts = $request->input('member_counts');
                        $teacherHistory->created_at = $teacherHistory->created_at;
                        $teacherHistory->updated_at = date_format(now(), 'Y-m-d');
                        $teacherHistory->save();
                    }
                }*/
                $class->active = 2;
                $message = config('consts')['MESSAGES']['SUCCEED'];
            } 
            elseif($btnflag == 3){
                /*if($class->teacher_id !== null){ //before teacher history
                    $teacherHistory = TeacherHistory::where('class_id',$class->id)->where('teacher_id',$class->teacher_id)->orderby('id', 'desc')->first();
                    if(isset($teacherHistory) && $teacherHistory->count() > 0){
                        $teacherHistory->member_counts = $request->input('member_counts');
                        $teacherHistory->created_at = $teacherHistory->created_at;
                        $teacherHistory->updated_at = date_format(now(), 'Y-m-d');
                        $teacherHistory->save();
                    }
                }*/
                $class->teacher_id = '';
            } 
        }
        
        $class->save();

        
        
        return redirect('/top')->withMessage($message);
    }

//    public function edit_class_search(Request $request){
//      if(Auth::user()->isGroup()){
//        $group = User::find(Auth::id());
//      }else if(Auth::user()->isSchoolMember()){
//        $group = Auth::user()->School;
//      }
//      $classes = Classes::where('group_id','=',$group->id)->where('grade','=',$request->input('grade'))->where('classname','=',$request->input('classname'))->get();
//		$teacher_ids = $classes->map(function($class){
//			return $class->teacher_id;
//		})->toArray();
//	  	$teacher = User::find($teacher_ids);
//	  	return redirect('/group/teacher/edit_class')
//	  	->withTeacher($teacher)
//	  	->withInput();
//    }

    //get Class options by Year and Grade in edit Class Page 2.2f
    public function getClassOption(Request $request){

        $schoolid = $request->input('schoolid');
        $classes = Classes::where('group_id','=',$schoolid)->where('grade', 'like', $request->input('grade'))->where('year','=', $request->input('year'))->get();
        $classoption = View::make('partials.classoption')
            ->with('classes', $classes)
            ->render();

        $response = array(
            "body" => $classoption
        );

        return response()->json($response);
    }

    public function getTeacherOption(Request $request){
        $class = Classes::find($request->input('classid'));

        $teachers = $class->group->Members;
        $teacher = $class->TeacherOfClass;
        //$vice_teacher = $class->ViceTeacherOfClass;
        $teacher_options = View::make('partials.teacheroption')
            ->withTeachers($teachers)
            ->withteacher($teacher)
            ->render();
       // $vice_teacher_options = View::make('partials.teacheroption')
       //     ->withTeachers($teachers)
       //     ->withteacher($vice_teacher)
       //     ->render();
        $response = array(
            "teacher" => $teacher_options,
            //"vice_teacher" => $vice_teacher_options,
            "member_counts" => $class->member_counts
        );
        return response()->json($response);
    }


    public function updateClass(Request $request){
        if(is_null($request->input('classname'))){
            return Redirect::back()->withErrors('クラスを選択して下さい。');
        }
        $class = Classes::find($request->input('classname'));
        $class->teacher_id = $request->input('teacher_id');
        //$class->vice_teacher_id = $request->input('vice_teacher_id');
        $class->member_counts = $request->input('member_counts');
        $class->save();
        return Redirect::to('/');
    }
    //end update class 2.2f

    public function manual(Request $request){
        $this->page_info = array(
            'side' => 'group_manual',
            'subside' => 'group_manual',
            'top' => 'group_manual',
            'subtop' => 'group_manual',
        );
        $result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 8));
        return view('group.manual')
            ->with('page_info', $this->page_info);
    }


    public function edit_teacher_top(Request $request){
        $this->page_info = array(
            'side' => 'edit_teacher_top',
            'subside' => 'edit_teacher_top',
            'top' => 'home',
            'subtop' => 'home',
        );
        $result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 8));
        //       if(Auth::user()->isGroup()){
        //        $schoolid = Auth::id();
        //      }else if(Auth::user()->isSchoolMember()){
        //        $schoolid = Auth::user()->School->id;
        //      }
        $current_season = GroupController::CurrentSeaon_Pupil(now());
        $schoolid = $request->input('group_id');
        if($schoolid !== null && $schoolid != "") {
           // $classes = Classes::where('id', '=', $schoolid)->where('year', '=', Date('Y'))->get();
            //$classes = Auth::user()->classes->where('id', '=', $schoolid);
            $classes = Auth::user()->classes;
        } else {
            $classes = Auth::user()->classes;
        }

        //        if(($request->input('messageid')!==null) && ($request->input('messageid') != "")) {
        //            $messages = Messages::where('from_id','=', $schoolid)
        //                ->where('id', '!=', $request->input('messageid'))
        //                ->orderby('created_at', 'desc')
        //                ->limit(config('consts')['MESSAGES']['EDITTOP_COUNTS'])
        //                ->get();
        //            $message = Messages::find($request->input('messageid'));
        //            return view('group.edit_top')
        //                ->with('page_info', $this->page_info)
        //                ->withMessages($messages)
        //                ->with('class_id', $schoolid)
        //                ->withClasses($classes)
        //                ->withMessage($message);
        //        }
        
        $totalClassNames = array();
        $totalClassPoints = array();
        $i = 0;
        foreach($classes as $key => $class){
            
            $totalClassNames[$i] = [$i,$class->grade."-".$class->class_number];
            if($class->grade == 0){
                $totalClassNames[$i] = [$i, $class->class_number];
                if($class->class_number == '') $totalClassNames[$i] = [$i, ''];
            } 
            $pupils = $class->Pupils;
            $sum = 0;
            for($j = 0; $j < count($pupils); $j++){
                $sum += $pupils[$j]->SuccessQuizPoints($current_season['begin_thisyear'],4,1,$current_season['end_thisyear'],3,31)->first()->sum;
            }
            $totalClassPoints[$i] = [$i, $sum];
            $i++;
        }
        //get top class on current year grade
        $topClassNames = array();

        for($i = 1; $i<= 6; $i++){
            $max = 0;
            $maxIndex = -1;

            foreach($classes as $key => $class){

                if($class->grade == $i){
                    $pupils = $class->Pupils;
                    $sum = 0;
                    for($j = 0; $j < count($pupils); $j++){
                        $sum += $pupils[$j]->SuccessQuizPoints(date_format($current_season['begin_season'], 'Y'), date_format($current_season['begin_season'], 'm'), date_format($current_season['begin_season'], 'd'), date_format($current_season['end_season'], 'Y'), date_format($current_season['end_season'], 'm'),date_format($current_season['end_season'], 'd'))->first()->sum;
                    }

                    if($max < $sum){
                        $max = $sum;
                        $maxIndex = $key;
                    }
                   
                }
            }

            if($maxIndex!= -1){
                $topClassNames[$i] = $classes[$maxIndex]->grade."-".$classes[$maxIndex]->class_number." ".$classes[$maxIndex]->TeacherOfClass->fullname();
            }else{
                $topClassNames[$i]= null;
            }

        }

        //get top students on current year
        $topStudentsNames = array();

        for($i = 1; $i<= 6; $i++){
            $max = 0;
            $maxPeople = null;

            foreach($classes as $key => $class){
                if($class->grade == $i){
                    $pupils = $class->Pupils;
                    for($j = 0; $j < count($pupils); $j++){
                        $sum = $pupils[$j]->SuccessPoints->sum('point');
                        if($max < $sum){
                            $max = $sum;
                            $maxPeople = $pupils[$j];
                        }
                    }
                }
            }

            if($maxPeople!= null){
                $topStudentsNames[$i] = $maxPeople;
            }else{
                $topStudentsNames[$i]= null;
            }
        }

        $teachers = Auth::user()->Members;
        $teacher_ids = $teachers->map(function($teacher){
            return $teacher->id;
        });

        if(count($teacher_ids) > 0){
            $to_id = implode(",",$teacher_ids->toArray());
        }else{
            $to_id = "-1";
        }

        $date = now(); 

        $curQuartDateString = $current_season['from_num']."~".$current_season['to_num'];

        $view = view('group.edit_top')
            ->with('school_classes',[])
            ->with('page_info',$this->page_info)
            ->with('total_class_names', $totalClassNames)
            ->with('total_class_points', $totalClassPoints)
            ->with('top_class_names', $topClassNames)
            ->with('top_student_names', $topStudentsNames)
            ->with('classes', $classes)
            ->with('class_id', $schoolid)
            ->with('curQuartDateString', $curQuartDateString)
            ->with('to_id',$to_id);
        $message = Messages::where('type', 1)->where('from_id', Auth::id())->orderBy("updated_at", "desc")->get();
        $view = $view->withMessage($message);
        return $view;
    }

//      $messages = Messages::where('from_id','=', $schoolid)->orderby('created_at', 'desc')->limit(config('consts')['MESSAGES']['EDITTOP_COUNTS'])->get();
//      return view('group.edit_top')
//        ->with('page_info', $this->page_info)
//        ->withMessages($messages)
//        ->withClasses($classes);



    public function teacher_list(Request $request){
        $this->page_info = array(
            'side' => 'teacher_set',
            'subside' => 'teacher_list',
            'top' => 'teacher_set',
            'subtop' => 'teacher_list',
        );
        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }

        $members = User::selectRaw("users.*")
                        //->leftJoin('classes','users.id','=','classes.teacher_id')
                        //->whereRaw('(classes.group_id='.Auth::id().' or users.org_id='.$group->id.')')
                        ->where('users.org_id' , $group->id)
                        ->where('users.active','1')
                        // ->orwhere('users.active','2')
                        ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]])
                        ->groupby('users.id');

        /*$result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 3));*/
        /*if($request->has("year")){
            $members->where('users.created_at', '<=', date("Y-m-d h:i:sa", mktime(0, 0, 0, 12, 31, $request->input("year"))));
        }*/
        $members = $members->orderBy(DB::raw("users.firstname_yomi asc, users.lastname_yomi"), 'asc')->get();
        $current_season = GroupController::CurrentSeaon_Pupil(now());
        return view('group.teacher_set.list')
            ->with('page_info', $this->page_info)
            ->withGroup($group)
            ->withMembers($members)
            //->withYear($request->input('year'))
            ->with('current_season',$current_season);
    }
    //remove teacher from school
    public function removeTeacher(Request $request)
    {
        $remove_ids = explode(" ", $request->input('ids'));
        for ($i=0; $i <count($remove_ids) ; $i++) {
            $user = User::find($remove_ids[$i]);
            $user->org_id = 0;
            $user->save();
        }
        $message = config('consts')['MESSAGES']['REMOVED_FROM_SCHOOL'];
        return Redirect::back()->withMessage($message);
    }

        //    public function TeacherCard($id, $action){
        //      $teacher = User::find($id);
        //      $histories = Classes::RecentClasses($teacher->id)->get();
        //      $this->page_info['side'] = 'teacher_list';
        //      $this->page_info['subside'] = 'teacher_list';
        //      return view('group.teacher_set.edit_card')
        //        ->withTeacher($teacher)
        //        ->with('page_info', $this->page_info)
        //        ->withHistories($histories)
        //        ->withAction($action);
        //    }
    public function TeacherCard(Request $request, $action){
        $teacher = null;
        $histories = [];
        $action = "create";
        $current_season = GroupController::CurrentSeaon_Pupil(now());
        if($request->has('selected') && $request->input('selected') != '' && $request->input('selected') !== null){
            $teacher = User::find($request->input('selected'));
            //$histories = Classes::RecentClasses($teacher->id)->where("year", ">", $current_season['year'] - 5 )->get();
            if(is_object($teacher)){
                $histories = TeacherHistory::GetTeacherHistories($teacher->id)
                ->where("created_at", ">", Carbon::create($current_season['year'] - 5,4, 1,0,0,0))
                ->get();
            }
            $action="edit";
        }
        elseif($request->input('name_search_flag') == 1){
            $teacher = User::find($request->input('name_search_id'));
            //$histories = Classes::RecentClasses($teacher->id)->where("year", ">", $current_season['year'] - 5 )->get();
            if(is_object($teacher)){
                $histories = TeacherHistory::GetTeacherHistories($teacher->id)
                ->where("created_at", ">", Carbon::create($current_season['year'] - 5,4, 1,0,0,0))
                ->get();
            }
            $action="edit";
        }

        $this->page_info['side'] = 'teacher_list';
        $this->page_info['subside'] = 'teacher_list';
        return view('group.teacher_set.edit_card')
            ->withTeacher($teacher)
            ->with('page_info', $this->page_info)
            ->with('current_season', $current_season)
            ->withHistories($histories)
            ->withForwardurl('/group/teacher/list')
            ->withAction($action);
    }
    public function  deleteTeacher(Request $request){
        $ids = preg_split('/,/', $request->input('teacher'));
        for ($i = 0; $i < count($ids); $i++) {
            $user = User::find($ids[$i]);
            if($user->role == config('consts')['USER']['ROLE']["LIBRARIAN"]){
                $delete = Classes::where('teacher_id', '=', $user->id)
                                ->where('group_id', '=', Auth::id())
                                ->delete();
                $rec = classes::where('teacher_id', '=', $user->id)->get();
                if(count($rec)>0)
                    continue;
            }
            // $user->role = 2;
            Classes::where('teacher_id', '=', $user->id)->update(array('teacher_id' => null));

            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 4;
            if($user->isSchoolMember()){
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                   $personworkHistory->org_username = $user->School->username;
            }else if($user->isAuthor())
                $personworkHistory->user_type = '著者';
            else if($user->isOverseer())
                $personworkHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personworkHistory->user_type = '生徒';
                $personworkHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personworkHistory->user_type = '一般';
            $personworkHistory->content = '団体で削除';
            $personworkHistory->age = $user->age();
            $personworkHistory->address1 = $user->address1;
            $personworkHistory->address2 = $user->address2;
            $personworkHistory->save(); 
            $user->active = 2;
            // $user->org_id = 0;
            // $user->group_name = "";
            // $user->group_yomi = "";
            // $user->group_roma = "";
            $user->save();

        }
        $this->page_info = array(
            'side' => 'teacher_set',
            'subside' => 'teacher_list',
            'top' => 'teacher_set',
            'subtop' => 'teacher_list',
        );
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);

        return redirect('/group/teacher/list')
            ->with('page_info', $this->page_info);
    }

    public function updateTeacher(Request $request){

        if(Auth::user()->isGroup()){
            $group = User::find(Auth::id());
        }else if(Auth::user()->isSchoolMember()){
            $group = Auth::user()->School;
        }
        $user_old_active = 1;
        if($request->input('action') != "create"){
            $user = User::find($request->input('id'));
            $user_old_active = $user->active;
        }
        else{
            $user =new User();
            $user->lastname = $request->input('lastname');
            $user->username = $request->input('username');
            $user->org_id = $group->id;
            $user->refresh_token = md5($request->input('email')).md5(time());
        }
        $this->page_info = array(
            'side' => 'teacher_set',
            'subside' => 'teacher_list',
            'top' => 'teacher_set',
            'subtop' => 'teacher_list',
        );
        
        $rule = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'firstname_yomi' => 'required',
            'lastname_yomi' => 'required',
            'firstname_roma' => 'required',
            'lastname_roma' => 'required',
            'r_password' => 'required|max:15|min:8',
            'email' => 'required:users|email',//email
            'birthday' => 'required|date',
            'role' => 'required',
            'gender' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            // 'address4' => 'required',
            // 'address5' => 'required',
        );
        if(count(User::where('username', '!=', $user->username)->where('email',$request->input('email'))->get()) > 0) {
            $rule['email']='required|unique:users';
        }
        $messages = array(
            'required' => config('consts')['MESSAGES']['REQUIRED'] ,
            'firstname.required' => config('consts')['MESSAGES']['FIRSTNAME_REQUIRED'] ,
            'lastname.required' => config('consts')['MESSAGES']['LASTNAME_REQUIRED'] ,
            'firstname_yomi.required' => config('consts')['MESSAGES']['FIRST_KATA_REQUIRED'],
            'lastname_yomi.required' => config('consts')['MESSAGES']['LAST_KATA_REQUIRED'],
            'firstname_roma.required' => config('consts')['MESSAGES']['FIRST_ROMA_REQUIRED'],
            'lastname_roma.required' => config('consts')['MESSAGES']['LAST_ROMA_REQUIRED'],
            'r_password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED'],
            'r_password.max' => config('consts')['MESSAGES']['PASSWORD_MAXLENGTH'],
            'r_password.min' => config('consts')['MESSAGES']['PASSWORD_LENGTH'],
            'birthday.required' => config('consts')['MESSAGES']['DATE_REQUIRED'],
            'birthday.date' => config('consts')['MESSAGES']['DATE_ERROR'],
            'email.required' => config('consts')['MESSAGES']['EMAIL_REQUIRED'],
            'email.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE'],
            'role.required' => config('consts')['MESSAGES']['ROLE_REQUIRED'],
            'gender.required' => config('consts')['MESSAGES']['GENDER_REQUIRED'],
        );

        $validator = Validator::make($request->all(), $rule, $messages);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)
                                    ->withForwardurl('/group/search_teacher')
                                    ->withInput()->with('page_info', $this->page_info);
        }

         //alerdy password double
        $password_others = User::where('r_password', '=', $request->input('r_password'))->where('id', '<>', $request->input('id'))->count();
        if($password_others != 0){
            $error = config('consts')['MESSAGES']['PASSWORD_EXIST'];
         
            return Redirect::back()
                   ->withErrors(["r_password" => $error])
                   ->withForwardurl('/group/search_teacher')
                  ->withInput();

        }
        //$user->update($request->all());
        //      $user->r_password = trim($request->input('r_password'));
        //      $user->password = bcrypt(trim($request->input('r_password')));
                $current_season = GroupController::CurrentSeaon_Pupil(now());

                if($request->input('action') != "create"){
                    //教員が転校される時,以前団体の学級担任で削除する。
                    if($user->org_id != Auth::id()){
                        $preorg_classes = Classes::where('group_id', '=', $user->org_id)
                                                ->where('teacher_id','=', $user->id)
                                                ->where('year','=', $current_season['year'])
                                                ->get();
                        if(count($preorg_classes) > 0){
                            foreach ($preorg_classes as $key => $preorg_class) {
                                $preorg_class->teacher_id = null;
                                $preorg_class->save();
                            }
                        }


                    }
                }
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->firstname_yomi = $request->input('firstname_yomi');
                $user->lastname_yomi = $request->input('lastname_yomi');
                $user->firstname_roma = $request->input('firstname_roma');
                $user->lastname_roma = $request->input('lastname_roma');
                $user->r_password = $request->input('r_password');
                $user->password = md5($user->r_password);
                $user->role = $request->input('role');
                $user->gender = $request->input('gender');
                $user->email = $request->input('email');
                $user->birthday = $request->input('birthday');
                $user->org_id = Auth::id();
                $user->aptitude = 1;
                $user->active = 1;
                $user->address1 = $request->input('address1');
                $user->address2 = $request->input('address2');
                $user->address3 = $request->input('address3');
                $user->address4 = $request->input('address4');
                $user->address5 = $request->input('address5');
                $user->address6 = $request->input('address6');
                $user->address7 = $request->input('address7');
                $user->address8 = $request->input('address8');
                $user->address9 = $request->input('address9');
                $user->address10 = $request->input('address10');
                
                // if($user->role == config('consts')['USER']['ROLE']["LIBRARIAN"])
                //     $user->org_id = 0;

                $user->save();

                if($user->role == config('consts')['USER']['ROLE']["LIBRARIAN"])
                {
                    
                    $recs = Classes::where('group_id','=',Auth::id())
                                    ->where('teacher_id','=', $user->id)
                                    ->where('year','=', $current_season['year'])
                                    ->get();
                    if(count($recs) > 0){
                        $newclass = Classes::find($recs[0]->id);
                        /*foreach ($recs as $key => $rec) {
                            # code...
                        }*/
                    }
                    else{
                        $newclass = new Classes();
                        
                    }

                    $newclass->group_id = Auth::id();
                    $newclass->type =  $group->group_type;
                    $newclass->teacher_id = $user->id;
                    $newclass->year = $current_season['year'];
                    
                    $newclass->save();
                }
                
                $members = User::leftJoin('classes','users.id','=','classes.teacher_id')
                                ->where('classes.group_id','=',Auth::id())
                                ->orwhere('users.org_id','=',$group->id)
                                ->where('users.active','1')
                                ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                                config('consts')['USER']['ROLE']["LIBRARIAN"],
                                config('consts')['USER']['ROLE']["REPRESEN"],
                                config('consts')['USER']['ROLE']["ITMANAGER"],
                                config('consts')['USER']['ROLE']["OTHER"]])
                                ->get();
                $action = $request->input('action');
                
                if($action == "create"){
                    $teacherHistory = new TeacherHistory();
                }
                else{
                    $teacherHistories = TeacherHistory::where('teacher_id', $user->id)
                                                    ->where('group_id', Auth::id())
                                                    //->where('teacher_role', $user->role)
                                                    ->where('year', $current_season['year'])
                                                    ->orderby('id', 'desc')
                                                    ->first();
                
                    if(!isset($teacherHistories) ||  (isset($teacherHistories) && $teacherHistories->count() == 0))
                        $teacherHistory = new TeacherHistory();
                    else{
                        if(isset($teacherHistories) && $teacherHistories->teacher_role != $user->role)
                            $teacherHistory = new TeacherHistory();
                        //else
                        //    $teacherHistory = $teacherHistories;
                    }
                }
                if(isset($teacherHistory)){
                    $teacherHistory->teacher_id = $user->id;
                    $teacherHistory->group_id = Auth::id(); 
                    $teacherHistory->group_name = Auth::user()->group_name;
                    $teacherHistory->teacher_role = $user->role;
                    $teacherHistory->year = $current_season['year'];
                    $teacherHistory->created_at = date_format(now(), 'Y-m-d');
                    $teacherHistory->save();
                }

                if($request->input('action') == "create" || $user_old_active != 1){
                    $personworkHistory = new PersonworkHistory();
                    $personworkHistory->user_id = $user->id;
                    $personworkHistory->username = $user->username;
                    $personworkHistory->item = 0;
                    $personworkHistory->work_test = 5;
                    if($user->isSchoolMember()){
                        $personworkHistory->user_type = '教職員';
                        if(!$user->isLibrarian())
                            $personworkHistory->org_username = $user->School->username;
                    }else if($user->isAuthor())
                        $personworkHistory->user_type = '著者';
                    else if($user->isOverseer())
                        $personworkHistory->user_type = '監修者';
                    else if($user->isPupil()){
                        $personworkHistory->user_type = '生徒';
                        $personworkHistory->org_username = $user->ClassOfPupil->school->username;
                    }else
                        $personworkHistory->user_type = '一般';
                    $personworkHistory->age = $user->age();
                    $personworkHistory->address1 = $user->address1;
                    $personworkHistory->address2 = $user->address2;
                    $personworkHistory->save();
                }
                $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);


        //      return Redirect::to('/group/teacher/list')
        //      		->with('page_info', $this->page_info);
        return redirect('/group/teacher/list')
            ->with('page_info', $this->page_info)
            ->withForwardurl('/group/search_teacher')
            ->withMember($members)
            ->withGroup($group);
    }
    //register teacher to school
    public function registerTeacher(Request $request){
        $rule = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'firstname_roma' => 'required',
            'lastname_roma' => 'required',
            'gender' => 'required',
        );
        $messages = array(
            'required' => config('consts')['MESSAGES']['REQUIRED']
        );
        $validator = Validator::make($request->all(), $rule, $messages);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $user = new User;
        $user->firstname = $request->input('firstname');
        $user->firstname_roma = $request->input('firstname_roma');
        $user->lastname = $request->input('lastname_roma');
        $user->lastname_roma = $request->input('lastname_roma');
        $user->gender = $request->input('gender');
        $password = $this->passwordGenerator(8);
        $user->r_password = $password;
        $user->password = bcrypt($password);
        $user->birthday = $request->input('birthday');
        $user->org_id = Auth::id();
        $user->username = trim($request->input('lastname_roma')) . "0" . $user->id . $user->gender . "s";
        $user->group_name = Auth::user()->group_name;
        $user->role = $request->input('role');//teacher 4,5,6,7,8
        $user->active = 1;
        $user->refresh_token = md5($request->input('email')).md5(time());
        $user->save();
        return Redirect::to('/group/teacher/'.$user->id.'/edit/card');

    }
    protected function passwordGenerator($length){
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }

    public function selClassAjax(Request $request){
        $sel_class = $request->input('sel_class');
        $request->session()->put('selclasstop', $sel_class);
        
        $response = array(
            "status" => 'success'
        );

        return response()->json($response);
    }
    
    static function CurrentSeaon_Pupil1($date){
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
            $current_season['from'] = (Date('Y') - 1) . '年冬期' . '1月1日';
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
