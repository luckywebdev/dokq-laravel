<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use App\Mail\ForgotPassword;
use App\Mail\ForgotFace;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;
use App\User;
use App\Mail\ResetPwdSuccess;
use App\Model\PersonadminHistory;
use App\Model\PersoncontributionHistory;
use App\Model\PersontestoverseeHistory;
use App\Model\PersonbooksearchHistory;
use App\Model\PersonoverseerHistory;
use App\Model\PersonquizHistory;
use App\Model\PersontestHistory;
use App\Model\PersonworkHistory;
use App\Model\OrgworkHistory;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
    }

    public function index() {
        $title = 'ログイン';
        $page = 'forgot_index';
        return view('auth.passwords.index')
            ->withNofooter(true)
            ->withTitle($title)
            ->withPage($page)
            ->withNosidebar(true);
    }

    public function emailview() {
        $title = 'ログイン';
        $page = 'forgot_index';
        return view('auth.passwords.email')
            ->withNofooter(true)
            ->withTitle($title)
            ->withPage($page)
            ->withNosidebar(true);
    }

    public function doforgotemail(Request $request) {
        $title = 'ログイン';
        $email = $request->input("email");

        $rule = array(
            //"email" => "email"
        );
        $message = array(
            "email.email" => config('consts')['MESSAGES']['EMAIL_EMAIL']
        );

        $validator = Validator::make($request->all(), $rule, $message);
        if($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput()
                ->withTitle($title);
        } else {
            $user = User::where('email', $email)->first();
            if(isset($user)){
                try{
                    Mail::to($user)->send(new ForgotPassword($user));

                    //admin
                    $admin = User::find(1);
                    $personadminHistory = new PersonadminHistory();
                    $personadminHistory->user_id = $admin->id;
                    $personadminHistory->username = $admin->username;
                    $personadminHistory->item = 0;
                    $personadminHistory->work_test = 13;
                    $personadminHistory->bookregister_name = $user->username;
                    $personadminHistory->content = 'ﾊﾟｽﾜｰﾄﾞ再発行';
                    $personadminHistory->save();
                }catch(Swift_TransportException $e){
                    
                    return Redirect::back()
                        ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                        ->withInput()
                        ->withTitle($title);
                }
            }

            return Redirect::to("/");
        }
    }

    public function faceVerify(Request $request) {
        $title = 'ログイン';
        $page = 'forgot_index';
        return view('auth.passwords.verify')
            ->withTitle($title)
            ->withPage($page);
    }

    public function preFaceVerify(Request $request) {
        $title = 'ログイン';
        $firstname = $request->input("firstname");
        $lastname = $request->input("lastname");

        $users = User::where('firstname', $firstname)->where('lastname',$lastname);
        if($request->has("phone") && $request->input("phone") != ""){
            $phone = $request->input("phone");
            $users = $users->where('phone', $phone);
        }
        if($request->has("email") && $request->input("email") != ""){
            $email = $request->input("email");
            $users = $users->where('email', $email);
        }

        $user = $users->first();
        if(!isset($user) || $user == null) {
            return Redirect::back()->withErrors("invalid input")->withInput();
        }
        return view('auth.passwords.verify_face')
            ->withTitle($title)
            ->with('user',$user)
            ->with('userId',$user->id);
    }

    public function signinTeacher(Request $request){
        $userId = $request->input('user_id');
        if ($request->session()->has("errors")){
            $userId = $request->session()->get("user_id");
        }
        return view('auth.passwords.signin_teacher')
            ->with('userId', $userId)
            ->withNosidebar(true);
    }

    public function passwordTeacherVerify(Request $request){
        $title = 'ログイン';
        $page = 'forgot_index';
        $password = $request->input('password');
        $userId = $request->input('userId');
        if ($request->session()->has("errors")){
            $userId = $request->session()->get("userId");
            $mode = $request->session()->get("mode");
        }
        $user = User::find($userId);

        $rule = array(
            'password' => 'required'
        );
        $message = array(
            'password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED']
        );

        if (!$request->session()->has("errors")){
            $validator = Validator::make($request->all(), $rule, $message);
            if($validator->fails()) {
                return Redirect::to('/auth/signin_teacher')
                            ->with('user_id', $userId)
                           ->withErrors($validator);
            }
        }

        $pupilclass = $user->PupilsClass;
       
        $teacher_user = User::where('r_password','=',$password)->first();
        if(isset($teacher_user) && $teacher_user !== null) {
            if($pupilclass->teacher_id == $teacher_user->id){

                 return view('auth.passwords.register_face')
                        ->with('user_id', $userId)
                        ->withNosidebar(true);
            }
        }

        return Redirect::to('/auth/signin_teacher')
                            ->with('page', $page)
                            ->with('user_id', $userId)
                            ->withErrors(array('invalid_pwd' => 'true'));
    }

}
