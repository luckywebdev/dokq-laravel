<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;
use App\Model\Classes;
use App\Model\Books;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name', 
        'group_yomi',
        'group_roma', 
        'rep_name', 
        'rep_post', 
        'firstname', 
        'lastname', 
        'firstname_yomi', 
        'lastname_yomi', 
        'firstname_roma', 
        'lastname_roma', 
    	'firstname_nick',
    	'firstname_nick_yomi',
    	'lastname_nick',
    	'lastname_nick_yomi',
        'gender', 
        'birthday', 
        'auth_type', 
        'address1', 
        'address2', 
        'address3',
        'address4',
        'address5', 
        'address6', 
        'address7',  
        'address8',
        'address9',
        'address10',              
        'phone', 
        'teacher', 
        'email', 
        'group_type', 
        //'pupil_count', 
        //'teacher_count', 
        'using_purpose', 
        'role', 
        'active',   //0:初期加入  1:正式加入 2:教員が転校されて,準会員になった場合 3:退会 4: after 3months 완전퇴회, 削除 by admin
        'username', 
        'password', 
        'r_password', 
    	't_username',
    	't_password',
        'authfile', 
        'file',
        'authfile_date',
        'certifilename',
        'certifile',
        'certifile_date',
        'myprofilename',
        'myprofile',
        'myprofile_date', 
        'org_id',
        'testable',
        'wifi',
        'ip_address',
        'mask',
        'nat_flag',
        'refresh_token',
        'islogged',
        'image_path',
        'imagepath_date',
        'beforeimage_path',
        'beforeimagepath_date',
        'scholarship',
        'job',
        'about',
        'overseerbook_list',
        'recommend_flag',
        'verifyface_flag',
        'recommend_content',
    	'fullname_is_public',
    	'fullname_yomi_is_public',
    	'gender_is_public',
    	'birthday_is_public',
    	'role_is_public',
    	'address_is_public',
        'address1_is_public',
        'address2_is_public',
    	'username_is_public',
        'groupyomi_is_public',
    	'org_id_is_public',
    	'wishlists_is_public',
    	'mybookcase_is_public',
    	'profile_is_public',
    	'targetpercent_is_public',
        'history_all_is_public',
        'last_report_is_public',
    	'ranking_order_is_public',
    	'passed_records_is_public',
        'point_ranking_is_public',
    	'register_point_ranking_is_public',
    	'register_record_is_public',
    	'quiz_allowed_record_is_public',
    	'book_allowed_record_is_public',
        'article_is_public',
        'overseerbook_is_public',
        'author_readers_is_public',
        'aptitude',
        'passcode',
        'passcode_date',
        'authfile_check',
        'certifile_check',
        'imagepath_check',
        'namepwd_check',
    	'replied_date1',
    	'replied_date2',
    	'replied_date3',
        'replied_date4',
        'paypal_stop_date',
        'escape_date',
        'settlement_date',
        'period',
        'pay_date',
        'pay_content',
        'pay_amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
    ];

    public function fullname(){
        return $this->firstname . ' ' . $this->lastname;
    }
    public function full_furiname(){
        return $this->firstname_yomi . ' ' . $this->lastname_yomi;
    }
    public function fullname_nick(){
        return $this->firstname_nick . ' ' . $this->lastname_nick;
    }
    public function fullname_nick_yomi(){
        return $this->firstname_nick_yomi . ' ' . $this->lastname_nick_yomi;
    }
    public function isGroup(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["GROUP"]);
    }
    public function isGeneral(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["GENERAL"]);
    }
    public function isOverseer(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["OVERSEER"]);
    }
     public function isOverseerAll(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["OVERSEER"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["TEACHER"] 
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["LIBRARIAN"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["REPRESEN"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["ITMANAGER"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["OTHER"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["AUTHOR"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["ADMIN"]);
    }
    public function isTestable(){
        return ($this->getAttribute('testable') == 1);
    }
    public function isAuthor(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["AUTHOR"]);
    }
    public function isTeacher(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["TEACHER"]);
    }
    public function isLibrarian(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["LIBRARIAN"]);
    }
    public function isRepresen(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["REPRESEN"]);
    }
    public function isItmanager(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["ITMANAGER"]);
    }
    public function isOther(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["OTHER"]);
    }
    public function isSchoolMember(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["TEACHER"] 
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["LIBRARIAN"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["REPRESEN"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["ITMANAGER"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["OTHER"] );
    }
    public function isGroupSchoolMember(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["GROUP"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["TEACHER"] 
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["LIBRARIAN"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["REPRESEN"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["ITMANAGER"]
                || $this->getAttribute('role') == config('consts')['USER']['ROLE']["OTHER"] );
    }
    public function isPupil(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["PUPIL"]);
    }
    public function isAdmin(){
        return ($this->getAttribute('role') == config('consts')['USER']['ROLE']["ADMIN"]);
    }
    public function isOverseerOfBook($bookId){
        if(Auth::check() && (Auth::user()->role == config('consts')['USER']['ROLE']['AUTHOR'] || Auth::user()->role == config('consts')['USER']['ROLE']['ADMIN'] )){
            $user = Auth::user(); 
            $cnt = DB::table("books")->where("id", $bookId)
                                     ->where( function ($query) use ($user) {
                                            $query->where('overseer_id', $user->id)
                                                  ->orWhere( function ($query1) use ($user) {
                                                        $query1->where('author_overseer_flag', 1)
                                                               ->where('writer_id', $user->id);
                                                     });     
                                        }) 
                                    ->count();
        }
        else
            $cnt = DB::table("books")->where("overseer_id", $this->id)->where("id", $bookId)->count();
        return $cnt > 0 ? true : false;
    }
    public function isTestOfBook($bookId){
        $cnt = DB::table("user_quizes")->where("user_id", $this->id)->where("book_id", $bookId)->where("type", 2)->count();
        return $cnt > 0 ? true : false;
    }
    public function isQuizMaker($bookId){
        $cnt = DB::table("quizes")->where("register_id", $this->id)->where("book_id", $bookId)->count();
        return $cnt > 0 ? true : false;
    }
    public function isWisher($bookId){
        $cnt = DB::table("wishlists")->where("user_id", $this->id)->where("book_id", $bookId)->count();
        return $cnt > 0 ? true : false;
    }
   
    public function getDateTestPassedOfBook($bookId){
        $userQuiz = DB::table("user_quizes")->where("user_id", $this->id)->where("book_id", $bookId)->where("type", 2)->where("status", 3)->first();
        return ($userQuiz && $userQuiz !== null) ? $userQuiz->finished_date : null;
    }

    public function getViewflag($checked_user){
        $view_flag = 0;
        if(isset($checked_user)){
            if($checked_user->isPupil() && $checked_user->age() < 15 && $checked_user->active == 1){
                $checked_user_class = $checked_user->PupilsClass()->first();
                
                if(Auth::user()->isGroup()){
                    if(Auth::user()->id == $checked_user_class->group_id)
                        $view_flag = 1;
                }else if(Auth::user()->isRepresen() || Auth::user()->isItmanager() || Auth::user()->isOther()){
                    if(Auth::user()->org_id == $checked_user_class->group_id)
                        $view_flag = 1;
                }else if(Auth::user()->isTeacher()){
                    if(Auth::user()->id == $checked_user_class->teacher_id)
                        $view_flag = 1;
                }/*else if(Auth::user()->isPupil()){
                    if(Auth::user()->id == $checked_user->id)
                        $view_flag = 1;
                }*/
            }
        }
    }

    public function getAgeAndBookyear($bookId){
        //      $birthyear = date_format($user->birthday,"Y");
        //      $today = new Date();
        $today = now();
        $birthday=date_create($this->birthday);
        //$diff=date_diff($today,$birthday);
        $age = Date("Y") - date_format($birthday,"Y");
        //$age = $diff->format("%Y");
        if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
            $age -= 1;
        if($birthday <= Carbon::create(date_format($birthday,"Y"), 3, 31,23,59,59))
            $age += 1;

        $book = DB::table("books")->where("id", $bookId)->first();
        
        if ($book->recommend == 8) {
            $tempage = [16,150];
            if($age >= $tempage[0] && $age <= $tempage[1])
                return null;
        }else{
            return null;
        }

        //return $age;
        return null;
    }

    public function getBookyear($bookId){
        //      $birthyear = date_format($user->birthday,"Y");
        //      $today = new Date();
        $today = now();
        $birthday=date_create($this->birthday);
        //$diff=date_diff($today,$birthday);
        $age = Date("Y") - date_format($birthday,"Y");
        //$age = $diff->format("%Y");
        /*if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
            $age -= 1;
        if($birthday <= Carbon::create(date_format($birthday,"Y"), 3, 31,23,59,59))
            $age += 1;*/

        $book = DB::table("books")->where("id", $bookId)->first();
        
        if (isset($book) && $book->recommend == 8) {
            $tempage = [16,150];
            if($age >= $tempage[0] && $age <= $tempage[1])
                return null;
        }else{
            return null;
        }

        return $age;
    }

    public function getEqualBooks($bookId){
        $book = DB::table("books")->where("id", $bookId)->first();
        $tempbooks = DB::table("books")->select('books.point')
                                    ->join('user_quizes','user_quizes.book_id', DB::raw('books.id and user_quizes.type =2 and user_quizes.status=3 and user_quizes.user_id='.$this->id.' and user_quizes.book_id <>'.$bookId))
                                    ->where("books.title", '=', $book->title)
                                    ->where("books.writer_id", '=', $book->writer_id)
                                    ->get();
        foreach ($tempbooks as $key => $tempbook) {
            $temppoint = $tempbook->point + 1.00;
            if($book->point <= $temppoint)
                return $book->point;
        }
        return null;
    }

    public function getBook($bookId){
        //$book = DB::table("books")->where("id", $bookId)->first();
        $book = Books::find($bookId);
        return $book;
    }
    
    //get all groups
    public function scopeGetAllGroups($query){
    	return $query->where('role', config('consts')['USER']['ROLE']["GROUP"])->orderBy("updated_at", "desc")->get();
    }
    
    //get all members: General, Author, Overseer
    public function scopeGetAllPersons($query){
    	return $query->where('role', config('consts')['USER']['ROLE']['GENERAL'])
    				 ->OrWhere('role', config('consts')['USER']['ROLE']['AUTHOR'])
    				 ->OrWhere('role', config('consts')['USER']['ROLE']['OVERSEER'])
    				 ->orderBy("created_at", "desc")->get();
    }

    public function scopeGetAllMembers($query){
        return $query->where('role', config('consts')['USER']['ROLE']['GENERAL'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['AUTHOR'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['OVERSEER'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['TEACHER'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['LIBRARIAN'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['REPRESEN'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['ITMANAGER'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['OTHER'])
                     ->OrWhere('role', config('consts')['USER']['ROLE']['PUPIL'])
                     ->orderBy("created_at", "desc")->get();
    }
    
    public function scopeGetAllOverseers($query){
    	return $query->select("users.*", DB::raw("count(b.id) as book_count"))
            ->leftJoin('books as b','b.overseer_id', DB::raw('users.id and b.active <> 7'))
            ->whereIn('users.role', [config('consts')['USER']['ROLE']['OVERSEER'],
                                    config('consts')['USER']['ROLE']['AUTHOR'], 
                                    config('consts')['USER']['ROLE']['TEACHER'], 
                                    config('consts')['USER']['ROLE']['LIBRARIAN'],
                                    config('consts')['USER']['ROLE']['REPRESEN'],
                                    config('consts')['USER']['ROLE']['ITMANAGER'],
                                    config('consts')['USER']['ROLE']['ADMIN'],
                                    config('consts')['USER']['ROLE']['OTHER']])
            ->where('users.active', 1)
            ->groupBy('users.id')
            ->get();
    }

    public function scopeOverseerBookCount($query) {
        return DB::table("books")->where('active', '<>', 7)->where("overseer_id", $this->id)->count();
    }

    public function scopeOverseerBooks($query, $overseer) {
        $id = $overseer->id;
        if($overseer->role == config('consts')['USER']['ROLE']['AUTHOR'])
            $books = Books::where('overseer_id', $id)
                            ->where('active', '<>', 7)
                            ->orWhere( function ($query) use ($id)  {
                                $query->where('author_overseer_flag', 1)
                                   ->where('writer_id', $id);
                             })
                            ->get();
        else
            $books = Books::where('overseer_id', $id)->where('active', '<>', 7)->orderby('replied_date3', 'desc')->get();
        $bookids_ary = array();
        foreach ($books as $key => $book) {
            array_push($bookids_ary, $book->id);
        }
        return $bookids_ary;
    }

    //registerclasses of the school
    public function registerclasses(){
        $current_season = $this->CurrentSeaon_Pupil(now());
        return $this->hasMany('App\Model\Classes', 'group_id')
            ->select("classes.id", "classes.type","classes.grade","classes.class_number","classes.member_counts","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"))
            ->leftJoin('users as a','classes.teacher_id','=','a.id')
            ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.active=1 and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
            //->where('classes.member_counts','>',0)
            ->where('classes.active','=',1)
            ->where('classes.year', $current_season['year'])
            ->groupBy('classes.id', 'a.firstname', 'a.lastname')
            ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }

    //registerclasses of the school 児童生徒を含めない
    public function registerclasseswithoutpupil(){
        $current_season = $this->CurrentSeaon_Pupil(now());
        return $this->hasMany('App\Model\Classes', 'group_id')
            ->select("classes.id", "classes.type","classes.grade","classes.class_number","classes.member_counts","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"))
            ->leftJoin('users as a','classes.teacher_id','=','a.id')
            ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.active=1 and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
            ->whereIn('classes.type', [0,1,2,3])
            ->where('classes.active','=',1)
            ->where('classes.year', $current_season['year'])
            ->groupBy('classes.id', 'a.firstname', 'a.lastname')
            ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }
    
    //classes of the school
    public function classes(){
        $current_season = $this->CurrentSeaon_Pupil(now());
        return $this->hasMany('App\Model\Classes', 'group_id')
            ->select("classes.id","classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
            ->leftJoin('users as a','classes.teacher_id','=','a.id')
            ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.active=1 and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
            //->where('classes.member_counts','>',0)
            ->where('classes.active','=',1)
            ->where('classes.year', $current_season['year'])
            ->groupBy('classes.id', 'a.firstname', 'a.lastname')
        	->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }

    //wifi of the school
    public function getWifi(){
        return $this->getAttribute('wifi');
    }
    public function age() {
        //return Carbon::parse($this->birthday)->diffInYears(Carbon::now());
           $birthday=date_create($this->birthday);

        $today = now();
        $curage=date('Y')-date_format($birthday,"Y");
        
        if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
            $curage -= 1;
        if($birthday >= Carbon::create(date_format($birthday,"Y"), 4, 1,0,0,0))
            $curage -= 1; 
        
        if($curage >= 15)
            $curage=date('Y')-date_format($birthday,"Y");
               
        return $curage;   
       
     }
    //this means total pupils count of the school
    public function totalMemberCounts(){
    	if($this->registerclasses->count() != 0){
        return $this->registerclasses->sum('member_counts');
    	}else{
    		return $this->pupil_count;
    	}
    }

    //this means total pupils count of the school
    public function nopupiltotalMemberCounts(){
        if($this->registerclasseswithoutpupil->count() != 0){
        return $this->registerclasseswithoutpupil->sum('member_counts');
        }else{
            return $this->pupil_count;
        }
    }

    //this means total pupils count of the school
    public function totalTeacherCounts(){
        $current_season = $this->CurrentSeaon_Pupil(now());
        $teacher_db = $this->hasMany('App\Model\Classes', 'group_id')
            ->select("classes.id", "classes.type","classes.grade","classes.class_number","classes.member_counts","classes.group_id","classes.teacher_id","classes.year", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"))
            ->leftJoin('users as a','classes.teacher_id','=','a.id')
            ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.active=1 and b.role='.config('consts')['USER']['ROLE']['TEACHER']))
            //->where('classes.member_counts','>',0)
            ->where('classes.active','=',1)
            ->where('classes.year', $current_season['year'])
            ->groupBy('classes.id', 'a.firstname', 'a.lastname')->get();
    	if(!is_null($teacher_db) && count($teacher_db) != 0){
            return count($teacher_db);
    	}else{
    		return $this->teacher_count;
    	}
    }
    public function getITmanager($group_id){
        return DB::table('users')
                ->where('org_id', '=', $group_id)
                ->where('role', '=', '7')
                ->first();
    }

    public function groupFeePlan(){
        return $this->totalMemberCounts() * config('consts')['YEAR_FEE'];
    }

    public function nopupilgroupFeePlan(){
        return $this->nopupiltotalMemberCounts() * config('consts')['YEAR_FEE'];
    }

    public function passwordShow(){
        $r_password = $this->r_password;
        $length = strlen($r_password);

        //$laststring =substr_replace($r_password, str_repeat("*", $length - 2), 0 , $length - 2);
        if($length > 2){
            $laststring = "●●●●●●".$r_password[$length-2].$r_password[$length-1];
        }else{
            $laststring = $r_password;
        }
        return $laststring;
    }
    public function ClassOfPupil(){
        return $this->belongsTo('App\Model\Classes', 'org_id');
    }
    public function GroupOfLibrarian(){
        return $this->hasMany('App\Model\Classes', 'teacher_id')->whereNull('class_number');
    }
    //members of the school(teachers librarian)
    public function Members(){
        return $this->hasMany('App\User','org_id');
    }
    //school corresponding to the teacher if user is a teacher
    public function School(){
        return $this->belongsTo('App\User', 'org_id');
    }
    public function SchollTitle(){
        if($this->isGroup()){
            return $this->group_name;
        }elseif($this->isTeacher() || $this->isPupil()){
            return $this->School->group_name;
        }
    }
    // Get Device Type
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
    //classes of the teacher
    public function ClassesOfTeacher($current_season){
        return $this->hasMany('App\Model\Classes','teacher_id')->whereNotNull('class_number')->where('active','=','1')->where('classes.year','=', $current_season['year'])->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }
    //grades of the group
    public function GradesOfGroup($current_season){
        return $this->hasMany('App\Model\Classes','group_id')->whereNotNull('class_number')->where('active','=','1')->where('classes.year','=', $current_season['year'])->groupBy(DB::raw("classes.grade, classes.year"))->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }
    //grades of the teacher
    public function GradesOfTeacher($current_season){
        return $this->hasMany('App\Model\Classes','teacher_id')->whereNotNull('class_number')->where('active','=','1')->where('classes.year','=', $current_season['year'])->groupBy(DB::raw("classes.grade, classes.year"))->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }
    //grades of the school
    public function GradesOfSchool($current_season){
        return $this->hasMany('App\Model\Classes','org_id')->whereNotNull('class_number')->where('active','=','1')->where('classes.year','=', $current_season['year'])->groupBy(DB::raw("classes.grade, classes.year"))->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc');
    }
    //classes of the librarian
    public function SchoolOfLibrarian(){
        return $this->hasMany('App\Model\Classes','teacher_id')->whereNull('class_number')->where('active','=','1');
    }
    
    //classes of the vice_teacher
    //public function ClassesOfViceTeacher(){
    //    return $this->hasMany('App\Model\Classes','teacher_id');
    //}
    
    // public function Teacher_History(){
    //     return Classes::RecentClasses($this->id);
    // }
    ////////////////search pupil engine////////////////////
    public function scopeSearchPupilByClass($query, $class_id){
        return $query->where( function ($query) use ($class_id) {
                $query->where('org_id', '=', $class_id);
                })->where('role', '=', config('consts')['USER']['ROLE']["PUPIL"])
                ->orderBy('created_at', 'desc');
    }
    //define if teacher is teacher of the corresponding class
    public function isChargeClass($class){
        return $this->id == $class->teacher_id;
    }
    
    public function PupilsClass(){
        return $this->belongsTo('App\Model\Classes', 'org_id');
    }

    public function GetTeacher($pupil_org_id){
        return DB::table('classes')
            ->select('users.*')
            ->where('classes.id', $pupil_org_id)
            ->join('users', 'classes.teacher_id', '=', 'users.id')->first();
    } 

    public function SuccessPoints(){

        return $this->hasMany('App\Model\UserQuiz', 'user_id')
            ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
            ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('user_quizes.type', '=', 0)->where('user_quizes.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('user_quizes.type', '=', 1)->where('user_quizes.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('user_quizes.type', '=', 2)->where('user_quizes.status', '=', 3);
                });
            });
    }

    public function SuccessQuizPoints($fromyear,$fromM,$fromD,$toyear,$toM,$toD){

        return $this->hasMany('App\Model\UserQuiz', 'user_id')
        ->select(DB::raw('SUM(user_quizes.point) AS sum'))
        ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
        ->whereBetween('created_date',array(Carbon::create($fromyear, $fromM,$fromD,0,0,0), Carbon::create($toyear, $toM, $toD,23,59,59)))
            ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('user_quizes.type', '=', 0)->where('user_quizes.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('user_quizes.type', '=', 1)->where('user_quizes.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('user_quizes.type', '=', 2)->where('user_quizes.status', '=', 3);
                });
            });
    }
    
    public function SuccessQuizPoints1($fromyear,$fromM,$fromD,$toyear,$toM,$toD){

        return $this->hasMany('App\Model\UserQuiz', 'user_id')
                ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
                ->whereBetween('created_date',array(Carbon::create($fromyear, $fromM,$fromD,0,0,0), Carbon::create($toyear, $toM, $toD,23,59,59)))
                ->where( function ($q) {
                    $q->Where(function ($q1) {
                        $q1->where('user_quizes.type', '=', 0)->where('user_quizes.status', '=', 1);                    
                    })->orWhere(function ($q1) {
                        $q1->where('user_quizes.type', '=', 1)->where('user_quizes.status', '=', 1);
                    })->orWhere(function ($q1) {
                        $q1->where('user_quizes.type', '=', 2)->where('user_quizes.status', '=', 3);
                    });
                });
    }
	
	public function QuizStatus(){
    	return $this->hasMany('App\Model\UserQuiz', 'user_id')
                    ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
                    ->orderBy('user_quizes.created_date','desc');
    }
    
    public function WishLists(){
    	return $this->hasMany('App\Model\WishLists','user_id')
                    ->join('books', 'wishlists.book_id', DB::raw('books.id and books.active <> 7')) 
                    ->orderBy('wishlists.created_at','desc');
    }

    public function WishbookdateStatus($user_id){
       
        return DB::table('wishlists')
                    ->join('books', 'wishlists.book_id', DB::raw('books.id and books.active <> 7')) 
                    ->where('wishlists.user_id', $user_id)
                    ->whereNotNull('wishlists.finished_date')
                    ->orderBy('wishlists.created_at','desc');
    }

    static function Countgradepupils(){
    	$pupils = DB::table('users')
    				->select('users.id')
    				->join('classes', 'users.org_id','=','classes.id')
    				->where('users.role',config('consts')['USER']['ROLE']['PUPIL'])
                    ->where('users.active',1)
     				->where('classes.group_id', Auth::user()->PupilsClass->group_id)
    				->where('classes.grade', Auth::user()->PupilsClass->grade);
    	return $pupils->count();
    }
    static function Countgradepupils1($group_id, $grade){
        $pupils = DB::table('users')
                    ->select('users.id')
                    ->join('classes', 'users.org_id','=','classes.id')
                    ->where('users.role',config('consts')['USER']['ROLE']['PUPIL'])
                    ->where('users.active',1)
                    ->where('classes.group_id', $group_id)
                    ->where('classes.grade', $grade);

        return $pupils->count();
    }
    static function Countclasspupil1($org_id){
        $pupils = DB::table('users')
                    ->select('users.id')
                    ->where('org_id', $org_id)
                    ->where('users.role',config('consts')['USER']['ROLE']['PUPIL'])
                    ->where('users.active',1);
                
        return $pupils->count();
    }
    static function groupbyClass($group_id){
       return DB::table('users')
                ->select('id', 'address1', 'address2')
                ->where('users.id',$group_id);
    }
    static function scopeGroupsbycity($query,$group_id, $type){
       /* select id from `users` where `users`.`address2` = (select `address2` from `users` where `users`.`id` = 2) 
        and `users`.`address1` = (select `address1` from `users` where `users`.`id` = 2)  
        and `users`.`active` = 1 and `users`.`role` = 0 and `users`.`group_type` = 0*/
       return $query
                ->where('users.address2',DB::raw('(SELECT address2 FROM users WHERE users.id = "'.$group_id.'")'))
                ->where('users.address1',DB::raw('(SELECT address1 FROM users WHERE users.id = "'.$group_id.'")'))
                ->where('users.active',1)
                ->where('users.role',config('consts')['USER']['ROLE']["GROUP"])
                ->where('users.group_type',$type);
    }
    static function scopecitypupils1($query,$group,$grade){
        return $query->join('classes', 'users.org_id','=','classes.id')
                    ->where('role', config('consts')['USER']['ROLE']['PUPIL'])
                    ->where('active', 1)
                    ->where('classes.group_id','=',$group->id)
                    ->where('classes.grade','=',$grade);
    }
    static function scopeGroupsbyprovince($query,$group_id, $type){
       /* select id from `users` where `users`.`address1` = (select `address1` from `users` where `users`.`id` = 2)  
        and `users`.`active` = 1 and `users`.`role` = 0 and `users`.`group_type` = 0*/
       return $query
                ->where('users.address1',DB::raw('(SELECT address1 FROM users WHERE users.id = "'.$group_id.'")'))
                ->where('users.active',1)
                ->where('users.role',config('consts')['USER']['ROLE']["GROUP"])
                ->where('users.group_type',$type);
    }

    static function scopeGroupsbycountry($query,$group_id, $type){
       /* select id from `users` where `users`.`address1` = (select `address1` from `users` where `users`.`id` = 2)  
            and `users`.`active` = 1 and `users`.`role` = 0 and `users`.`group_type` = 0*/
       return $query
                ->where('users.active',1)
                ->where('users.role',config('consts')['USER']['ROLE']["GROUP"])
                ->where('users.group_type',$type);
    }
  
    static function Countusers_byage($rankingage, $grade=null){
    	
    	$users = User::where('users.role', '<>', config('consts')['USER']['ROLE']['GROUP'])
                        ->where('users.role', '<>', config('consts')['USER']['ROLE']['ADMIN']);
        $today = now();
    	switch($rankingage)
   		{
             case "1":
                $users = $users->join('classes','classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))->where('users.role','=',config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null)
                    $users = $users->where('classes.grade','=',$grade);
                break;
            case "2":
                $users = $users->join('classes','classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))->where('users.role','=',config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null)
                    $users = $users->where('classes.grade','=',$grade);
                break;
            case "3":
                $users = $users->join('classes','classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))->where('users.role','=',config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null)
                    $users = $users->where('classes.grade','=',$grade);
                break;
            case "4":
                $users = $users->join('classes','classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))->where('users.role','=',config('consts')['USER']['ROLE']['PUPIL']);
                if($grade !== null)
                    $users = $users->where('classes.grade','=',$grade);
                break;
            case "5":
                /*if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-10), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-9), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")), 3, 31), "Y-m-d")));*/
                $users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-9), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")), 12, 31), "Y-m-d")));
                break;  			
    		case "6":
    			/*if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-20), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-10), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-9), 3, 31), "Y-m-d")));*/
                $users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-10), 12, 31), "Y-m-d")));
                break;
    		case "7":
    			/*if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-20), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-19), 3, 31), "Y-m-d")));*/
                $users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                break;
    		case "8":
    			$users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
    			break;    			
    		case "9":
    			$users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
    			break;    			
    		case "10":
    			$users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
    			break;    			
    		case "11": 
    			$users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
    			break;
    		case "12":
    			$users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
    			break;
    		case "13":
    			$users = $users->whereBetween('users.birthday',array(date_format(Carbon::createFromDate((Date("Y")-89), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
    			break;
   		}
        
   		return $users;
    }

    public function scopegetUsersbyClass($query, $class_id){
        $pupils = $query->where('users.role',config('consts')['USER']['ROLE']['PUPIL'])
                    ->where('users.org_id', $class_id)
                    ->orderBy(DB::raw("users.firstname_yomi, users.lastname_yomi"), 'asc')
                    ->where('active',1);
        return $pupils;
    }

    public function identify_teacher_position($school_ip, $school_mask)
    {
        $local_ip = \Request::ip();
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
        return $ip_check;
    }

    //wifi_flag- 0: 学校WiFi外(不) 1: 学校WiFi下(合格)
    public function getWifiFlag(){
        $wifi_flag = 0;
        if (Auth::user()->isGroup() && Auth::user()->active == 1){
            $school = Auth::user();
            $school_ip = $school->ip_address;
            $school_mask = $school->mask;
            // if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
            if(Auth::user()->identify_teacher_position($school_ip, $school_mask))
                $wifi_flag = 1;  
        }else if(Auth::user()->isLibrarian() && Auth::user()->active == 1){
            $recs = Auth::user()->SchoolOfLibrarian;
            foreach ($recs as $key => $value) {
                $school = Classes::getSchoolByGroupId($value->group_id);
                $school_ip = $school->ip_address;
                $school_mask = $school->mask;
                    // if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
                    if(Auth::user()->identify_teacher_position($school_ip, $school_mask))
                        $wifi_flag = 1;

                if($wifi_flag == 1)
                    break; 
            }
        }else if(Auth::user()->isSchoolMember() && Auth::user()->active == 1){
            $school = Auth::user()->School;
            $school_ip = $school->ip_address;
            $school_mask = $school->mask;
            // if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
            if(Auth::user()->identify_teacher_position($school_ip, $school_mask))
                        $wifi_flag = 1;
        }else if(Auth::user()->isPupil() && Auth::user()->active == 1){
            $class = Auth::user()->ClassOfPupil;
            $school =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $class->group_id)
                           ->first();
            $school_ip = $school->ip_address;
            $school_mask = $school->mask;
            // if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
            if(Auth::user()->identify_teacher_position($school_ip, $school_mask))
                $wifi_flag = 1;
        }   
        
        //temperary
        $wifi_flag = 1;
        return $wifi_flag;

        /*$wifi_flag = 0; 
        if (Auth::user()->isGroup() && Auth::user()->active == 1){
            $school = Auth::user();
            if($school->nat_flag == 1){
                if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
                    $wifi_flag = 1; 
            }else{
                
                $mask = $school->mask;
                $mask_ary = explode (".", $mask);
                $ip_global_address = $school->ip_global_address;
                $ip_address_ary = explode (".", $ip_global_address);
                $remote_address = $_SERVER['REMOTE_ADDR'];
                $remote_address_ary = explode (".", $remote_address);

                $flag = 0;
                foreach ($mask_ary as $key => $value) {
                    if($value != 0 && $value != '0' && $value != ''){
                        if(isset($ip_address_ary[$key]) && isset($remote_address_ary[$key])){
                            if($ip_address_ary[$key] == $remote_address_ary[$key]){
                                $flag = 1;
                            }else{
                                $flag = 0;
                                break; 
                            }
                        }else{
                           $flag = 0;
                           break; 
                        }
                    }else{
                        break;
                    }
                }
                if($flag == 1) $wifi_flag = 1;
            }
        }else if(Auth::user()->isLibrarian() && Auth::user()->active == 1){
            $recs = Auth::user()->SchoolOfLibrarian;
            foreach ($recs as $key => $value) {
                $school = Classes::getSchoolByGroupId($value->group_id);
                if($school->nat_flag == 1){
                    if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
                        $wifi_flag = 1; 
                }else{
                   
                    $mask = $school->mask;
                    $mask_ary = explode (".", $mask);
                    $ip_global_address = $school->ip_global_address;
                    $ip_address_ary = explode (".", $ip_global_address);
                    $remote_address = $_SERVER['REMOTE_ADDR'];
                    $remote_address_ary = explode (".", $remote_address);

                    $flag = 0;
                    foreach ($mask_ary as $key => $value) {
                        if($value != 0 && $value != '0' && $value != ''){
                            if(isset($ip_address_ary[$key]) && isset($remote_address_ary[$key])){
                                if($ip_address_ary[$key] == $remote_address_ary[$key]){
                                    $flag = 1;
                                }else{
                                    $flag = 0;
                                    break; 
                                }
                            }else{
                               $flag = 0;
                               break; 
                            }
                        }else{
                            break;
                        }
                    }
                    if($flag == 1) $wifi_flag = 1;
                }

                if($wifi_flag == 1)
                    break;
            }
        }else if(Auth::user()->isSchoolMember() && Auth::user()->active == 1){
            $school = Auth::user()->School;

            if($school->nat_flag == 1){
                if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
                    $wifi_flag = 1; 
            }else{
                
                $mask = $school->mask;
                $mask_ary = explode (".", $mask);
                $ip_global_address = $school->ip_global_address;
                $ip_address_ary = explode (".", $ip_global_address);
                $remote_address = $_SERVER['REMOTE_ADDR'];
                $remote_address_ary = explode (".", $remote_address);

                $flag = 0;
                foreach ($mask_ary as $key => $value) {
                    if($value != 0 && $value != '0' && $value != ''){
                        if(isset($ip_address_ary[$key]) && isset($remote_address_ary[$key])){
                            if($ip_address_ary[$key] == $remote_address_ary[$key]){
                                $flag = 1;
                            }else{
                                $flag = 0;
                                break; 
                            }
                        }else{
                           $flag = 0;
                           break; 
                        }
                    }else{
                        break;
                    }
                }
                if($flag == 1) $wifi_flag = 1;
            }
        }else if(Auth::user()->isPupil() && Auth::user()->active == 1){
            $class = Auth::user()->ClassOfPupil;
            $school =DB::table('users')
                           ->select('*')
                           ->where('id', '=', $class->group_id)
                           ->first();
            if($school->nat_flag == 1){
                if($_SERVER['REMOTE_ADDR'] == $school->ip_address)
                    $wifi_flag = 1; 
            }else{
                
                $mask = $school->mask;
                $mask_ary = explode (".", $mask);
                $ip_global_address = $school->ip_global_address;
                $ip_address_ary = explode (".", $ip_global_address);
                $remote_address = $_SERVER['REMOTE_ADDR'];
                $remote_address_ary = explode (".", $remote_address);

                $flag = 0;
                foreach ($mask_ary as $key => $value) {
                    if($value != 0 && $value != '0' && $value != ''){
                        if(isset($ip_address_ary[$key]) && isset($remote_address_ary[$key])){
                            if($ip_address_ary[$key] == $remote_address_ary[$key]){
                                $flag = 1;
                            }else{
                                $flag = 0;
                                break; 
                            }
                        }else{
                           $flag = 0;
                           break; 
                        }
                    }else{
                        break;
                    }
                }
                if($flag == 1) $wifi_flag = 1;
            }
        }

        return $wifi_flag;*/
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
