<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use DB;
use Redirect;
use App\Model\Books;
use App\Model\Advertise;
use App\Model\AlertMail;
use App\Mail\ForgotPassword;
use App\Mail\AlertToMember;
use App\Model\Messages;
use App\Model\Notices;
use App\Model\Classes;
use App\Model\OrgworkHistory;
use App\Model\CertiBackup;

use Illuminate\Pagination\Paginator;
use App\Model\AccessHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\Restore;
use Swift_TransportException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $page = 'home';

    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               
        $result = DB::table('users')
            ->where('id',Auth::id())
            ->update(['reload_flag' => 8]);

        $del = DB::table("messages")
            ->select('messages.*')
            ->where('created_at','<', Carbon::createFromDate((Date("Y")-2), Date("m"), Date("d")))
            ->delete();

        $page_info = [
            'side' =>'guest_top',
            'subside' =>'guest_top',
            'top' =>'home',
            'subtop' =>'home',
        ];

        $newBooks = Books::where('active','=', 6)
            ->where('qc_date','>', DB::raw('DATE_SUB(now(), INTERVAL 1 MONTH)'))
            ->orderBy('qc_date', 'desc')
            ->take(4)->get();

        $notices = Notices::orderby('updated_at', 'desc')
                        ->take(4)->get();
                   // ->paginate(4);

        $quizBooks = Books::where('active','>=', 3)->where('active','<', 6)
            ->orderBy('updated_at', 'desc')
            ->take(4)->get();

        $overseerBooks = Books::where('active','=', 3)
            ->orderBy('updated_at', 'desc')
            ->take(4)->get();
        $advertise = Advertise::first();
        return view('home.index')
            ->withPage($this->page)
            ->withNosidebar(true)
            ->withNewBooks($newBooks)
            ->withNotices($notices)
            ->withQuizBooks($quizBooks)
            ->with('advertise', $advertise)
            ->withObBooks($overseerBooks)
            ->with('page_info',$page_info);
    }

    public function get_notice(Request $request){
        $notice = $request->input('notice');
        if($notice == 1){
            $notices = Notices::orderby('updated_at', 'desc')
            ->get();
        }
        else{
            $notices = Notices::orderby('updated_at', 'desc')
            ->take(4)->get();
        }
        return response()->json($notices);
    }

    public function top(Request $request) {
        $result = DB::table('users')
            ->where('id',Auth::id())
            ->update(['reload_flag' => 8]);
        $settlement_flag = CertiBackup::where('user_id', Auth::id())->where('settlement_date','<',date_add(now(),date_interval_create_from_date_string("1 months")))->first();    
        if((is_object($settlement_flag) || is_array($settlement_flag)) && count(get_object_vars($settlement_flag))){
            $message = new Messages;
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = Auth::id();
            $message->name = "協会";
            $message->content = sprintf(config('consts')['MESSAGES']['SETTLEMENT_1MONTH'],
                date_format(date_create($settlement_flag->settlement_date), 'm月d日'));
            $message->save();
        }

        $accessHistory = new AccessHistory;
        $accessHistory->user_id = Auth::user()->id;
        $accessHistory->save(); 
        $advertise = Advertise::first();
        $current_season = HomeController::CurrentSeaon_Pupil(now());
        if(Auth::check() && Auth::user()->active == 2)
            return Redirect::to("/mypage/top?confirm=vice_log");

        if ((Auth::check() && Auth::user()->isGroup())) {
            $messages = Messages::SchoolMessages(Auth::id())->limit(5)->get();
                /*$classes = DB::table('classes')
                //->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("concat(b.firstname, ' ', b.lastname) as vice_teacher_name"))
                ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                //->leftJoin('users as b','classes.teacher_id','=','b.id')
                ->where('classes.group_id', Auth::id())
                ->where('classes.member_counts','>',0)
                ->where('classes.year', $current_season['year'])
                ->where( function ($query) {
                     $query->whereNotNull('class_number')
                     ->orWhere('grade', '>', 0);
                 })
                ->where('classes.active','=',1)
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get();*/
            $classes = DB::table('classes')
                ->select("classes.id", "classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                ->where('classes.group_id', Auth::id())
                ->where('classes.member_counts','>', 0)
                ->where('classes.active','=', 1)
                ->where('classes.year', $current_season['year'])
                ->orwhere('classes.year', $current_season['year'] + 1)
                ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                ->orderBy('classes.year', 'asc')
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get();
            // return $query->where( function ($query) use ($schoolid) {
            //             $query->where('group_id', '=', $schoolid)
            //             ->whereNotNull('teacher_id');
            //         })->orderBy('year', 'desc');

            $page_info = [
                'side' =>'group_top',
                'subside' =>'group_top',
                'top' =>'home',
                'subtop' =>'home',
            ];
             if($request->session()->has("message"))    
            $request->session()->flash('status', $request->session()->get("message"));
            return view('group.home')
                ->with('page_info',$page_info)
                ->withMessages($messages)
                ->withPage($this->page)
                ->with('advertise', $advertise)
                ->with('current_season', $current_season['year'])
                ->withClasses($classes);
        } else if ((Auth::check() && (Auth::user()->isTeacher() || Auth::user()->isRepresen() || Auth::user()->isItmanager() || Auth::user()->isOther()))) {
            //get message from schoolAuth::user()->isItmanager()
            //$messages = Messages::where('from_id', Auth::user()->School->id)->where('type',1)->orderBy('created_at','desc')->get();
            $messages = Messages::where(DB::raw("concat(',',to_id, ',')"),'like','%,'.Auth::user()->id.',%')->where('type',1)->orderBy("updated_at", "desc")->take(3)->get();
            
            //get classes on current year
            if(Auth::user()->isTeacher()){
                //$classes = Auth::user()->School->classes->where('teacher_id',Auth::id());
                $classes = Auth::user()->School->classes->where('teacher_id',Auth::user()->id);
            }
            elseif(Auth::user()->isRepresen() || Auth::user()->isItmanager()){
                 
                 $classes = Auth::user()->School->classes;
            }elseif(Auth::user()->isOther()){
                 
                 $classes = Auth::user()->School->classes;
            }
            
            $totalClassNames = array();
            $totalClassPoints = array();
            $i = 0;
            $current_season = HomeController::CurrentSeaon_Pupil(now());
            
            foreach($classes as $key => $class) {
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
            //get top class on current season grade
            
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
                    $topClassNames[$i] = $classes[$maxIndex]->grade."-".$classes[$maxIndex]->class_number;
                    if($classes[$maxIndex]->TeacherOfClass != null)
                        $topClassNames[$i] = $topClassNames[$i]." ".$classes[$maxIndex]->TeacherOfClass->fullname();
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

            $date = now(); 

            $curQuartDateString = $current_season['from_num']."~".$current_season['to_num'];

            //            $messages = Messages::TeacherMessages(Auth::user()->org_id)->limit(5)->get();
            $page_info = [
                'side' =>'teacher_top',
                'subside' =>'teacher_top',
                'top' =>'home',
                'subtop' =>'home',
            ];
           
            return view('teacher.home')
                ->withPage($this->page)
                ->withMessages($messages)
                ->with('school_classes',[])
                ->with('page_info',$page_info)
                ->with('total_class_names', $totalClassNames)
                ->with('total_class_points', $totalClassPoints)
                ->with('top_class_names', $topClassNames)
                ->with('top_student_names', $topStudentsNames)
                ->with('curQuartDateString', $curQuartDateString)
                ->with('advertise', $advertise)
                ->with('classes', $classes);
        } else if((Auth::check() && Auth::user()->isAdmin())){
            //  $messages = Messages::AdminMessages(Auth::user()->org_id)->limit(5)->get();
            $page_info = [
                'side' =>'admin_top',
                'subside' =>'admin_top',
                'top' =>'admin_top',
                'subtop' =>'home',
            ];
            $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
        
            $accessCnt = DB::table("history_access")
                ->where("created_at" , "like", $yesterday . "%")
                ->count();
            $loginCnt = DB::table("history_login")
                ->where("created_at" , "like", $yesterday . "%")
                ->count();
            $testCnt = DB::table("userquizes_history")
                ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                ->where("userquizes_history.type", 2)
                ->where("userquizes_history.created_date" , "like", $yesterday . "%")
                ->count();
            $testPassedCnt = DB::table("userquizes_history")
                ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                ->where("userquizes_history.type", 2)
                ->where("userquizes_history.status", 3)
                ->where("userquizes_history.created_date" , "like", $yesterday . "%")
                ->count();
            $demandBooksCnt = DB::table("userquizes_history")
                ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                ->where("userquizes_history.type", 0)
                ->where("userquizes_history.status", 3)
                ->where("userquizes_history.created_date" , "like", $yesterday . "%")
                ->count();
            $approvalBooksCnt = DB::table("userquizes_history")
                ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                ->where("userquizes_history.type", 0)
                ->where("userquizes_history.status", 1)
                ->where("userquizes_history.created_date" , "like", $yesterday . "%")
                ->count();
            $newQuizCnt = DB::table("userquizes_history")
                ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                ->where("userquizes_history.type", 1)
                ->where("userquizes_history.status", 3)
                ->where("userquizes_history.created_date" , "like", $yesterday . "%")
                ->count();
            $approvalQuizCnt = DB::table("userquizes_history")
                ->join('books', 'userquizes_history.book_id', DB::raw('books.id and books.active <> 7'))
                ->where("userquizes_history.type", 1)
                ->where("userquizes_history.status", 1)
                ->where("userquizes_history.created_date" , "like", $yesterday . "%")
                ->count();
            $newGroupCnt = DB::table("users")
                ->where("role", config('consts')['USER']['ROLE']["GROUP"])
                ->where("active", 1)
                ->where("created_at" , "like", $yesterday . "%")
                ->count();
            $newPersonCnt = DB::table("users")
                ->whereIn("role", [config('consts')['USER']['ROLE']["ADMIN"],
                                    config('consts')['USER']['ROLE']["GENERAL"],
                                    config('consts')['USER']['ROLE']["OVERSEER"],
                                    config('consts')['USER']['ROLE']["AUTHOR"],
                                    config('consts')['USER']['ROLE']["TEACHER"],
                                    config('consts')['USER']['ROLE']["LIBRARIAN"],
                                    config('consts')['USER']['ROLE']["REPRESEN"],
                                    config('consts')['USER']['ROLE']["ITMANAGER"],
                                    config('consts')['USER']['ROLE']["OTHER"],
                                    config('consts')['USER']['ROLE']["PUPIL"]])
                ->where("active", 1)
                ->where("created_at" , "like", $yesterday . "%")
                ->count();

            return view('admin.home')
                ->withPage($this->page)
                // ->withMessages($messages)
                ->with('page_info',$page_info)
                ->with('accessCnt',$accessCnt)
                ->with('loginCnt',$loginCnt)
                ->with('testCnt',$testCnt)
                ->with('testPassedCnt',$testPassedCnt)
                ->with('demandBooksCnt',$demandBooksCnt)
                ->with('approvalBooksCnt',$approvalBooksCnt)
                ->with('newQuizCnt',$newQuizCnt)
                ->with('approvalQuizCnt',$approvalQuizCnt)
                ->with('newGroupCnt',$newGroupCnt)
                ->with('advertise', $advertise)
                ->with('newPersonCnt',$newPersonCnt);
        }

        $newBooks = Books::where('active','=', 6)
            ->where('qc_date','>', DB::raw('DATE_SUB(now(), INTERVAL 1 MONTH)'))
            ->orderBy('qc_date', 'desc')
            ->take(4)->get();

        $notices = Notices::orderby('updated_at', 'desc')
                        ->take(4)->get();
                   // ->paginate(4);

        $quizBooks = Books::where('active','>=', 3)->where('active','<', 6)
            ->orderBy('updated_at', 'desc')
            ->take(4)->get();

        $overseerBooks = Books::where('active','=', 3)
            ->orderBy('updated_at', 'desc')
            ->take(4)->get();
        //
        $page_info = [
            'side' =>'guest_top',
            'subside' =>'guest_top',
            'top' =>'home',
            'subtop' =>'home',
        ];
        return view('home.index')
            ->withPage($this->page)
            ->withNosidebar(true)
            ->withNewBooks($newBooks)
            ->withNotices($notices)
            ->withQuizBooks($quizBooks)
            ->withObBooks($overseerBooks)
            ->with('advertise', $advertise)
            ->with('page_info',$page_info);
    }

    public function CurrentSeaon($date){
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
            $current_season['end_thisyear'] = Date('Y');
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
            $current_season['end_thisyear'] = Date('Y');
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
            $current_season['end_thisyear'] = Date('Y');
        } else if ($date >= Carbon::create((Date("Y")), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 3, 31,23,59,59)){
            $current_season['fromyear'] = Date('Y');
            $current_season['fromM'] = 1;
            $current_season['fromD'] = 1; 
            $current_season['toyear'] = Date('Y');
            $current_season['toM'] = 3;
            $current_season['toD'] = 31;
            $current_season['from'] = (Date('Y')) . '年冬期' . '1月1日';
            $current_season['to'] = Date('Y') . '年' . '3月31日';
            $current_season['term'] = 3; // this year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = Date('Y');
            $current_season['from_num'] = Date('Y') . '.' . '1.1';
            $current_season['to_num'] = Date('Y') . '.' . '3.31';
            $current_season['begin_season']= Carbon::create(Date("Y"), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create(Date("Y"), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y');
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
        } */

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

    public function alerttomember(){
        $now = now();
        $msg = '';
        $current_season = HomeController::CurrentSeaon($now);
        //$time = Carbon::create((Date("Y")), $current_season['fromM'], 21,0,0,0);
        $time = $current_season['begin_season'];
        //$sendMaildate = AlertMail::sendalertMail($time)->first();
        $sendMaildate = AlertMail::find(1);

        if(isset($sendMaildate) && $sendMaildate->sendmail_date < $time){

            $noMembers = DB::table('users')
                ->where('active','=', 2)->get();
            if(isset($noMembers)){
                
                foreach ($noMembers as $user) {
                    if(isset($user)){
                        //$_SESSION['email'] = $user->email;
                        /*try{
                           Mail::to($user)->send(new AlertToMember($user));
                           //admin
                            $admin = User::find(1);
                            $personadminHistory = new PersonadminHistory();
                            $personadminHistory->user_id = $admin->id;
                            $personadminHistory->username = $admin->username;
                            $personadminHistory->item = 0;
                            $personadminHistory->work_test = 13;
                            $personadminHistory->bookregister_name = $user->username;
                            $personadminHistory->content = '準会員に通知';
                            $personadminHistory->save();
                        }catch(Swift_TransportException $e){
                        
                            return Redirect::back()
                                ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']]);
                        }*/
                    }
                }
            }

            $sendMaildate->sendmail_date = now();
            $sendMaildate->created_date = now();
            $sendMaildate->save();
            $msg = $sendMaildate->sendmail_date;
        }
        
        $response = array(
            'status' => $msg,
         );
        return response()->json($response);
    }
}
