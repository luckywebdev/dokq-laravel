<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Model\Classes;
use App\Model\ClassType;
use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Mail\Restore;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Model\Books;
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
use App\Model\Messages;

use Redirect;
use Auth;
use DB;
use Swift_TransportException;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        date_default_timezone_set('Asia/Tokyo');
    }

    public function get_next_pay_date($start_date, $pay_content){
        $real_pay_start_arr = explode("-", $start_date);
        $start_year = $real_pay_start_arr[0];
        $start_month = $real_pay_start_arr[1];
        $start_day = $real_pay_start_arr[2];
        if(strpos(strtolower($pay_content), "yearly") === false){
            if($start_month == 12){
                $period_month = 1;
                $period_year = $start_year + 1;
                $end_day_of_period_year_month = cal_days_in_month(CAL_GREGORIAN,$period_month,$period_year);
                if($start_day > $end_day_of_period_year_month){
                    $period_day = $end_day_of_period_year_month;
                }
                else{
                    $period_day = $start_day;
                }
            }
            else{
                $period_month = $start_month + 1;
                $period_year = $start_year;
                $end_day_of_period_year_month = cal_days_in_month(CAL_GREGORIAN,$period_month,$period_year);
                if($start_day > $end_day_of_period_year_month){
                    $period_day = $end_day_of_period_year_month;
                }
                else{
                    $period_day = $start_day;
                }
            }
        }
        else{
            
                $period_year = $start_year + 1;
                $period_month = $start_month;
                $end_day_of_period_year_month = cal_days_in_month(CAL_GREGORIAN,$period_month,$period_year);
                if($start_day > $end_day_of_period_year_month){
                    $period_day = $end_day_of_period_year_month;
                }
                else{
                    $period_day = $start_day;
                }
        }
        $period = $period_year."-".$period_month."-".$period_day;

        $period = date('Y-m-d', strtotime($period));
        return $period;
    }

    public function get_device(){
        $device_data = $_SERVER['HTTP_USER_AGENT'];
        $device = '';
        if(strpos($device_data, 'Android') > 0){
            $device = 'Android';
        }
        else if(strpos($device_data, 'iPhone') > 0){
            $device = 'iPhone';
        }
        else if(strpos($device_data, 'Windows') > 0){
            $device = 'Windows Desktop';
        }
        else if(strpos($device_data, 'iPhone') !== false && strpos($device_data, 'Mac OS') > 0){
            $device = 'Mac OS Desktop';
        }
        else{
            $device = "Tablet";
        }
        return $device;
    }

    /**
     * go to user type selection page.
     *
     * @return void
     */
    public function index(){
        $title = '新規会員登録';
        $page = 'register_index';

        $deleted=User::where(function($query){
            $query->where('active','=',0)
                ->where('created_at','<',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("7 days")))
                ->delete();
        });
        /*
        User::where(function($query){
            $query->where('active','=',2)
                ->where('updated_at','<',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("90 days")))
                ->delete();
        });*/

        $active_update = DB::table('users')
                          ->where('active','=',3)
                          ->where('escape_date','<',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")))
                          ->update(['active' => 4]);
        return view('auth.register.index')
            ->withNofooter(true)
            ->withTitle($title)
            ->withPage($page)
            ->withNosidebar(true);
    }

    public function prepay(Request $request){
        $refresh_token = $request->session()->get('refresh_token');
        $user = User::where('refresh_token', $refresh_token)->first();
        $pay_content = $request->input('pay_content');
        $user->pay_date = now();
        $user->pay_content = strtolower($pay_content);
        $user->pay_amount = config('consts')['PAY_AMOUNT'][strtolower($pay_content)];
        $current_day = date("Y-n-d");
        $real_pay_start = date_add(date_create($current_day), date_interval_create_from_date_string('14 days'));
        $real_pay_start = date_format($real_pay_start, 'Y-n-j');

        $next_pay_date = $this->get_next_pay_date($real_pay_start, $pay_content);

        // echo config('consts')['PAY_LIST'][strtolower($pay_content)];
        // echo $real_pay_start . "&&&" . $pay_content . "&&&" . $next_pay_date;
        // exit;

        $period = date_sub(date_create($next_pay_date), date_interval_create_from_date_string('1 days'));
        $user->period = date_format($period, 'Y-m-d');
        $user->properties = 1;

        $user->save();
        return Redirect::back();
    } 

    public function payment(Request $request){
        $title = '新規会員登録';
        $page = 'register_choose_payment';
        $request->session()->put('pay_path', 2);
        $refresh_token = $request->session()->get('refresh_token');
        $user = User::where('refresh_token', $refresh_token)->first();
        $current_date = date("Y-n-d");
        $current_date_time = date("Y-n-d H:i:s");
    
        $pay_state_row = PersonworkHistory::where('user_id', $user->id)
                                    ->where('pay_point', '!=', '0')
                                    ->where('pay_point', '!=', null)
                                    ->where('period', '>=', $current_date)
                                    ->where('created_at', '<=', $current_date_time)
                                    ->orderby('id', 'desc')
                                    ->first();
        $pay_period = '0000-00-00';
        $pay_amount = 0;
        if(!is_null($pay_state_row) && count($pay_state_row)){
            $pay_state = 1;

        }
        else{
            $pay_state = 0;
        }
        return view('auth.register.choose_payment')
            ->withNofooter(true)
            ->withTitle($title)
            ->with('pay_state', $pay_state)
            ->withPage($page)
            ->withNosidebar(true);
    }

    public function getPayment_result(Request $request){

        $type = $request->session()->get('type');
        $step = $request->session()->get('step');
        $refresh_token = $request->session()->get('refresh_token');

            $user = User::where('refresh_token', $refresh_token)->first();
            $pay_amount = $user->pay_amount;
            $pay_content = $user->pay_content;
            $period = $user->period;
            $pay_date = $user->pay_date;

            if($user->pay_amount !== 0 && $user->pay_amount !== null){
                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 10;
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
                $personworkHistory->pay_point = $pay_amount;
                $personworkHistory->period = $period;
                $personworkHistory->content = config('consts')['PAY_LIST'][$pay_content];        
                $personworkHistory->device = $this->get_device();
                $personworkHistory->save();
            }
            // echo $this->pay_state;
            return Redirect::to('/auth/register/'.$type.'/'.$step.'?refresh_token='.$refresh_token);        
    }

    public function getPayment_result_cancel(Request $request){

        $type = $request->session()->get('type');
        $step = $request->session()->get('step');
        $refresh_token = $request->session()->get('refresh_token');

        $user = User::where('refresh_token', $refresh_token)->first();
        $user->pay_amount = 0;
        $user->pay_content = "";
        $user->pay_date = "";
        $user->period = "";
        $user->save();

        // echo $this->pay_state;
        return Redirect::to('/auth/register/'.$type.'/'.$step.'?refresh_token='.$refresh_token);        
    }


    /**
     * go to user register page.
     *
     * @return void
     */
    public function viewregister(Request $request, $type, $step){
        $deleted=User::where(function($query){
            $query->where('active','=',0)
                ->where('created_at','<',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("7 days")))
                ->delete();
        });

        $user = config('consts')['USER']['TYPE'][$type];
        $title = '新規会員登録(' . config('consts')['USER']['TYPE'][$type] . ')';
        $isAuthor = 0;
        $request->session()->put('type', $type);
        $request->session()->put('step', $step);
        $request->session()->put('refresh_token', $request->input("refresh_token"));
        $data=($request->data != null)?json_decode($request->data):""; 
        //      $data=substr(strrchr($data, "{"),0);
        //      print_r(json_decode($data));

        if($step == 3 || $step == 4 || (($type == 1||$type == 2||$type == 3) && $step == 2)){

            $user = User::where('refresh_token', $request->input("refresh_token"))->first();
            // Auth::login($user);
            // return Redirect::to('/auth/register/'.$type.'/'.$step.'?refresh_token='.$user->refresh_token);
            if(!$user){
                return response('Unauthorized.', 401);
            }
        }

        if($type == 0){
            $ip_add = \Request::ip();
            $view = 'group';
            $retview =  view('auth.register.'.$view.'step'.$step)
                ->withTitle($title)
                ->withType($type)
                ->withData($data)
                ->with('local_ip', $ip_add);
            if($step == 3 || $step == 4 )
            {
                if($step == 3){
                    // echo "SSS";
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

                    if($classes){
                        return $retview->withClasses($classes)
                            ->withUser($user)
                            ->withClassTypes($class_types)
                            ->withTotalMembers($totalMembers)
                            ->with('nopupiltotalMembers', $nopupiltotalMembers);
                    }
                }else{ //step == 4
                    //username roma & number split
                    $username = $user->t_username;
                    $romaname = substr($username, 0, strlen($username) - strlen($user->address4) - strlen($user->address5));
                    $numbername = $user->address4.$user->address5;
                }

                return $retview->withUser($user)
                               ->withRomaname($romaname)
                               ->withNumbername($numbername);
            }else{
                return $retview;
            }
        }else{
            if ($type == 3 && $step == 1) $isAuthor = 1;
            $groups = User::Where('role','=', config('consts')['USER']['ROLE']['GROUP'])->where('org_id','=',0)->get();

            $view = 'indivstep';
            $groups = $groups->map(function ($group){
                return array('group' => $group->group_name);
            });
            if($step==3 && isset($user)){
                
                try{
                    Mail::to($user)->send(new Contact($user));
                    //admin
                    $admin = User::find(1);
                    $personadminHistory = new PersonadminHistory();
                    $personadminHistory->user_id = $admin->id;
                    $personadminHistory->username = $admin->username;
                    $personadminHistory->item = 0;
                    $personadminHistory->work_test = 13;
                    $personadminHistory->bookregister_name = $user->username;
                    $personadminHistory->content = '会員登録完了';
                    $personadminHistory->save();
                }catch(Swift_TransportException $e){
                    
                     return Redirect::back()
                         ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                         ->withInput()
                         ->withTitle($title);
                }

                //change login status
                $user->testable = 0;
                $user->islogged = 1;
                $user->namepwd_check = 0;
                // $user->replied_date3 = now();
                if($user->role == config('consts')['USER']['ROLE']['OVERSEER'])
                    $user->replied_date4 = now(); //適性検査合格日
                $user->save();

                $personworkHistory = new PersonworkHistory();
                $personworkHistory->user_id = $user->id;
                $personworkHistory->username = $user->username;
                $personworkHistory->item = 0;
                $personworkHistory->work_test = 2;
                if($user->isSchoolMember()){
                    $personworkHistory->user_type = '教職員';
                    if(!$user->isLibrarian())
                        $personworkHistory->org_username = $user->School->username;
                }
                else if($user->isAuthor())
                    $personworkHistory->user_type = '著者';
                else if($user->isOverseer())
                    $personworkHistory->user_type = '監修者';
                else if($user->isPupil())
                    $personworkHistory->user_type = '生徒';
                else
                    $personworkHistory->user_type = '一般';
                $personworkHistory->age = $user->age();
                $personworkHistory->address1 = $user->address1;
                $personworkHistory->address2 = $user->address2;
                $users = User::whereIn('active', [1,2])->get();
                $personworkHistory->content = count($users).'人';
                $personworkHistory->save(); 

                Auth::login($user);

                $accessHistory = new LoginHistory;
                $accessHistory->user_id = Auth::user()->id;
                $accessHistory->save();

                
            }   
            return view('auth.register.'.$view.$step)
                ->withData($data)
                ->withTitle($title)
                ->withType($type)
                ->withGroups($groups)
                ->withUser($user)
                ->with('step', $step)
                ->withIsAuthor($isAuthor);
        }

    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request){
        $data = $request->all();
        $role = $request->input('role');
        $user = config('consts')['USER']['TYPE'][$role];
        $rister_flag = false;
        
        $rule = array(
            'phone' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            //'address3' => 'required',
            'address4' => 'required',
            'address5' => 'required',
            //'using_purpose' => 'required',
        //  'group_type' => 'required',
        );
        if($role == config('consts')['USER']['ROLE']['GROUP']){
            $rule['group_name'] = 'required|unique:users|max:256';
            $rule['group_yomi'] = 'required';
            $rule['group_roma'] = 'required';
            $rule['rep_name'] = 'required';
            $rule['rep_post'] = 'required';
            $rule['teacher'] = 'required';
            //$rule['pupil_count'] = 'required|integer';
            //$rule['teacher_count'] = 'required|integer';
        } else if($role == config('consts')['USER']['ROLE']['AUTHOR']) {
            $rule['firstname'] = 'required';
            $rule['lastname'] = 'required';
            $rule['firstname_yomi'] = 'required';
            $rule['lastname_yomi'] = 'required';
            $rule['firstname_roma'] = 'required';
            $rule['lastname_roma'] = 'required';
            $rule['firstname_nick'] = 'required';
            $rule['firstname_nick_yomi'] = 'required';
            $rule['lastname_nick'] = 'required';
            $rule['lastname_nick_yomi'] = 'required';
            $rule['gender'] = 'required';
            $rule['birthday'] = 'required|date';
            $rule['auth_type'] = 'required';

            $rule['address3'] = 'required';
            $rule['address6'] = 'required';
            //$rule['address7'] = 'required';
            //$rule['address8'] = 'required';
            //$rule['address9'] = 'required';
            //$rule['address10'] = 'required';

        } else {
            $rule['firstname'] = 'required';
            $rule['lastname'] = 'required';
            $rule['firstname_yomi'] = 'required';
            $rule['lastname_yomi'] = 'required';
            $rule['firstname_roma'] = 'required';
            $rule['lastname_roma'] = 'required';
            $rule['gender'] = 'required';
            $rule['birthday'] = 'required|date';
            $rule['auth_type'] = 'required';

            $rule['address3'] = 'required';
            $rule['address6'] = 'required';
            //$rule['address7'] = 'required';
            //$rule['address8'] = 'required';
            //$rule['address9'] = 'required';
            //$rule['address10'] = 'required';
        }
        
        $teacher = $request->input('teacher');
        $prev_username = $request->input('prev_username');
        $rule['email'] = 'required|email';

       
        if(isset($prev_username) && $prev_username !== null && strlen($prev_username) > 0){

            $user = User::where("username", $prev_username)->first();
            if (!$user || $user == null) {
                $rule['email'] .= '|unique:users';
            }
            else{
                if($user->email != $request->input("email"))
                    $rule['email'] .= '|unique:users';
            }
        }
        else
            $rule['email'] .= '|unique:users';
       
        $message = array(
            'required' => config('consts')['MESSAGES']['REQUIRED'] ,
            'group_name.unique' => config('consts')['MESSAGES']['GROUP_EXIST'],
            'username.unique' => config('consts')['MESSAGES']['TEACHERNAME_NO'],
            'email.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE']
        );
        $validator = Validator::make($data, $rule, $message);

        $title = '新規会員登録(' . $user . ')';

        if($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)
                ->withInput()
                ->withTitle($title);
        }



        //create refresh_token
        $data['refresh_token'] = md5($data['email']).md5(time());
        $user1=null;
       
        if(isset($prev_username) && $prev_username !== null && strlen($prev_username) > 0) {
            $user1 = User::where("username", $prev_username)->first();
            if (!$user1 || $user1 == null) {
                $user = $this->create($data);
            } else {
                //$user = new User();
                $user = $user1;
                $user->firstname = $request->input("firstname");
                $user->lastname = $request->input("lastname");
                $user->firstname_yomi = $request->input("firstname_yomi");
                $user->lastname_yomi = $request->input("lastname_yomi");
                $user->firstname_roma = $request->input("firstname_roma");
                $user->lastname_roma = $request->input("lastname_roma");
                $user->gender = $request->input("gender");
                $user->birthday = $request->input("birthday");
                $user->auth_type = $request->input("auth_type");
                $user->address1 = $request->input("address1");
                $user->address2 = $request->input("address2");
                $user->address3 = $request->input("address3");
                $user->address4 = $request->input("address4");
                $user->address5 = $request->input("address5");
                $user->address6 = $request->input("address6"); 
                $user->address7 = $request->input("address7");
                $user->address8 = $request->input("address8");                
                $user->address9 = $request->input("address9"); 
                $user->address10 = $request->input("address10"); 
                $user->phone = $request->input("phone");
                $user->group_name = $request->input("group_name");
                $user->group_type = $request->input("group_type");
                //$user->using_purpose = $request->input("using_purpose");
                $user->email = $request->input("email");
                $user->refresh_token = $data['refresh_token'];
                $user->role = $role; //mmg 180601
                $user->teacher = $teacher;
                $user->password = "";
                $user->r_password = "";
                $user->org_id = 0;
                $user->active = 0;

                $rister_flag = true;
            }
        } else {
            $user = $this->create($data);
        }
        if($role == config('consts')['USER']['ROLE']['GROUP']) {
            $user->group_name = trim($request->input('group_name'));
            if($request->input("group_type") < 5) {
                $user->t_username = $request->input("group_roma").config('consts')['USER']['GROUP_TYPE'][2][$request->input("group_type")].$request->input("address4").$request->input("address5");
            } else {
                $user->t_username = $request->input("group_roma").$request->input("address4").$request->input("address5");
            }

            $group_yomi = $request->input("group_yomi");

            $user->group_roma = $request->input("group_roma");
            $user->t_password = str_random(8);
            $user->password = md5($user->t_password);
            $local_ip = \Request::ip();
            $user->ip_global_address = $local_ip;
        
            if(RegisterController::isHiragana($group_yomi)){
                $user->save();
            }

        } else {
            //if org is exist register to it
            $group = User::Where("group_name","like",trim($request->input('group_name')))->get();
            if(count($group) > 0){
                $user->org_id = $group[0]->id;
            }

            if (!$user1 || $user1 == null) {
                if($role == config('consts')['USER']['ROLE']['OVERSEER'])
                    $user->username = $user['lastname_roma'] ."0".$this->passwordNGenerator(3).$request->input('gender').'k';
                else if ($role == config('consts')['USER']['ROLE']['AUTHOR']) 
                    $user->username = $user['lastname_roma'] ."0".$this->passwordNGenerator(3).$request->input('gender').'c';
                else 
                    $user->username = $user['lastname_roma'] ."0".$this->passwordNGenerator(3).$request->input('gender');
            }
            else{
                $username = $user1->username;
                if($role == config('consts')['USER']['ROLE']['OVERSEER'])
                    $user->username = substr($username,0,strlen($username)-1).'k';
                else if ($role == config('consts')['USER']['ROLE']['AUTHOR']) 
                    $user->username = substr($username,0,strlen($username)-1).'c';
                // else
                //     $user->username = substr($username,0,strlen($username)-1);
            }
        }

        if($rister_flag){
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

        if($role == config('consts')['USER']['ROLE']['OVERSEER']
            || $role == config('consts')['USER']['ROLE']['AUTHOR']
            || $role == config('consts')['USER']['ROLE']['TEACHER']
            || $role == config('consts')['USER']['ROLE']['LIBRARIAN']
            || $role == config('consts')['USER']['ROLE']['REPRESEN']
            || $role == config('consts')['USER']['ROLE']['ITMANAGER']
            || $role == config('consts')['USER']['ROLE']['OTHER']) {
            $user->aptitude = 1;
        }
        // if($role == config('consts')['USER']['ROLE']['GROUP']) {
        //     if(RegisterController::isHiragana($group_yomi)){
        //         $user->save();
        //     }
        // }
        // else{
        //     $user->save();
        // }        
        if ($role == config('consts')['USER']['ROLE']['GENERAL']) {
            try{
                Mail::to($user->email)->send(new Restore($user));
                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = $admin->id;
                $personadminHistory->username = $admin->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '会員登録申請回答';
                $personadminHistory->save();
            }catch(Swift_TransportException $e){
                //$user->delete();
                return Redirect::back()
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                    ->withInput()
                    ->withTitle($title);
            } 
            $user->replied_date1 = now();      
        }
        if($role == config('consts')['USER']['ROLE']['GROUP']) {
            if(RegisterController::isHiragana($group_yomi)){
                $user->save();
            }
        }
        else{
            $user->save();
        }

        return Redirect::to('auth/reg_step1/'.$role.'/suc')
            ->withTitle($title);
    }

    public function isHiragana($str) {
        return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
    }

    public function step1_suc($role){
        $title = '新規会員登録'; 
        return view('auth.register.step1_suc')
            ->withRole($role)
            ->withTitle($title);
    }

    public function step2_suc(Request $request, $role){
        $title = '';
          
        $refresh_token = $request->input("refresh_token");
        $user = User::where('refresh_token', $refresh_token)->first();
        
        if(!$user) {
            return response('Unauthorized.', 401);
        }else{
            return view('auth.register.step2_suc')
                ->withRole($role)
                ->withTitle($title)
                ->withUser($user);
        }
    }

    public function step3_suc(Request $request, $role){
        $title = '';

        $refresh_token = $request->input("refresh_token");
        $user = User::where('refresh_token', $refresh_token)->first();

        if(!$user){
            return response('Unauthorized.', 401);
        }else{
            return view('auth.register.step3_suc')
                ->withRole($role)
                ->withTitle($title)
                ->withUser($user);
        }
    }

    public function step4_suc(Request $request, $role){
        $title = '';

        $refresh_token = $request->input("refresh_token");
        $user = User::where('refresh_token', $refresh_token)->first();
        if(!$user){
            return response('Unauthorized.', 401);
        }else{
            
             try{
                Mail::to($user)->send(new Contact($user));
                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = $admin->id;
                $personadminHistory->username = $admin->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '会員登録完了';
                $personadminHistory->save();
            } catch(Swift_TransportException $e) {

                return Redirect::back()
                ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                ->withInput()
                ->withTitle($title);
            }
            //change login status
            $user->testable = 0;
            $user->islogged = 1;
            $user->namepwd_check = 0;
            $user->replied_date3 = now();
            $user->active = 1;
            if($user->role == config('consts')['USER']['ROLE']['OVERSEER'])
                $user->replied_date4 = now(); //適性検査合格日
            //$user->t_username = "";
            //$user->t_password = "";
            $user->save();

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
                $orgworkHistory->work_test = 0;
                $orgworkHistory->save();
            }

            Auth::login($user);
            
            $accessHistory = new LoginHistory;
            $accessHistory->user_id = Auth::user()->id;
            $accessHistory->save();

            return view('auth.register.step4_suc')
                ->withRole($role)
                ->withTitle($title)
                ->withUser($user);
        }
    }

   

    public function login(Request $request){
        $title = '新規会員登録';
        return view('auth.register.login')
            ->withTitle($title);
    }
    protected function passwordEGenerator($length){
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }

    protected function passwordNGenerator($length){
        $characters = '0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }

    protected function create(array $data)
    {
        return User::create($data);
    }

    public function checktempauth(Request $request){
        $username = $request->input("username");
        $password = $request->input("password");

        $user = User::where(array('t_username' => $username, "t_password" => $password))->first();

        if($user){
            $user->save();

            return redirect('/auth/register/'.$user->role.'/3?refresh_token='.$user->refresh_token);
        }else{
            return Redirect::back()->withInput()->withErrors('');
        }

    }

    public function enterdetaildata(Request $request){
        $refresh_token = $request->input("refresh_token");
        $email = $request->input("email");
        $title = '';

        $user = User::where('refresh_token', $refresh_token)->first(); 
        if(!$user){
            return response('Unauthorized.', 401);
        }else{
            if($user->role == config('consts')['USER']['ROLE']['GROUP']) {
                $auth_type = $request->input("auth_type");
                //$wifi = $request->input("wifi");
                
                $rule = array(
                    //'wifi' => 'required'
                    'ip_address' => 'required',
                    'mask' => 'required'
                );
               
                /*if($request->input('nat_flag') != 'on'){
                     $rule['ip_address'] = 'required';
                     $rule['mask'] = 'required';
                }*/
                $messages = array(
                    'required' => '入力してください。'
                );
                $validator = Validator::make($request->all(), $rule, $messages);
                if ($validator->fails()){
                    return Redirect::back()->withErrors($validator)->withInput();
                }

                $user->auth_type = $auth_type;
                //$user->wifi = $wifi;
                $user->ip_address = $request->input('ip_address');
               // $user->ip_global_address = $request->input('ip_global_address');
                $user->mask = $request->input('mask');
                if($request->input('fixed_flag') == 'on')
                    $user->fixed_flag = 1;
                else
                    $user->fixed_flag = 0;
            } else {
                $user->password = md5($request->input("password"));
                $user->r_password = $request->input("password");
            }
            $user->save();
            //本人確認書類アップロード
            $authfile = $request->file("authfile");
            if($authfile){
                $ext = $authfile->getClientOriginalExtension();
                $authfilename = $authfile->getClientOriginalName();
                $realfilename = time().md5($authfilename);

                $authfilesize = $authfile->getClientSize();
                $maxfilesize = $authfile->getMaxFilesize();
                $maxfilesize1 = round($maxfilesize / 1024 / 1024, 0);
                if($authfilesize == 0 || $authfilesize > $maxfilesize){
                    //$user->replied_date2 = now();
                    $user->save();
                    $user->fileno = 'no';
                    $view = 'group';

                    return Redirect::back()
                    ->withErrors(["filemaxsize" => 'ファイルは'.$maxfilesize1.'MB以下でしてください。'])
                    ->withInput()
                    ->withTitle($title);
                }else{
                    $authfiledir = "/uploads/files";
                    if(file_exists(public_path().$user->file) && $user->file != '' && $user->file !== null){
                        if(file_exists(public_path()."/uploads/files/".$user->id)){
                            rename(public_path()."/uploads/files/".$user->id, public_path()."/uploads/files/doqregfile");

                            $filedh  = opendir(public_path()."/uploads/files/doqregfile");
                            while (false !== ($filename1 = readdir($filedh))) {
                                if ($filename1 != "." && $filename1 != "..") { 
                                    unlink(public_path()."/uploads/files/doqregfile/".$filename1);
                                }
                            }
                            rmdir(public_path()."/uploads/files/doqregfile");
                        }
                    }
                    //upload file
                    $authfile->move(public_path().'/uploads/files/'.$user->id.'/',$authfilename);

                    $user->authfile_date = date_format(now(), "Y-m-d");
                    $user->authfile = $authfilename;
                    $user->file = '/uploads/files/'.$user->id."/".$authfilename;
                }
            }
                
            //if overseer: 資格書類アップロード if Author:著書画像、著者照合画像等アップロード 
            $certifile = $request->file("certificatefile");
            if($certifile){
                $ext = $certifile->getClientOriginalExtension();
                $authfilename = $certifile->getClientOriginalName();
                $realfilename = time().md5($authfilename);

                $authfilesize = $certifile->getClientSize();
                $maxfilesize = $certifile->getMaxFilesize();
                $maxfilesize1 = round($maxfilesize / 1024 / 1024, 0);
                if($authfilesize == 0 || $authfilesize > $maxfilesize){
                    $user->save();
                    $user->fileno = 'no';
                    return Redirect::back()
                    ->withErrors(["filemaxsize1" => 'ファイルは'.$maxfilesize1.'MB以下でしてください。'])
                    ->withInput()
                    ->withTitle($title);
                }else{
                    if($user->role == config('consts')['USER']['ROLE']['OVERSEER']){
                        $authfiledir = "/uploads/certifiles";
                        if(file_exists(public_path().$user->certifile) && $user->certifile != '' && $user->certifile !== null){
                            if(file_exists(public_path()."/uploads/certifiles/".$user->id)){
                                rename(public_path()."/uploads/certifiles/".$user->id, public_path()."/uploads/certifiles/doqregfile");

                                $filedh  = opendir(public_path()."/uploads/certifiles/doqregfile");
                                while (false !== ($filename1 = readdir($filedh))) {
                                    if ($filename1 != "." && $filename1 != "..") { 
                                        unlink(public_path()."/uploads/certifiles/doqregfile/".$filename1);
                                    }
                                }
                                rmdir(public_path()."/uploads/certifiles/doqregfile");
                            }
                        }
                        //upload file
                        $certifile->move(public_path().'/uploads/certifiles/'.$user->id.'/',$authfilename);

                        $user->certifilename = $authfilename;
                        $user->certifile = '/uploads/certifiles/'.$user->id."/".$authfilename;
                        $user->certifile_date = date_format(now(), "Y-m-d");
                    }elseif ($user->role == config('consts')['USER']['ROLE']['AUTHOR']) {
                        $authfiledir = "/uploads/myprofile";
                        if(file_exists(public_path().$user->myprofile) && $user->myprofile != '' && $user->myprofile !== null){
                            if(file_exists(public_path()."/uploads/myprofile/".$user->id)){
                                rename(public_path()."/uploads/myprofile/".$user->id, public_path()."/uploads/myprofile/doqregfile");

                                $filedh  = opendir(public_path()."/uploads/myprofile/doqregfile");
                                while (false !== ($filename1 = readdir($filedh))) {
                                    if ($filename1 != "." && $filename1 != "..") { 
                                        unlink(public_path()."/uploads/myprofile/doqregfile/".$filename1);
                                    }
                                }
                                rmdir(public_path()."/uploads/myprofile/doqregfile");
                            }
                        }
                        //upload file
                        $certifile->move(public_path().'/uploads/myprofile/'.$user->id.'/',$authfilename);

                        $user->myprofilename = $authfilename;
                        $user->myprofile = '/uploads/myprofile/'.$user->id."/".$authfilename;
                        $user->myprofile_date = date_format(now(), "Y-m-d");
                    }
                }
            }


            if($user->role == config('consts')['USER']['ROLE']['AUTHOR']){
                $books = Books::where('active', '>=', 3)->where('active', '<=', 6)->get();
                foreach ($books as $key => $book) {
                                        
                    if($book->fullname_nick() == $user->fullname_nick())
                        $book->writer_id = $user->id;
                    $book->save();
                }
            } 
            if($user->role == config('consts')['USER']['ROLE']['GROUP']){
               return redirect('/auth/reg_step2/'.$user->role.'/suc?refresh_token='.$user->refresh_token.'&email='.$email);
            }else{
                if(($user->pay_date !== null && isset($user->pay_date) && $user->pay_date !== '') || $request->input('password') == "dd99dd99"){
                    $user->active = 1;
                    $user->replied_date2 = now();
                    $user->save(); 
                    return redirect('/auth/register/'.$user->role.'/3?refresh_token='.$user->refresh_token.'&email='.$email);
                }
                else{
                    return Redirect::back()->withInput()->withErrors('会費支払い手続きをしてください。');
                }
    

            }
        }
    }

    public function filesizecheck(Request $request){
        
           /* $authfilename = $request->file("authfile")->getClientOriginalName();
            $realfilename = time().md5($authfilename);

            $authfilesize = $request->file("authfile")->getClientSize();
            $maxfilesize = $request->file("authfile")->getMaxFilesize();
            if($authfilesize == 0 || $authfilesize > $maxfilesize){
                $user->replied_date2 = now();
                $user->save();
                return redirect('/auth/register/'.$user->role.'/3?refresh_token='.$user->refresh_token.'&fileno=false');
            }
         
           */
            
            
            //return response()->json(array('result'=>$result), 200);
           
        
    }

    public function downloadAuthFile(Request $request, $username) {
        $user = User::where('username','=',$username)->first();
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        return response()->download(public_path().$user->file, $user->authfile, $headers);
    }

    public function viewregisterAPI(Request $request, $type, $step){
        if($type == 0 && $step == 1){
             $data = $request->all();
             $role = $type;     /////$request->input('role');
             $user = config('consts')['USER']['TYPE'][$role];
             $rule = array(
                 'phone' => 'required',
                 'address1' => 'required',
                 'address2' => 'required',
                 'address3' => 'required',            
                 'address4' => 'required|integer',
                 'address5' => 'required|integer',
                 //'using_purpose' => 'required',
                 'group_type' => 'required',
             );
             if($role == config('consts')['USER']['ROLE']['GROUP']){
                 $rule['group_name'] = 'required|unique:users|max:256';
                 $rule['group_yomi'] = 'required';
                 $rule['group_roma'] = 'required';
                 $rule['rep_name'] = 'required';
                 $rule['rep_post'] = 'required';
                 $rule['teacher'] = 'required';
                 //$rule['pupil_count'] = 'required|integer';
                 //$rule['teacher_count'] = 'required|integer';
             } else if($role == config('consts')['USER']['ROLE']['AUTHOR']) {
                 $rule['firstname'] = 'required';
                 $rule['lastname'] = 'required';
                 $rule['firstname_yomi'] = 'required';
                 $rule['lastname_yomi'] = 'required';
                 $rule['firstname_roma'] = 'required';
                 $rule['lastname_roma'] = 'required';
                 $rule['firstname_nick'] = 'required';
                 $rule['firstname_nick_yomi'] = 'required';
                 $rule['lastname_nick'] = 'required';
                 $rule['lastname_nick_yomi'] = 'required';
                 $rule['gender'] = 'required';
                 $rule['birthday'] = 'required|date';
                 $rule['auth_type'] = 'required';

                 $rule['address6'] = 'required';
                 $rule['address7'] = 'required';
                 $rule['address8'] = 'required';
                 
                 $rule['address10'] = 'required';

             } else {
                 $rule['firstname'] = 'required';
                 $rule['lastname'] = 'required';
                 $rule['firstname_yomi'] = 'required';
                 $rule['lastname_yomi'] = 'required';
                 $rule['firstname_roma'] = 'required';
                 $rule['lastname_roma'] = 'required';
                 $rule['gender'] = 'required';
                 $rule['birthday'] = 'required|date';
                 $rule['auth_type'] = 'required';
                 $rule['address6'] = 'required';
                 $rule['address7'] = 'required';
                 $rule['address8'] = 'required';
                 
                 $rule['address10'] = 'required';
             }
             $rule['email'] = 'required|unique:users';
             $message = array(
                 'required' => config('consts')['MESSAGES']['REQUIRED'] ,
                 'group_name.unique' => config('consts')['MESSAGES']['GROUP_EXIST'],
                 'email.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE']
             );
             $validator = Validator::make($data ,$rule, $message);
             //create refresh_token
                $data['refresh_token'] = md5($data['email']).md5(time());
                $teacher = $request->input('teacher');
                if($role == config('consts')['USER']['ROLE']['OBSERVER'] && isset($teacher) && $teacher !== null && strlen($teacher) > 0) {
                    $user = User::where("username", $teacher)->first();
                    if (!$user || $user == null) {
                        $user = $this->create($data);
                    } else {
                        $user->firstname = $request->input("firstname");
                        $user->lastname = $request->input("lastname");
                        $user->firstname_yomi = $request->input("firstname_yomi");
                        $user->lastname_yomi = $request->input("lastname_yomi");
                        $user->firstname_roma = $request->input("firstname_roma");
                        $user->lastname_roma = $request->input("lastname_roma");
                        $user->gender = $request->input("gender");
                        $user->birthday = $request->input("birthday");
                        $user->auth_type = $request->input("auth_type");
                        $user->address1 = $request->input("address1");
                        $user->address2 = $request->input("address2");
                        $user->address3 = $request->input("address3");
                        $user->address4 = $request->input("address4");
                        $user->address5 = $request->input("address5");
                        $user->address6 = $request->input("address6"); 
                        $user->address7 = $request->input("address7"); 
                        $user->address8 = $request->input("address8");
                        $user->address9 = $request->input("address9");
                        $user->address710 = $request->input("address10");                  
                        $user->phone = $request->input("phone");
                        $user->group_name = $request->input("group_name");
                        $user->group_type = $request->input("group_type");
                        //$user->using_purpose = $request->input("using_purpose");
                        $user->email = $request->input("email");
                        $user->refresh_token = $data['refresh_token'];

                    }
                } else {
                    $user = $this->create($data);
                }

                if($role == config('consts')['USER']['ROLE']['GROUP']) {
                    $user->group_name = trim($request->input('group_name'));
                    if($request->input("group_type") < 5) {
             //                $user->t_username = $request->input("group_roma").config('consts')['USER']['GROUP_TYPE'][2][$request->input("group_type")].$request->input("address4").$request->input("address5");
                    } else {
                        $user->t_username = $request->input("group_roma").$request->input("address4").$request->input("address5");
                    }  
                    $user->group_roma = $request->input("group_roma");
                    $user->t_password = str_random(8);
                    $user->password = md5($user->t_password);
                } else {
                    //if org is exist register to it
                    $group = User::Where("group_name","like",trim($request->input('group_name')))->get();
                    if(count($group) > 0){
                        $user->org_id = $group[0]->id;
                    }

                    if($role == config('consts')['USER']['ROLE']['OBSERVER']) {
                        if (!isset($teacher) || $teacher == null || strlen($teacher) == 0) {
                            $user->username = $user['lastname_roma'] ."0".$this->passwordNGenerator(3).$request->input('gender').'k';
                        }
                    } else if ($role == config('consts')['USER']['ROLE']['AUTHOR']) {
                        $user->username = $user['lastname_roma'] ."0".$this->passwordNGenerator(3).$request->input('gender').'c';
                    } else {
                        $user->username = $user['lastname_roma'] ."0".$this->passwordNGenerator(3).$request->input('gender');
                    }
                }
                if($role == config('consts')['USER']['ROLE']['OBSERVER']) {
                    $user->testable = 1;
                }
                $user->replied_date1 = now();
                $user->username = str_random(8);
                $user->r_password = str_random(8);
                $user->save();
                return $user;
        }else if($type == 0 && $step == 2){
            $data = $request->all();
            $classes = Classes::create();
            $classes->type = $request->input("type");
            $classes->grade = $request->input('grade');
            $classes->class_number = $request->input("class_number");
            $classes->member_counts = $request->input('member_counts');
            $classes->group_id = $request->input('group_id');
            $classes->year = date("Y", mktime(0, 0, 0, 3, 1, Date('Y')));
            $classes->save();
            $id = $request->input("id");
            $user = User::where("id", $id)->first();
            $user->wifi = $request->input("wifi");
            $user->save();
        }else if(($type == 2 || $type == 1)&& $step == 1){
            $data = $request->all();
            $user = User::create($data);
            $user->firstname = $request->input("firstname");
            $user->lastname = $request->input("lastname");
            $user->firstname_yomi = $request->input("firstname_yomi");
            $user->lastname_yomi = $request->input("lastname_yomi");
            $user->firstname_roma = $request->input("firstname_roma");
            $user->lastname_roma = $request->input("lastname_roma");
            $user->gender = $request->input("gender");
            $user->birthday = $request->input("birthday");
            $user->address1 = $request->input("address1");
            $user->address2 = $request->input("address2");
            $user->address3 = $request->input("address3");
            $user->address4 = $request->input("address4");
            $user->address5 = $request->input("address5");
            $user->address6 = $request->input("address6");
            $user->address7 = $request->input("address7"); 
            $user->address8 = $request->input("address8");
            $user->address9 = $request->input("address9");
            $user->address10 = $request->input("address10");                   
            $user->phone = $request->input("phone");
            $user->scholarship = $request->input("scholarship");
            $user->email = $request->input("email");
            $user->group_name = $request->input("group_name");
            $user->org_id = $request->input("org_id");
            $user->teacher = $request->input("teacher");
            //$user->using_purpose = $request->input("using_purpose"); 
            $user->group_roma = $request->input("group_roma");
            $user->t_password = str_random(8);
            $user->password = md5($user->t_password);
            $user->role = config('consts')['USER']['ROLE']['OVERSEER'];
            $user->active = 0;
            $user->replied_date1 = now();
            $user->username = str_random(8);
            $user->r_password = str_random(8);
            $user->save();
            return $user;
        }else if($type == 3 && $step == 1){
            $data = $request->all();
            $user = User::create($data);
            $user->firstname = $request->input("firstname");
            $user->lastname = $request->input("lastname");
            $user->firstname_yomi = $request->input("firstname_yomi");
            $user->lastname_yomi = $request->input("lastname_yomi");
            $user->firstname_roma = $request->input("firstname_roma");
            $user->lastname_roma = $request->input("lastname_roma");
            $user->firstname_nick_yomi = $request->input("firstname_nick_yomi");
            $user->lastname_nick_yomi = $request->input("lastname_nick_yomi");
            $user->gender = $request->input("gender");
            $user->birthday = $request->input("birthday");
            $user->address1 = $request->input("address1");
            $user->address2 = $request->input("address2");
            $user->address3 = $request->input("address3");
            $user->address4 = $request->input("address4");
            $user->address5 = $request->input("address5");
            $user->address6 = $request->input("address6");
            $user->address7 = $request->input("address7");
            $user->address8 = $request->input("address8");
            $user->address9 = $request->input("address9");
            $user->address10 = $request->input("address10");                    
            $user->phone = $request->input("phone");
            $user->scholarship = $request->input("scholarship");
            $user->email = $request->input("email");                    
            $user->group_name = $request->input("group_name");
            $user->org_id = $request->input("org_id");
            $user->teacher = $request->input("teacher");
            //$user->using_purpose = $request->input("using_purpose");
            $user->t_password = str_random(8);
            $user->password = md5($user->t_password);
            $user->role = config('consts')['USER']['ROLE']['OVERSEER'];
            $user->active = 0;
            $user->replied_date1 = now();
            $user->username = str_random(8);
            $user->r_password = str_random(8);
            $user->save();
            return $user;
        }else if ($type !=0 && $step == 2) {
            $id = $request->input("id");
            $user = User::where("id", $id);
            $user->r_password = $request->input('r_password');
            $user->save();
        }else if ($type == 0 && $step == 3) {
            $id = $request->input("id");
            $user = User::where("id", $id);
            $user->r_password = $request->input('r_password');
            $user->save();
        }
   }

     public function loginPostAPI(Request $request){
        echo $request;
   }

}
