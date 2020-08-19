<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use App\User;
use App\Model\Classes;
use App\Model\ClassType;
use App\Model\UserQuiz;
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

class ClassController extends Controller
{
	protected $page = 'home';

    public $page_info = [
        'side' =>'teacher_top',
        'subside' =>'teacher_top',
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

    public function index(Request $request){
    	$rule = array(
    		'classid' => 'required', 
		);
		$message = array(
			'classid.required' => 'クラスを選択して下さい。', );
    	$validator = Validator::make($request->all(), $rule, $message);
    	if ($validator->fails()){
    		return Redirect::back()->withErrors($validator);
    	}
    	$classid = $request->input('classid');
    	
    	return Redirect::to('/class/'. $classid .'/top');
    }
    public function viewClassRank(Request $request,$type) {
    	if (!Auth::user()->isSchoolMember()){
    		return Redirect::to('/');
    	}
        $this->page_info['side'] = 'class_activity';
        $this->page_info['top'] = 'class_activity';
       
        if ($type == 1) {
            $this->page_info['subside'] = 'current_rank';
            $this->page_info['subtop'] = 'current_rank';
        } else if ($type == 2) {
            $this->page_info['subside'] = 'last_rank';
            $this->page_info['subtop'] = 'last_rank';
        } else if ($type == 3) {
            $this->page_info['subside'] = 'year_rank';
            $this->page_info['subtop'] = 'year_rank';
        } else if ($type == 4) {
            $this->page_info['subside'] = 'total_rank';
            $this->page_info['subtop'] = 'total_rank';
        } else if ($type == 5) {
            $this->page_info['subside'] = 'activity';
            $this->page_info['subtop'] = 'activity';
        }
        $current_season = ClassController::CurrentSeaon_Pupil(now());
        $before_date = date_sub(now(), date_interval_create_from_date_string("3 months"));
        $before_season = ClassController::CurrentSeaon_Pupil($before_date);
        if (Auth::user()->isGroup()){
            //$the_classes = Classes::ActiveClasses(Auth::id())->get();
            $classes = DB::table('classes')
                ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                ->where('group_id', Auth::id())
                ->where('member_counts','>',0)
                ->where('classes.active','=',1)
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get();
        }else if(Auth::user()->isTeacher()){

            //$the_classes  = Classes::ActiveClasses(Auth::user()->School->id)->get();
             //$the_classes = Auth::user()->School->classes->where('teacher_id',Auth::id());
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isRepresen()){
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isLibrarian()){
            $recs = Auth::user()->SchoolOfLibrarian;
            $qq = array();
            for ($i=0;$i<count($recs);$i++) {
              $qq[]=$recs[$i]->group_id;
            }
            $classes = Classes::classListbyLibrarian($qq, $current_season['year']);

        }else if(Auth::user()->isItmanager()){
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isOther()){
            $classes = Auth::user()->School->classes;
        }else {
            $classes = Auth::user()->School->classes;
        }
    	
    	if($request->has("class_id")){
  			$class_id = $request->input("class_id");
  		}else{
  			$class_id = null;
  		}
  		
        $curQuartDateString = $current_season['from_num']."~".Date('Y.m.d');
        $preQuartDateString = $before_season['from_num']."~".$before_season['to_num'];
        $temp = array();
        $classnumber = '';
        $gradenumber = '';
        $citynumber = '';
        $provincenumber = '';
        $countrynumber = '';
        	  		
        if($type == 5){	        
	  		
            $users = User::getUsersbyClass($class_id)->get();

            foreach($users as $user){

                $userquiz = UserQuiz::RecentUserQuiz($user->id)->first();
                if(isset($userquiz)){
                    if(($userquiz->type == 0 && $userquiz->status ==1) || ($userquiz->type == 1 && $userquiz->status ==1) || ($userquiz->type == 2 && $userquiz->status ==3)){

                    }else{
                        $userquiz->point = 0;
                    }
                }
                $user->userquiz = $userquiz;

                $cur_point = UserQuiz::CurPoint($user->id, config('consts')['USER']['ROLE']['PUPIL'])->first();
                
                if(isset($cur_point))
                    $user->cur_point = floor($cur_point->sumpoint*100)/100;
                else
                    $user->cur_point = 0;
            }
        }

        if($type == 1){ 
        	$users = User::getUsersbyClass($class_id)->get(); 
            
            foreach($users as $user){
                $userquiz = UserQuiz::QuartUserQuiz($user->id, date_format($current_season['begin_season'], 'Y'), date_format($current_season['begin_season'], 'm'), date_format($current_season['begin_season'], 'd'), Date('Y'), Date('m'), Date('d'))->first();
                if(isset($userquiz)){
                    if(($userquiz->type == 0 && $userquiz->status ==1) || ($userquiz->type == 1 && $userquiz->status ==1) || ($userquiz->type == 2 && $userquiz->status ==3)){

                    }else{
                        $userquiz->cur_point = 0;
                    }
                }
                $user->userquiz = $userquiz;
                
                $cur_point = UserQuiz::CurPoint($user->id, config('consts')['USER']['ROLE']['PUPIL'])->first();
                
                if(isset($cur_point))
                    $user->cur_point = floor($cur_point->sumpoint*100)/100;
                else
                    $user->cur_point = 0;

                if(isset($user->PupilsClass)){
                    if($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->PupilsClass->id == $class_id && $class_id !== null){
                        
                        $classRank = UserQuiz::classranking1($current_season['term'],$current_season, $user->org_id)->get();
                        $user->classrank = 1;
                        $classnumber = User::Countclasspupil1($user->org_id);
                        
                        for($i=0;$i<count($classRank);$i++){
                            if($classRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->classrank++;
                            }
                        }

                        $gradeRank = UserQuiz::graderanking1($current_season['term'],$current_season, $user->PupilsClass->group_id, $user->PupilsClass->grade)->get();
                        $user->graderank = 1;
                        $gradenumber =  User::Countgradepupils1($user->PupilsClass->group_id, $user->PupilsClass->grade);
                        for($i=0;$i<count($gradeRank);$i++){
                            if($gradeRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->graderank++;
                            }
                        }
                    }
                }
            }
        }
        
        if($type == 2){
        	$users = User::getUsersbyClass($class_id)->get(); 
            foreach($users as $user){
                $userquiz = UserQuiz::QuartUserQuiz($user->id,date_format($before_season['begin_season'], 'Y'), date_format($before_season['begin_season'], 'm'), date_format($before_season['begin_season'], 'd'), date_format($before_season['end_season'], 'Y'), date_format($before_season['end_season'], 'm'),date_format($before_season['end_season'], 'd'))->first();
                if(isset($userquiz)){
                    if(($userquiz->type == 0 && $userquiz->status ==1) || ($userquiz->type == 1 && $userquiz->status ==1) || ($userquiz->type == 2 && $userquiz->status ==3)){

                    }else{
                        $userquiz->cur_point = 0;
                    }
                }
                $user->userquiz = $userquiz;
                
                $cur_point = UserQuiz::CurPoint($user->id, config('consts')['USER']['ROLE']['PUPIL'])->first();
                
                if(isset($cur_point))
                    $user->cur_point = floor($cur_point->sumpoint*100)/100;
                else
                    $user->cur_point = 0;

                if(isset($user->PupilsClass)){
                    if($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->PupilsClass->id == $class_id && $class_id !== null){
                        
                        $classRank = UserQuiz::classranking1($before_season['term'], $before_season, $user->org_id)->get();
                        $user->classrank = 1;
                        $classnumber = User::Countclasspupil1($user->org_id);
                        
                        for($i=0;$i<count($classRank);$i++){
                            if($classRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->classrank++;
                            }
                        }

                        $gradeRank = UserQuiz::graderanking1($before_season['term'], $before_season, $user->PupilsClass->group_id, $user->PupilsClass->grade)->get();
                        $user->graderank = 1;
                        $gradenumber =  User::Countgradepupils1($user->PupilsClass->group_id, $user->PupilsClass->grade);
                        for($i=0;$i<count($gradeRank);$i++){
                            if($gradeRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->graderank++;
                            }
                        }
                        
                        $groups =  User::groupsbycity($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $citynumber = 0;
                        $user->cityrank = 1;
                        foreach ($groups as $group) {
                            $citynumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $cityRank = [];
                            $cityRank = UserQuiz::graderanking1($before_season['term'], $before_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($cityRank);$i++){
                                if($cityRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->cityrank++;
                                }
                            }
                        }

                        $groups =  User::groupsbyprovince($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $provincenumber = 0;
                        $user->provincerank = 1;
                        foreach ($groups as $group) {
                            $provincenumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $provinceRank = [];
                            $provinceRank = UserQuiz::graderanking1($before_season['term'],$before_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($provinceRank);$i++){
                                if($provinceRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->provincerank++;
                                }
                            }
                        }
                       
                    }
                }
            }
        }
  		
        if($type == 3){
            $users = User::getUsersbyClass($class_id)->get(); 
            foreach($users as $user){
                $userquiz = UserQuiz::CurrentYearUserQuiz($user->id, $current_season, $user->role)->first();
                if(isset($userquiz)){
                    if(($userquiz->type == 0 && $userquiz->status ==1) || ($userquiz->type == 1 && $userquiz->status ==1) || ($userquiz->type == 2 && $userquiz->status ==3)){

                    }else{
                        $userquiz->cur_point = 0;
                    }
                }
                $user->userquiz = $userquiz;
                
                $cur_point = UserQuiz::CurPoint($user->id, config('consts')['USER']['ROLE']['PUPIL'])->first();
                
                if(isset($cur_point))
                    $user->cur_point = floor($cur_point->sumpoint*100)/100;
                else
                    $user->cur_point = 0;

                if(isset($user->PupilsClass)){
                    if($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->PupilsClass->id == $class_id && $class_id !== null){
                        
                        $classRank = UserQuiz::classranking1(21, $current_season, $user->org_id)->get();
                        $user->classrank = 1;
                        $classnumber = User::Countclasspupil1($user->org_id);
                        
                        for($i=0;$i<count($classRank);$i++){
                            if($classRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->classrank++;
                            }
                        }

                        $gradeRank = UserQuiz::graderanking1(21, $current_season, $user->PupilsClass->group_id, $user->PupilsClass->grade)->get();
                        $user->graderank = 1;
                        $gradenumber =  User::Countgradepupils1($user->PupilsClass->group_id, $user->PupilsClass->grade);
                        for($i=0;$i<count($gradeRank);$i++){
                            if($gradeRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->graderank++;
                            }
                        }
                        
                        $groups =  User::groupsbycity($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $citynumber = 0;
                        $user->cityrank = 1;
                        foreach ($groups as $group) {
                            $citynumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $cityRank = [];
                            $cityRank = UserQuiz::graderanking1(21, $current_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($cityRank);$i++){
                                if($cityRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->cityrank++;
                                }
                            }
                        }

                        $groups =  User::groupsbyprovince($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $provincenumber = 0;
                        $user->provincerank = 1;
                        foreach ($groups as $group) {
                            $provincenumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $provinceRank = [];
                            $provinceRank = UserQuiz::graderanking1(21, $current_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($provinceRank);$i++){
                                if($provinceRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->provincerank++;
                                }
                            }
                        }

                        $groups =  User::groupsbycountry($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $countrynumber = 0;
                        $user->countryrank = 1;
                        foreach ($groups as $group) {
                            $countrynumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $countryRank = [];
                            $countryRank = UserQuiz::graderanking1(21, $current_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($countryRank);$i++){
                                if($countryRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->countryrank++;
                                }
                            }
                        }
                       
                    }
                }
            }
        }
        
        if($type == 4){
            $users = User::getUsersbyClass($class_id)->get(); 
            foreach($users as $user){
                $userquiz = UserQuiz::AllPointUserQuiz($user->id)->first();
                if(isset($userquiz)){
                    if(($userquiz->type == 0 && $userquiz->status ==1) || ($userquiz->type == 1 && $userquiz->status ==1) || ($userquiz->type == 2 && $userquiz->status ==3)){

                    }else{
                        $userquiz->cur_point = 0;
                    }
                }
                $user->userquiz = $userquiz;
                
                $cur_point = UserQuiz::CurPoint($user->id, config('consts')['USER']['ROLE']['PUPIL'])->first();
                
                if(isset($cur_point))
                    $user->cur_point = floor($cur_point->sumpoint*100)/100;
                else
                    $user->cur_point = 0;

                $user->classRanks = "temp";
                if(isset($user->PupilsClass)){
                    if($user->role == config('consts')['USER']['ROLE']['PUPIL'] && $user->PupilsClass->id == $class_id && $class_id !== null){
                        $classRank = UserQuiz::classranking1(23, $current_season, $user->org_id)->get();
                        $user->classRanks = $classRank;
                        $user->classrank = 1;
                        $classnumber = User::Countclasspupil1($user->org_id);
                        
                        for($i=0;$i<count($classRank);$i++){
                            if($classRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->classrank++;
                            }
                        }

                        $gradeRank = UserQuiz::graderanking1(23, $current_season, $user->PupilsClass->group_id, $user->PupilsClass->grade)->get();
                        $user->graderank = 1;
                        $gradenumber =  User::Countgradepupils1($user->PupilsClass->group_id, $user->PupilsClass->grade);
                        for($i=0;$i<count($gradeRank);$i++){
                            if($gradeRank[$i]->sumpoint > $user->userquiz->cur_point){
                                $user->graderank++;
                            }
                        }
                        
                        $groups =  User::groupsbycity($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $citynumber = 0;
                        $user->cityrank = 1;
                        foreach ($groups as $group) {
                            $citynumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $cityRank = [];
                            $cityRank = UserQuiz::graderanking1(23, $current_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($cityRank);$i++){
                                if($cityRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->cityrank++;
                                }
                            }
                        }

                        $groups =  User::groupsbyprovince($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $provincenumber = 0;
                        $user->provincerank = 1;
                        foreach ($groups as $group) {
                            $provincenumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $provinceRank = [];
                            $provinceRank = UserQuiz::graderanking1(23, $current_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($provinceRank);$i++){
                                if($provinceRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->provincerank++;
                                }
                            }
                        }

                        $groups =  User::groupsbycountry($user->PupilsClass->group_id, $user->PupilsClass->type)->get();
                        $countrynumber = 0;
                        $user->countryrank = 1;
                        foreach ($groups as $group) {
                            $countrynumber +=  User::Countgradepupils1($group->id, $user->PupilsClass->grade);
                            $countryRank = [];
                            $countryRank = UserQuiz::graderanking1(23, $current_season, $group->id, $user->PupilsClass->grade)->get();
                            
                            for($i=0;$i<count($countryRank);$i++){
                                if($countryRank[$i]->sumpoint > $user->userquiz->cur_point){
                                    $user->countryrank++;
                                }
                            }
                        }
                       
                    }
                }
            }
        } 
        
        $sum = 0;
        $avg_point = 0;
     
        if($type == 1 || $type == 2 || $type == 3 || $type == 4 ){
            foreach ($users as $user){
            	$sum += $user->userquiz->cur_point;
            	      	
            }
            if(count($users)>= 1){
            	$avg_point = floor($sum*100/count($users))/100;
            }else{
            	$avg_point = 0;	
            }       
        }
  		$userQuizStatus = array('','', '','合格','不合格');
  		
  		
  		        
        return view('class.rank')
    		->with('page_info', $this->page_info)
            ->withUsers($users)
    		->with('type', $type)
    		->withClasses($classes)
            ->withClassid($class_id)
    		->withUserQuizStatus($userQuizStatus)
    		->withAvgpoint($avg_point)
    		->withCurQuartDateString($curQuartDateString)
    		->withPreQuartDateString($preQuartDateString)
            ->withClassnumber($classnumber)
            ->withGradenumber($gradenumber)
            ->withCitynumber($citynumber)
            ->withProvincenumber($provincenumber)
            ->withCountrynumber($countrynumber)
    		->withTotalPoint($sum)
            ->with('current_season', $current_season);
    }
    
    //render search people page 2.2f
    public function search_pupil(Request $request){
        $this->page_info['side'] = 'search_pupil';
        $this->page_info['subside'] = 'search_pupil';
        $this->page_info['top'] = 'search_pupil';
        $this->page_info['subtop'] = 'search_pupil';
        $class1 = User::find(Auth::id());
        $current_season = $this->CurrentSeaon_Pupil(now());
        
        if (Auth::user()->isGroup()){
            //$the_classes = Classes::ActiveClasses(Auth::id())->get();
            $current_season = $this->CurrentSeaon_Pupil(now());
            $the_classes = DB::table('classes')
                ->select("classes.id","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                ->where('classes.group_id', Auth::id())
                ->where('classes.member_counts','>', 0)
                ->where('classes.active','=', 1)
                ->where('classes.year', $current_season['year'])
                ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get();
        }else if(Auth::user()->isTeacher()){

            //$the_classes  = Classes::ActiveClasses(Auth::user()->School->id)->get();
             //$the_classes = Auth::user()->School->classes->where('teacher_id',Auth::id());
            $the_classes = Auth::user()->School->classes;
           
            
        }else if(Auth::user()->isRepresen()){
            $the_classes = Auth::user()->School->classes;
        }else if(Auth::user()->isLibrarian()){
            $recs = Auth::user()->SchoolOfLibrarian;
            $qq = array();
            for ($i=0;$i<count($recs);$i++) {
              $qq[]=$recs[$i]->group_id;
            }
            $the_classes = Classes::classListbyLibrarian($qq, $current_season['year']);

        }else if(Auth::user()->isItmanager()){
            $the_classes = Auth::user()->School->classes;
        }else if(Auth::user()->isOther()){
            $the_classes = Auth::user()->School->classes;
        }else {
            $the_classes = Auth::user()->School->classes;
        }

        /*$result = DB::table('users')
            ->where('id', Auth::id())
            ->update(array('reload_flag' => 2));*/
       
        $view = view('class.search_pupil')
            ->with('the_action', $request->input('action'))
            ->with('the_classes', $the_classes)
            ->with('class1', $class1)
            ->with('page_info', $this->page_info);
        if($request->input('class') !== null && $request->input('class') != "") {
            $the_class = Classes::find($request->input('class'));

            $pupils = User::where('org_id', '=', $the_class->id)
                        ->where('role', '=', config('consts')['USER']['ROLE']['PUPIL'])
                        ->where('active', '=', 1)->get();


            // $pupils = $the_class->Pupils;
            $view = $view->with('the_class', $the_class);
        } else{
            /* $class_ids = $the_classes->map(function($value){
                return $value->id;
            })->toArray();*/
            if(isset($the_classes[0]) && $the_classes[0] !== null){
                $pupils = User::where('org_id', '=', $the_classes[0]->id)
                        ->where('role', '=', config('consts')['USER']['ROLE']['PUPIL'])
                        ->where('active', '=', 1)->get();
            }
        }
        if($request->input('action') !== null && $request->input('action') != ""){
            $view = $view->with('the_action', $request->input('action'));
        }
        if(isset($pupils) && $pupils !== null)
            $view = $view->withPupils($pupils);

        return $view;
    }
    
    //render search people page 2.3f
    public function searchPupilCheck(Request $request){

        $selclassid = $request->input("selclassid");
        $selactionid = $request->input("selactionid");
        $id = $selclassid;
        $teacherid = Classes::find($id)->teacher_id;
        
        
        if($selactionid == config('consts')['TEACHER']['ACTIONS']['A']['ACTION'])
            return response(["status" => "success"]);
        elseif(Auth::user()->isRepresen() || Auth::user()->isItmanager() || $teacherid == Auth::id())
            return response(["status" => "success"]);
        elseif($selactionid == config('consts')['TEACHER']['ACTIONS']['B']['ACTION'] && Auth::user()->isLibrarian())
            return response(["status" => "success"]);
        else
            return response(["status" => "error"]);

    }
    public function addclass(Request $request){
    	$group_id = $request->input("group_id");
    	$type = $request->input("type");
    	$member_counts = $request->input("member_counts");
    	$grade = $request->input("grade");
    	$number = $request->input("class_number");
    	
    	$newclass = new Classes();
    	$newclass->group_id = $group_id;
    	$newclass->type =  $type;
    	$newclass->member_counts = $member_counts;
    	$newclass->grade = $grade;
    	$newclass->class_number = $number;
        $current_season = ClassController::CurrentSeaon_Pupil(now());
    	$newclass->year = $current_season['year'];
    	
    	$newclass->save();

        $user = User::find($group_id);
        //get class types 児童生徒を含む
        $class_types = ClassType::all();

        //get classes of school
        $classes = $user->registerclasses;

        //calculate total members
        if($classes){
            $totalMembers = $classes->sum('member_counts');
        }else{
            $totalMembers = 0;
        }

         //get 児童生徒を含めない classes of school
        $nopupilclasses = $user->registerclasseswithoutpupil;
        //calculate total members
        if($classes){
            $nopupiltotalMembers = $nopupilclasses->sum('member_counts');
        }else{
            $nopupiltotalMembers = 0;
        }

        $response = array(
            'totalMembers' => $totalMembers,
            'nopupiltotalMembers' => $nopupiltotalMembers,
            'newclass' => $newclass
        );

        return response()->json($response);
    }
    
    public function delclass(Request $request){
    	$id = $request->input("id");
        $userid = $request->input("userid");
    	$newclass = Classes::find($id);
    	$newclass->delete();

        $user = User::find($userid);
        //get class types 児童生徒を含む
        $class_types = ClassType::all();

        //get classes of school
        $classes = $user->registerclasses;

        //calculate total members
        if($classes){
            $totalMembers = $classes->sum('member_counts');
        }else{
            $totalMembers = 0;
        }

         //get 児童生徒を含めない classes of school
        $nopupilclasses = $user->registerclasseswithoutpupil;
        //calculate total members
        if($classes){
            $nopupiltotalMembers = $nopupilclasses->sum('member_counts');
        }else{
            $nopupiltotalMembers = 0;
        }

        $response = array(
            'totalMembers' => $totalMembers,
            'nopupiltotalMembers' => $nopupiltotalMembers,
            'status' => 'success'
        );

    	return response()->json($response);
    }
    
    public function getclass(Request $request){
    	$id = $request->input("id");
    	$newclass = Classes::find($id);
    	return response($newclass);	
    }
    
    public function updateclass(Request $request){
    	$id = $request->input("id");
        $group_id = $request->input("group_id");
    	$newclass = Classes::find($id);
    	$type = $request->input("type");
    	$member_counts = $request->input("member_counts");
    	$grade = $request->input("grade");
    	$class_number = $request->input("class_number");

    	$newclass->type =  $type;
    	$newclass->member_counts = $member_counts;
    	$newclass->grade = $grade;
    	$newclass->class_number = $class_number;
    	$newclass->year = Date('Y');
    	
    	$newclass->save();
    	
        $user = User::find($group_id);
        //get class types 児童生徒を含む
        $class_types = ClassType::all();

        //get classes of school
        $classes = $user->registerclasses;

        //calculate total members
        if($classes){
            $totalMembers = $classes->sum('member_counts');
        }else{
            $totalMembers = 0;
        }

         //get 児童生徒を含めない classes of school
        $nopupilclasses = $user->registerclasseswithoutpupil;
        //calculate total members
        if($classes){
            $nopupiltotalMembers = $nopupilclasses->sum('member_counts');
        }else{
            $nopupiltotalMembers = 0;
        }

        $response = array(
            'totalMembers' => $totalMembers,
            'nopupiltotalMembers' => $nopupiltotalMembers,
            'newclass' => $newclass
        );

        return response()->json($response);
    }
    
    public function check(Request $request){
    	$refresh_token = $request->input("refresh_token");
    	$type = $request->input("type");
    	$grade = $request->input("grade");
    	$class_number = $request->input("class_number");
    	$group_id = $request->input("group_id");   
    	$cid = $request->input("cid"); 	

    	$class = Classes::where("group_id", $group_id)
    						   ->where("type", $type)
    						   ->where("grade", $grade)
    						   ->where("class_number",$class_number)->first();

    	if($class){
    		if($class->id == $cid){
    			return response("true");
    		}else{
    			return response("false");
    		}
    	}else{
    		return response("true");
    	}
    }
    
    public function pupil_unlock(Request $request){
    	//$pupil = User::find($request->input("pupil"));
        $student_id_text = $request->input("pupil");
        $student_ids = explode(",", $student_id_text);
        $users = User::whereIn('id',$student_ids)->get();

    	$classid = $request->input("class");
        if(isset($users)){
            foreach($users as $pupil){
                if($pupil){
                    if($pupil->PupilsClass){
                        if($pupil->PupilsClass->id == $classid){
                            $pupil->testable = 0;
                            $pupil->save();
                        }
                    }
                }
            }
        }
    	//$request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
    	return Redirect::back()->with('unlock', 1)->withInput();
    }

    public function CurrentSeaon_Pupil($date){
            //$current_season = [];
        if ($date >= Carbon::create((Date("Y")), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 6, 30,23,59,59)){
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
            $current_season['from'] = (Date('Y')) . '年冬期' . '1月1日';
            $current_season['to'] = Date('Y') . '年' . '3月31日';
            $current_season['term'] = 3; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y') ) . '.' . '1.1';
            $current_season['to_num'] = Date('Y') . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y")), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
            $current_season['end_thisyear'] = Date('Y');
        } /*else if ($date >= Carbon::create((Date("Y")), 12, 21,0,0,0)){
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
        }*/ else if ($date >= Carbon::create((Date("Y") - 1), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 1), 6, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 1) . '年春期' . '4月1日';
            $current_season['to'] = (Date('Y') - 1) . '年' . '6月30日';
            $current_season['term'] = 5; // last year spring
            $current_season['season'] = '春期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y') - 1) . '.' . '4.1';
            $current_season['to_num'] = (Date('Y') - 1) . '.' . '6.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 1), 4, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-1), 6, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
            $current_season['end_thisyear'] = Date('Y');
        } else if ($date >= Carbon::create((Date("Y") - 1), 7, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 1), 9, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 1) . '年夏期' . '7月1日';
            $current_season['to'] = (Date('Y') - 1) . '年' . '9月30日';
            $current_season['term'] = 6; // last year summer
            $current_season['season'] = '夏期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y') - 1) . '.' . '7.1';
            $current_season['to_num'] = (Date('Y') - 1). '.' . '9.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 1), 7, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-1), 9, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
            $current_season['end_thisyear'] = Date('Y');
        } else if ($date >= Carbon::create((Date("Y") - 1), 10, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 1), 12, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 1) . '年秋期' . '10月1日';
            $current_season['to'] = (Date('Y') - 1) . '年' . '12月31日';
            $current_season['term'] = 7; // last year autumn
            $current_season['season'] = '秋期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y') - 1) . '.' . '10.1';
            $current_season['to_num'] = (Date('Y') - 1) . '.' . '12.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 1), 10, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-1), 12, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
            $current_season['end_thisyear'] = Date('Y');
        } else if($date >= Carbon::create((Date("Y") - 1), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 1), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 2) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 1) . '年' . '3月31日';
            $current_season['term'] = 8; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 2);
            $current_season['from_num'] = (Date('Y') - 1) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 1) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 1), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-1), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-2;
            $current_season['end_thisyear'] = Date('Y')-1;
        }else if($date >= Carbon::create((Date("Y") - 2), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 2), 6, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 2) . '年春期' . '4月1日';
            $current_season['to'] = (Date('Y') - 2) . '年' . '6月30日';
            $current_season['term'] = 9; // last year spring
            $current_season['season'] = '春期';
            $current_season['year'] = (Date('Y') - 2);
            $current_season['from_num'] = (Date('Y') - 2) . '.' . '4.1';
            $current_season['to_num'] = (Date('Y') - 2) . '.' . '6.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 2), 4, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-2), 6, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-2;
            $current_season['end_thisyear'] = Date('Y')-1;
        }else if($date >= Carbon::create((Date("Y") - 2), 7, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 2), 9, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 2) . '年夏期' . '7月1日';
            $current_season['to'] = (Date('Y') - 2) . '年' . '9月30日';
            $current_season['term'] = 10; // last year summer
            $current_season['season'] = '夏期';
            $current_season['year'] = (Date('Y') - 2);
            $current_season['from_num'] = (Date('Y') - 2) . '.' . '7.1';
            $current_season['to_num'] = (Date('Y') - 2) . '.' . '9.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 2), 7, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-2), 9, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-2;
            $current_season['end_thisyear'] = Date('Y')-1;
        }else if($date >= Carbon::create((Date("Y") - 2), 10, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 2), 12, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 2) . '年秋期' . '10月1日';
            $current_season['to'] = (Date('Y') - 2) . '年' . '12月31日';
            $current_season['term'] = 11; // last year autumn
            $current_season['season'] = '秋期';
            $current_season['year'] = (Date('Y') - 2);
            $current_season['from_num'] = (Date('Y') - 2) . '.' . '10.1';
            $current_season['to_num'] = (Date('Y') - 2) . '.' . '12.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 2), 10, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-2), 12, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-2;
            $current_season['end_thisyear'] = Date('Y')-1;
        }else if($date >= Carbon::create((Date("Y") - 2), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 2), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 3) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 2) . '年' . '3月31日';
            $current_season['term'] = 12; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 3);
            $current_season['from_num'] = (Date('Y') - 2) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 2) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 2), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-2), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-3;
            $current_season['end_thisyear'] = Date('Y')-2;
        }else if($date >= Carbon::create((Date("Y") - 3), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 3), 6, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 3) . '年春期' . '4月1日';
            $current_season['to'] = (Date('Y') - 3) . '年' . '6月30日';
            $current_season['term'] = 13; // last year spring
            $current_season['season'] = '春期';
            $current_season['year'] = (Date('Y') - 3);
            $current_season['from_num'] = (Date('Y') - 3) . '.' . '4.1';
            $current_season['to_num'] = (Date('Y') - 3) . '.' . '6.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 3), 4, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-3), 6, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-3;
            $current_season['end_thisyear'] = Date('Y')-2;
        }else if($date >= Carbon::create((Date("Y") - 3), 7, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 3), 9, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 3) . '年夏期' . '7月1日';
            $current_season['to'] = (Date('Y') - 3) . '年' . '9月30日';
            $current_season['term'] = 14; // last year summer
            $current_season['season'] = '夏期';
            $current_season['year'] = (Date('Y') - 3);
            $current_season['from_num'] = (Date('Y') - 3) . '.' . '7.1';
            $current_season['to_num'] = (Date('Y') - 3) . '.' . '9.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 3), 7, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-3), 9, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-3;
            $current_season['end_thisyear'] = Date('Y')-2;
        }else if($date >= Carbon::create((Date("Y") - 3), 10, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 3), 12, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 3) . '年秋期' . '10月1日';
            $current_season['to'] = (Date('Y') - 3) . '年' . '12月31日';
            $current_season['term'] = 15; // last year autumn
            $current_season['season'] = '秋期';
            $current_season['year'] = (Date('Y') - 3);
            $current_season['from_num'] = (Date('Y') - 3) . '.' . '10.1';
            $current_season['to_num'] = (Date('Y') - 3) . '.' . '12.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 3), 10, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-3), 12, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-3;
            $current_season['end_thisyear'] = Date('Y')-2;
        }else if($date >= Carbon::create((Date("Y") - 3), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 3), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 4) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 3) . '年' . '3月31日';
            $current_season['term'] = 16; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 4);
            $current_season['from_num'] = (Date('Y') - 3) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 3) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 3), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-3), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-4;
            $current_season['end_thisyear'] = Date('Y')-3;
        }else if($date >= Carbon::create((Date("Y") - 4), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 4), 6, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 4) . '年春期' . '4月1日';
            $current_season['to'] = (Date('Y') - 4) . '年' . '6月30日';
            $current_season['term'] = 17; // last year spring
            $current_season['season'] = '春期';
            $current_season['year'] = (Date('Y') - 4);
            $current_season['from_num'] = (Date('Y') - 4) . '.' . '4.1';
            $current_season['to_num'] = (Date('Y') - 4) . '.' . '6.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 4), 4, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-4), 6, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-4;
            $current_season['end_thisyear'] = Date('Y')-3;
        }else if($date >= Carbon::create((Date("Y") - 4), 7, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 4), 9, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 4) . '年夏期' . '7月1日';
            $current_season['to'] = (Date('Y') - 4) . '年' . '9月30日';
            $current_season['term'] = 18; // last year summer
            $current_season['season'] = '夏期';
            $current_season['year'] = (Date('Y') - 4);
            $current_season['from_num'] = (Date('Y') - 4) . '.' . '7.1';
            $current_season['to_num'] = (Date('Y') - 4) . '.' . '9.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 4), 7, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-4), 9, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-4;
            $current_season['end_thisyear'] = Date('Y')-3;
        }else if($date >= Carbon::create((Date("Y") - 4), 10, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 4), 12, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 4) . '年秋期' . '10月1日';
            $current_season['to'] = (Date('Y') - 4) . '年' . '12月31日';
            $current_season['term'] = 19; // last year autumn
            $current_season['season'] = '秋期';
            $current_season['year'] = (Date('Y') - 4);
            $current_season['from_num'] = (Date('Y') - 4) . '.' . '10.1';
            $current_season['to_num'] = (Date('Y') - 4) . '.' . '12.31';
             $current_season['begin_season']= Carbon::create((Date("Y") - 4), 10, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-4), 12, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-4;
            $current_season['end_thisyear'] = Date('Y')-3;
        }else if($date >= Carbon::create((Date("Y") - 4), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 4), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 5) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 4) . '年' . '3月31日';
            $current_season['term'] = 20; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 5);
            $current_season['from_num'] = (Date('Y') - 4) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 4) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 4), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-4), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-5;
            $current_season['end_thisyear'] = Date('Y')-4;
        }

        return $current_season;
    }

}
