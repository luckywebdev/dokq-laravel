<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Auth;
use DB;
use View;
use App\User;
use App\Model\Classes;
use App\Model\Messages;
use App\Model\PwdHistory;
use App\Model\UserQuiz;
use App\Model\UserQuizesHistory;
use App\Model\PupilHistory;
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
use DateInterval;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
    }
    
    public $page_info = [
        'side' =>'teacher_top',
        'subside' =>'teacher_top',
        'top' =>'home',
        'subtop' =>'home',
    ];

    //render pupil registeration form
    public function reg_pupil(Request $request){
        $this->page_info['side'] = 'pupil_info';
        $this->page_info['subside'] = 'reg_pupil';
        $this->page_info['top'] = 'pupil_info';
        $this->page_info['subtop'] = 'reg_pupil';        
        if(Auth::guest()){
            return Redirect::to('/');
        }

        if(Auth::user()->isTeacher()){
           
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isGroup()){
            $classes = Classes::where('group_id', '=', Auth::id())
                ->whereNotNull('teacher_id')
                ->orderBy('year')
                ->get();
        }else if(Auth::user()->isRepresen()){
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isItmanager()){
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isOther()){
            $classes = Auth::user()->School->classes;
        }
        $teacherinfo = User::find(Auth::id());

        return view('teacher.manage_pupil.register')
            ->with('the_classes', $classes)
            ->with('the_reg_form', 1)  
            ->with('teacherinfo', $teacherinfo)          
    		->with('page_info', $this->page_info);
    }
    
    public function viewClassList(Request $request) {
        //if (!Auth::user()->isTeacher()){
        if (!Auth::user()->isSchoolMember()){
            return Redirect::to('/');
        }
        $unlock = $request->input("unlock"); //if clicks  ログインエラー ロック解除 pulldown

        $this->page_info['side'] = 'class_list';
        $this->page_info['top'] = 'class_list';
        $this->page_info['subside'] = 'class_list';
        $this->page_info['subtop'] = 'class_list';
        $current_season = TeacherController::CurrentSeaon_Pupil(now());

        if($request->session()->has('teacher_auth') && $request->session()->get('teacher_auth') == 1){
            $fixed_flag = 1;
        }
        else{
            $fixed_flag = 0;
        }

        if (Auth::user()->isGroup()){
            $classes = Classes::ActiveClasses(Auth::id())->get();
        }else if(Auth::user()->isTeacher()){
            /*$classes = Classes::where('teacher_id',Auth::user()->id)
                                ->where('group_id', Auth::user()->org_id)
                                ->where('year', $current_season['year'])
                                ->get();*/
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isRepresen()){
            $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isItmanager()){
             $classes = Auth::user()->School->classes;
        }else if(Auth::user()->isOther()){
            $classes = Auth::user()->ClassesOfTeacher($current_season);
        }else if(Auth::user()->isLibrarian()){
            if(Auth::user()->org_id != 0){
                $classes = Auth::user()->School->classes;
            }
            else{
                $classes = [];
            }
            //  $recs = Auth::user()->SchoolOfLibrarian;
            //  $qq = array();
            // for ($i=0;$i<count($recs);$i++) {
            //   $qq[]=$recs[$i]->group_id;
            // }
            // // $classes = $qq;
            // $classes = Classes::classListbyLibrarian($qq, $current_season['year']);
           
        }
        else{
            $classes = Auth::user()->School->classes;
        }
        $pupil = array();
        $pupilStatus = array();
        $wishStatus = array();
        $teacher_belong = 0;
        $class_id = $request->input("class_id");
        if($request->has("class_id")){
            $pupil = Classes::find($class_id)->Pupils;
            $teacher_id_chk = Classes::find($class_id)->teacher_id;

            if($teacher_id_chk == Auth::id()){
                $teacher_belong = 1;
            }
            else{
                $teacher_belong = 0;
            }
        	//get pupil status
        	for($i = 0; $i < count($pupil); $i++){
                $status = $pupil[$i]->QuizStatus;
        		if($pupil[$i]->islogged == 0){
        			$pupilStatus[$i] = 5;
        		}else if(count($status)>0){
        			$pupilStatus[$i] = $status[0]->status;
        		}else{
        			$pupilStatus[$i] = 3;
        		}
                $wishStatus[$i] = 0;
                $wishlists = $pupil[$i]->WishbookdateStatus($pupil[$i]->id)->get();
                $k = 0;
                foreach ($wishlists as $key => $value) {
                    $userquiz = UserQuiz::where('user_id', $pupil[$i]->id)->where('book_id', $value->book_id)->where('type',2 )->where('status',3)->get();
                    if(count($userquiz) == 0){
                        $wishStatus[$i] = 1;
                        break;
                    }
                    $k++;
                }
        	}
        }

        $user = User::find(Auth::id());

        //$the_class = Classes::find($request->input('class'));
        // $pupils = $the_class->Pupils;
     
        $view = view('teacher.pupil_list')
        	->with('page_info', $this->page_info)
            //->with('the_classes', $the_classes)
            //->with('the_class', $the_class)
            ->withClasses($classes)
        	->withPupil($pupil)
        	->withPupilStatus($pupilStatus)
            ->withWishStatus($wishStatus)
            ->withClassId($class_id)
            ->withUser($user)
            ->with('fixed_flag', $fixed_flag)
            ->with('teacher_belong', $teacher_belong);
        if ($request->session()->has("unlock"))
            $view = $view->with('unlock', $request->session()->get('unlock'));

        return $view;  
    }

    public function viewPwdHistory() {
        if (!Auth::user()->isSchoolMember()){
            return Redirect::to('/');
        }
        $this->page_info['side'] = 'password_history';
        $this->page_info['top'] = 'password_history';
        $this->page_info['subside'] = 'password_history';
        $this->page_info['subtop'] = 'password_history';
 		
        $overseers = PwdHistory::where('overseer_id', Auth::id())->get();
        return view('teacher.pwd_history')
            ->with('page_info', $this->page_info)
            ->withOverseers($overseers);
    }

    public function sendNotify(Request $request) {
        if (!Auth::user()->isSchoolMember()){
            return Redirect::to('/');
        }
        if($request->input('class') == null || $request->input('class') == ""){
            return Redirect::to('/class/search_pupil?mode=B');
            // $pupils = User::where('org_id', '=', 0)->where('role', config('consts')['USER']['ROLE']['PUPIL'])->get();
        }
        $this->page_info['side'] = 'send_notify';
        $this->page_info['top'] = 'send_notify';
        $this->page_info['subside'] = 'send_notify';
        $this->page_info['subtop'] = 'send_notify';

        //        if (Auth::user()->isGroup()){
        //            $the_classes = Classes::ActiveClasses(Auth::id())->get();
        //        }else if(Auth::user()->isTeacher()){
        //            $the_classes  =Classes::ActiveClasses(Auth::user()->School->id)->get();
        //        }
        //        $the_class = Classes::find($request->input('class'));
        // $pupils = $the_class->pupils;
                
        $student_id_text = $request->input("pupil");
        $student_ids = explode(",", $student_id_text);
        $users = User::whereIn('id',$student_ids)->get();
        $messages = Messages::where('from_id', Auth::id())->where('type',0)->orderBy('created_at','desc')->get();
        $messages->map(function($message){
        	$toids = explode(",",$message->to_id);
        	$to_usernames ='';
        	foreach($toids as $id){

        		$user = User::find($id);
        		if (isset($user) && $user->fullname() && strlen($user->fullname()) > 0) {
        		   if (strlen($to_usernames) > 0) $to_usernames =$to_usernames.',';
        		   $to_usernames =$to_usernames.$user->fullname();
        		}
        	}
        	
        	$message->to_username = $to_usernames;
        	return $message;
        });
        $classes =  Classes::where("id", $request->input("class"))->get();

        return view('teacher.send_notify')
                ->with('page_info', $this->page_info)
                ->withMessages($messages)
                ->withUsers($users)
                ->withToId($student_id_text)
                ->withClasses($classes);
    }
    
    public function post_notify(Request $request){
    	$content = $request->input("content");
    	$to_id = $request->input("pupil");
    	$newrecord = new Messages();
    	$newrecord->content = $content;
    	$newrecord->to_id = $to_id;
    	$newrecord->from_id = Auth::id();
    	$newrecord->type = 0;
        $rolename = "";
        $user = User::find(Auth::id());
        if($user->role == config('consts')['USER']['ROLE']['GROUP']) 
            $rolename = "団体";
        elseif($user->role == config('consts')['USER']['ROLE']['GENERAL']) 
            $rolename = "一般";
        elseif($user->role == config('consts')['USER']['ROLE']['OVERSEER']) 
            $rolename = "監修者";
        elseif($user->role == config('consts')['USER']['ROLE']['AUTHOR']) 
            $rolename = "著者";
        elseif($user->role == config('consts')['USER']['ROLE']['TEACHER']) 
            $rolename = "担任";
        elseif($user->role == config('consts')['USER']['ROLE']['LIBRARIAN']) 
            $rolename = "司書";
        elseif($user->role == config('consts')['USER']['ROLE']['REPRESEN']) 
            $rolename = "代表（校長、教頭等）";
        elseif($user->role == config('consts')['USER']['ROLE']['ITMANAGER']) 
            $rolename = "IT担当者";
        elseif($user->role == config('consts')['USER']['ROLE']['OTHER']) 
            $rolename = "その他";
        elseif($user->role == config('consts')['USER']['ROLE']['ADMIN']) 
            $rolename = "協会";
        elseif($user->role == config('consts')['USER']['ROLE']['PUPIL']) 
            $rolename = "生徒";
        $newrecord->name = $rolename." ".$user->fullname();
    	$newrecord->save();
    	
        if($user->isGroup() || $user->isSchoolMember()){
                        
            $orgworkHistory = new OrgworkHistory();
            if($user->isSchoolMember()){
                $orgworkHistory->user_id = $user->id;
                $orgworkHistory->username = $user->username;
                $orgworkHistory->group_id = $user->org_id;
                if(!$user->isLibrarian())
                    $orgworkHistory->group_name = User::find($user->org_id)->username; 
            }
            if($user->isGroup()){
                $orgworkHistory->user_id = $user->id;
                $orgworkHistory->username = $user->id;
                $orgworkHistory->group_id = $user->id;
                $orgworkHistory->group_name = $user->username;
            }
                                                       
            $orgworkHistory->item = 2;
            $orgworkHistory->work_test = 2;
            $orgworkHistory->objuser_name = User::find($to_id)->username;
            $classname = "";
            $classes = User::find($to_id)->PupilsClass;
            if($classes->grade != 0)
               $classname .= $classes->grade."年"; 
            $classname .= $classes->class_number.""; 
            $classname .= "組";
            $orgworkHistory->class = $classname;
            $orgworkHistory->content = $content;
            $orgworkHistory->save();
        }

    	return Redirect::back()->withInput();
    }
    
    public function delNotify(Request $request){
    	$id = $request->input("id");
    	$message = Messages::find($id);
    	if($message){

    		//$message->delete();
            $message->del_flag = 1;
            $message->save();
            $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
    		return Redirect::back();
    	}else{
    		return response('Unathorized', 404);
    	}
    }

    public function cancelPass(Request $request) {
        if (!Auth::user()->isSchoolMember()){
            return Redirect::to('/');
        }
        $this->page_info['side'] = 'cancel_pass';
        $this->page_info['top'] = 'cancel_pass';
        $this->page_info['subside'] = 'cancel_pass';
        $this->page_info['subtop'] = 'cancel_pass';
        //$user = User::find($request->input("pupil"));

        $student_id_text = $request->input("pupil");
        $student_ids = explode(",", $student_id_text);
        $users = User::whereIn('id',$student_ids)->get();

        if(isset($student_ids)){
            
            $userQuizes = UserQuiz::select('user_quizes.*', 'books.title', 'books.firstname_nick', 'books.isbn', 'books.firstname_yomi')
                                    ->whereIn('user_id', $student_ids)
                                    ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
                                    ->where('user_quizes.type',2 )->where('user_quizes.status',3)->orderBy('user_quizes.finished_date','desc')->get();
        	return view('teacher.cancel_pass')
            ->with('page_info', $this->page_info)
            ->withUsers($users)
            ->with('student_ids', $student_id_text)
            ->withUserQuizes($userQuizes);

        } else {
        	return Redirect::to('/class/search_pupil?mode=E');
        }        
    }

    public function checkSameUser(Request $request){

        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        // $gender = $request->input('gender');
        $birthday = $request->input('birthday');
        $username = $request->input('username');
        $user = User::select("*");
        if(isset($firstname) && $firstname != "" && isset($lastname) && $lastname != "" && isset($username) && $username != ""){
            $user->where('firstname', $firstname)
                 ->where('lastname', $lastname)
                 ->where('username', $username);
        }
        elseif(isset($username) && $username != "" && isset($birthday) && $birthday != ""){
            $user->where('birthday', $birthday)
                 ->where('username', $username);
        }
        elseif(isset($firstname) && $firstname != "" && isset($lastname) && $lastname != "" && isset($birthday) && $birthday != ""){
            $user->where('firstname', $firstname)
                    ->where('lastname', $lastname)
                    ->where('birthday', $birthday);
        }
        else{
            $response = array(
                'status' => 'there_is_no',
            );
            return response()->json($response);
        }
        $user = $user->get();
        if(count($user) > 0) {
            # there is same user..
            $response = array(
                'status' => 'there_is',
                'firstname' => $user[0]->firstname,
                'lastname' => $user[0]->lastname,
                'firstname_yomi' => $user[0]->firstname_yomi,
                'lastname_yomi' => $user[0]->lastname_yomi,
                'firstname_roma' => $user[0]->firstname_roma,
                'lastname_roma' => $user[0]->lastname_roma,
                'birthday' => $user[0]->birthday,
                'gender' => $user[0]->gender,
                'username' => $user[0]->username,
                'password' => $user[0]->r_password,
                'address1' => $user[0]->address1,
                'address2' => $user[0]->address2,
                'address3' => $user[0]->address3,
                'address4' => $user[0]->address4,
                'address5' => $user[0]->address5,
                'address6' => $user[0]->address6,
                'address7' => $user[0]->address7,
                'address8' => $user[0]->address8,
                'address9' => $user[0]->address9,
                'address10' => $user[0]->address10,
                'image_path' => $user[0]->image_path,
                'teacher' => $user[0]->teacher,
                'properties' => $user[0]->properties,
                'email' => $user[0]->email,
                'phone' => $user[0]->phone,
                'pupil_id' => $user[0]->id
            );
        }
        else{
            $response = array(
                'status' => 'there_is_no',
            );
        }
        return response()->json($response);

    }

    public function checkPupilExists(Request $request){

        $firstname_roma = $request->input('firstname_roma');
        $lastname_roma = $request->input('lastname_roma');
        $gender = $request->input('gender');
        $birthday = $request->input('birthday');

        $birthdayary = preg_split('{/}', $birthday);
        /*$month = $birthdayary[1];
        $firststrofmonth = substr($month, 0, 1);
        if($firststrofmonth == "0") $month = substr($month, 1, 1);
        $day = $birthdayary[2];
        $firststrofday = substr($day, 0, 1);
        if($firststrofday == "0") $day = substr($day, 1, 1);
        $index = 0;
        $username = $this->checkusername($month, $day, $firstname_roma, $index);*/

        $ran = rand(100, 999);
        $firstnamecut = substr($firstname_roma, 0, 2);
        $lastnamecut = substr($lastname_roma, 0, 2);
        $username = strtolower($lastname_roma)."0".$ran.$gender;
        $password = strtolower($firstnamecut).strtolower($lastnamecut)."0".$ran.$gender;
        $response = array(
            'status' => 'success',
            'username' => $username,
            'password' => $password,
        );
        
        return response()->json($response);
    }

    public function movewtoUsername(Request $request){

        $pupilids = $request->input("pupilids");
        $pupilid_ary = explode(",", $pupilids);
        $users = User::whereIn('id',$pupilid_ary)->get();

        //$classid = $request->input("class");
        if(isset($users)){
            foreach($users as $pupil){
                if($pupil){
                    if($pupil->islogged == 0){
                        $pupil->namepwd_check = true;
                        $pupil->save();
                    }
                }
            }
        }
        $response = array(
            'status' => 'success',
        );
        
        return response()->json($response);
    }

    public function checkusername($month, $day, $firstname_roma, $index){
       
        
        if($index == 0)
            $username = $month.$day.substr($firstname_roma, 0, 8 - strlen($month) - strlen($day));
        else
            $username = $month.$day.substr($firstname_roma, 0, 8 - strlen($month) - strlen($day) - strlen(string($index))).string($index);
        
        $user = User::where('username', $username)->get();

        if(count($user) > 0) {
            $index ++;
            $username = $this->checkusername($month, $day, $firstname_roma, $index);
        } 
        
        return $username;
        
    }

    public function RegisterPupil($mode, Request $request){
     
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $firstname_yomi = $request->input('firstname_yomi');
        $lastname_yomi = $request->input('lastname_yomi');
        $firstname_roma = $request->input('firstname_roma');
        $lastname_roma = $request->input('lastname_roma');
        $content = '';
        $current_season = $this->CurrentSeaon_Pupil(now());

        if($request->input('update_key') == 0){
            $user = new User;
            $user->username = $request->input('username');
            $rule = array(
                'r_password' => 'string|required|max:15|min:8|unique:users',
                //'parent_email' =>'required|email',
                'email' =>'required|unique:users|email'
            );
        }else{
            $user = User::find($request->input('pupil_id'));
            $rule = array(
                'r_password' => 'string|required|max:15|min:8',
                //'parent_email' =>'required|email',
            );
            if(count(User::where('username', '!=', $user->username)->where('email',$request->input('email'))->get()) > 0) {
                $rule['email'] = 'required|unique:users';
            }
            if(count(User::where('username', '!=', $user->username)->where('r_password',$request->input('r_password'))->get()) > 0) {
                $rule['r_password'] = 'string|required|max:15|min:8|unique:users';
            }

            if($user->firstname != $request->input('firstname')){
                if($content != '') $content .= '、';
                $content .= '氏';
            }
            if($user->lastname != $request->input('lastname')){
                if($content != '') $content .= '、';
                $content .= '名';
            } 
            if($user->firstname_yomi != $request->input('firstname_yomi')){
                if($content != '') $content .= '、';
                $content .= '氏(カタカナ)';
            } 
            if($user->lastname_yomi != $request->input('lastname_yomi')){
                if($content != '') $content .= '、';
                $content .= '名(カタカナ)';
            } 
            if($user->firstname_roma != $request->input('firstname_roma')){
                if($content != '') $content .= '、';
                $content .= '氏(ローマ字)';
            } 
            if($user->lastname_roma != $request->input('lastname_roma')){
                if($content != '') $content .= '、';
                $content .= '名(ローマ字)';
            } 
            if($user->gender != $request->input('gender')){
                if($content != '') $content .= '、';
                $content .= '性別';
            } 
            if($user->birthday != $request->input('birthday')){
                if($content != '') $content .= '、';
                $content .= '生年月日';
            }  
            if($user->properties != $request->input('role')){
                if($content != '') $content .= '、';
                $content .= '属性';
            }  
            if($user->org_id != $request->input('classes') || $request->input('classes') == ""){
                if($content != '') $content .= '、';
                $content .= '学級';
            }  
            if($user->address1 != $request->input('address1') || $user->address2 != $request->input('address2') || 
                $user->address3 != $request->input('address3') || $user->address4 != $request->input('address4') || 
                $user->address5 != $request->input('address5') || $user->address6 != $request->input('address6') || 
                $user->address7 != $request->input('address7') || $user->address8 != $request->input('address8') || 
                $user->address9 != $request->input('address9') || $user->address10 != $request->input('address10')){
                if($content != '') $content .= '、';
                $content .= '住所';
            }  
            if($user->username != $request->input('username')){
                if($content != '') $content .= '、';
                $content .= '読Qネーム';
            }  
            if($user->r_password != $request->input('r_password')){
                if($content != '') $content .= '、';
                $content .= 'パスワード';
            }  
            if($user->phone != $request->input('phone')){
                if($content != '') $content .= '、';
                $content .= '電話';
            }  
            if($user->group_name != $request->input('group1')){
                if($content != '') $content .= '、';
                $content .= '所属１';
            } 
            if($user->group_yomi != $request->input('group2')){
                if($content != '') $content .= '、';
                $content .= '所属2';
            } 
            /*if($user->teacher != $request->input('parent_email')){
                if($content != '') $content .= '、';
                $content .= '保護者メールアドレス';
            }  */
            if($user->email != $request->input('email')){
                if($content != '') $content .= '、';
                $content .= '本人メールアドレス';
            }  

        }
        $messages = array(
            'r_password.unique' => config('consts')['MESSAGES']['PASSWORD_EXIST'],
            'r_password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED'],
            'r_password.min' => config('consts')['MESSAGES']['PASSWORD_LENGTH'],
            'r_password.max' => config('consts')['MESSAGES']['PASSWORD_MAXLENGTH'],
            
            //'parent_email.required' => config('consts')['MESSAGES']['EMAIL_REQUIRED'],
            //'parent_email.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email.required' => config('consts')['MESSAGES']['EMAIL_REQUIRED'],
            'email.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE'],
        );
        $validator = Validator::make($request->all(), $rule, $messages);
        
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput()->with('page_info', $this->page_info);
        }
        //class numbers compare
        $classInfos = Classes::find($request->input('classes'));
        if(!is_null($classInfos)){
            $memberCounts = $classInfos ->member_counts;
        }
        if($request->input('update_key') == 0){
            $RegPupilNumbers = count(User::where('org_id',$request->input('classes'))->where('role',config('consts')['USER']['ROLE']['PUPIL'])->where('active',1)->get());
            if($memberCounts <= $RegPupilNumbers){
                return Redirect::back()->withErrors(["membererr" =>  config('consts')['MESSAGES']['MEMBER_COUNT_ERROR']])->withInput()->with('page_info', $this->page_info);
            }
        }
        $user->r_password = trim($request->input('r_password'));
        $user->password = md5($user->r_password);
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->firstname_yomi = $firstname_yomi;
        $user->lastname_yomi = $lastname_yomi;
        $user->firstname_roma = $firstname_roma;
        $user->lastname_roma = $lastname_roma;
        $user->org_id = $request->input('classes');
        $user->birthday = $request->input('birthday');
        $user->group_name = $request->input('group1');
        $user->group_yomi = $request->input('group2');
        $user->phone = $request->input('phone');
        $user->properties = $request->input('role');
        $user->role = config('consts')['USER']['ROLE']['PUPIL'];
        $user->email = $request->input('email');
        //$user->teacher = $request->input('parent_email');
        $user->gender = $request->input('gender');
        $user->rep_name = $request->input('rep_name');//name of register
        $user->address3 = $request->input('address3');
        $user->address4 = $request->input('address4');
        $user->address5 = $request->input('address5');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->address6 = $request->input('address6');  
        $user->address7 = $request->input("address7"); 
        $user->address8 = $request->input("address8"); 
        $user->address9 = $request->input("address9"); 
        $user->address10 = $request->input("address10");     

        $file = $request->file('face_img');
        if($file){
           /* $ext = $file->getClientOriginalExtension();
            $now = date('YmdHis');
            $filename = md5($now . $file->getClientOriginalName()) . '.' . $ext;
            $url = 'uploads/myprofile/'. Auth::id();
            $file->move($url , $filename);
            $user->image_path = $url . '/' . $filename ;*/

            $ext = $file->getClientOriginalExtension();
            $now = date('YmdHis');
            $filename = md5($now . $file->getClientOriginalName()) . '.' . $ext;
            $authfilesize = $file->getClientSize();
            $maxfilesize =$file->getMaxFilesize();
            $maxfilesize1 = round($maxfilesize / 1024 / 1024, 0);
            if($authfilesize == 0 || $authfilesize > $maxfilesize){
                             
                return Redirect::back()
                ->withErrors(["filemaxsize" => 'ファイル容量は'.$maxfilesize1.'MB以下でしてください。'])
                ->withInput();
               
            }else{
                //$url = 'uploads/myprofile/'. Auth::id();
                $url = '/uploads/users';
                if(file_exists(public_path().$user->image_path) && $user->image_path !== null && $user->image_path != ''){
                    if(file_exists(public_path().$user->beforeimage_path) && $user->beforeimage_path !== null && $user->beforeimage_path != ''){
                        unlink(public_path().$user->beforeimage_path);
                    } 
                    $user->beforeimage_path = $user->image_path;
                    $user->beforeimagepath_date = $user->imagepath_date;
                }
                                //upload file
                $file->move($url, $filename);
                $user->image_path = $url . '/' . $filename ;
                $user->imagepath_date = date_format(now(), "Y-m-d");
            }
        }

        $user->active = 1;
        $user->fullname_is_public = 0;
        $user->fullname_yomi_is_public = 0;
        $user->gender_is_public = 0;
        $user->birthday_is_public = 0;
        $user->role_is_public = 0;
        $user->address_is_public = 0;
        $user->address1_is_public = 0;
        $user->address2_is_public = 0;
        $user->username_is_public = 0;
        $user->groupyomi_is_public  = 0;
        $user->refresh_token  = md5($user->email).md5(time());
        $user->save();

        $classes = $user->PupilsClass;
        //register or edit to pupil_history
        $pupil_history = PupilHistory::where('pupil_id', $user->id)->orderBy('created_at','desc')->first();
        if(!isset($pupil_history) || (!is_null($classes) && $pupil_history->class_id != $classes->id)){
            if(isset($pupil_history)){
                //$pupil_history->updated_at = date_format(DATE_SUB(now(), new DateInterval("P1D")), "Y-m-d");
                $pupil_history->updated_at = date_format(now(), "Y-m-d");
                $pupil_history->save(); //卒業・転出日
            }

            $pupil_history = new PupilHistory();
            $pupil_history->pupil_id = $user->id;
            $pupil_history->group_name = $request->input('group1');
            
            $classname = "";
            if($classes->grade != 0)
               $classname .= $classes->grade."-"; 
            $classname .= $classes->class_number." "; 
            if($classes->TeacherOfClass !== null)
               $classname .= $classes->TeacherOfClass->fullname()." ";
            $classname .= "学級/".$classes->year."年度";
            $pupil_history->grade = $classes->grade;
            $pupil_history->class_number = $classes->class_number;
            $pupil_history->teacher_name = $classes->TeacherOfClass->fullname();
            $pupil_history->class = $classname;
            $pupil_history->class_id = $classes->id;
            $pupil_history->created_at = date_format(now(), "Y-m-d");
            $pupil_history->save();
        }

        if(Auth::user()->isGroup() || Auth::user()->isSchoolMember()){
                        
            $orgworkHistory = new OrgworkHistory();
            if(Auth::user()->isSchoolMember()){
                $orgworkHistory->user_id = Auth::user()->id;
                $orgworkHistory->username = Auth::user()->username;
                $orgworkHistory->group_id = Auth::user()->org_id;
                if(!$user->isLibrarian())
                    $orgworkHistory->group_name = User::find(Auth::user()->org_id)->username; 
            }
            if(Auth::user()->isGroup()){
                $orgworkHistory->user_id = Auth::user()->id;
                $orgworkHistory->username = Auth::user()->id;
                $orgworkHistory->group_id = Auth::user()->id;
                $orgworkHistory->group_name = Auth::user()->username;
            }
                                                       
            $orgworkHistory->item = 2;
            if($request->input('update_key') == 0){
                $orgworkHistory->work_test = 0;
            }else{
                $orgworkHistory->work_test = 1;
                $orgworkHistory->content = $content;
            } 
            $orgworkHistory->objuser_name = $user->username;
            $classname = "";
            if($classes->grade != 0)
               $classname .= $classes->grade."年"; 
            $classname .= $classes->class_number.""; 
            $classname .= "組";
            $orgworkHistory->class = $classname;
            
            $pupil_numbers = 0;

            $classes = DB::table('classes')
                ->select("classes.id", "classes.type","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                ->where('classes.member_counts','>', 0)
                ->where('classes.active','=', 1)
                ->where('classes.year', $current_season['year'])
                ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
            if(Auth::user()->isSchoolMember()){
                $classes = $classes->where('classes.group_id', Auth::user()->org_id);
            }else if(Auth::user()->isGroup()){
                $classes = $classes->where('classes.group_id', Auth::id());
            }
            $classes = $classes->get();
            foreach ($classes as $key => $class) {
                if($class->member_counts > 0)
                    $pupil_numbers += $class->member_counts;
            }
            if($pupil_numbers > 0) //because after $user->save(), $pupil_numbers -= 1;
                $pupil_numbers -= 1;
            $orgworkHistory->pupil_numbers = $pupil_numbers;

            $orgworkHistory->save();
        }
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);

        if($mode == 'continue'){
            return Redirect::to("/teacher/reg_pupil");
        }else{
            return Redirect::to("/top");
        }
    }
    
    public function action_pupil(Request $request){
        $rule = array(
            'pupil' => 'required', 
            'action' => 'required', 
        );
        $messages = array(
            'pupil.required' => config('consts')['MESSAGES']['PUPIL_REQUIRED'] ,
            'action.required' => config('consts')['MESSAGES']['ACTION_REQUIRED'] ,
        );
        $validator = Validator::make($request->all(), $rule, $messages);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator);
        }
        $action = config('consts')['TEACHER']['ACTIONS'][$request->input('action')]['ACTION'];
        return Redirect::to($action . "?pupil=" . $request->input('pupil'));
    }
    public function edit_pupil(Request $request){
        if(Auth::user()->isGroup()){
            $this->page_info = array(
                'top' => 'search_pupil',
                'subtop' => 'edit_pupil',
                'side' => 'search_pupil',
                'subside' => 'edit_pupil'
            );    
        }else{
            $this->page_info = array(
                'top' => 'pupil_info',
                'subtop' => 'edit_pupil',
                'side' => 'pupil_info',
                'subside' => 'edit_pupil'
            );
        }
        $this->page_info['mode'] = str_replace("/teacher/edit_pupil?mode=", "", $request->input('action'));
        if ($this->page_info['mode'] == 'delete') {
            $this->page_info['subtop'] = 'del_pupil';
            $this->page_info['subside'] = 'del_pupil';
        }

        $pupil = User::find($request->input('pupil'));
        $pupilclass = $pupil->PupilsClass; 
        $the_classes = Classes::GetClassesForEditing($pupilclass)->get();
        /*if (Auth::user()->isGroup()){
            $the_classes = Classes::ActiveClasses(Auth::id())->get();
        }else if(Auth::user()->isTeacher()){
            //$the_classes  =Classes::ActiveClasses(Auth::user()->School->id)->get();
            //$the_classes = Auth::user()->School->classes;
            
        }else if(Auth::user()->isRepresen()){
            $the_classes = Auth::user()->School->classes;
        }else if(Auth::user()->isItmanager()){
            $the_classes = Auth::user()->School->classes;
        }else if(Auth::user()->isOther()){
            $the_classes = Auth::user()->School->classes->where('teacher_id',Auth::id());
        }*/
        
        
        return view('teacher.manage_pupil.edit')
            ->with('pupil', $pupil)
            ->with('the_classes', $the_classes)
            ->with('the_reg_form', 2)
            ->with('page_info', $this->page_info);
    }

    public function delete_pupil(Request $request){
        if(Auth::user()->isGroup()){
            $this->page_info = array(
                'side' => 'search_pupil',
                'subside' => 'delete_pupil',
            );    
        }else{
            $this->page_info = array(
                'side' => 'delete_pupil',
                'subside' => 'delete_pupil'
            );
        }

        if (Auth::user()->isGroup()){
            $the_classes = Classes::ActiveClasses(Auth::id())->get();
        }else if(Auth::user()->isTeacher()){
            $the_classes  =Classes::ActiveClasses(Auth::user()->School->id)->get();
        }
        
        $pupil = User::find($request->input('pupil'));
        return view('teacher.manage_pupil.register')
            ->with('pupil', $pupil)
            ->with('the_classes', $the_classes)
            ->with('page_info', $this->page_info);
    }
    public function remove_pupil(Request $request){
        $rule = array('id' => 'required', );
        $message = array('id.required' => '児童生徒を選択して下さい。');
        $validator = Validator::make($request->all(), $rule, $message);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $id = $request->input('id');
        User::destroy($id);
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/top');
    }
    public function move_pupil(Request $request){
        $ids = preg_split('/,/', $request->input('pupil'));
        $current_season = $this->CurrentSeaon_Pupil(now());
        for ($i = 0; $i < count($ids); $i++) {
            $user = User::find($ids[$i]);

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
            $personworkHistory->content = '転校';
            $personworkHistory->age = $user->age();
            $personworkHistory->address1 = $user->address1;
            $personworkHistory->address2 = $user->address2;
            $personworkHistory->save(); 

            $classes = $user->ClassOfPupil;
                            
            $pupil_history = new PupilHistory();
            $pupil_history->pupil_id = $user->id;
            $pupil_history->group_name = '転校';
            
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

            if(Auth::user()->isGroup() || Auth::user()->isSchoolMember()){
                        
                $orgworkHistory = new OrgworkHistory();
                if(Auth::user()->isSchoolMember()){
                    $orgworkHistory->user_id = Auth::user()->id;
                    $orgworkHistory->username = Auth::user()->username;
                    $orgworkHistory->group_id = Auth::user()->org_id;
                    if(!Auth::user()->isLibrarian())
                        $orgworkHistory->group_name = User::find(Auth::user()->org_id)->username; 
                }
                if(Auth::user()->isGroup()){
                    $orgworkHistory->user_id = Auth::user()->id;
                    $orgworkHistory->username = Auth::user()->id;
                    $orgworkHistory->group_id = Auth::user()->id;
                    $orgworkHistory->group_name = Auth::user()->username;
                }
                                                           
                $orgworkHistory->item = 2;
                $orgworkHistory->work_test = 4;
                $orgworkHistory->objuser_name = User::find($user->id)->username;
                $classname = "";
                $classes = User::find($user->id)->PupilsClass;
                if($classes->grade != 0)
                   $classname .= $classes->grade."年"; 
                $classname .= $classes->class_number.""; 
                $classname .= "組";
                $orgworkHistory->class = $classname;
                $orgworkHistory->content = $user->fullname();
                $orgworkHistory->newyear = '所属解除（準会員へ）';
                $pupil_numbers = 0;

                $classes = DB::table('classes')
                    ->select("classes.id", "classes.type","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                    ->leftJoin('users as a','classes.teacher_id','=','a.id')
                    ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                    ->where('classes.member_counts','>', 0)
                    ->where('classes.active','=', 1)
                    ->where('classes.year', $current_season['year'])
                    ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                    ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
                if(Auth::user()->isSchoolMember()){
                    $classes = $classes->where('classes.group_id', Auth::user()->org_id);
                }else if(Auth::user()->isGroup()){
                    $classes = $classes->where('classes.group_id', Auth::id());
                }
                $classes = $classes->get();
                foreach ($classes as $key => $class) {
                    if($class->member_counts > 0)
                        $pupil_numbers += $class->member_counts;
                }
                if($pupil_numbers > 0) //because after $user->save(), $pupil_numbers -= 1;
                    $pupil_numbers -= 1;
                $orgworkHistory->pupil_numbers = $pupil_numbers;
                $orgworkHistory->save();
            }
            if($user->properties == 0){
                $user->active = 2;
                $user->role = 1;
                $user->org_id = 0;
                $user->group_name = '';
                $user->group_yomi = '';
            }
            elseif($user->properties == 1){
                $user->role = 1;
                $user->org_id = 0;
                $user->group_name = '';
                $user->group_yomi = '';
            }
            //$user->role = 1;
            $user->save();
        }
        
        return Redirect::to('/top');
    }

    public function graduate_pupil(Request $request){
        $ids = preg_split('/,/', $request->input('pupil'));
        $current_season = $this->CurrentSeaon_Pupil(now());
        for ($i = 0; $i < count($ids); $i++) {
            $user = User::find($ids[$i]);

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
            $personworkHistory->content = '卒業';
            $personworkHistory->age = $user->age();
            $personworkHistory->address1 = $user->address1;
            $personworkHistory->address2 = $user->address2;
            $personworkHistory->save(); 

            $classes = $user->ClassOfPupil;
                            
            $pupil_history = new PupilHistory();
            $pupil_history->pupil_id = $user->id;
            $pupil_history->group_name = '卒業';
            
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

            if(Auth::user()->isGroup() || Auth::user()->isSchoolMember()){
                        
                $orgworkHistory = new OrgworkHistory();
                if(Auth::user()->isSchoolMember()){
                    $orgworkHistory->user_id = Auth::user()->id;
                    $orgworkHistory->username = Auth::user()->username;
                    $orgworkHistory->group_id = Auth::user()->org_id;
                    if(!Auth::user()->isLibrarian())
                        $orgworkHistory->group_name = User::find(Auth::user()->org_id)->username; 
                }
                if(Auth::user()->isGroup()){
                    $orgworkHistory->user_id = Auth::user()->id;
                    $orgworkHistory->username = Auth::user()->id;
                    $orgworkHistory->group_id = Auth::user()->id;
                    $orgworkHistory->group_name = Auth::user()->username;
                }
                                                           
                $orgworkHistory->item = 2;
                $orgworkHistory->work_test = 7;
                $orgworkHistory->objuser_name = User::find($user->id)->username;
                $classname = "";
                $classes = User::find($user->id)->PupilsClass;
                if($classes->grade != 0)
                   $classname .= $classes->grade."年"; 
                $classname .= $classes->class_number.""; 
                $classname .= "組";
                $orgworkHistory->class = $classname;
                $orgworkHistory->content = $user->fullname();
                $orgworkHistory->newyear = '所属解除（準会員へ）';
                $pupil_numbers = 0;

                $classes = DB::table('classes')
                    ->select("classes.id", "classes.type","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                    ->leftJoin('users as a','classes.teacher_id','=','a.id')
                    ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                    ->where('classes.member_counts','>', 0)
                    ->where('classes.active','=', 1)
                    ->where('classes.year', $current_season['year'])
                    ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                    ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
                if(Auth::user()->isSchoolMember()){
                    $classes = $classes->where('classes.group_id', Auth::user()->org_id);
                }else if(Auth::user()->isGroup()){
                    $classes = $classes->where('classes.group_id', Auth::id());
                }
                $classes = $classes->get();
                foreach ($classes as $key => $class) {
                    if($class->member_counts > 0)
                        $pupil_numbers += $class->member_counts;
                }
                if($pupil_numbers > 0) //because after $user->save(), $pupil_numbers -= 1;
                    $pupil_numbers -= 1;
                $orgworkHistory->pupil_numbers = $pupil_numbers;
                $orgworkHistory->save();
            }

            if($user->properties == 0){
                $user->active = 2;
                $user->role = 1;
                $user->org_id = 0;
                $user->group_name = '';
                $user->group_yomi = '';
            }
            elseif($user->properties == 1){
                $user->role = 1;
                $user->org_id = 0;
                $user->group_name = '';
                $user->group_yomi = '';
            }
            //$user->role = 1;
            $user->save();
        }
        
        return Redirect::to('/top');
    }

    public function  deleteRecord(Request $request){
        $ids = preg_split('/,/', $request->input('selected'));
        $student_ids = $request->input('user_id');
        $user = Auth::user();
        for ($i = 0; $i < count($ids); $i++) {
            $user_quiz = UserQuiz::find($ids[$i]);
            // $index = array_search($user_quiz->user_id, $student_ids);
            // if($index !== false){
            //     unset($student_ids[$index]);
            //     $student_ids = array_values($student_ids);
            // }
            //$user->active = 0;
            $user_quiz->status = 4;
            $point = floor($user_quiz->point*100)/100;
            $user_quiz->point = 0;
            $user_quiz->save();
            $record_history = new UserQuizesHistory();
            $record_history->user_id = $user_quiz->user_id;
            $record_history->book_id = $user_quiz->book_id;
            $record_history->type = 2;
            $record_history->status = 4;
            $record_history->finished_date = now();
            $record_history->published_date = now();
            $record_history->created_date = now();
            $record_history->point =  0 - $point;
            $record_history->save();

            if($user->isGroup() || $user->isSchoolMember()){
                        
                $orgworkHistory = new OrgworkHistory();
                if($user->isSchoolMember()){
                    $orgworkHistory->user_id = $user->id;
                    $orgworkHistory->username = $user->username;
                    $orgworkHistory->group_id = $user->org_id;
                    if(!$user->isLibrarian())
                        $orgworkHistory->group_name = User::find($user->org_id)->username; 
                }
                if($user->isGroup()){
                    $orgworkHistory->user_id = $user->id;
                    $orgworkHistory->username = $user->id;
                    $orgworkHistory->group_id = $user->id;
                    $orgworkHistory->group_name = $user->username;
                }
                                                           
                $orgworkHistory->item = 2;
                $orgworkHistory->work_test = 3;
                $orgworkHistory->objuser_name = User::find($user_quiz->user_id)->username;
                $classname = "";
                $classes = User::find($user_quiz->user_id)->PupilsClass;
                if($classes->grade != 0)
                   $classname .= $classes->grade."年"; 
                $classname .= $classes->class_number.""; 
                $classname .= "組";
                $orgworkHistory->class = $classname;
                $orgworkHistory->content = $user_quiz->Book->title;
                $orgworkHistory->point = 0 - $point;
                $orgworkHistory->save();
            }
        }        
        return redirect('/teacher/cancel_pass?pupil=' . $student_ids);        
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
