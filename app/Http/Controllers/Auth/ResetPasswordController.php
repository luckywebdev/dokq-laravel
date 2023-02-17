<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\PersonadminHistory;
use App\Model\PersonworkHistory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\Mail\ResetPwdSuccess;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use Redirect;
use Auth;
use Swift_TransportException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        date_default_timezone_set('Asia/Tokyo');
    }
    
	public function index(Request $request){
    	$title = 'ログイン';
    	$page = 'reset_index';
    	
    	$token = $request->input("refresh_token");
    	$user = User::where('refresh_token', $token)->first();
    	if(!$user){
    		return response('Unauthorized.', 401);
    	}else{
    		return view('auth.passwords.reset')
    			->withTitle($title)
    			->withUser($user)
    			->withPage($page);
    	}   	
    }
    
    public function doreset(Request $request){
    	$refresh_token = $request->input("token");
    	$password = $request->input("password");

    	$user = User::where('refresh_token', $refresh_token)->first();
    	if(!$user){
    		return response('Unauthorized', 401);	
    	}else{
    		
            $rule = array(
                'password' => 'string|required|max:15|min:8'
            );
            
            $message = array(
                'password.min' => config('consts')['MESSAGES']['PASSWORD_LENGTH'],
                'password.max' => config('consts')['MESSAGES']['PASSWORD_MAXLENGTH'],
                'required' => config('consts')['MESSAGES']['REQUIRED']
            );
            //$validator = Validator::make($request->all(), $rule, $message);
            $validator = Validator::make( $request->all(), $rule, $message);

            if ($validator->fails()){
               return Redirect::back()->withErrors($validator)->withInput();
            }

            if($request->input("r_password") == 'sayonaradq'){
                $error = config('consts')['MESSAGES']['PASSWORD_NO_USE'];
                return Redirect::back()->withErrors(["password" => $error])->withInput();
            }
            //alerdy password double
            $password_others = User::where('r_password', '=', $password)->where('id', '<>', Auth::id())->count();
           
            if($password_others != 0){
                $error = config('consts')['MESSAGES']['PASSWORD_EXIST'];
             
                return Redirect::back()
                       ->withErrors(["password" => $error])
                      ->withInput();
            }

    		try{
                $user->password = md5($password);
                $user->r_password = $password;
                $user->testable = 0;
                $user->save();
        		//send mail
        		Mail::to($user)->send(new ResetPwdSuccess($user));

                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = $admin->id;
                $personadminHistory->username = $admin->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '新しいパスワード登録';
                $personadminHistory->save();
            }catch(Swift_TransportException $e){
                    
                return Redirect::back()
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                    ->withInput();
            }
            
    		return Redirect::to('/auth/reset_pwd_success');
    	}
    }
    
    public function success(){
    	$title = 'ログイン';
    	$page = 'reset_index';
    	return view('auth.passwords.resetsuccess')
    			->withTitle($title)
    			->withPage($page);
    }
}
