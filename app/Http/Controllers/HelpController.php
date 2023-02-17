<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Model\Messages;
use App\Model\PersonadminHistory;
use App\Model\PersoncontributionHistory;
use App\Model\PersontestoverseeHistory;
use App\Model\PersonbooksearchHistory;
use App\Model\PersonoverseerHistory;
use App\Model\PersonquizHistory;
use App\Model\PersontestHistory;
use App\Model\PersonworkHistory;
use App\Model\PersonhelpHistory;
use App\Model\OrgworkHistory;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;

class HelpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $page = 'about';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
    }

    public function aboutSite()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 0;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

        $page_info = [
            'side' =>'about',
            'subside' =>'about_site',
            'top' =>'about',
            'subtop' =>'about_site',
        ];
        return view('help.about_site')
            ->with('page_info',$page_info);
    }

    public function aboutScore()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 1;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'about_score',
            'top' =>'about',
            'subtop' =>'about_score',
        ];
        return view('help.about_score')
            ->with('page_info',$page_info);
    }

    public function aboutTarget()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 2;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
       $personhelpHistory->save(); 
       $page_info = [
            'side' =>'about',
            'subside' =>'about_target',
            'top' =>'about',
            'subtop' =>'about_target',
        ];
        return view('help.about_target')
            ->with('page_info',$page_info);
    }

    public function aboutoverseer(Request $request)
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 3;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'about_overseer',
            'top' =>'about',
            'subtop' =>'about_overseer',
        ];
        //    	if(Auth::user()->isOverseer()){
        //       	   $user = User::find(Auth::id());
        //      	}
        $overseers = User::select('users.*',DB::raw('SUM(books.point) as point'))
                    ->leftJoin('books','users.id','=', DB::raw('books.overseer_id or (users.id = books.writer_id and books.author_overseer_flag = 1) and books.active <> 7' ))
                    ->whereIn('users.role',[config('consts')['USER']['ROLE']["OVERSEER"],
                                    config('consts')['USER']['ROLE']["TEACHER"],
                                    config('consts')['USER']['ROLE']["LIBRARIAN"],
                                    config('consts')['USER']['ROLE']["REPRESEN"],
                                    config('consts')['USER']['ROLE']["ITMANAGER"],
                                    config('consts')['USER']['ROLE']["OTHER"],
                                    config('consts')['USER']['ROLE']["ADMIN"],
                                    config('consts')['USER']['ROLE']["AUTHOR"]])
                    ->where('users.active','=','1')
                    ->having(DB::raw('SUM(books.point)'), '>' , '0')
                    ->groupby('users.id');
  
      	$order=3; 
      	if($request->has('order')){
	      	if($request->input('order') == 0){
	    		$overseers = $overseers->orderby('point','desc');
	    		$order=0;
	    	}elseif($request->input('order') == 1){
                $overseers = $overseers->orderby(DB::raw("users.firstname_yomi asc, users.lastname_yomi"), 'asc'); 
                $order=1;
            }
	    	else{
	    		$overseers = $overseers->orderby('users.address1'); 
	    		$order=2;
	    	}
      	}else{
            $overseers = $overseers->orderby('point','desc'); 
                $order=0;
        }
        $overseers = $overseers->get();
        //    	return redirect('/about_overseer');
        
        return view('help.about_overseer')
            ->with('page_info',$page_info)
            ->withOverseers($overseers)            
            ->withOrder($order);
    }

    public function aboutTest()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 4;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'about_test',
            'top' =>'about',
            'subtop' =>'about_test',
        ];
        return view('help.about_test')
            ->with('page_info',$page_info);
    }

    public function aboutRecog()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 5;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'about_recog',
            'top' =>'about',
            'subtop' =>'about_recog',
        ];
        return view('help.about_recog')
            ->with('page_info',$page_info);
    }

    public function aboutSiteMap()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 6;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'about_sitemap',
            'top' =>'about',
            'subtop' =>'about_sitemap',
        ];
        return view('help.about_sitemap')
            ->with('page_info',$page_info);
    }

    public function viewOutline()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 7;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'outline',
            'top' =>'about',
            'subtop' =>'outline',
        ];
        return view('help.outline')
            ->with('page_info',$page_info);
    }

    public function viewAgreement()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 8;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'agreement',
            'top' =>'about',
            'subtop' =>'agreement',
        ];
        return view('help.agreement')
            ->with('page_info',$page_info);
    }

    public function aboutPay()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 9;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'about_pay',
            'top' =>'about',
            'subtop' =>'about_pay',
        ];
        return view('help.about_pay')
            ->with('page_info',$page_info);
    }

    public function aboutSecurity()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 10;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'security',
            'top' =>'about',
            'subtop' =>'security',
        ];
        return view('help.security')
            ->with('page_info',$page_info);
    }

    public function viewAsk()
    {     
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 11;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 
 
       $page_info = [
            'side' =>'about',
            'subside' =>'ask',
            'top' =>'about',
            'subtop' =>'ask',
        ];

       //    $user = Auth::user();
       if(isset($user)){
            return view('help.ask')
                ->with('page_info',$page_info)
            ->withUser($user);
       }
       else{
            return view('help.ask')
            ->with('page_info',$page_info);
       }

    }
	
    public function sendMessage(Request $request){
    	$page_info = [
            'side' =>'about',
            'subside' =>'ask',
            'top' =>'about',
            'subtop' =>'ask',
        ];
    	
        $user = User::find($request->input('id'));
        if($user != null)
        {
           $rule = array(
            'name' => 'required',
            );
            $errors = array(
                'name' => config('consts')['MESSAGES']['FIRSTNAME_REQUIRED'],
            );
             $validator = Validator::make($request->all(), $rule, $errors);
          if($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)
                ->withInput()
                ->with('page_info', $page_info);
          } 
        }
        else
        {
            $rule = array(
            'name' => 'required',
            'email'=> 'required|email'
            );
            $errors = array(
                'name' => config('consts')['MESSAGES']['FIRSTNAME_REQUIRED'],
                'email.required' => config('consts')['MESSAGES']['EMAIL_REQUIRED'],
                'email.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            );
             $validator = Validator::make($request->all(), $rule, $errors);
          if($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)
                ->withInput()
                ->with('page_info', $page_info);
          }   
        }
    	
    	$message = new Messages();
    	$message->type = 2;
    	$message->from_id = $request->input('id');
    	$message->content = $request->input('content');
        
    	
    	$message->name = $request->input('name');
        if($user != null)
        {
            $message->email = $user->email;
        }
        else
        {
            $message->email = $request->input('email');    
        }
    	
    	$message->save();

        $PersoncontributionHistory = new PersoncontributionHistory();
        if($user != null)
        {
            $PersoncontributionHistory->user_id = $user->id;
            $PersoncontributionHistory->username = $user->username;
            $PersoncontributionHistory->age = $user->age();     
        }
        else
        {
            $PersoncontributionHistory->user_id = 0;
            $PersoncontributionHistory->username = '';
            $PersoncontributionHistory->age = 0;
        }
        $PersoncontributionHistory->item = 0;
        $PersoncontributionHistory->work_test = 2;
        
        $PersoncontributionHistory->content = $request->input('content');
        $PersoncontributionHistory->save();

    	$success ="true";
    	return Redirect::back()
    		->withSuccess($success);
    	
    }
    public function viewFaq()
    {
        $user = Auth::user();
        $personhelpHistory = new PersonhelpHistory();
        $personhelpHistory->item = 12;
        $personhelpHistory->work_test = 12;

        if(isset($user) && $user !== null){
            $personhelpHistory->user_id = $user->id;
            $personhelpHistory->username = $user->username;
            if($user->isSchoolMember()){
                $personhelpHistory->user_type = '教職員';
                if(!$user->isLibrarian())
                    $personhelpHistory->org_username = $user->School->username;
            }
            else if($user->isAdmin())
                $personhelpHistory->user_type = '管理者';
            else if($user->isAuthor())
                $personhelpHistory->user_type = '著者';
            else if($user->isOverseer())
                $personhelpHistory->user_type = '監修者';
            else if($user->isPupil()){
                $personhelpHistory->user_type = '生徒';
                $personhelpHistory->org_username = $user->ClassOfPupil->school->username;
            }else
                $personhelpHistory->user_type = '一般';
            $personhelpHistory->age = $user->age();
            $personhelpHistory->address1 = $user->address1;
            $personhelpHistory->address2 = $user->address2;
        }
        else{
            $personhelpHistory->username = '非会員';
            $personhelpHistory->user_type = '非会員';
        }
        $personhelpHistory->created_at = now();
        $personhelpHistory->updated_at = now();
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
        $personhelpHistory->device = $device;
        $personhelpHistory->save(); 

       $page_info = [
            'side' =>'about',
            'subside' =>'faq',
            'top' =>'about',
            'subtop' =>'faq',
        ];
        return view('help.faq')
            ->with('page_info',$page_info);
    }

    public function viewpdf(Request $request, $book_index = ''){
        if($book_index === '' || !isset($book_index)){
            $title = '新規会員登録';
            $helpdoc = $request->input("helpdoc");
            $role = $request->input("role");
            $data = json_encode($request->all());
    
            return view('auth.register.viewpdf')
                    ->withTitle($title)
                    ->withHelpdoc($helpdoc)
                    ->withRole($role)
                    ->withPdfheight($request->input("pdfheight"))
                    ->withData($data);
        }
        else{
            $title = '新規会員登録';
            $helpdoc = '\\/\\manual\\/\\'.$book_index.'.pdf';
            $role= 100;
            $data = json_encode($request->all());
        }
        return view('auth.register.viewpdf')
        ->withTitle($title)
        ->withHelpdoc($helpdoc)
        ->withRole($role)
        ->withPdfheight($request->input("pdfheight"))
        ->withData($data);

    }

    public function storepdfheight(Request $request)
    {
        $request->session()->put('pdfheight',$request->input('pdfheight'));
        return response(["status" => "success"]);
    }
}
