<?php

namespace App\Http\Controllers\Auth;

use App\Model\WishLists;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Auth;
use App\User;
use App\Model\Books;
use App\Model\Classes;
use App\Model\UserQuiz;
use App\Model\UserQuizesHistory;
use App\Model\PersonadminHistory;
use App\Model\PersoncontributionHistory;
use App\Model\PersontestoverseeHistory;
use App\Model\PersonbooksearchHistory;
use App\Model\PersonoverseerHistory;
use App\Model\PersonquizHistory;
use App\Model\PersontestHistory;
use App\Model\PersonworkHistory;
use App\Model\OrgworkHistory;
use App\Model\LoginHistory;
use App\Model\PupilHistory;
use App\Mail\Escape;
use App\Mail\Mailescape;
use App\Mail\ForgotFace;
use DB;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class UserController extends Controller
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
        'side' =>'basic_info',
        'subside' =>'basic_info',
        'top' =>'home',
        'subtop' =>'home',
    ];

    public function file_upload($file, $type){
        $ext = $file->getClientOriginalExtension();
        $now = date('YmdHis');
        $filename = md5($now.$file->getClientOriginalName()) . '.' . $ext;
        $url = 'uploads/users/'.Auth::id();
        $file->move($url , $filename);
        $user = User::find(Auth::id());
        $user->$type = $url .'/'. $filename ;
    }

    public function getStep2(){
        $title = '新規会員登録';
        if(Auth::user()->isGroup()){
            return view('auth.register.groupstep2')
                ->withTitle($title);
        } else{
            return view('auth.register.indivstep2')
                ->withTitle($title);
        }
    }

    /*  public function postStep2(Request $request){
        $rule = array(
            'password' => 'string|required|max:255|min:8'
        );

        $message = array(
            'required' => config('consts')['MESSAGES']['REQUIRED']
        );
        $validator = Validator::make($request->all(), $rule, $message);

        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        // if ($request->input('password') != $request->input('confirm_pwd')) {
        //     return Redirect::back()->withErrors(array('pwd_confirm' => 'Password confirm error.'))->withInput();
        // }

        $user = User::find(Auth::id());
        $authfile = $request->file('authfile');
        if($authfile){
            $ext = $authfile->getClientOriginalExtension();
            $now = date('YmdHis');
            $filename = md5($now.$authfile->getClientOriginalName()) . '.' . $ext;
            $url = 'uploads/users/'.Auth::id();
            $authfile->move($url , $filename);
            $user->authfile = $url .'/'. $filename ;
            $user->save();

           
        }
        $file = $request->file('file');
        if($file){
            $ext = $file->getClientOriginalExtension();
            $now = date('YmdHis');
            $filename = md5($now.$file->getClientOriginalName()) . '.' . $ext;
            $url = 'uploads/users/'.Auth::id();
            $file->move($url , $filename);
            $user->file = $url .'/'. $filename ;
            $user->save();
        }
        $password = $request->input('password');
        $password_others = User::where('r_password', '=', $password)->where('id', '<>', Auth::id())->count();
        if($password_others != 0){
            $error = config('consts')['MESSAGES']['PASSWORD_EXIST'];
            return Redirect::back()->withErrors($error)->withInput();
        }
        return Redirect::to('/auth/reg/step3');
    }*/

    public function getStep3(){
        $title = '新規会員登録';
        if(Auth::user()->isGroup()){
            return view('auth.register.groupstep3')->withTitle($title);
        }
        return view('auth.register.indivstep3')->withTitle($title);
    }

    public function regClass(Request $request){

        if (!Auth::user()->isGroup()){
            return Redirect::to('/');
        }
        $rule = array(
            'auth_type'=>'required',
        );
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::id());
        $user->active = '1';
        $user->auth_type = $request->input('auth_type');

        $user->lastname_roma = $request->input('wifi');

        $authfile = $request->file('authfile');

        if ($authfile){
            $ext = $authfile->getClientOriginalExtension();
            $now = date('YmdHis');
            $filename = md5($now.$authfile->getClientOriginalName()) . '.' . $ext;
            $url = 'uploads/files/'.Auth::id();
            $authfile->move($url , $authfile->getClientOriginalName());

            $user = User::find(Auth::id());
            $user->authfile = $url .'/'. $filename ;

            $user->save();
        }
        $user->save();

        $classes = json_decode($request->input('inform'));
        if (count($classes)>0){
            foreach ($classes as $key => $class) {
                $saved_class =new Classes;
                $saved_class->classname = $class->classname;
                $saved_class->type = $class->type;
                $saved_class->member_counts = $class->member_counts;
                $saved_class->group_id = Auth::id();
                $saved_class->save();
            }
        }

        return Redirect::to('/group/reg/step2');
    }

    public function step2_confirm(){
        $title = '新規会員登録';
        return view('auth.register.step2_suc')
            ->withTitle($title);
    }

    public function groupStep3(){
        $title = '新規会員登録';
        return view('auth.register.groupStep3')
            ->withTitle($title);
    }

    public function passwordCheck(Request $request){
        $id = $request->input("id");
        $password = $request->input("password");

        $user = User::find($id);
        if(!$user){
            return response(["status" => "error"]);
        }else{
            if($user->password == md5($password)){
                $user->reload_flag = 2;
                $user->save();
                return response(["status" => "success"]);
            }else{
                return response(["status" => "error"]);
            }
        }
    }

    public function changepassword(Request $request){
        $refresh_token = $request->input("refresh_token");

        $user = User::where("refresh_token", $refresh_token)->first();
        if(!$user){
            return response('Unauthorized.', 401);
        }

        $rule = array(
            'password' => 'required|max:15|min:8|unique:users'
        );
        
        $requestall = $request->all();
        $requestall['username'] = $request->input('romaname').$request->input('numbername');

        if($requestall['username'] != $user->username){
            $rule['username'] = 'string|required|max:30|unique:users';
        }

        $message = array(
            'password.min' => config('consts')['MESSAGES']['PASSWORD_LENGTH'],
            'password.max' => config('consts')['MESSAGES']['PASSWORD_MAXLENGTH'],
            'password.unique' => config('consts')['MESSAGES']['PASSWORD_EXIST'],
        //          'username.unique' => config('consts')['MESSAGES']['PASSWORD_EXIST'],
            'username.max' => config('consts')['MESSAGES']['USERNAME_MAXERROR'],
            'required' => config('consts')['MESSAGES']['REQUIRED']
        );
        //$validator = Validator::make($request->all(), $rule, $message);
        $validator = Validator::make( $requestall, $rule, $message);

        if ($validator->fails()){
           return Redirect::back()->withErrors($validator)->withInput();
        }
        // if ($request->input('password') != $request->input('confirm_pwd')) {
        //   return Redirect::back()->withErrors(array('pwd_confirm' => 'Password confirm error.'))->withInput();
        // }

        //$user->username = $request->input('username');
        $user->username = $requestall['username'];
        $user->r_password = $request->input('password');
        $user->password =md5($request->input('password'));
        $user->replied_date2 = now();
        $user->save();
        return Redirect::to('auth/reg_step3/'.$user->role.'/suc?refresh_token='.$user->refresh_token);
    }

    public function getStep3_suc(){
        $title = '新規会員登録';
        return view('auth.register.step3_suc')
            ->withTitle($title);
    }
    public function getStep4(){
        $title = '新規会員登録';
        return view('auth.register.step4')
            ->withTitle($title);
    }

    public function dupPasswordCheck(Request $request) {
        $username = $request->input("username");
        $password = $request->input("password");
        if(strlen($password) < 8) return response()->json(array('result'=>'len'), 200);
        $user = User::Where('username','!=', $username)->where('r_password','=',$password)->first();
        if ($user && $password != 'dd99dd99') {
            $result = "dup";
        } else {
            $result = "ok";
        }
        return response()->json(array('result'=>$result), 200);
    }

    public function dupDoqUserCheck(Request $request) {
        $firstname = $request->input("firstname");
        $lastname = $request->input("lastname");
        $birthday = $request->input("birthday");
        if ($birthday == "") {
            $result = "ok";
        } else {
            $user = User::where('firstname','=', $firstname)->where('lastname','=', $lastname)->where('birthday','=',$birthday)->first();
            if ($user) {
                $result = "dup";
            } else {
                $result = "ok";
            }
        }
        return response()->json(array('result'=>$result), 200);
    }

    public function changeDisplayName(Request $request) {
        $id = $request->input("user_id");
        $isPublic = $request->input("fullname_is_public");
        $user = User::find($id);
        $user->fullname_is_public = $isPublic;
        $user->save();
        if($user->role != config('consts')['USER']['ROLE']['AUTHOR']){
            if ($isPublic == 0) {
                $result = $user->username;
            } else {
                $result = $user->firstname . ' ' . $user->lastname;
            }
        }else{
            if ($isPublic == 0) {
                $result = $user->username;
            } else {
                $result = $user->firstname_nick . ' ' . $user->lastname_nick;
            }
        }
        return response()->json(array('result'=>$result), 200);
    }

    public function aptitude(Request $request){
        $id = $request->input("user_id");
        $user = User::find($id);
        $value = $request->input("value");
        if ($value == "1,4,5,8,10,12,13,16") {
            $user->aptitude = 1;
            $user->save();
        }
        else{
            $user->aptitude = 0;
            $user->save();
        }
        return response()->json(array('result' => $user->aptitude), 200);
    }

    public function updateWishDate(Request $request){
        $wishId = $request->input("wish_id");
        $finishedDate = $request->input("finished_date");
        $wishList = WishLists::find($wishId);
        $wishList->finished_date = $finishedDate;
        $wishList->save();
        $book = Books::find($wishList->book_id);
        $user = User::find($wishList->user_id);
        $isTestPassed = false;
        $userquiz = UserQuiz::where("type", 2)->where("status", 3)->where("user_id", Auth::id())->where("book_id", $wishList->book_id)->count();
        if($userquiz > 0)  $isTestPassed = true;

        if((!$user->isGroup()) && ($book->isAdult())  && $user->getDateTestPassedOfBook($book->id) === null && $user->getBookyear($book->id) === null && $user->getEqualBooks($book->id) === null && !$user->isGroupSchoolMember() && ($user->active==1 or $user->active==2)){
            if($book->active == 6 && !$isTestPassed)
                return response()->json(array('quizable' => 'success'));
        }
        return response()->json(array('result' => 1), 200);
    }

    public function csrftokenAPI() {
        return response()->json(array('token'=>csrf_token()), 200);
    }

    public function loginAPI(Request $request){
        $username=$request->input('username');
        $password=$request->input("password");
        $user = User::where('r_password', '=', $password);
        $user = $user->where('username', '=', $username);
        $user = $user->first();
        return $user;
    }
    //escape by mail
    public function userEscape(Request $request){
        // $active_update = DB::table('users')
        //                  ->where('users.id','=',Auth::id())
        //                  ->update(['active' => 2]);
        $token = $request->input("refresh_token");
        $user = User::where('refresh_token', $token)->first();

        if(!isset($user)){
            return response('Unauthorized.', 401);
        }else{
            $user->active = 3;
            $user->r_password = 'sayonaradq';
            $user->password = md5('sayonaradq');
            $user->escape_date = now();
            $user->save();

            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 3;
            if($user->isSchoolMember()){
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personworkHistory->org_username = $user->School->username;
            }
            else if($user->isAuthor())
                $personworkHistory->user_type = '著者';
            else if($user->isOverseer())
                $personworkHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personworkHistory->user_type = '生徒';
                $personworkHistory->org_username = $user->ClassOfPupil->school->username;

                $classes = $user->ClassOfPupil;
                            
                $pupil_history = new PupilHistory();
                $pupil_history->pupil_id = $user->id;
                $pupil_history->group_name = '退会';
                
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
            }else
                $personworkHistory->user_type = '一般';
            $personworkHistory->age = $user->age();
            $personworkHistory->address1 = $user->address1;
            $personworkHistory->address2 = $user->address2;
            $users = User::whereIn('active', [1,2])->get();
            $personworkHistory->content = count($users).'人';
            $personworkHistory->save(); 

            //admin
            $personadminHistory = new PersonadminHistory();
            //$personadminHistory->user_id = $admin->id;
            $personadminHistory->username = '協会';
            $personadminHistory->item = 0;
            $personadminHistory->work_test = 8;
            $personadminHistory->bookregister_name = $user->username;
            $users = User::whereIn('active', [1,2])->get();
            $personadminHistory->content = count($users).'人';
            $personadminHistory->save();

            $this->page_info['side'] = 'main_info';
            $this->page_info['subside'] = 'userescape';
            return view('auth.register.userEscape')
                ->with('page_info', $this->page_info)
                ->withNosidebar(true);
        }
        //return Redirect::to('/auth/login');
    }
    //escape if Eメールで本人確認して退会
    public function escape_mail(Request $request){
        
        $user = Auth::user();
        if(isset($user)){
            
            try{
                Mail::to($user)->send(new Mailescape($user));
                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = $admin->id;
                $personadminHistory->username = $admin->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '退会';
                $personadminHistory->save();
            }catch(Swift_TransportException $e){

                return Redirect::back()
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                    ->withInput();
            }
        }

        if($user->isAdmin()){
            $PersonadminHistory = new PersonadminHistory();
            $PersonadminHistory->user_id = $user->id;
            $PersonadminHistory->username = $user->username;
            $PersonadminHistory->item = 0;
            $PersonadminHistory->work_test = 1;
            $PersonadminHistory->save();
        }else if($user->isGroup() || $user->isSchoolMember()){
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
                                                       
            $orgworkHistory->item = 0;
            $orgworkHistory->work_test = 1;
            $orgworkHistory->save();

            if($user->isSchoolMember()){
                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 1;
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personworkHistory->org_username = $user->School->username;
                $personworkHistory->age = $user->age();
                $personworkHistory->address1 = $user->address1;
                $personworkHistory->address2 = $user->address2;
                $personworkHistory->save();
            }
        }else{
            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 1;
            if($user->isAuthor())
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

        Auth::logout();
        return Redirect::to('/');
    }
    //escape by face verify
     public function escape_group(Request $request){
        
        $user = Auth::user();
        if(!isset($user)){
            return response('Unauthorized.', 401);
        }
        if($user->verifyface_flag == 0){
            return Redirect::to('/');
        }
        $user->verifyface_flag = 0;
        $user->save();

        if(isset($user)){
            
            try{
                Mail::to($user)->send(new Escape($user));
                $user->active = 3;
                $user->r_password = 'sayonaradq';
                $user->password = md5('sayonaradq');
                $user->escape_date = now();
                $user->save();

                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 3;
                if($user->isSchoolMember()){
                    $personworkHistory->user_type = '教職員';
                    if(!$user->isLibrarian())
                        $personworkHistory->org_username = $user->School->username;
                }
                else if($user->isAuthor())
                    $personworkHistory->user_type = '著者';
                else if($user->isOverseer())
                    $personworkHistory->user_type = '監修者';
                else if($user->isPupil()){
                    $personworkHistory->user_type = '生徒';
                    $personworkHistory->org_username = $user->ClassOfPupil->school->username;

                    $classes = $user->ClassOfPupil;
                            
                    $pupil_history = new PupilHistory();
                    $pupil_history->pupil_id = $user->id;
                    $pupil_history->group_name = '退会';
                    
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
                }else
                    $personworkHistory->user_type = '一般';
                $personworkHistory->age = $user->age();
                $personworkHistory->address1 = $user->address1;
                $personworkHistory->address2 = $user->address2;
                $users = User::whereIn('active', [1,2])->get();
                $personworkHistory->content = count($users).'人';
                $personworkHistory->save(); 

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
                                                               
                    $orgworkHistory->item = 0;
                    $orgworkHistory->work_test = 1;
                    $orgworkHistory->save();
                }
                //admin
                //$admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                //$personadminHistory->user_id = $admin->id;
                $personadminHistory->username = '協会';
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '退会';
                $personadminHistory->save();

                $personadminHistory = new PersonadminHistory();
                //$personadminHistory->user_id = $admin->id;
                $personadminHistory->username = '協会';
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 8;
                $personadminHistory->bookregister_name = $user->username;
                $users = User::whereIn('active', [1,2])->get();
                $personadminHistory->content = count($users).'人';
                $personadminHistory->save();
            }catch(Swift_TransportException $e){
                return Redirect::back()
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                    ->withInput();
            }
        }
        
        Auth::logout();
        return Redirect::to('/');
    }

    
    public function viewFaceRegister(Request $request, $type){
        //$user = User::find($id);
        $refresh_token = $request->input("refresh_token");

        $user = User::where("refresh_token", $refresh_token)->first();
        if(!$user){
            return response('Unauthorized.', 401);
        }

        $this->page_info['side'] = 'main_info';
        $this->page_info['subside'] = 'faceregister';
        //return view('auth.register.register_face')
        return view('auth.register.signin')
            ->with('page_info', $this->page_info)
            ->with('user', $user)
            ->with('type', $type)
            ->withNosidebar(true);
    }

    public function signin(Request $request){
        $refresh_token = $request->input("refresh_token");
        $type = $request->input("type");
        $password = $request->input('password');
        if ($request->session()->has("errors")){
            $refresh_token = $request->session()->get("refresh_token");
            $type = $request->session()->get("type");
            $password = $request->session()->get('password');
        }

        $rule = array(
            'password' => 'required'
        );
        $message = array(
            'password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED']
        );

       
        //if (!$request->session()->has("errors")){
            $validator = Validator::make($request->all(), $rule, $message);
            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
        //}
           
        $user = User::where('refresh_token',$refresh_token)->first();
        if ($user->r_password != $password) {                
            return Redirect::back()->withErrors(array('invalid_pwd' => 'true'))->withInput();
        }            
        return view('auth.register.register_face')
            ->with('page_info', $this->page_info)
            ->with('user', $user)
            ->with('type', $type)
            ->withNosidebar(true);
        
    }

    public function faceSuccessAjax(Request $request) {
        
        $cameraImage = $request->input("cameraImg");
        $cameraImage = str_replace('data:image/jpeg;base64,', '', $cameraImage);
        $imageBinaryData = base64_decode($cameraImage);
        $image_path = "/uploads/users/".time().".jpg";
        $filename = public_path().$image_path;
        $ret = file_put_contents($filename, $imageBinaryData);

        $message = "upload success";

        if($ret === FALSE){
            unlink($filename);
            $message = 'Failed to register!';
            $ret = FALSE;
        }

        $fp = stream_socket_client("tcp://".config('socket')['FACE_SERVER'], $errno, $errstr, 30);
        if (!$fp) {
            unlink($filename);
            $message = 'Server is not running!';
            $ret = FALSE;
        }
        $action = 'register';
        //        $filename = str_replace('/', '\\', $filename);
        //        $request = $action . '*' . str_replace('/', '\\', $filename);
        $request = $action . '*' . $filename;
        fwrite($fp, $request);
        $contents = '';
        $line     = '';
        while (!feof($fp)) {
            $line = fread($fp, 4096);
            $contents = $contents . $line;
        }
        fclose($fp);
        $result = json_decode($contents, true);
        if ($result['result'] == 'ok') {
            $message = "Register - OK!";
            $ret = TRUE;
        } else {
            unlink($filename);
            $message = "Failed to register! " . $result['message'] . $cameraImage;
            $ret = FALSE;
        }

       return $response = array( 'message' => $message, 'success' => ($ret!==FALSE), 'image_path' => $image_path );

    }


    public function faceRegister(Request $request) {

        $userId = $request->input("user_id");
        $type = $request->input("type");
        $bookId = $request->input("book_id");
        $password = $request->input("password");
        $mode = $request->input("mode");
        $image_path = $request->input("image_path");
        /*$cameraImage = $request->input("cameraImg");
        $cameraImage = str_replace('data:image/jpeg;base64,', '', $cameraImage);
        $imageBinaryData = base64_decode($cameraImage);
        $image_path = "/uploads/users/".time().".jpg";
        $filename = public_path().$image_path;
        $ret = file_put_contents($filename, $imageBinaryData);

        if($ret === FALSE){
            unlink($filename);
            return Redirect::back()->withErrors(array('Failed to register!' => 'true'))->with('book_id',$bookId)
                                    ->with('mode',$mode)
                                    ->with('password',$password)
                                    ->with('user_id',$userId)
                                    ->with('type',$type)->withInput();
        }

        $fp = stream_socket_client("tcp://".config('socket')['FACE_SERVER'], $errno, $errstr, 30);
        if (!$fp) {
            unlink($filename);
            return Redirect::back()->withErrors(array('Server is not running!' => 'true'))->with('book_id',$bookId)
                                    ->with('mode',$mode)
                                    ->with('password',$password)
                                    ->with('user_id',$userId)
                                    ->with('type',$type)->withInput();
        }
        $action = 'register';
        //        $filename = str_replace('/', '\\', $filename);
        //        $request = $action . '*' . str_replace('/', '\\', $filename);
        $request = $action . '*' . $filename;
        fwrite($fp, $request);
        $contents = '';
        $line     = '';
        while (!feof($fp)) {
            $line = fread($fp, 4096);
            $contents = $contents . $line;
        }
        fclose($fp);
        $result = json_decode($contents, true);
        if ($result['result'] != 'ok') {
            unlink($filename);
            return Redirect::back()->withErrors(array('Failed to register! No face' => 'true'))
                                    ->with('book_id',$bookId)
                                    ->with('mode',$mode)
                                    ->with('password',$password)
                                    ->with('user_id',$userId)
                                    ->with('type',$type)
                                    ->withInput();
        }
        */
        $user = User::find($userId);
        if(file_exists(public_path().$user->image_path) && $user->image_path !== null && $user->image_path != ''){
            
            if(file_exists(public_path().$user->beforeimage_path) && $user->beforeimage_path !== null && $user->beforeimage_path != ''){
                unlink(public_path().$user->beforeimage_path);
            } 
            $user->beforeimage_path = $user->image_path;
            $user->beforeimagepath_date = $user->imagepath_date;
        }

        $user->image_path = $image_path;
        $user->imagepath_date = date_format(now(), "Y-m-d");
        $user->testable = 0;
        $user->islogged = 1;
        $user->namepwd_check = 0;
        $user->verifyface_flag = 1;
        $user->save();
        
        if($user->isAdmin()){
            $PersonadminHistory = new PersonadminHistory();
            $PersonadminHistory->user_id = $user->id;
            $PersonadminHistory->username = $user->username;
            $PersonadminHistory->item = 0;
            $PersonadminHistory->work_test = 0;
            $PersonadminHistory->save();
        }else if($user->isGroup() || $user->isSchoolMember()){
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
                                                       
            $orgworkHistory->item = 0;
            $orgworkHistory->work_test = 0;
            $orgworkHistory->save();

            if($user->isSchoolMember()){
                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 7;
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personworkHistory->org_username = $user->School->username;
                $personworkHistory->age = $user->age();
                $personworkHistory->address1 = $user->address1;
                $personworkHistory->address2 = $user->address2;
                $personworkHistory->save();

                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 0;
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personworkHistory->org_username = $user->School->username;
                $personworkHistory->age = $user->age();
                $personworkHistory->address1 = $user->address1;
                $personworkHistory->address2 = $user->address2;
                $personworkHistory->save();
            }
        }else{
            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 7;
            if($user->isAuthor())
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

            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 0;
            if($user->isAuthor())
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

        Auth::login($user);

        $accessHistory = new LoginHistory;
        $accessHistory->user_id = Auth::user()->id;
        $accessHistory->save();

        if ($type == 0) { // forgot password
            return Redirect::to("/mypage/top");
        } else if ($type == 1) { // mypage
            return Redirect::to("/mypage/edit_info");
        } else if ($type == 2) { // test
            return Redirect::to("/book/test/mode_recog?book_id=".$bookId);
        }else if ($type == 3) { // pay
            return Redirect::to("/mypage/payment");
        } 
        return Redirect::to("/mypage/top");
    }

    public function faceVerifyResult(Request $request) {

        $userId = $request->input("user_id");
        $user = User::find($userId);
        $cameraImage = $request->input("cameraImg");
        $cameraImage = str_replace('data:image/jpeg;base64,', '', $cameraImage);
        $imageBinaryData = base64_decode($cameraImage);


        // $image_path = "/uploads/users/".time().".jpg";
        $filename = public_path()."/uploads/users/".time().".jpg";
        $ret = file_put_contents($filename, $imageBinaryData);

        if ($ret === FALSE || !file_exists($filename) || !file_exists(public_path().$user->image_path)) {
            //unlink($filename);
            if($user->isAdmin()){
                
            }else if($user->isGroup() || $user->isSchoolMember()){
                
                if($user->isSchoolMember()){
                    $personworkHistory = new PersonworkHistory();
                    $personworkHistory->user_id = $user->id;
                    $personworkHistory->username = $user->username;
                    $personworkHistory->item = 0;
                    $personworkHistory->work_test = 9;
                    $personworkHistory->user_type = '教職員';
                    if(!$user->isLibrarian())
                        $personworkHistory->org_username = $user->School->username;
                    $personworkHistory->age = $user->age();
                    $personworkHistory->address1 = $user->address1;
                    $personworkHistory->address2 = $user->address2;
                    $personworkHistory->save();
                }
            }else{
                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 9;
                if($user->isAuthor())
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
            return response()->json(array('status' => 'failed'));
        }
        $fp = stream_socket_client("tcp://".config('socket')['FACE_SERVER'], $errno, $errStr, 30);

        if ($fp) {
            $action = "verify";
            //  $filename = str_replace('/', '\\', $filename);
            //  $req = $action."*".str_replace('/', '\\', $filename)."*".public_path().$user->image_path;
            $req = $action."*".$filename."*".public_path().$user->image_path;
            // $req = $action."*".$filename."*".public_path()."/uploads/users/".time().".jpg";
            fwrite($fp, $req);
            $contents = '';
            $line = '';
            while(!feof($fp)) {
                $line = fread($fp, 4096);
                $contents = $contents.$line;
            }
            fclose($fp);

            $result = json_decode($contents, true);
            // return $result;
            if( $result['score'] >= 0.6 ) {
                $user->testable = 0;
                if(!Auth::check()) {
                    $user->testable = 0;
                    $user->islogged = 1;
                    $user->namepwd_check = 0;
                    $user->save();

                    if($user->isAdmin()){
                        $PersonadminHistory = new PersonadminHistory();
                        $PersonadminHistory->user_id = $user->id;
                        $PersonadminHistory->username = $user->username;
                        $PersonadminHistory->item = 0;
                        $PersonadminHistory->work_test = 0;
                        $PersonadminHistory->save();
                    }else if($user->isGroup() || $user->isSchoolMember()){
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
                                                                
                        $orgworkHistory->item = 0;
                        $orgworkHistory->work_test = 0;
                        $orgworkHistory->save();

                        if($user->isSchoolMember()){
                            $personworkHistory = new PersonworkHistory();
                            $personworkHistory->user_id = $user->id;
                            $personworkHistory->username = $user->username;
                            $personworkHistory->item = 0;
                            $personworkHistory->work_test = 8;
                            $personworkHistory->user_type = '教職員';
                            if(!$user->isLibrarian())
                                $personworkHistory->org_username = $user->School->username;
                            $personworkHistory->age = $user->age();
                            $personworkHistory->address1 = $user->address1;
                            $personworkHistory->address2 = $user->address2;
                            $personworkHistory->save();

                            $personworkHistory = new PersonworkHistory();
                            $personworkHistory->user_id = $user->id;
                            $personworkHistory->username = $user->username;
                            $personworkHistory->item = 0;
                            $personworkHistory->work_test = 0;
                            $personworkHistory->user_type = '教職員';
                            if(!$user->isLibrarian())
                                $personworkHistory->org_username = $user->School->username;
                            $personworkHistory->age = $user->age();
                            $personworkHistory->address1 = $user->address1;
                            $personworkHistory->address2 = $user->address2;
                            $personworkHistory->save();
                        }
                    }else{
                        $personworkHistory = new PersonworkHistory();
                        $personworkHistory->user_id = $user->id;
                        $personworkHistory->username = $user->username;
                        $personworkHistory->item = 0;
                        $personworkHistory->work_test = 8;
                        if($user->isAuthor())
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

                        $personworkHistory = new PersonworkHistory();
                        $personworkHistory->user_id = $user->id;
                        $personworkHistory->username = $user->username;
                        $personworkHistory->item = 0;
                        $personworkHistory->work_test = 0;
                        if($user->isAuthor())
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

                    Auth::login($user);

                    $accessHistory = new LoginHistory;
                    $accessHistory->user_id = Auth::user()->id;
                    $accessHistory->save();
                }
                $user->verifyface_flag = 1;
                $user->save();

                unlink($filename);

                return response()->json(array('status' => 'success'));
            }
        }

        unlink($filename);

        if($user->isAdmin()){
            
        }else if($user->isGroup() || $user->isSchoolMember()){
            
            if($user->isSchoolMember()){
                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 9;
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personworkHistory->org_username = $user->School->username;
                $personworkHistory->age = $user->age();
                $personworkHistory->address1 = $user->address1;
                $personworkHistory->address2 = $user->address2;
                $personworkHistory->save();
            }
        }else{
            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 9;
            if($user->isAuthor())
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
        return response()->json(array('status' => 'failed'));
    }

    public function overseerfaceVerifyResult(Request $request) {
        $userId = $request->input("user_id");
        $book_id = $request->input("book_id");
        $book = Books::find($book_id);
        $user = User::find($userId);
        $mode = $request->input("mode");
        $cameraImage = $request->input("cameraImg");
        $cameraImage = str_replace('data:image/jpeg;base64,', '', $cameraImage);
        $imageBinaryData = base64_decode($cameraImage);


        //  $image_path = "/uploads/users/".time().".jpg";
        $filename = public_path()."/uploads/users/".time().".jpg";
        $ret = file_put_contents($filename, $imageBinaryData);

        if ($ret === FALSE || !file_exists($filename) || !file_exists(public_path().$user->image_path)) {
            //unlink($filename);
            $personworkHistory = new PersonworkHistory();
            $personworkHistory->user_id = $user->id;
            $personworkHistory->username = $user->username;
            $personworkHistory->item = 0;
            $personworkHistory->work_test = 9;
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

            return response()->json(array('status' => 'failed'));
        }
        $fp = stream_socket_client("tcp://".config('socket')['FACE_SERVER'], $errno, $errStr, 30);
        if ($fp) {
            $action = "verify";
            // $filename = str_replace('/', '\\', $filename);
            // $req = $action."*".str_replace('/', '\\', $filename)."*".public_path().$user->image_path;
            $req = $action."*".$filename."*".public_path().$user->image_path;

            // $req = $action."*".$filename."*".public_path()."/uploads/users/".time().".jpg";
            fwrite($fp, $req);
            $contents = '';
            $line = '';
            while(!feof($fp)) {
                $line = fread($fp, 4096);
                $contents = $contents.$line;
            }
            fclose($fp);

            $result = json_decode($contents, true);
            if( $result['score'] >= 0.6 ) {
                $user->testable = 0;
                if(!Auth::check()) {
                    //$user->islogged = 1;
                    $user->save();
                   // Auth::login($user);
                }
                unlink($filename);

                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 8;
                if($user->isSchoolMember()){
                    $personworkHistory->user_type = '教職員';
                    if(!$user->isLibrarian())
                        $personworkHistory->org_username = $user->School->username;
                }
                else if($user->isAuthor())
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

                //overseer
                if($user->isOverseerAll()){
                    $PersontestoverseeHistory = new PersontestoverseeHistory();
                    $PersontestoverseeHistory->user_id = $user->id;
                    $PersontestoverseeHistory->username = $user->username;
                    $PersontestoverseeHistory->item = 0;
                    $PersontestoverseeHistory->age = $user->age();
                    $PersontestoverseeHistory->address1 = $user->address1;
                    $PersontestoverseeHistory->address2 = $user->address2;
                    $PersontestoverseeHistory->book_id = $book_id;
                    $PersontestoverseeHistory->test_username = Auth::user()->username;
                    $PersontestoverseeHistory->title = $book->title;
                    $PersontestoverseeHistory->writer = $book->fullname_nick();
                    $PersontestoverseeHistory->overseer_num = UserQuizesHistory::testOverseer($user->id)->get()->count();
                    //$PersontestoverseeHistory->overseer_real = UserQuizesHistory::testOverseers($user->id)->get()->count();
                    if($mode == 3)                    
                        $PersontestoverseeHistory->work_test = 1; //合格顔認証
                    else
                        $PersontestoverseeHistory->work_test = 0; //開始顔認証
                    $PersontestoverseeHistory->device = Auth::user()->get_device();
                    $PersontestoverseeHistory->save();
                }

                return response()->json(array('status' => 'success'));
            }
        }

        unlink($filename);

        $personworkHistory = new PersonworkHistory();
        $personworkHistory->user_id = $user->id;
        $personworkHistory->username = $user->username;
        $personworkHistory->item = 0;
        $personworkHistory->work_test = 9;
        if($user->isSchoolMember()){
            $personworkHistory->user_type = '教職員';
            if(!$user->isLibrarian())
                $personworkHistory->org_username = $user->School->username;
        }
        else if($user->isAuthor())
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
        $personworkHistory->device = Auth::user()->get_device();
        $personworkHistory->save(); 

        return response()->json(array('status' => 'failed'));
    }


    public function faceVerifyEmail(Request $request) {
        $userId = $request->input("user_id");
        $user = User::find($userId);
       
        if(isset($user)){
            try{

               Mail::to($user)->send(new ForgotFace($user)); 

               //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = $admin->id;
                $personadminHistory->username = $admin->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '顔認証再登録';
                $personadminHistory->save();
            }catch(Swift_TransportException $e){
                return response()->json(array('status' => 'failed'));
            }
            return response()->json(array('status' => 'success'));
        }
        return response()->json(array('status' => 'failed'));
    }

}