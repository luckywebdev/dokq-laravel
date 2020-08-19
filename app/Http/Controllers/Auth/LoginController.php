<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Classes;
use App\Model\Messages;
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
use App\Model\CertiBackup;
use App\Http\Controllers\MypageController;
use App\Mail\UserescapeByadmin;

use Validator;
use Redirect;
use DB;
use Mail;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        date_default_timezone_set('Asia/Tokyo');
    }
    
    protected function username(){
        return 'username';
    }
    public function get_next_pay_date($start_date, $pay_content){
        $real_pay_start_arr = explode("-", $start_date);
        $start_year = $real_pay_start_arr[0];
        $start_month = $real_pay_start_arr[1];
        $start_day = $real_pay_start_arr[2];
        if(strpos(strtolower($pay_content), "yearly") === false){
            if($start_year == 12){
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


    public function index(){
        $title = 'ログイン';
        $page = 'login_index';

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

        $threeMonthsUsers = DB::table('users')
                          ->where('active','=',3)
                          ->where('escape_date','<',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")))
                          ->get();
                          //->update(['active' => 4]);
        foreach ($threeMonthsUsers as $key => $user) {
            if(isset($user)){
                try{
                    Mail::to($user)->send(new UserescapeByadmin($user));
                    $user->active = 4;
                    $user->r_password = 'sayonaradq';
                    $user->password = md5('sayonaradq');
                    $user->save();
                   
                }catch(Swift_TransportException $e){
                            
                    return Redirect::back()
                        ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']]);
                }
            }
        }

        
        return view('auth.login')
            ->withNofooter(true)
            ->withTitle($title)
            ->withPage($page)
            ->withNosidebar(true);
    }
  
    public function login(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        $namepwd_check = 0;
        /*if(isset($username) && !$namepwd_check){
             $user = User::whereRaw('users.username = "'.$username.'"')->first();
             if(isset($user) && $user->namepwd_check){
                $namepwd_check = 1;
             }
        }*/
        if(isset($password) && !$namepwd_check){
             $md5password = md5($password);
             $user = User::whereRaw('users.password = "'.$md5password.'"')->first();
             if(isset($user) && $user->namepwd_check){
                $namepwd_check = 1;
             }
        }
        if($namepwd_check){
            $this->loginHistory($request,$user);
        }

        $rule = array(
            'username' => 'required',
            'password' => 'required'
        );
        $message = array(
            'username.required' => config('consts')['MESSAGES']['USERNAME_REQUIRED'] ,
            'password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED']
        );
       
        $validator = Validator::make($request->all(), $rule, $message);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        

        $user = User::whereRaw('users.username = "'.$request->input('username').'"')->first();
    //   $user = DB::raw('(SELECT * FROM users WHERE users.username = "'.$request->input('username').'")');
         
        if($user){  

            if ($user->active != 0) {

            	if($user->active <= 3) {
                    if($user->password == md5($request->input("password")) && $user->testable < 3){
                		if(!$user->replied_date3){
                            $user->replied_date3 = now();
                        }
                        $current_period = $user->period;
                        $current_date = date("Y-m-d");
                        if(($current_date > $current_period) && $user->pay_content !== null && $user->pay_content !== '' && $user->pay_amount !== 0){
                            $next_start_pay_date = date_add(date_create($current_period), date_interval_create_from_date_string('1 days'));
                            $next_start_pay_date = date_format($next_start_pay_date, "Y-n-j");
                            $next_start_pay_date_next = $this->get_next_pay_date($next_start_pay_date, $user->pay_content);
                            $next_period = date_sub(date_create($next_start_pay_date_next), date_interval_create_from_date_string('1 days'));
                            $user->period = date_format($next_period, 'Y-m-d');
                        }
                        
                        //cancel testable
                        $user->testable = 0;
                        $user->islogged = 1;
                        $user->namepwd_check = 0;
                        $user->save();
                        $next_month_date = date_format(date_add(now(), date_interval_create_from_date_string('1 months')), "Y-m-d");
                        $settlement_check = CertiBackup::where('user_id', $user->id)
                                                ->where('passcode', '!=', '')
                                                ->whereNotNull('passcode')
                                                ->whereNotNull('settlement_date')
                                                ->where('settlement_date' ,'<', $next_month_date)
                                                ->count();
                        $certi_back = CertiBackup::where('user_id', $user->id)
                                                ->where('passcode', '!=', '')
                                                ->whereNotNull('passcode')
                                                ->whereNotNull('settlement_date')
                                                ->where('settlement_date' ,'<', $next_month_date)
                                                ->first();
                
                        if($settlement_check > 0){
                            $message = new Messages;
                            $message->type = 0;
                            $message->from_id = 0;
                            $message->to_id = $user->id;
                            $message->name = "協会";
                            $message->content = '読書認定書（パスコード'.$certi_back->passcode.'）の閲覧期間は'.date_format(date_create($certi_back->settlement_date), "Y年n月j日").'までです。延長する必要がある場合はマイ書斎の読書認定書発行欄からお手続きください。';
                            $message->save();
                        }
                
                        if($user->isAdmin()){
                            $PersonadminHistory = new PersonadminHistory();
                            $PersonadminHistory->user_id = $user->id;
                            $PersonadminHistory->username = $user->username;
                            $PersonadminHistory->item = 0;
                            $PersonadminHistory->work_test = 0;
                            $PersonadminHistory->device = $user->get_device();
                            $PersonadminHistory->save();
                        }else if($user->isGroup() || $user->isSchoolMember()){
                            $orgworkHistory = new OrgworkHistory();
                            if($user->isSchoolMember()){
                                $orgworkHistory->user_id = $user->id;
                                $orgworkHistory->username = $user->username;
                                $orgworkHistory->group_id = $user->org_id;
                                if(!$user->isLibrarian() && $user->active == 1)
                                    $orgworkHistory->group_name = User::find($user->org_id)->username; 
                                if($user->isTeacher() && $user->active == 1){
                                    $local_ip = \Request::ip();
                                    $org_data = User::whereRaw('users.id = "'.$user->org_id.'"')->first();
                                    $school_ip = $org_data->ip_address;
                                    $school_mask = $org_data->mask;
                                    if($school_mask !== null && $school_mask != ""){
                                        $mask_long = ip2long($school_mask);
                                        $base = ip2long('255.255.255.255');
                                        $cidr = 32-log(($mask_long ^ $base)+1,2);
                                    }
                                    else{
                                        $school_mask = "255.255.255.0";
                                        $cidr = 24;
                                    }
                                    $local_ip = ip2long($local_ip);
                                    $school_ip = ip2long($school_ip);
                                    $mask = -1 << (32 - $cidr);
                                    $school_ip &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
                                    $ip_check = ($local_ip & $mask) == $school_ip;
                                    if($ip_check && $org_data->fixed_flag == 1){
                                        $request->session()->put('teacher_auth', 1);
                                        $orgworkHistory->ip_check_result = 1;
                                    }
                                    elseif($org_data->fixed_flag == 0){
                                        $request->session()->put('teacher_auth', 1);
                                    }
                                }
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

                            if($user->isSchoolMember() && $user->active == 1){
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
                                if($user->isTeacher()){
                                    $local_ip = \Request::ip();
                                    $org_data = User::whereRaw('users.id = "'.$user->org_id.'"')->first();
                                    $school_ip = $org_data->ip_address;
                                    $school_mask = $org_data->mask;
                                    if($school_mask !== null && $school_mask != ""){
                                        $mask_long = ip2long($school_mask);
                                        $base = ip2long('255.255.255.255');
                                        $cidr = 32-log(($mask_long ^ $base)+1,2);
                                    }
                                    else{
                                        $school_mask = "255.255.255.0";
                                        $cidr = 24;
                                    }
                                    $local_ip = ip2long($local_ip);
                                    $school_ip = ip2long($school_ip);
                                    $mask = -1 << (32 - $cidr);
                                    $school_ip &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
                                    $ip_check = ($local_ip & $mask) == $school_ip;
                                    if($ip_check && $org_data->fixed_flag == 1){
                                        $request->session()->put('teacher_auth', 1);
                                        $personworkHistory->ip_check_result = 1;
                                    }
                                    elseif($org_data->fixed_flag == 0){
                                        $request->session()->put('teacher_auth', 1);
                                    }                                                
                                }
                                $personworkHistory->device = $user->get_device();
                                $personworkHistory->save();
                            }
                        }else{
                            $personworkHistory = new PersonworkHistory();
                            $personworkHistory->user_id = $user->id;
                            $personworkHistory->username = $user->username;
                            $personworkHistory->item = 0;
                            $personworkHistory->work_test = 0;
                            if($user->isAuthor())
                                $personworkHistory->user_type = '著者';
                            else if($user->isOverseer())
                                $personworkHistory->user_type = '監修者';
                            else if($user->isPupil() && $user->acitve == 1){
                                $personworkHistory->user_type = '生徒';
                                $personworkHistory->org_username = $user->ClassOfPupil->school->username;
                            }else
                                $personworkHistory->user_type = '一般';
                            $personworkHistory->age = $user->age();
                            $personworkHistory->address1 = $user->address1;
                            $personworkHistory->address2 = $user->address2;
                            $personworkHistory->device = $user->get_device();
                            $personworkHistory->save(); 
                        }
                                            
                        Auth::login($user);
                        
                        $accessHistory = new LoginHistory;
                        $accessHistory->user_id = Auth::user()->id;
                        $accessHistory->device = Auth::user()->get_device();
                        $accessHistory->save();

                        $login = $request->session()->put('msglogin',Auth::id()); //login view in 一括操作
                        $bookregister = $request->session()->get('bookregister');
                        
                        if(!$user->isGroup()){
                            $mypage = new MypageController;
                            $mypage->reportbackup($user->id); //backup
                        }
                  
                        if($user->active == 2){
                            $bookregister = $request->session()->put('bookregister',0);
                            return Redirect::to("/mypage/top?confirm=vice_log");
                        }

                        if($bookregister == 1){
                            //$request->session()->remove('bookregister');
                            $bookregister = $request->session()->put('bookregister',0);
                             
                            return Redirect::to("/book/register/caution?cautionflag=1");
                        }
                        
                        $bookregister = $request->session()->put('bookregister',0);
                        
                        
                        return Redirect::to('/top');
                	}else{
                		$user->testable = $user->testable + 1;
                		$user->save();

                        if($user->testable > 3)
                            return Redirect::back()->withInput()->withErrors(["error" =>'locked']);
                        else
                            return Redirect::back()->withInput()->withErrors(["error" =>'invalid password']);
                	}            	
            	}else{
                    return Redirect::back()->withInput()->withErrors(["error" =>'no_use']);
                }
            } else {
            	if($user->password == md5($request->input('password')) && $user->active == 0){
            		if($user->role == config('consts')['USER']['ROLE']['GROUP']){
            			return Redirect::to('/auth/register/'.$user->role.'/3?refresh_token='.$user->refresh_token);
            		}else{
            			return Redirect::to('/auth/register/'.$user->role.'/2?refresh_token='.$user->refresh_token);
            		}            		
            	}else{
            		return Redirect::back()->withErrors("notallowed")->withInput();
            	}
            }              
        } else{
            return Redirect::back()->withErrors("no user")->withInput();
        }
    }

    public function logout(Request $request){
    	$user = Auth::user();
    	$user->islogged = 0;
        $user->namepwd_check = 0;
    	$user->save();

    	$logout = $request->session()->put('msglogout',Auth::id()); //logout view in 一括操作

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
                if(!$user->isLibrarian() && $user->active == 1)
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
                if(!$user->isLibrarian() && $user->active == 1)
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
                if($user->acitve == 1)
                    $personworkHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personworkHistory->user_type = '一般';
            $personworkHistory->age = $user->age();
            $personworkHistory->address1 = $user->address1;
            $personworkHistory->address2 = $user->address2;
            $personworkHistory->save(); 
        }
        if($request->session()->has('teacher_auth'))
             $request->session()->forget('teacher_auth');
        Auth::logout();
        return Redirect::to('/');
    }

    public function loginHistory(Request $request,$user){
        if(!$user->replied_date3){
            $user->replied_date3 = now();
        }
        $current_period = $user->period;
        $current_date = date("Y-n-d");
        if(($current_date > $current_period) && $user->pay_content !== null && $user->pay_content !== '' && $user->pay_amount !== 0){
            $next_start_pay_date = date_add(date_create($current_period), date_interval_create_from_date_string('1 days'));
            $next_start_pay_date = date_format($next_start_pay_date, "Y-n-j");
            $next_start_pay_date_next = $this->get_next_pay_date($next_start_pay_date, $user->pay_content);
            $next_period = date_sub(date_create($next_start_pay_date_next), date_interval_create_from_date_string('1 days'));
            $user->period = date_format($next_period, 'Y-m-d');
        }
        $next_month_date = date_format(date_add(now(), date_interval_create_from_date_string('1 months')), "Y-m-d");
        $settlement_check = CertiBackup::where('id', $user->id)
                                ->where('passcode', '!=', '')
                                ->whereNotNull('passcode')
                                ->whereNotNull('settlement_date')
                                ->where('settlement_date' ,'<', $next_month_date)
                                ->count();
        $certi_back = CertiBackup::where('user_id', $user->id)
                                ->where('passcode', '!=', '')
                                ->whereNotNull('passcode')
                                ->whereNotNull('settlement_date')
                                ->where('settlement_date' ,'<', $next_month_date)
                                ->first();
                
        if($settlement_check > 0){
            $message = new Messages;
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = $user->id;
            $message->name = "協会";
            $message->content = '読書認定書（パスコード'.$certi_back->passcode.'）の閲覧期間は'.date_format(date_create($certi_back->settlement_date), "Y年n月j日").'までです。延長する必要がある場合はマイ書斎の読書認定書発行欄からお手続きください。';
            $message->save();
        }
        //cancel testable
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
            $PersonadminHistory->device = $user->get_device();
            $PersonadminHistory->save();
        }else if($user->isGroup() || $user->isSchoolMember()){
            $orgworkHistory = new OrgworkHistory();
            if($user->isSchoolMember()){
                $orgworkHistory->user_id = $user->id;
                $orgworkHistory->username = $user->username;
                $orgworkHistory->group_id = $user->org_id;
                if(!$user->isLibrarian())
                    $orgworkHistory->group_name = User::find($user->org_id)->username; 
                if($user->isTeacher()){
                    $local_ip = \Request::ip();
                    $org_data = User::whereRaw('users.id = "'.$user->org_id.'"')->first();
                    $school_ip = $org_data->ip_address;
                    $school_mask = $org_data->mask;
                    if($school_mask !== null && $school_mask != ""){
                        $mask_long = ip2long($school_mask);
                        $base = ip2long('255.255.255.255');
                        $cidr = 32-log(($mask_long ^ $base)+1,2);
                    }
                    else{
                        $school_mask = "255.255.255.0";
                        $cidr = 24;
                    }
                    $local_ip = ip2long($local_ip);
                    $school_ip = ip2long($school_ip);
                    $mask = -1 << (32 - $cidr);
                    $school_ip &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
                    $ip_check = ($local_ip & $mask) == $school_ip;
                    if($ip_check && $org_data->fixed_flag == 1){
                        $request->session()->put('teacher_auth', 1);
                        $orgworkHistory->ip_check_result = 1;
                    }
                    elseif($org_data->fixed_flag == 0){
                        $request->session()->put('teacher_auth', 1);
                    }
                }
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
                $personworkHistory->work_test = 0;
                $personworkHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personworkHistory->org_username = $user->School->username;
                if($user->isTeacher()){
                    $local_ip = \Request::ip();
                    $org_data = User::whereRaw('users.id = "'.$user->org_id.'"')->first();
                    $school_ip = $org_data->ip_address;
                    $school_mask = $org_data->mask;
                    if($school_mask !== null && $school_mask != ""){
                        $mask_long = ip2long($school_mask);
                        $base = ip2long('255.255.255.255');
                        $cidr = 32-log(($mask_long ^ $base)+1,2);
                    }
                    else{
                        $school_mask = "255.255.255.0";
                        $cidr = 24;
                    }
                    $local_ip = ip2long($local_ip);
                    $school_ip = ip2long($school_ip);
                    $mask = -1 << (32 - $cidr);
                    $school_ip &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
                    $ip_check = ($local_ip & $mask) == $school_ip;
                    if($ip_check && $org_data->fixed_flag == 1){
                        $request->session()->put('teacher_auth', 1);
                        $personworkHistory->ip_check_result = 1;
                    }
                    elseif($org_data->fixed_flag == 0){
                        $request->session()->put('teacher_auth', 1);
                    }
                }
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
            $personworkHistory->device = $user->get_device();
            $personworkHistory->save(); 
        }
        
        Auth::login($user);
        
        $accessHistory = new LoginHistory;
        $accessHistory->user_id = Auth::user()->id;
        $accessHistory->device = Auth::user()->get_device();
        $accessHistory->save();


        $login = $request->session()->put('msglogin',Auth::id()); //login view in 一括操作
        $bookregister = $request->session()->get('bookregister');
        
        if($user->active == 2){
            $bookregister = $request->session()->put('bookregister',0);
            return Redirect::to("/mypage/top?confirm=vice_log");
        }

        if($bookregister == 1){
            //$request->session()->remove('bookregister');
            $bookregister = $request->session()->put('bookregister',0);
             
            return Redirect::to("/book/register/caution?cautionflag=1");
        }
        
       
        $bookregister = $request->session()->put('bookregister',0);
        return Redirect::to('/top');
    }

}
