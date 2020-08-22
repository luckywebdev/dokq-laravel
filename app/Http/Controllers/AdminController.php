<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Error\Notice;
use Redirect;
use Auth;
use View;
use App\User;
use App\Model\Books;
use App\Model\Advertise;
use App\Model\Article;
use App\Model\Angate;
use App\Model\Demand;
use App\Model\Categories;
use App\Model\Classes;
use App\Model\Messages;
use App\Model\Notices;
use App\Model\UserQuiz;
use App\Model\UserQuizesHistory;
use App\Model\PupilHistory;
use App\Model\TeacherHistory;
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
use App\Model\CertiBackup;
use App\Model\AccessHistory;
use App\Model\LoginHistory;
use App\Model\PwdHistory;
use App\Model\Quizes;
use App\Model\Vote;
use App\Model\QuizesTemp;
use App\Model\ReportBackup;
use App\Model\ReportGraphBackup;
use App\Model\WishLists;
use App\Model\BookCategory;
use App\Http\Controllers\GroupController;
use Carbon\Carbon;
use DB;
use App\Mail\UserescapeByadmin;
use App\Mail\Unsubscribe;
use App\Mail\Answer;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

use App\Export\PHPExcel_Output;
class AdminController extends Controller
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
        'side' =>'aa',
        'subside' =>'aaa',
        'top' =>'home',
        'subtop' =>'home',
    ];
    public function reg_group_list(){
        $this->page_info['side'] = 'reg_list';
        $this->page_info['subside'] = 'reg_group_list';
        //$users = User::getAllGroups();
        $users = User::where('active', '=', 0)
                        ->where('role', config('consts')['USER']['ROLE']['GROUP'])
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('admin.reg_group_list')
            ->with('page_info', $this->page_info)
            ->withUsers($users);
    }
    public function reg_person_list(){
        $this->page_info['side'] = 'reg_list';
        $this->page_info['subside'] = 'reg_person_list';
        $users = User::where('active', '=', 0)
                        ->whereIn('role', [config('consts')['USER']['ROLE']['GENERAL'],
                                    config('consts')['USER']['ROLE']['OVERSEER'],
                                    config('consts')['USER']['ROLE']['AUTHOR'], 
                                    config('consts')['USER']['ROLE']['TEACHER'], 
                                    config('consts')['USER']['ROLE']['LIBRARIAN'],
                                    config('consts')['USER']['ROLE']['REPRESEN'],
                                    config('consts')['USER']['ROLE']['ITMANAGER'],
                                    config('consts')['USER']['ROLE']['PUPIL'],
                                    config('consts')['USER']['ROLE']['OTHER']]);
        
        $users = $users->orwhere('active', '=', 1)
                        ->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("2 weeks")))
                        ->orderBy('created_at', 'desc');
                        $users = $users->get();
                        
        return view('admin.reg_person_list')
            ->with('page_info', $this->page_info)
            ->withUsers($users);
    }
    public function unsubscribe_list(){
        $this->page_info['side'] = 'unsubscribe';
        $this->page_info['subside'] = 'unsubscribe';
        $users = User::where('active', '=', 3)
                        ->where('r_password', '=', 'sayonaradq')
                        ->where('unsubscribe_date', '=', null)
                        ->orwhere('unsubscribe_date', '>=', date_sub(date_create(date("Y-n-d")), date_interval_create_from_date_string("2 weeks")))
                        ->whereIn('role', [config('consts')['USER']['ROLE']['GENERAL'],
                                    config('consts')['USER']['ROLE']['OVERSEER'],
                                    config('consts')['USER']['ROLE']['AUTHOR'], 
                                    config('consts')['USER']['ROLE']['TEACHER'], 
                                    config('consts')['USER']['ROLE']['LIBRARIAN'],
                                    config('consts')['USER']['ROLE']['REPRESEN'],
                                    config('consts')['USER']['ROLE']['ITMANAGER'],
                                    config('consts')['USER']['ROLE']['PUPIL'],
                                    config('consts')['USER']['ROLE']['GROUP'],
                                    config('consts')['USER']['ROLE']['OTHER']])
                        ->orderBy(DB::raw('users.unsubscribe_date desc, users.escape_date'), 'desc');

        $users = $users->leftjoin('certi_backup', 'users.id', '=', 'user_id')
                        ->select(DB::raw('users.*, certi_backup.level'))
                        ->orderBy('unsubscribe_date', 'desc')
                        ->get();
        
                        
        return view('admin.unsubscribe_list')
            ->with('page_info', $this->page_info)
            ->withUsers($users);
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

    public function unsubscribe_email(Request $request, $user_id = null){
        $user = User::where('id', '=', $user_id)
                        ->first();
        if(isset($user)){

            try{
                Mail::to($user)->send(new Unsubscribe($user));
                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = $admin->id;
                $personadminHistory->username = $admin->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 20;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '退会完了';
                $personadminHistory->save();
                $user->unsubscribe_date = now();
                $user->save();
            }catch(Swift_TransportException $e){
                return Redirect::back()
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                    ->withInput();
            }
            return Redirect::back();
        }

    }
    public function pay_list(Request $request){
        $this->page_info['side'] = 'pay_list';
        $this->page_info['subside'] = 'pay_list';
        $users = PersonworkHistory::whereRaw('person_work_history.id IN (select MAX(id) FROM person_work_history WHERE `pay_point` <> 0 GROUP BY user_id ORDER BY id DESC)')
                                    ->orderBy('id', 'desc');
                                    // ->get();

        $users = $users->leftjoin('users', 'users.id', DB::raw('user_id'))
                        ->leftjoin('certi_backup', 'users.id', '=', 'certi_backup.user_id')
                        ->select(DB::raw('users.*, person_work_history.created_at, person_work_history.pay_point, person_work_history.content, certi_backup.level, certi_backup.passcode as passcodes'))
                        ->get();

        return view('admin.pay_list')
            ->with('page_info', $this->page_info)
            ->withUsers($users);
    }

    public function reg_overseer_list(){
        $this->page_info['side'] = 'reg_list';
        $this->page_info['subside'] = 'reg_overseer_list';
        $users = User::where('recommend_flag', 1)->orderBy('created_at', 'desc')->get();
        return view('admin.reg_overseer_list')
            ->with('page_info', $this->page_info)
            ->withUsers($users);
    }
    public function can_book_list(){
        $this->page_info['side'] = 'can_list';
        $this->page_info['subside'] = 'can_book_list';
        $books = Books::whereBetween('active', [1,6])->orderby('created_at', 'desc')->get();
        return view('admin.can_book_list')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }
    public function can_book_a($book_id){
        $this->page_info['side'] = 'can_list';
        $this->page_info['subside'] = 'can_book_a';
        $book = Books::find($book_id);
        $categories = Categories::all();
        if(!$book){
            return response("Unauthorized", 404);
        }

        return view('admin.can_book_a')
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->withCategories($categories);
    }

    public function do_can_book_a(Request $request){
        $rule = array(
            'type' => 'required',
            'title' => 'required',
            'title_furi' => 'required',
            //            'cover_img' => 'required',
            'firstname_nick' => 'required',
            'lastname_nick' => 'required',
            'firstname_yomi' => 'required',
            'lastname_yomi' => 'required',
            //'isbn' => 'required|unique:books',
            'categories' => 'required|max:4',
            'recommend' => 'required',
            'total_chars' => 'required',
            'register_visi_type' => 'required'
        );

        if($request->input('type') == 0){
            $rule['max_rows'] = 'required|min:1';
            $rule['max_chars'] = 'required';
            $rule['pages'] = 'required';
            $rule['max_rows'] = 'required';
            $rule['entire_blanks'] = 'required';
            $rule['quarter_filled'] = 'required';
            $rule['half_blanks'] = 'required';
            $rule['quarter_blanks'] = 'required';
            $rule['p30'] = 'required';
            $rule['p50'] = 'required';
            $rule['p70'] = 'required';
            $rule['p90'] = 'required';
            $rule['p110'] = 'required';
            $book_chk = Books::where('active', 0)
                        ->where('isbn', $request->input('isbn'))->get();
            if($book_chk && count($book_chk) > 0){
                Books::where('active', 0)
                        ->where('isbn', $request->input('isbn'))
                        ->update(['isbn' => '']);

            }

            if($request->input('book_id')!=""){
                $rule['isbn'] = 'required|unique:books,isbn,'. $request->input('book_id');
            }else{
                $rule['isbn'] = 'required|unique:books';
            }
            $rule['publish'] = 'required';
        }else{
            $rule['total_chars'] = 'required';
            $isbn = $request->input('isbn');
            if(isset($isbn) && $isbn != ''){
                $book_chk = Books::where('active', 0)
                            ->where('isbn', $isbn)->get();
                if($book_chk && count($book_chk) > 0){
                    Books::where('active', 0)
                            ->where('isbn', $isbn)
                            ->update(['isbn' => '']);

                }
                if($request->input('book_id')!=""){
                    $rule['isbn'] = 'required|unique:books,isbn,'. $request->input('book_id');
                }else{
                    $rule['isbn'] = 'required|unique:books';
                }
            }
        }
        $messages = array(
            'required' => '入力してください。',
            'type.required' => '選択してください。',
            'categories.required' => '選択してください。',
            'recommend.required' => '選択してください。',
            'register_visi_type.required' => '選択してください。',
            'isbn.unique' => 'この本は、既に他の人が登録申請をしているため登録できません。',
            'categories.max' => '4つまで選択できます。'
        );
      
       //却下本
         if($request->input('title') !== null && $request->input('firstname_nick') !== null && $request->input('lastname_nick') !== null)
            $bookout = Books::where('firstname_nick','=',$request->input('firstname_nick'))->where('lastname_nick','=',$request->input('lastname_nick'))->where('title','=', $request->input('title'))->where('active', 2)
                           ->get();
           
        if (isset($bookout) && count($bookout)>0){
            return Redirect::back()
                ->withErrors(["bookouterr" => config('consts')['MESSAGES']['BOOKOUT_UNIQUE']])->withInput()
                ->with("act", "confirm");
        }

        $validator = Validator::make($request->all(), $rule, $messages);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput()->with("act", "confirm");
        }

        $answer = $request->input("answer");
        $reason1= $request->input("reason1");
        $reason2= $request->input("reason2");
        $book = Books::find($request->input("book_id"));
        $book->image_url = $request->input('image_url');
        $book->rakuten_url = $request->input('rakuten_url');
        $book->honto_url = $request->input('honto_url');
        $book->seven_net_url = $request->input('seven_net_url');

        if(!$book){
            return response("Unauthorized", 404);
        }
        $book_old_active = $book->active;
        $book->categories()->detach();
        $book->categories()->attach($request->input('categories'));

        $file = $request->file('cover_img');
        if($file) { // && $file->isValid()
            /*$ext = $file->getClientOriginalExtension();
            $now = date('YmdHis');
            $filename = md5($now . $file->getClientOriginalName()) . '.' . $ext;
            $url = 'uploads/books/'. $book->id;
            $file->move($url , $filename);
            $book->cover_img = $url . '/' . $filename ;*/

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
                $url = 'uploads/books/'. $book->id;
                if(file_exists($book->cover_img) && $book->cover_img != '' && $book->cover_img !== null)  unlink($book->cover_img); //remove before file
                //upload file
                $file->move($url, $filename);
                $book->cover_img = $url . '/' . $filename ;
            }
        }

        if($answer == 1 || $answer == 3) {
            //accept book
            $book->active = 3;
            if($answer == 3)
                $book->recommend_flag = date_format(now(),"Y-m-d");
            else
                $book->recommend_flag = null;

            $book->replied_date1 = now();
            if($book->point <= 3.0)
                $book->quiz_count = 8;
            elseif ($book->point <= 7.0) 
                $book->quiz_count = 10;
            elseif ($book->point <= 12.0) 
                $book->quiz_count = 12;
            elseif ($book->point <= 15.0) 
                $book->quiz_count = 15;
            elseif ($book->point <= 24.0) 
                $book->quiz_count = 18;
            else
                $book->quiz_count = 20;

            $author = User::where('firstname_nick', $book->firstname_nick)->where('lastname_nick', $book->lastname_nick)->where('role', config('consts')['USER']['ROLE']['AUTHOR'])->where('users.active','>=', 1)->first();
            if($author){
                $book->writer_id = $author->id;
            }
            $book->save();

            $message = new Messages;
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = $book->register_id;
            $message->name = "協会";
            $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_BOOK_ACCEPT'],
                "<a href='/book/".$book->id."/detail'>".$book->title."</a>");
            $message->save();

            $beforebookRegister_totalpoint = 0;
            if(isset($book->Register) && $book->Register !== null && $book->register_id != 0)
                $beforebookRegister_totalpoint = UserQuiz::TotalPoint($book->Register->id);
            $beforebookRegister_rank = 10;
            
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
                if ($beforebookRegister_totalpoint >= $ranks[$i] && $beforebookRegister_totalpoint < $ranks[$i - 1]) {
                    $beforebookRegister_rank = $i;
                }
            }
            
            //accept user quiz
            if(isset($book->Register) && $book->Register !== null && $book->register_id != 0)
                $activity = UserQuiz::where('book_id', $book->id)
                    ->where('user_id', $book->Register->id)
                    ->where('type', 0)->first();
            if(isset($activity) && $activity !== null){
                $activity->status =  1;
                $activity->finished_date = now();
                $activity->created_date = date_create($activity->created_date);
                $activity->point = floor($book->point * 0.1 * 100) / 100;
                $activity->save();

                //create quiz history
                $userquiz_history = new UserQuizesHistory();
                $userquiz_history->user_id = $activity->user_id;
                $userquiz_history->book_id = $activity->book_id;
                $userquiz_history->type = $activity->type;
                $userquiz_history->status = 1;         
                $userquiz_history->point = $activity->point;
                $userquiz_history->created_date = now();
                $userquiz_history->finished_date = now();
                $userquiz_history->published_date = $activity->published_date;
                $userquiz_history->save();

                $afterbookRegister_totalpoint = 0;
                if(isset($book->Register) && $book->Register !== null && $book->register_id != 0)
                    $afterbookRegister_totalpoint = UserQuiz::TotalPoint($book->Register->id);
                $afterbookRegister_rank = 10;
            
                for ($i = 0; $i < 11; $i++) {
                    if ($afterbookRegister_totalpoint >= $ranks[$i] && $afterbookRegister_totalpoint < $ranks[$i - 1]) {
                        $afterbookRegister_rank = $i;
                    }
                }
                //昇級
                if($afterbookRegister_rank < $beforebookRegister_rank){
                    if($book->register_id != 0 && $book->register_id !== null){
                        $message1 = new Messages;
                        $message1->type = 0;
                        $message1->from_id = 0;
                        $message1->to_id = $book->register_id;
                        $message1->name = "協会";
                        $message1->content = config('consts')['MESSAGES']['AUTOMSG_LEVEL_UP'];
                        $message1->save();

                        /*$bookregister = User::find($book->register_id);
                        if(isset($bookregister) && $bookregister->isPupil() && $bookregister->active == 1){
                            $classes = $bookregister->PupilsClass;
                            
                            $pupil_history = new PupilHistory();
                            $pupil_history->pupil_id = $bookregister->id;
                            $pupil_history->group_name = $afterbookRegister_rank.'級';
                            
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
                        }*/
                    }
                }
            }
            //book
            $PersonquizHistory = new PersonquizHistory();
            $PersonquizHistory->user_id = $book->register_id;
            if($book->register_id != 0 && $book->register_id !== null){
                $PersonquizHistory->username = User::find($book->register_id)->username;
                $PersonquizHistory->age = User::find($book->register_id)->age();
            }
            $PersonquizHistory->item = 0;
            $PersonquizHistory->work_test = 1;
            
            $PersonquizHistory->book_id = $book->id;
            $PersonquizHistory->quiz_point = floor($book->point * 100) / 100;
            $cur_point = UserQuiz::TotalPoint($book->register_id);
            if(isset($cur_point) && $cur_point !== null)
                $PersonquizHistory->point = floor($cur_point*100)/100;
            else
                $PersonquizHistory->point = 0;

            $PersonquizHistory->rank = 10;
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
              if ($PersonquizHistory->point >= $ranks[$i] && $PersonquizHistory->point < $ranks[$i - 1]) {
                  $PersonquizHistory->rank = $i;
               }
            }
            $PersonquizHistory->title = $book->title;
            $PersonquizHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
            //$PersonquizHistory->isbn = $book->isbn;
            $PersonquizHistory->save();

            //admin
            $personadminHistory = new PersonadminHistory();
            $personadminHistory->user_id = Auth::id();
            $personadminHistory->username = Auth::user()->username;
            $personadminHistory->item = 0;
            $personadminHistory->work_test = 2;
            $personadminHistory->book_id = $book->id;
            if($book->register_id != 0 && $book->register_id !== null)
                $personadminHistory->bookregister_name = User::find($book->register_id)->username;
            $personadminHistory->title = $book->title;
            $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
            $personadminHistory->save();

            return redirect('/admin/can_book_list');
        } else {
            if($reason1 == 3 && (!$reason2 || $reason2 == '')) {
                return Redirect::back()->withInput()->with('noreason', true);
            } else {
                //reject book with reason
                $book->active = 2;
                $book->reason1 = $reason1;
                if($reason1 == 1) {
                    $book->reason2 = '既に登録されている';
                } else if($reason1 == 2) {
                    $book->reason2 = '読Q本の規定外';
                } else {
                    $book->reason2 = $reason2;
                }
                $book->replied_date1 = now();
                $book->save();

                $message = new Messages;
                $message->type = 0;
                $message->from_id = 0;
                $message->to_id = $book->register_id;
                $message->name = "協会";
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_BOOK_REJECT'],
                    date_format($book->updated_at, 'm月d日'),
                    "<a>".$book->title."</a>",
                    $reason2);
                $message->save();

                if(isset($book->Register) && $book->Register !== null && $book->register_id != 0)
                    $activity = UserQuiz::where('book_id', $book->id)
                        ->where('user_id', $book->Register->id)
                        ->where('type', 0)->first();
                if(isset($activity) && $activity !== null) {
                    $activity->status = 2;
                    $activity->point = 0;
                    $activity->created_date = date_create($activity->created_date);
                    $activity->save();

                    //create quiz history
                    $userquiz_history = new UserQuizesHistory();
                    $userquiz_history->user_id = $activity->user_id;
                    $userquiz_history->book_id = $activity->book_id;
                    $userquiz_history->type = $activity->type;
                    $userquiz_history->status = 2;
                    if($book_old_active == 3)
                        $userquiz_history->point = 0 - floor($book->point * 0.1 * 100) / 100;
                    else       
                        $userquiz_history->point = 0;
                    $userquiz_history->finished_date = now();
                    $userquiz_history->published_date = $activity->published_date;
                    //$userquiz_history->created_date = $activity->created_date;
                    $userquiz_history->created_date = now();
                    $userquiz_history->save();
                }
                //remove all quizes which is related with book
                Quizes::where('book_id', $book->id)->delete();
                //book
                $PersonquizHistory = new PersonquizHistory();
                $PersonquizHistory->user_id = $book->register_id;
                if($book->register_id != 0 && $book->register_id !== null){
                   $PersonquizHistory->username = User::find($book->register_id)->username;
                   $PersonquizHistory->age = User::find($book->register_id)->age();
                }
                $PersonquizHistory->item = 0;
                $PersonquizHistory->work_test = 2;
                $PersonquizHistory->book_id = $book->id;
                $PersonquizHistory->quiz_point = floor($book->point * 100) / 100;

                $cur_point = UserQuiz::TotalPoint($book->register_id);
                if(isset($cur_point) && $cur_point !== null)
                    $PersonquizHistory->point = floor($cur_point*100)/100;
                else
                    $PersonquizHistory->point = 0;

                $PersonquizHistory->rank = 10;
                $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                for ($i = 0; $i < 11; $i++) {
                  if ($PersonquizHistory->point >= $ranks[$i] && $PersonquizHistory->point < $ranks[$i - 1]) {
                      $PersonquizHistory->rank = $i;
                   }
                }
                $PersonquizHistory->title = $book->title;
                $PersonquizHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
                //$PersonquizHistory->isbn = $book->isbn;
                $PersonquizHistory->save();
                
                //admin
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 3;
                $personadminHistory->book_id = $book->id;
                if($book->register_id != 0 && $book->register_id !== null)
                    $personadminHistory->bookregister_name = User::find($book->register_id)->username;
                $personadminHistory->title = $book->title;
                $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
                $personadminHistory->save();
                
                

                return redirect('/admin/can_book_list');
            }
        }
    }

    public function can_book_b(){
        $this->page_info['side'] = 'can_list';
        $this->page_info['subside'] = 'can_book_b';

        //get books for overseer
        $books = Books::where('active', 3)->orderby('updated_at', 'desc')->get();
        return view('admin.can_book_b')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }

    public function do_can_book_b(Request $request){
        $reason = $request->input('reason');
        $book_id = $request->input("book_id");

        $book = Books::where("id", $book_id)
            ->where("active", 3)->first();
        if(!$book){
            return response('Unauthorized', 404);
        }

        $book->reason2 = $reason;
        $book->active = 4;
        $book->replied_date2 = now();
        $book->save();

        return redirect('admin/can_book_c/');

    }

    public function can_book_c(Request $request){
        $this->page_info['side'] = 'can_list';
        $this->page_info['subside'] = 'can_book_c';

        $books = Books::where("active", 3);
        $book_id = $request->input('book_id');
        if(isset($book_id) && $book_id !== null){
            $books = $books->where("id", $request->input('book_id'));
        }
        $books = $books->orderby('updated_at', 'desc')->get();
        //        $overseers = User::getAllOverseers();
        $overseers = array();
        foreach($books as $key => $book) {
            $overseers[$key] = Demand::where("book_id", $book->id)->get();
        }

        return view('admin.can_book_c')
            ->with('page_info', $this->page_info)
            ->withBooks($books)
            ->withOverseers($overseers);
    }

    public function do_can_book_c(Request $request){
        $book = Books::find($request->input("book_id"));
        if(!$book){
            return response('Unauthorized', 404);
        }
        $overseerId = $request->input("user_id");

        $book->active = 5;
        $book->overseer_id = $overseerId;
        $book->replied_date3 = now();
        $book->save();

        //        $overseers = User::getAllOverseers();
        $overseers = Demand::where("book_id", $book->id)->get();
        foreach ($overseers as $one) {
            $message = new Messages;
            $message->type = 0;
            $message->from_id = 0;
            $message->name = "協会";
            if ($one->overseer_id == $overseerId) {
                $one->status = 1;
                $message->to_id = $overseerId;
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_OVERSEER_DECISION'],
                    "<a href='/book/".$book->id."/detail'>".$book->title."</a>");
                //overseer
                $personoverseerHistory = new PersonoverseerHistory();
                $personoverseerHistory->user_id = $one->overseer_id;
                if($one->overseer_id != 0 && $one->overseer_id !== null){
                    $personoverseerHistory->username = User::find($one->overseer_id)->username;
                    $personoverseerHistory->age = User::find($one->overseer_id)->age();
                }
                $personoverseerHistory->item = 0;
                $personoverseerHistory->work_test = 4;
                
                $personoverseerHistory->book_id = $book->id;
                $personoverseerHistory->title = $book->title;
                $personoverseerHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
                $personoverseerHistory->save();
                //admin
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 4;
                $personadminHistory->book_id = $book->id;
                if($one->overseer_id != 0 && $one->overseer_id !== null)
                    $personadminHistory->bookregister_name = User::find($one->overseer_id)->username;
                $personadminHistory->title = $book->title;
                $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
                $personadminHistory->save();
            } else {
                $one->status = 2;
                $message->to_id = $one->overseer_id;
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_OVERSEER_DEFEAT'],
                    "<a href='/book/".$book->id."/detail'>".$book->title."</a>");
                //overseer
                $personoverseerHistory = new PersonoverseerHistory();
                $personoverseerHistory->user_id = $one->overseer_id;
                if($one->overseer_id != 0 && $one->overseer_id !== null){
                    $personoverseerHistory->username = User::find($one->overseer_id)->username;
                    $personoverseerHistory->age = User::find($one->overseer_id)->age();
                }
                
                $personoverseerHistory->item = 0;
                $personoverseerHistory->work_test = 5;
                $personoverseerHistory->book_id = $book->id;
                $personoverseerHistory->title = $book->title;
                $personoverseerHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
                $personoverseerHistory->save();
                //admin
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 5;
                $personadminHistory->book_id = $book->id;
                if($one->overseer_id != 0 && $one->overseer_id !== null)
                    $personadminHistory->bookregister_name = User::find($one->overseer_id)->username;
                $personadminHistory->title = $book->title;
                $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
                $personadminHistory->save();
            }
            $one->save();
            $message->save();
        }

        return Redirect::back();
    }

    public function can_book_d(){
        $this->page_info['side'] = 'can_list';
        $this->page_info['subside'] = 'can_book_d';
        $books = Books::whereBetween('active', [1,6])->orderby('updated_at', 'desc')->get();
        return view('admin.can_book_d')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }

    public function can_book_e($book_id){
        $this->page_info['side'] = 'can_list';
        $this->page_info['subside'] = 'can_book_e';
        $book = Books::find($book_id);
        if(!$book){
            return response("Unauthorized", 404);
        }
        return view('admin.can_book_e')
            ->with('page_info', $this->page_info)
            ->withBook($book);
    }
    public function data_work_sel(){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_work_sel';
        $books = Books::whereBetween('active', [1,6])->orderby('updated_at', 'desc')->get();
        return view('admin.data_work_sel')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }
    public function data_card_per1(){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_per';
        $books = Books::whereBetween('active', [1,6])->orderby('updated_at', 'desc')->get();
        return view('admin.data_card_per')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }
    public function data_card_per(Request $request){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_per';
        $username = $request->input('username'); 

        //if(!isset($username))
       //      return;

        $user = Auth::user()->where('username', $username)
                            ->where('role', '<>', config('consts')['USER']['ROLE']['GROUP'])
                            ->where('role', '<>', config('consts')['USER']['ROLE']['ADMIN'])
                            ->where('active', '<=', 2)
                            ->orwhere(function($q) use ($username){
                                $q->where('active', '=', 3)->where('r_password', '=', 'sayonaradq')
                                ->where('username', $username)
                                ->where('role', '<>', config('consts')['USER']['ROLE']['GROUP'])
                                ->where('role', '<>', config('consts')['USER']['ROLE']['ADMIN']);
                            })
                            ->first();
        if(!isset($user)){
            return Redirect::back()->withErrors(["nouser" => '検索結果0件です。'])->withInput();
        }

        $id = $user->id;
        $user->total_point = UserQuiz::TotalPoint($id);
        $user->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
            if ($user->total_point >= $ranks[$i] && $user->total_point < $ranks[$i - 1]) {
                $user->rank = $i;
            }
        }
        $user->allowedbooks = UserQuiz::AllowedBooks($id)->get();
        $user->allowedquizes = UserQuiz::AllUserQuizes($id)->get()->count();
        $user->testquizes = UserQuizesHistory::testQuizes($id)->get()->count();
        $user->testallowedquizes = UserQuiz::testAllowedQuizes($id)->get()->count();
        $user->testoverseer = UserQuizesHistory::testOverseer($id)->get()->count();
        $user->testoverseers = UserQuizesHistory::testOverseers($id)->get()->count();
        $user->overseerbooks = Books::whereBetween('active', [1,6])->where('overseer_id', $id)->get();
        $user->myAllHistories = UserQuiz::selectRaw("user_quizes.*, books.title")
                                            ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7'))
                                            ->where("user_quizes.user_id", $id)->where("user_quizes.type", 2)->where("user_quizes.status", 3)->get();
        $authorbooks = [];
        if($user->fullname_nick() != '' && $user->fullname_nick() !== null && $user->fullname_nick() != ' '){
            $authorbooks = Books::whereBetween('active', [1,6])->Where('firstname_nick', $user->firstname_nick)->Where('lastname_nick', $user->lastname_nick)->get();
        }
        $user->authorbooks = $authorbooks;

        if($user->role == config('consts')['USER']['ROLE']["PUPIL"]){
            /*$class = $user->PupilsClass;
            if($class !== null){
                
                $user->grade = '';
                if($class->grade != 0)
                    $user->grade = $class->grade; 
                $user->class_number = $class->class_number;
                $user->class_teacher = $class->TeacherOfClass->fullname();
                $user->dateintoschool = PupilHistory::where('pupil_id', $id)->orderby('created_at', 'desc')->first()->created_at;
            }*/
            $user->pupilHistories = PupilHistory::GetPupilHistories($id);
        }
        if($user->isSchoolMember()){
            $user->teacherHistories = TeacherHistory::GetTeacherHistories($id);
        }
        /*if($user->period == null){
            $date=date_create($user->created_at);
            date_add($date,date_interval_create_from_date_string("1 years"));
            $user->period = date_format($date,"Y-m-d");
        }*/
        return view('admin.data_card_per')
            ->with('page_info', $this->page_info)
            ->withUser($user);
    }

    public function personalData(Request $request, $id=null){

        if($id == null) return;

        $user = User::find($id);
        $user->total_point = UserQuiz::TotalPoint($id);
        $user->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
            if ($user->total_point >= $ranks[$i] && $user->total_point < $ranks[$i - 1]) {
                $user->rank = $i;
            }
        }
        $user->allowedbooks = UserQuiz::AllowedBooks($id)->get();
        $user->allowedquizes = UserQuiz::AllUserQuizes($id)->get()->count();
        $user->testquizes = UserQuizesHistory::testQuizes($id)->get()->count();
        $user->testallowedquizes = UserQuiz::testAllowedQuizes($id)->get()->count();
        $user->testoverseer = UserQuizesHistory::testOverseer($id)->get()->count();
        $user->testoverseers = UserQuizesHistory::testOverseers($id)->get()->count();
        $user->overseerbooks = Books::where('active', '<>', 7)->where('overseer_id', $id)->get();
        $user->myAllHistories = UserQuiz::selectRaw("user_quizes.*, books.title")
                                            ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
                                            ->where("user_quizes.user_id", $id)->where("user_quizes.type", 2)->where("user_quizes.status", 3)->get();
        $authorbooks = []; 
        if($user->isAuthor() && $user->fullname_nick() != '' && $user->fullname_nick() !== null && $user->fullname_nick() != ' '){
            $authorbooks = Books::whereIn('active', [3,4,5,6])
                                ->Where('firstname_nick', $user->firstname_nick)
                                ->Where('lastname_nick', $user->lastname_nick)
                                ->get();
        }
        $user->authorbooks = $authorbooks;

        if($user->role == config('consts')['USER']['ROLE']["PUPIL"]){
            /*$class = $user->PupilsClass;
            if($class !== null){
                
                $user->grade = '';
                if($class->grade != 0)
                    $user->grade = $class->grade; 
                $user->class_number = $class->class_number;
                $user->class_teacher = $class->TeacherOfClass->fullname();
                $user->dateintoschool = PupilHistory::where('pupil_id', $id)->orderby('created_at', 'desc')->first()->created_at;
            }*/
            $user->pupilHistories = PupilHistory::GetPupilHistories($id);
        }
        if($user->isSchoolMember()){
            $user->teacherHistories = TeacherHistory::GetTeacherHistories($id);
        }
        /*if($user->period == null){
            $date=date_create($user->created_at);
            date_add($date,date_interval_create_from_date_string("1 years"));
            $user->period = date_format($date,"Y-m-d");
        }*/
        return view('admin.data_card_per')
            ->with('page_info', $this->page_info)
            ->withUser($user);
       
    }

    public function data_card_org(Request $request, $id=null){

        if($id == null) return;

        $user = User::find($id);

        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_org';
        
        $sql_represen="(select * from users where role=".config('consts')['USER']['ROLE']["REPRESEN"]." and active=1 and org_id=".$user->id.") as table1";
        //$sql_librarian="(select * from users where role=".config('consts')['USER']['ROLE']["LIBRARIAN"]." and active=1 and org_id=".$user->id.") as table1";
        
        $sql_librarian = DB::table('users')->Join('classes','classes.teacher_id','=','users.id')
                                ->where('users.role', config('consts')['USER']['ROLE']["LIBRARIAN"])
                               ->where('users.active', 1)
                               ->where('classes.group_id', $id)
                               ->where('classes.active', 1);

        $represens = DB::table(DB::raw($sql_represen))->get();
        $librarians = $sql_librarian->get();
        $current_season = AdminController::CurrentSeaon_Pupil(now());
        $classes = DB::table('classes')
                ->select("classes.id", "classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year","a.username", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                ->where('classes.group_id', $id)
                ->where('classes.member_counts','>', 0)
                ->where('classes.active','=', 1)
                ->where('classes.year', $current_season['year'])
                ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get();
        $teachers = DB::table('users')
                        ->select('users.*', "classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year")
                        ->leftJoin('classes','classes.teacher_id',DB::raw('users.id and classes.active = 1 and classes.member_counts > 0 and classes.group_id='.$id.' and classes.year='.$current_season['year']))
                        ->where('users.org_id' , $id)
                        ->where('users.active','1')
                        ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]])
                        ->orderBy(DB::raw("users.firstname asc, users.lastname asc, classes.grade asc, classes.class_number"), 'asc')
                        ->get();
        $old_teacher_id = '';
        $teachers_ary = array();
        $new_ary = array();
        foreach ($teachers as $key => $teacher) {

            if($teacher->id != $old_teacher_id){
                if($old_teacher_id != ''){
                    if($new_ary['classname'] != '')
                        $new_ary['classname'] .= ' 担任';
                    array_push($teachers_ary, $new_ary);
                    
                }

                $new_ary = array();
                $new_ary['id'] = $teacher->id;
                $new_ary['username'] = $teacher->username;
                $new_ary['fullname'] = $teacher->firstname.' '.$teacher->lastname;
                $new_ary['classname'] = '';
                if($teacher->grade != 0 && $teacher->grade !== null && $teacher->grade != '') 
                    $new_ary['classname'] .= $teacher->grade.'年';   
                if($teacher->class_number != '' && $teacher->class_number !== null)
                    $new_ary['classname'] .= $teacher->class_number.'組';
                
                 $old_teacher_id = $teacher->id;

            }else{
                $new_ary['classname'] .= '、';
                if($teacher->grade == 0)                                 
                    $new_ary['classname'] .= $teacher->class_number.'組';
                elseif($teacher->class_number == '' || $teacher->class_number == null)
                    $new_ary['classname'] .= $teacher->grade.'年';
                else
                    $new_ary['classname'] .= $teacher->grade.'年'.$teacher->class_number.'組';
            }
        }

        if(isset($teachers) && count($teachers) > 0){
            if($new_ary['classname'] != '')
                $new_ary['classname'] .= ' 担任';
            array_push($teachers_ary, $new_ary);
        }
        
        $members = User::selectRaw("users.*")
                //->leftJoin('classes','users.id','=','classes.teacher_id')
                //->whereRaw('(classes.group_id='.Auth::id().' or users.org_id='.$group->id.')')
                ->where('users.org_id' , $id)
                ->where('users.active','1')
                ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                  config('consts')['USER']['ROLE']["LIBRARIAN"],
                  config('consts')['USER']['ROLE']["REPRESEN"],
                  config('consts')['USER']['ROLE']["ITMANAGER"],
                  config('consts')['USER']['ROLE']["OTHER"]])
                ->groupby('users.id')->get();
        $teacher_numbers = count($members);
        // $teacher_numbers += count($librarians);
        $pupils = DB::table('classes') 
                 ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"),"a.username")
                 ->leftJoin('users as a','classes.id','=','a.org_id')
                 ->where('a.role', config('consts')['USER']['ROLE']["PUPIL"])
                //->leftJoin('users as b','classes.teacher_id','=','b.id')
                ->where('classes.group_id', $id)
                ->where('classes.active','=',1)
                ->where( function ($query) {
                     $query->whereNotNull('class_number')
                     ->orWhere('grade', '>', 0);
                 })
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get(); 

        /*if($user->period == null){
            $date=date_create($user->created_at);
            date_add($date,date_interval_create_from_date_string("1 years"));
            $user->period = date_format($date,"Y-m-d"); 
        }*/
        
        return view('admin.data_card_org')
            ->with('page_info', $this->page_info)
            ->with('represens',$represens)
            ->with('librarians',$librarians)
            ->with('classes',$classes)
            ->with('teachers_ary',$teachers_ary)
            ->with('teachers',$teachers)
            ->with('teacher_numbers',$teacher_numbers)
            ->withPupils($pupils)
            ->withUser($user);
    }

    public function data_card_org_view(Request $request){
        $username = $request->input('username');
        if(!isset($username))
             return;

        $user = Auth::user()->where('username', $username)
                            ->where('role', config('consts')['USER']['ROLE']['GROUP'])
                            ->where('active', '<=', 2)
                            ->first();
        if(!isset($user)){
            return Redirect::back()->withErrors(["nouser" => '検索結果0件です。'])->withInput();
        }

        $id = $user->id;

        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_org';
        
         $sql_represen="(select * from users where role=".config('consts')['USER']['ROLE']["REPRESEN"]." and active=1 and org_id=".$user->id.") as table1";
        //$sql_librarian="(select * from users where role=".config('consts')['USER']['ROLE']["LIBRARIAN"]." and active=1 and org_id=".$user->id.") as table1";
        
        $sql_librarian = DB::table('users')->Join('classes','classes.teacher_id','=','users.id')
                                ->where('users.role', config('consts')['USER']['ROLE']["LIBRARIAN"])
                               ->where('users.active', 1)
                               ->where('classes.group_id', $id)
                               ->where('classes.active', 1);

        $represens = DB::table(DB::raw($sql_represen))->get();
        $librarians = $sql_librarian->get();
        $current_season = AdminController::CurrentSeaon_Pupil(now());
        $classes = DB::table('classes')
                ->select("classes.id", "classes.grade","classes.class_number", "classes.member_counts","classes.group_id","classes.teacher_id","classes.year","a.username", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"), DB::raw("count(b.id) as member_counts"))
                ->leftJoin('users as a','classes.teacher_id','=','a.id')
                ->leftJoin('users as b', 'classes.id', DB::raw('b.org_id and b.role='.config('consts')['USER']['ROLE']['PUPIL']))
                ->where('classes.group_id', $id)
                ->where('classes.member_counts','>', 0)
                ->where('classes.active','=', 1)
                ->where('classes.year', $current_season['year'])
                ->groupBy('classes.id', 'a.firstname', 'a.lastname')
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get();
        $teachers = DB::table('users')
                        ->select('users.*', "classes.grade","classes.class_number","classes.group_id","classes.teacher_id","classes.year")
                        ->leftJoin('classes','classes.teacher_id',DB::raw('users.id and classes.active = 1 and classes.member_counts > 0 and classes.group_id='.$id.' and classes.year='.$current_season['year']))
                        ->where('users.org_id' , $id)
                        ->where('users.active','1')
                        ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                          config('consts')['USER']['ROLE']["LIBRARIAN"],
                          config('consts')['USER']['ROLE']["REPRESEN"],
                          config('consts')['USER']['ROLE']["ITMANAGER"],
                          config('consts')['USER']['ROLE']["OTHER"]])
                        ->orderBy(DB::raw("users.firstname asc, users.lastname asc, classes.grade asc, classes.class_number"), 'asc')
                        ->get();
        $old_teacher_id = '';
        $teachers_ary = array();
        $new_ary = array();
        foreach ($teachers as $key => $teacher) {

            if($teacher->id != $old_teacher_id){
                if($old_teacher_id != ''){
                    if($new_ary['classname'] != '')
                        $new_ary['classname'] .= ' 担任';
                    array_push($teachers_ary, $new_ary);
                    
                }

                $new_ary = array();
                $new_ary['id'] = $teacher->id;
                $new_ary['username'] = $teacher->username;
                $new_ary['fullname'] = $teacher->firstname.' '.$teacher->lastname;
                $new_ary['classname'] = '';
                if($teacher->grade != 0 && $teacher->grade !== null && $teacher->grade != '') 
                    $new_ary['classname'] .= $teacher->grade.'年';   
                if($teacher->class_number != '' && $teacher->class_number !== null)
                    $new_ary['classname'] .= $teacher->class_number.'組';
                
                 $old_teacher_id = $teacher->id;

            }else{
                $new_ary['classname'] .= '、';
                if($teacher->grade == 0)                                 
                    $new_ary['classname'] .= $teacher->class_number.'組';
                elseif($teacher->class_number == '' || $teacher->class_number == null)
                    $new_ary['classname'] .= $teacher->grade.'年';
                else
                    $new_ary['classname'] .= $teacher->grade.'年'.$teacher->class_number.'組';
            }
        }

        if(isset($teachers) && count($teachers) > 0){
            if($new_ary['classname'] != '')
                $new_ary['classname'] .= ' 担任';
            array_push($teachers_ary, $new_ary);
        }
        
        $members = User::selectRaw("users.*")
                //->leftJoin('classes','users.id','=','classes.teacher_id')
                //->whereRaw('(classes.group_id='.Auth::id().' or users.org_id='.$group->id.')')
                ->where('users.org_id' , $id)
                ->where('users.active','1')
                ->whereIn('users.role', [config('consts')['USER']['ROLE']["TEACHER"],
                  config('consts')['USER']['ROLE']["LIBRARIAN"],
                  config('consts')['USER']['ROLE']["REPRESEN"],
                  config('consts')['USER']['ROLE']["ITMANAGER"],
                  config('consts')['USER']['ROLE']["OTHER"]])
                ->groupby('users.id')->get();
        $teacher_numbers = count($members);
        // $teacher_numbers += count($librarians);
        $pupils = DB::table('classes') 
                 ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"),"a.username")
                 ->leftJoin('users as a','classes.id','=','a.org_id')
                 ->where('a.role', config('consts')['USER']['ROLE']["PUPIL"])
                //->leftJoin('users as b','classes.teacher_id','=','b.id')
                ->where('classes.group_id', $id)
                ->where('classes.active','=',1)
                ->where('classes.year', $current_season['year'])
                ->where( function ($query) {
                     $query->whereNotNull('class_number')
                     ->orWhere('grade', '>', 0);
                 })
                ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                ->get(); 
 
        if($user->period == null){
            $date=date_create($user->created_at);
            date_add($date,date_interval_create_from_date_string("1 years"));
            $user->period = date_format($date,"Y-m-d"); 
        }
        
        return view('admin.data_card_org')
            ->with('page_info', $this->page_info)
            ->with('represens',$represens)
            ->with('librarians',$librarians)
            ->with('classes',$classes)
            ->with('teachers_ary',$teachers_ary)
            ->with('teachers',$teachers)
            ->with('teacher_numbers',$teacher_numbers)
            ->withPupils($pupils)
            ->withUser($user);
    }

    public function saveOrgData(Request $request){
        $data = $request->all();
        $rule = array(
            'group_name' => 'required',
            'group_yomi' => 'required',
            'group_roma' => 'required'
        );
        $user = User::find($request->input('id'));
        
        $message = array(
            'required' => config('consts')['MESSAGES']['REQUIRED']
        );

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
                $user->save();
            }
        }
                
        //資格書類アップロード 
        $certifile = $request->file("certificatefile");
        if($certifile){
            $ext = $certifile->getClientOriginalExtension();
            $authfilename = $certifile->getClientOriginalName();
            $realfilename = time().md5($authfilename);

            $authfilesize = $certifile->getClientSize();
            $maxfilesize = $certifile->getMaxFilesize();
            $maxfilesize1 = round($maxfilesize / 1024 / 1024, 0);
            if($authfilesize == 0 || $authfilesize > $maxfilesize){
                
                $user->fileno = 'no';
                return Redirect::back()
                ->withErrors(["filemaxsize1" => 'ファイルは'.$maxfilesize1.'MB以下でしてください。'])
                ->withInput()
                ->withTitle($title);
            }else{
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
                $user->save();
            }
        }

        $validator = Validator::make($data, $rule, $message);

        if($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user->group_name = $request->input("group_name");
        $user->group_yomi = $request->input("group_yomi");
        $user->group_roma = $request->input("group_roma");
        $user->period = $request->input("period");
        $user->memo = $request->input("memo");
       
        if($request->input("authfile_check") == 'on')
            $user->authfile_check = 1;
        else
            $user->authfile_check = 0;
        if($request->input("certifile_check") == 'on')
            $user->certifile_check = 1;
        else
            $user->certifile_check = 0;
        
        //$user->wifi = $request->input("wifi");
        $user->ip_address = $request->input('ip_address');
        //$user->ip_global_address = $request->input('ip_global_address');
        $user->mask = $request->input('mask');
        if($request->input('fixed_flag') == 'on')
            $user->fixed_flag = 1;
        else
            $user->fixed_flag = 0;
        //if($request->input('nat_flag') == 'on')
        //    $user->nat_flag = 1;
        //else
        //    $user->nat_flag = 0; 
        $user->save();
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/admin/data_card_org/'.$request->input('id'));
    }

    public function data_card_book(){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_book';
        $books = Books::whereBetween('active', [1,6])->orderby('updated_at', 'desc')->get();
        return view('admin.data_card_book')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }
    public function data_card_quiz(){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_quiz';
        $books = Books::whereBetween('active', [1,6])->orderby('updated_at', 'desc')->get();
        return view('admin.data_card_quiz')
            ->with('page_info', $this->page_info)
            ->withBooks($books);
    }
    public function advertise(){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'advertise';
        $advise = Advertise::first();
        return view('admin.advertise')
            ->with('page_info', $this->page_info)
            ->with('advise', $advise);
    }
    public function app_search_history(Request $request){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'app_search_history';
        $this->history_item = config('consts')['HISTORY_ITEM'];
        if($request->input('history_item') !== null)
            $this->selected_item = $this->request->input('history_item');
        else
            $this->selected_item = '';
        $books = Books::whereBetween('active', [1,6])->orderby('updated_at', 'desc')->get();
        return view('admin.app_search_history')
            ->with('page_info', $this->page_info)
            ->with('history_item', $this->history_item)
            ->with('selected_item', $this->selected_item)
            ->withBooks($books);
    }
    public function exportSearchbook(Request $request){
        if($request->input('history_item') !== null)
            $this->selected_item = $request->input('history_item');
        else
            $this->selected_item = '';
        $this->period_sel = $request->input('period_sel');
        $this->start_time = config('consts')['PERIOD_TIME'][$this->period_sel]['start_time'];
        $this->end_time = config('consts')['PERIOD_TIME'][$this->period_sel]['end_time'];
        $books = PersonbooksearchHistory::selectRaw('person_booksearch_history.*, users.address1, users.address2, users.address3, users.firstname, users.lastname, users.gender')                       
                        ->where('person_booksearch_history.created_at', '>=', $this->start_time)
                        ->where('person_booksearch_history.created_at', '<=', $this->end_time)
                        ->orderby('person_booksearch_history.updated_at', 'desc')
                        ->leftjoin('users', 'users.id', '=', 'person_booksearch_history.user_id')
                        ->whereBetween('users.active', [1,6])
                        ->get();
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "使用デバイス, ページ名, 日にち, 閲覧開始時間、アクションした時間 , このページを離れた時間, 滞在時間,クリック、遷移先（戻る、トップ、サイド、フッターなどへは「他へ遷移」,直前のページ名, 公開人数, 読Ｑ本ポイント, 非公開人数, 読Qネーム, 氏名, 性別, 年齢, 都道府県, 市町村, 読Q本ID, 閲覧書籍名, 著者, ジャンル, 他者名前, 他者読Qネーム,他者年齢, 備考　読書認定書パスコード№、読書量１００年代、読書推進ランキング年代、協会書籍却下理由";
        $header = mb_convert_encoding($header, 'EUC_JP', 'auto');  //'shift_jis'
        fwrite($pFile, $header.PHP_EOL);
        foreach($books as $book){
            $content = "";
            $content .= $book->device. ",";
            if($book->item == 0){
                $page_name = '本のページ';
            }
            else if($book->item == 1){
                $page_name = 'クイズを作る際の注意';
            }
            else{
                $page_name = '';
            }
            $content .= $page_name. " ,";
            $content .= date_format(date_create($book->created_at), "Y/n/d"). ",";
            $content .= date_format(date_create($book->created_at), "H:i:s"). ",";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= $book->username. ",";
            $content .= $book->firstname . " " . $book->lastname . ",";
            $content .= $book->gender . ",";
            $content .= $book->age . ",";
            $content .= $book->address1 . " " . $book->address2 . ",";
            $content .= $book->address3 . ",";
            $content .= $book->book_id . ",";
            $content .= $book->title . ",";
            $content .= $book->writer . ",";
            $content .= $book->jangru . ",";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content = mb_convert_encoding($content, 'shift_jis', 'auto');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '本の検索.csv');                
    }
    public function exportQuizemake(Request $request){
        if($request->input('history_item') !== null)
            $this->selected_item = $request->input('history_item');
        else
            $this->selected_item = '';
        $this->period_sel = $request->input('period_sel');
        $this->start_time = config('consts')['PERIOD_TIME'][$this->period_sel]['start_time'];
        $this->end_time = config('consts')['PERIOD_TIME'][$this->period_sel]['end_time'];
        $quizs = PersonquizHistory::selectRaw('person_quiz_history.*, users.address1, users.address2, users.address3, users.firstname, users.lastname, users.gender')                       
                        ->where('person_quiz_history.created_at', '>=', $this->start_time)
                        ->where('person_quiz_history.created_at', '<=', $this->end_time)
                        ->orderby('person_quiz_history.updated_at', 'desc')
                        ->leftjoin('users', 'users.id', '=', 'person_quiz_history.user_id')
                        ->whereBetween('users.active', [1,6])
                        ->get();
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "使用デバイス, ページ名, 日にち, 閲覧開始時間、アクションした時間 , このページを離れた時間, 滞在時間,クリック、遷移先（戻る、トップ、サイド、フッターなどへは「他へ遷移」,直前のページ名, 公開人数, 読Ｑ本ポイント, 非公開人数, 読Qネーム, 氏名, 性別, 年齢, 都道府県, 市町村, 読Q本ID, 閲覧書籍名, 著者, ジャンル, 他者名前, 他者読Qネーム,他者年齢, 備考　読書認定書パスコード№、読書量１００年代、読書推進ランキング年代、協会書籍却下理由";
        $header = mb_convert_encoding($header, 'EUC_JP', 'auto');  //'shift_jis'
        fwrite($pFile, $header.PHP_EOL);
        foreach($quizs as $quiz){
            $content = "";
            $content .= $quiz->device. ",";
            $content .= " ,";
            $content .= date_format(date_create($quiz->created_at), "Y/n/d"). ",";
            $content .= date_format(date_create($quiz->created_at), "H:i:s"). ",";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= $quiz->username. ",";
            $content .= $quiz->firstname . " " . $quiz->lastname . ",";
            $content .= $quiz->gender . ",";
            $content .= $quiz->age . ",";
            $content .= $quiz->address1 . " " . $quiz->address2 . ",";
            $content .= $quiz->address3 . ",";
            $content .= $quiz->book_id . ",";
            $content .= $quiz->title . ",";
            $content .= $quiz->writer . ",";
            $content .= $quiz->jangru . ",";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '本の検索.csv');                
    }
    public function exportOverseer(Request $request){
        if($request->input('history_item') !== null)
            $this->selected_item = $request->input('history_item');
        else
            $this->selected_item = '';
        $this->period_sel = $request->input('period_sel');
        $this->start_time = config('consts')['PERIOD_TIME'][$this->period_sel]['start_time'];
        $this->end_time = config('consts')['PERIOD_TIME'][$this->period_sel]['end_time'];
        $quizs = PersontestoverseeHistory::selectRaw('person_testoversee_history.*, users.address1, users.address2, users.address3, users.firstname, users.lastname, users.gender')                       
                        ->where('person_testoversee_history.created_at', '>=', $this->start_time)
                        ->where('person_testoversee_history.created_at', '<=', $this->end_time)
                        // ->join('person_test_history', 'person_testoversee_history.test_username', '=', 'person_test_history.username')
                        ->orderby('person_testoversee_history.updated_at', 'desc')
                        ->leftjoin('users', 'users.id', '=', 'person_testoversee_history.user_id')
                        ->whereBetween('users.active', [1,6])
                        ->get();
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "使用デバイス, ページ名, 日にち, 閲覧開始時間、アクションした時間 , このページを離れた時間, 滞在時間,クリック、遷移先（戻る、トップ、サイド、フッターなどへは「他へ遷移」,直前のページ名, 公開人数, 読Ｑ本ポイント, 非公開人数, 読Qネーム, 氏名, 性別, 年齢, 都道府県, 市町村, 読Q本ID, 閲覧書籍名, 著者, ジャンル, 他者名前, 他者読Qネーム,他者年齢, 備考　読書認定書パスコード№、読書量１００年代、読書推進ランキング年代、協会書籍却下理由";
        $header = mb_convert_encoding($header, 'shift_jis', 'auto');  //'shift_jis'
        fwrite($pFile, $header.PHP_EOL);
        foreach($quizs as $quiz){
            $content = "";
            $content .= $quiz->device. ",";
            $content .= " ".",";
            $content .= date_format(date_create($quiz->created_at), "Y/n/d"). ",";
            $content .= date_format(date_create($quiz->created_at), "H:i:s"). ",";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= $quiz->username. ",";
            $content .= $quiz->firstname . " " . $quiz->lastname . ",";
            $content .= config('consts')['USER']['GENDER'][$quiz->gender] . ",";
            $content .= $quiz->age . ",";
            $content .= $quiz->address1 . " " . $quiz->address2 . ",";
            $content .= $quiz->address3 . ",";
            $content .= $quiz->book_id . ",";
            $content .= $quiz->title . ",";
            $content .= $quiz->writer . ",";
            $content .= $quiz->jangru . ",";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content .= " ,";
            $content = mb_convert_encoding($content, 'shift_jis', 'auto');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '本の検索.csv');                
    }
    public function exportHelppage(Request $request){
        if($request->input('history_item') !== null)
            $this->selected_item = $request->input('history_item');
        else
            $this->selected_item = '';
        $this->period_sel = $request->input('period_sel');
        $this->start_time = config('consts')['PERIOD_TIME'][$this->period_sel]['start_time'];
        $this->end_time = config('consts')['PERIOD_TIME'][$this->period_sel]['end_time'];
        $helps = PersonhelpHistory::selectRaw('person_help_history.*, users.address1, users.address2, users.address3, users.firstname, users.lastname, users.gender')                       
                        ->where('person_help_history.created_at', '>=', $this->start_time)
                        ->where('person_help_history.created_at', '<=', $this->end_time)
                        // ->join('person_test_history', 'person_testoversee_history.test_username', '=', 'person_test_history.username')
                        ->orderby('person_help_history.updated_at', 'desc')
                        ->leftjoin('users', 'users.id', '=', 'person_help_history.user_id')
                        ->whereBetween('users.active', [1,6])
                        ->get();
                       
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "使用デバイス, ページ名, 日にち, 閲覧開始時間, 読Qネーム, 氏名, 性別, 年齢, 都道府県, 市町村";
        $header = mb_convert_encoding($header, 'shift_jis', 'auto');  //'shift_jis'
        fwrite($pFile, $header.PHP_EOL);
        foreach($helps as $help){
            $content = "";
            $content .= $help->device.",";
            $content .= config('consts')['HELP_PAGE'][$help->item] .",";
            $content .= date_format(date_create($help->created_at), "Y/n/d"). ",";
            $content .= date_format(date_create($help->created_at), "H:i:s"). ",";
            $content .= $help->username. ",";
            if($help->firstname == 99){
                $content .= $help->user_type . ",";
            }
            else
                $content .= $help->firstname . " " . $help->lastname . ",";

            $content .= config('consts')['USER']['GENDER'][$help->gender] . ",";
            $content .= $help->age . ",";
            $content .= $help->address1 . " " . $help->address2 . ",";
            $content .= $help->address3 . ",";
            $content = mb_convert_encoding($content, 'shift_jis', 'auto');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '本の検索.csv');                
    }
    public function book_ranking(Request $request){
        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'book_ranking';
        $rankperiod = $request->input('rankperiod');
        $rankyear = $request->input('rankyear');
        $current_season = AdminController::CurrentSeaon(now());
        $ranks = UserQuiz::selectRaw("users.id, users.firstname, users.lastname, users.username, users.birthday, users.address1, SUM(user_quizes.point) as cur_point")
             ->leftJoin('users','users.id','=','user_quizes.user_id')
             ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7')) 
            ->where( function ($q) {
                $q->Where(function ($q1) {
                    $q1->where('user_quizes.type', '=', 0)->where('user_quizes.status', '=', 1);                    
                })->orWhere(function ($q1) {
                    $q1->where('user_quizes.type', '=', 1)->where('user_quizes.status', '=', 1);
                })->orWhere(function ($q1) {
                    $q1->where('user_quizes.type', '=', 2)->where('user_quizes.status', '=', 3);
                });
            })
            ->groupby("user_quizes.user_id")
            ->orderby("cur_point", "desc");

        if(isset($rankperiod)){
            if($rankperiod == 1){
            }
            else if($rankperiod == 2){
                $ranks = $ranks->whereBetween("user_quizes.created_date", array(Carbon::create($current_season['begin_thisyear'],1, 1,0,0,0), Carbon::create($current_season['end_thisyear'],12, 31,23,59,59)));
            }
            else if($rankperiod == 3){
                $ranks = $ranks->whereBetween("user_quizes.created_date", array(Carbon::create($current_season['begin_thisyear']-1,1, 1,0,0,0), Carbon::create($current_season['end_thisyear']-1,12, 31,23,59,59)));
            }
            
        }
        if(isset($rankyear)){
            $today = now();
            if($rankyear == 1){
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-20), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-10), 3, 31), "Y-m-d")));
                else
                    $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-9), 3, 31), "Y-m-d")));
            }
            else if($rankyear == 2){
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-20), 3, 31), "Y-m-d")));
                else
                    $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-19), 3, 31), "Y-m-d")));
            }
            else if($rankyear == 3){
                $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
            }
            else if($rankyear == 4){
                $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
            }
            else if($rankyear == 5){
                $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
            }
            else if($rankyear == 6){
                $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
            }
            else if($rankyear == 7){
                $ranks = $ranks->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
            }
            else if($rankyear == 8){
                $ranks = $ranks->where("users.birthday", '<=', date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d"));
               
            }
            
        }
        $ranks = $ranks->take(100)->get(); 
        return view('admin.book_ranking')
            ->with('page_info', $this->page_info)
            ->with('rankperiod', $rankperiod)
            ->with('rankyear', $rankyear)
            ->withRanks($ranks);
    }
    public function mem_search(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'mem_search';

        $messages1 = DB::table('messages as m')
                            ->select('m.created_at','m.from_id','m.content','m.to_id', 
                                    DB::raw('u.username as adminname'), 'r.username', 'r.group_name', 'r.firstname', 'r.lastname',
                                   'r.role', 'r.firstname_nick', 'r.lastname_nick')
                            ->leftJoin('users as u', 'u.id', 'm.from_id')
                            ->leftJoin('users as r', 'r.id', 'm.to_id')
                            ->where('m.search_flag', 1)
                            ->where('m.del_flag', 0)
                            ->groupby('m.created_at','m.from_id','m.content')
                            ->orderBy('m.created_at', 'desc');
        $messages1 = $messages1->get()->take(10);

        $messages2 = DB::table('messages as m')
                        ->select('m.*', DB::raw('u.username as adminname'), 'r.username', 'r.group_name', 'r.firstname', 'r.lastname',
                                   'r.role', 'r.firstname_nick', 'r.lastname_nick', DB::raw('count(m.id) as message_ct'))
                        ->leftJoin('users as u', 'u.id', 'm.from_id')
                        ->leftJoin('users as r', 'r.id', 'm.to_id')
                        ->where('m.search_flag', 1)
                        ->where('m.del_flag', 0)
                        ->groupby('m.created_at','m.from_id','m.content')
                         ->orderBy('m.created_at', 'desc');          
        $messages2 = $messages2->get()->take(10);

        $view = view('admin.mem_search')
                    ->with('page_info', $this->page_info)
                    ->with('messages1', $messages1)
                    ->with('messages2', $messages2);
        if ($request->session()->has("act"))
            $view = $view->withAct('several');
        
        return $view;
    }
    public function mem_search_result(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'mem_search';
        $temp = null;
        $count = 0;

        $users = User::whereIn('active', [1,2,3,4]);
        
        if($request->has('username') && $request->input('username') != ''){
            $users = $users->where("username", "like", "%".trim($request->input('username'))."%");
        }
        //$users = $users->get();
        /*if($request->has('fullname') && $request->input('fullname') != ''){
            
            $fullname = $request->input('fullname');
            $fullname = str_replace(" ", "", $fullname);
            $fullname = str_replace("　", "", $fullname);
            
            foreach ($users as $key => $user) {
                if($user->firstname.$user->lastname == $fullname){
                    $temp[$count] = $user;
                    $count ++;
                }
            }
        }else{
            foreach ($users as $key => $user) {
                if($request->has('username') && $request->input('username') != ''){
                    if($user->username == $request->input('username')){
                        $temp[$count] = $user;
                        $count ++;
                    }
                }
            }
        }*/
        if($request->has('firstname') && $request->input('firstname') != ''){
            $users = $users->where("firstname", "like",  "%".trim($request->input('firstname'))."%");
        }

        if($request->has('lastname') && $request->input('lastname') != ''){
            $users = $users->where("lastname", "like", "%".trim($request->input('lastname'))."%");
        }
         $users = $users->get(); 

        if(count($users) == 0){
            $this->page_info['side'] = 'search';
            $this->page_info['subside'] = 'mem_search';
            return Redirect::back()->withErrors(["nouser" => '検索結果0件です。'])->withInput();
        }else{
            
            $id_ary = [];
            foreach ($users as $key => $user) {
                array_push($id_ary, $user->id);
            }
           
            $messages1 = DB::table('messages as m')
                            ->select('m.created_at','m.from_id','m.content','m.to_id', 
                                    DB::raw('u.username as adminname'), 'r.username', 'r.group_name', 'r.firstname', 'r.lastname',
                                   'r.role', 'r.firstname_nick', 'r.lastname_nick')
                            ->leftJoin('users as u', 'u.id', 'm.from_id')
                            ->leftJoin('users as r', 'r.id', 'm.to_id')
                            ->whereIn('m.to_id', $id_ary)
                            ->where('m.search_flag', 1)
                            ->where('m.del_flag', 0)
                            ->groupby('m.created_at','m.from_id','m.content')
                            ->orderBy('m.created_at', 'desc');            
            $messages1 = $messages1->get();


            $view = view('admin.mem_search_result')
                ->with('page_info', $this->page_info)
                ->with('users', $users)
                ->with('messages1', $messages1)
                ->with('onesearch_flag', 1);
            if($request->has('username') && $request->input('username') != '')
                $view = $view->with('username', $request->input('username'));
            if($request->has('firstname') && $request->input('firstname') != '')
                $view = $view->with('firstname', $request->input('firstname'));
            if($request->has('lastname') && $request->input('lastname') != '')
                $view = $view->with('lastname', $request->input('lastname'));

            return $view;
        }
    }
    public function several_search_result(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'mem_search';
        
        $users = User::whereIn('users.active', [1,2,3,4]);
        if($request->input('address1') != ''){
            $users = $users->where("address1", "=", $request->input('address1'));
        }
        if($request->input('address2') != ''){
            $users = $users->where("address2", "=", $request->input('address2'));
        }
        if($request->input('gender') != ''){
            $users = $users->where("gender", "=", $request->input('gender'));            
        }
        if($request->input('rank') != ''){
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];
            $rankpoint = array();
            if($request->input('rank') == 1){
                $rankpoint = [ $ranks[$request->input('rank')-1]];
            }else{
                $rankpoint = [ $ranks[$request->input('rank')-1] , $ranks[$request->input('rank')-2]];
            }
            
            $users = $users->select(DB::raw("users.*, sum(b.point) as sumpoint"))
                            ->leftJoin("user_quizes AS b", "b.user_id","=","users.id")
                            ->join('books', 'b.book_id', DB::raw('books.id and books.active <> 7')) 
                            ->where( function ($q) {
                                $q->Where(function ($q1) {
                                    $q1->where('b.type', '=', 0)->where('b.status', '=', 1);                    
                                })->orWhere(function ($q1) {
                                    $q1->where('b.type', '=', 1)->where('b.status', '=', 1);
                                })->orWhere(function ($q1) {
                                    $q1->where('b.type', '=', 2)->where('b.status', '=', 3);
                                });
                            })->groupBy(DB::raw("users.id"));
            
                $users = $users->having("sumpoint", '>=', $rankpoint[0]);
            if($request->input('rank') != 0)
                $users = $users->having("sumpoint", '<', $rankpoint[1]);
                                        
        }
        if($request->input('action') != ''){
            if($request->input('action') == 1)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["GENERAL"]);          
            elseif ($request->input('action') == 2)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["OVERSEER"]); 
            elseif ($request->input('action') == 3)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["AUTHOR"]);           
            elseif ($request->input('action') == 4)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["PUPIL"]);
            elseif ($request->input('action') == 5)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["TEACHER"]);
            elseif ($request->input('action') == 6)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["REPRESEN"]);
            elseif ($request->input('action') == 7)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["ITMANAGER"]);
            elseif ($request->input('action') == 8)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["LIBRARIAN"]);
            elseif ($request->input('action') == 9)
                $users = $users->where("users.role", config('consts')['USER']['ROLE']["GROUP"]);

        }
        if($request->input('years') != ''){
            $today = now();
            if($request->input('years') == 1)
                $users = $users->join("classes", 'classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))->where('classes.active' ,'=', 1)->where('users.role' ,config('consts')['USER']['ROLE']["PUPIL"]);            
            elseif ($request->input('years') == 2)
                $users = $users->join("classes", 'classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=1'))->where('classes.active' ,'=', 1)->where('users.role' ,config('consts')['USER']['ROLE']["PUPIL"]);
            elseif ($request->input('years') == 3)
                $users = $users->join("classes", 'classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and (org.group_type=2 or org.group_type=3)'))->where('classes.active' ,'=', 1)->where('users.role' ,config('consts')['USER']['ROLE']["PUPIL"]);            
            elseif ($request->input('years') == 4)
                $users = $users->join("classes", 'classes.id','=','users.org_id')->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=4'))->where('classes.active' ,'=', 1)->where('users.role' ,config('consts')['USER']['ROLE']["PUPIL"]);
            elseif ($request->input('years') == 5){
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-20), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-10), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-9), 3, 31), "Y-m-d")));
            }else if($request->input('years') == 6){
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-20), 3, 31), "Y-m-d")));
                else
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-19), 3, 31), "Y-m-d")));
            }else if($request->input('years') == 7){
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
            }else if($request->input('years') == 8){
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
            }else if($request->input('years') == 9){
                    $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
            }else if($request->input('years') == 10){
               $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
            }else if($request->input('years') == 11){
                $users = $users->whereBetween("users.birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"), date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
            }else if($request->input('years') == 12){
                $users = $users->where("users.birthday", '<=', date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d"));
            }
           
        }
        $alluserscnt = $users->count();
        $checkallview = $request->input('checkallview'); 
        $users = $users->orderBy(DB::raw("users.firstname_yomi asc, users.lastname_yomi"), 'asc');
        if($checkallview == 1)
            $users = $users->get();
        else
            $users = $users->take(10)->get();
        if($alluserscnt == 0){
            $this->page_info['side'] = 'search';
            $this->page_info['subside'] = 'mem_search';
            return Redirect::back()->withErrors(["nouser" => '検索結果0件です。'])->withAct("several")->withInput();
        }else{
            $id_ary = [];

            foreach ($users as $key => $user) {
                array_push($id_ary, $user->id);
            }
           
            $messages2 = DB::table('messages as m')
                        ->select('m.*', DB::raw('u.username as adminname'), 'r.username', 'r.group_name', 'r.firstname', 'r.lastname',
                                   'r.role', 'r.firstname_nick', 'r.lastname_nick', DB::raw('count(m.id) as message_ct'))
                        ->leftJoin('users as u', 'u.id', 'm.from_id')
                        ->leftJoin('users as r', 'r.id', 'm.to_id')
                        ->where('m.search_flag', 1)
                        ->where('m.del_flag', 0)
                        ->whereIn('m.to_id', $id_ary)
                        ->groupby('m.created_at','m.from_id','m.content')
                         ->orderBy('m.created_at', 'desc');              
            $messages2 = $messages2->get();
                      
            return view('admin.mem_search_result')
                        ->with('page_info', $this->page_info)
                        ->withUsers($users)
                        ->with('alluserscnt', $alluserscnt)
                        ->with('checkallview', $checkallview)
                        ->with('address1', $request->input('address1'))
                        ->with('address2', $request->input('address2'))
                        ->with('gender', $request->input('gender'))
                        ->with('rank', $request->input('rank'))
                        ->with('action', $request->input('action'))
                        ->with('years', $request->input('years'))
                        ->with('messages2', $messages2)
                        ->with('onesearch_flag', 0);
            
        }
    }

    public function messages1(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'mem_search';

        $messages1 = DB::table('messages as m')
                            ->select('m.created_at','m.from_id','m.content','m.to_id', 
                                    DB::raw('u.username as adminname'), 'r.username', 'r.group_name', 'r.firstname', 'r.lastname',
                                   'r.role', 'r.firstname_nick', 'r.lastname_nick')
                            ->leftJoin('users as u', 'u.id', 'm.from_id')
                            ->leftJoin('users as r', 'r.id', 'm.to_id')
                            ->where('m.search_flag', 1)
                            ->where('m.del_flag', 0)
                            ->groupby('m.created_at','m.from_id','m.content')
                            ->orderBy('m.created_at', 'desc');
        $messages1 = $messages1->get()->take(1000);

        $view = view('admin.message1')
                    ->with('page_info', $this->page_info)
                    ->with('messages1', $messages1);
        if ($request->session()->has("act"))
            $view = $view->withAct('several');
        
        return $view;
    }

    public function messages2(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'mem_search';

        $messages2 = DB::table('messages as m')
                        ->select('m.*', DB::raw('u.username as adminname'), 'r.username', 'r.group_name', 'r.firstname', 'r.lastname',
                                   'r.role', 'r.firstname_nick', 'r.lastname_nick', DB::raw('count(m.id) as message_ct'))
                        ->leftJoin('users as u', 'u.id', 'm.from_id')
                        ->leftJoin('users as r', 'r.id', 'm.to_id')
                        ->where('m.search_flag', 1)
                        ->where('m.del_flag', 0)
                        ->groupby('m.created_at','m.from_id','m.content')
                         ->orderBy('m.created_at', 'desc');          
        $messages2 = $messages2->get()->take(1000);

        $view = view('admin.message2')
                    ->with('page_info', $this->page_info)
                    ->with('messages2', $messages2);
        if ($request->session()->has("act"))
            $view = $view->withAct('several');
        
        return $view;
    }

    public function quiz_answer(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'quiz_answer';
        $post = $request->input('post');
        if(isset($post)){
            $message = Messages::where("id", $request->input('checkid'))->first();
            if($message->from_id != 0 && $message->from_id !== null){
                $message->to_id = Auth::id();
                $message->post = $post;
                $message->save();
                //admin
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 14;
                $personadminHistory->bookregister_name = User::find($message->from_id)->username;
                $personadminHistory->content = $post;
                $personadminHistory->save();
            }
            else{
                try{
                    $user_data = (object)[
                        'email' => $message->email,
                        'name' => $message->name,
                        'content'=> $message->content,
                        'post' => $post
                    ];
                    $message->to_id = Auth::id();
                    $message->post = $post;
                    $message->save();
    
                    Mail::to($user_data)->send(new Answer($user_data));
                    //admin
                    $personadminHistory = new PersonadminHistory();
                    $personadminHistory->user_id = Auth::id();
                    $personadminHistory->username = Auth::user()->username;
                    $personadminHistory->item = 0;
                    $personadminHistory->work_test = 14;
                    $personadminHistory->content = $post;
                    $personadminHistory->save();
                }catch(Swift_TransportException $e){
                    return Redirect::back()
                        ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']])
                        ->withInput();
                }
            }
        }

        $inquiris = Messages::selectRaw("messages.*, SUBSTRING(messages.content, 1, 20) as content, users.role")
        ->leftJoin('users','users.id','=','messages.from_id')
        ->where("messages.type",2)
        ->orderBy('messages.created_at', 'desc')
        ->get();
        return view('admin.quiz_answer')
            ->with('page_info', $this->page_info)
            //->withBooks($books)
            ->with('inquiris', $inquiris);
    }
    public function quiz_answer_card(Request $request){
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'quiz_answer_card';
        $checkitem = $request->input('chbItem');
        if(isset($checkitem)){
            $message = Messages::selectRaw("messages.*, users.username")
            ->leftJoin('users','users.id','=','messages.from_id')
            ->where("messages.id",$checkitem)->first();
            return view('admin.quiz_answer_card')
            ->with('page_info', $this->page_info)
            ->withMessage($message);
        }
        else
            return view('admin.quiz_answer_card')
            ->with('page_info', $this->page_info);
        
    }
    public function basic_list(){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'basic_info';

        $users = User::where('role', config('consts')['USER']['ROLE']["ADMIN"])->where('active', 1)->get();
        return view('admin.basic_list')
            ->with('page_info', $this->page_info)
            ->with('users', $users);
    }

    public function basic_info(Request $request, $id = null){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'basic_info';
        if($id == null)
            $user = Auth::user();
        else
            $user = User::find($id);
        return view('admin.basic_info')
            ->with('page_info', $this->page_info)
            ->with('user', $user);
    }

    public function updatebasicinfo(Request $request){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'basic_info';
        $user = Auth::user();

        $rule = array(
            'username' => 'required|unique:users,username,'.$request->input('id'),
            'r_password' => 'required|max:15|min:8|unique:users,r_password,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,            
        );
        if($request->has('email1') && $request->input('email1') !== null && $request->input('email1') != '')
            $rule['email1'] = 'email|unique:users,email1,'.$user->id;
        
        if($request->has('email2') && $request->input('email2') !== null && $request->input('email2') != '')
            $rule['email2'] = 'email|unique:users,email2,'.$user->id;
        
        $messages = array(
            'required' => config('consts')['MESSAGES']['SENTENCE_REQUIRED'],
            'username.unique' => config('consts')['MESSAGES']['USERNAME_UNIQUE'],
            'r_password.unique' => config('consts')['MESSAGES']['PASSWORD_EXIST'],
            'r_password.min' => config('consts')['MESSAGES']['PASSWORD_LENGTH'],
            'r_password.max' => config('consts')['MESSAGES']['PASSWORD_MAXLENGTH'],
            'email.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE'],
            'email1.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email1.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE'],
            'email2.email' => config('consts')['MESSAGES']['EMAIL_EMAIL'],
            'email2.unique' => config('consts')['MESSAGES']['EMAIL_UNIQUE'],
        );
        $validator = Validator::make($request->all(), $rule, $messages);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if($request->input("r_password") == 'sayonaradq'){
            $error = config('consts')['MESSAGES']['PASSWORD_NO_USE'];
            return Redirect::back()->withErrors(["password" => $error])->withInput();
        }
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if($request->has('email1') && $request->input('email1') !== null && $request->input('email1') != '')
            $user->email1 = $request->input('email1');
        if($request->has('email2') && $request->input('email2') !== null && $request->input('email2') != '')
            $user->email2 = $request->input('email2');
        if($request->has('email_password') && $request->input('email_password') !== null && $request->input('email_password') != '')
            $user->email_password = $request->input('email_password');
        if($request->has('email1_password') && $request->input('email1_password') !== null && $request->input('email1_password') != '')
            $user->email1_password = $request->input('email1_password');
        if($request->has('email2_password') && $request->input('email2_password') !== null && $request->input('email2_password') != '')
            $user->email2_password = $request->input('email2_password');
        if($request->has('member_name') && $request->input('member_name') !== null && $request->input('member_name') != '')
            $user->member_name = $request->input('member_name');
        if($request->has('society_settlement_date') && $request->input('society_settlement_date') !== null && $request->input('society_settlement_date') != '')
            $user->society_settlement_date = $request->input('society_settlement_date');
        
        $user->save();
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to("/admin/basic_info/".$user->id);
    }

    public function notice(Request $request){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'notice';
        $contentflag = $request->input('contentflag');
        if(!isset($contentflag)) $contentflag = '';
        else{

            $rule = array(
                'content' => 'required',            
            );
            $messages = array(
                'required' => config('consts')['MESSAGES']['SENTENCE_REQUIRED']
            );
            $validator = Validator::make($request->all(), $rule, $messages);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->with('contentflag', '')->withInput();
            }
        
        }
        // $notices = Notices::all();
        $notices = Notices::paginate(3);
        return view('admin.notice_add_edit')
            ->with('page_info', $this->page_info)
            ->with('changed', 0)
            ->with('contentflag', $contentflag)
            ->withNotices($notices);
    }
    public function notice_add_edit(Request $request){
        
        /*$page = $request->input('page');
        if(!isset($page)){
            $rule = array(
                'content' => 'required',            
            );
            $messages = array(
                'required' => config('consts')['MESSAGES']['SENTENCE_REQUIRED']
            );
            $validator = Validator::make($request->all(), $rule, $messages);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'notice_add_edit';
        $date = $request->input('add_date');
        $contentflag = null;
        if ($request->input('content') != ''){
            $content = $request->input('content');
            $created_at = date_create($date);
            $notices_add = new Notices();
            $notices_add->created_at = $created_at;
            $notices_add->updated_at = $created_at;
            $notices_add->content = $content;
            $notices_add->save(); 
            $contentflag = 1;       
        }
        // $created_at = "2018-06-18";
        // $created_at = Carbon::createFromDate(date_format($date,"Y"), date_format($date,"M"), date_format($date,"D"));
        
        $notices = Notices::paginate(3);
        // $notices = $notices->paginate(3);
        return view('admin.notice_add_edit')
            ->with('page_info', $this->page_info)
            ->with('changed', 1)
            ->with('contentflag', $contentflag)
            ->with('refreshF5', 0)
            ->withNotices($notices);*/
        //update 18.07.21
        $date = $request->input('add_date');
        $contentflag = null;
        if ($request->input('content') != ''){
            $content = $request->input('content');
            $created_at = date_create($date);
            $notices_add = new Notices();
            $notices_add->created_at = $created_at;
            $notices_add->updated_at = $created_at;
            $notices_add->content = $content;
            $notices_add->save(); 
            $contentflag = 1;       
        }
        $response = array(
            'status' => 'success',
            
        );
       
        return response()->json($response);
    }
    public function notice_update_edit(Request $request){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'notice_add_edit';
        $id = $request->input('update_id');
        $date = $request->input('update_date');
        $content = $request->input('update_content');
        $update = DB::table('notices')
                    ->where('id','=',$id)
                    ->update(['content' => $content,'updated_at' => $date]);
        $notices = Notices::paginate(3);
        // $notices = $notices->paginate(3);
        return view('admin.notice_add_edit')
            ->with('page_info', $this->page_info)
            ->withNotices($notices)
            ->with('changed', 1);
    }
    public function notice_delete_edit(Request $request){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'notice_add_edit';
        $id = $request->input('delete_id');
        $delete = DB::table('notices')
                    ->where('id','=',$id)
                    ->delete();
        $notices = Notices::paginate(3);
        // $notices = $notices->paginate(3);
        return view('admin.notice_add_edit')
            ->with('page_info', $this->page_info)
            ->withNotices($notices)
            ->with('changed', 1);
    }
    public function book_credit(){
        $this->page_info['side'] = 'admin_basic_info';
        $this->page_info['subside'] = 'book_credit';
        
        $bookcredits = CertiBackup::all();
        return view('admin.book_credit')
            ->with('page_info', $this->page_info)
            ->with('bookcredits', $bookcredits);
    }

    
    public function successCancel(Request $request){

        $this->page_info['side'] = 'data_work';
        $this->page_info['subside'] = 'data_card_per';
        $user_id = $request->input('id');
        $cancelbook = "";
        $ids = preg_split('/,/', $request->input('selected'));
        for ($i = 0; $i < count($ids); $i++) {
            $user_quiz = UserQuiz::find($ids[$i]);
            $user_quiz->status = 4;
            $user_quiz->finished_date = now();
            $user_quiz->save();

            $book_point = $user_quiz->point;
            $userquiz_history = new UserQuizesHistory();
            $userquiz_history->user_id = $user_quiz->user_id;
            $userquiz_history->book_id = $user_quiz->book_id;
            $userquiz_history->type = 2;
            $userquiz_history->status = 4;         
            $userquiz_history->point = floor((0- $book_point)*100)/100;
            $userquiz_history->created_date = now();
            $userquiz_history->finished_date = now();
            $userquiz_history->published_date = now();
            $userquiz_history->save();

            $book = Books::find($user_quiz->book_id);
            if($book->active >= 3)
                $cancelbook .= "「<a href='/book/".$book->id."/detail'>".$book->title."</a>」";
            else
                $cancelbook .= "「<a>".$book->title."</a>」";
            if($i < count($ids) -1)
                $cancelbook .= "、";

            //admin
            $personadminHistory = new PersonadminHistory();
            $personadminHistory->user_id = Auth::id();
            $personadminHistory->username = Auth::user()->username;
            $personadminHistory->item = 0;
            $personadminHistory->work_test = 7;
            $personadminHistory->book_id = $book->id;
            $personadminHistory->bookregister_name = User::find($user_id)->username;
            $personadminHistory->title = $book->firstname_nick.' '.$book->lastname_nick;
            $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
            $personadminHistory->content = floor((0- $book_point)*100)/100;
            $personadminHistory->save();  
        }
        
        $message = new Messages;
        $message->type = 0;
        $message->from_id = Auth::id();
        $message->to_id = $user_id;
        $message->name = Auth::user()->username;
        $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_CANCELED'], $cancelbook);
        $message->save();

        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/admin/personaldata/'.$request->input('id'));
    }

    public function bookData(Request $request, $id=null){

        if($id == null) return;

        $book = Books::find($id);
        
        $author = User::where('firstname_nick', $book->firstname_nick)->where('lastname_nick', $book->lastname_nick)->where('role', config('consts')['USER']['ROLE']['AUTHOR'])->where('users.active','>=', 1)->first();

        if($author){
            $book->writer_id = $author->id;
            $book->save();
        }

        $bookauthor = User::find($book->writer_id);
        if($bookauthor)
            $book->username = $bookauthor->username;
        
        $book->angate = Angate::where('book_id', $id)->where('value', 1)->get()->count();
        //$categories = $book->categories()->get();
        $categories = Categories::all();
        return view('admin.data_card_book')
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->withCategories($categories);
    }

    public function bookdata_view(Request $request){
        $dqid = $request->input('username');
        if(!isset($dqid))
             return;
        $id = substr ($dqid, 2);    
        

        $book = Books::where('id',$id)->where('active', '>=', 3)->where('active', '<', 7)->first();
        if(!isset($book)){
            return Redirect::back()->withErrors(["nouser" => '検索結果0件です。'])->withInput();
        }

        $author = User::where('firstname_nick', $book->firstname_nick)->where('lastname_nick', $book->lastname_nick)->where('role', config('consts')['USER']['ROLE']['AUTHOR'])->where('users.active','>=', 1)->first();
        
        if(!is_null($author) && count(get_object_vars($author)) > 0 ){
            $book->writer_id = $author->id;
            $book->save();
        }

        
        $bookauthor = User::find($book->writer_id);
        if(!is_null($bookauthor) && count(get_object_vars($bookauthor)) > 0 )
            $book->username = $bookauthor->username;
        
        $book->angate = Angate::where('book_id', $id)->where('value', 1)->get()->count();
        // $categories = $book->categories()->get();
        $categories = Categories::all(); 
        return view('admin.data_card_book')
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->withCategories($categories);
    }
    
    public function saveBookData(Request $request){
        $data = $request->all();
        $rule = array(
            'title' => 'required',
            'title_furi' => 'required',
            'firstname_nick' => 'required',
            'lastname_nick' => 'required',
            'firstname_yomi' => 'required',
            'lastname_yomi' => 'required',
            'quiz_count' => 'required',
            'point' => 'required',
            'test_short_time' => 'required',
            'recommend_coefficient' => 'required',
            'categories' => 'required|max:4',
        );
        $isbn = $request->input('isbn');
        if(isset($isbn) && $isbn != ''){
            $book_chk = Books::where('active', 0)
                        ->where('isbn', $isbn)->get();
            if($book_chk && count($book_chk) > 0){
                Books::where('active', 0)
                        ->where('isbn', $isbn)
                        ->update(['isbn' => '']);

            }
            if($request->input('id')!=""){
                $rule['isbn'] = 'required|unique:books,isbn,'. $request->input('id');
            }else{
                $rule['isbn'] = 'required|unique:books';
            }
        }
        $book = Books::find($request->input('id'));
        
        $message = array(
            'required' => '入力してください。',
            'type.required' => '選択してください。',
            'categories.required' => '選択してください。',
            'recommend.required' => '選択してください。',
            'register_visi_type.required' => '選択してください。',
            'isbn.unique' => 'この本は、既に他の人が登録申請をしているため登録できません。',
            'categories.max' => '4つまで選択できます。'
        );

        //表紙画像アップロード
        $authfile = $request->file("coverimg");
        if($authfile){
            $ext = $authfile->getClientOriginalExtension();
            $authfilename = $authfile->getClientOriginalName();
            $realfilename = time().md5($authfilename);

            $authfilesize = $authfile->getClientSize();
            $maxfilesize = $authfile->getMaxFilesize();
            $maxfilesize1 = round($maxfilesize / 1024 / 1024, 0);
            if($authfilesize == 0 || $authfilesize > $maxfilesize){
                //$user->replied_date2 = now();
                
                $book->fileno = 'no';
                $view = 'group';

                return Redirect::to('/admin/bookdata/'.$request->input('id'))
                        ->withErrors(["filemaxsize" => 'ファイルは'.$maxfilesize1.'MB以下でしてください。'])
                        ->withInput()
                        ->withTitle($title);
            }else{
                $authfiledir = "/uploads/books";
                if(file_exists(public_path().$book->cover_img) && $book->cover_img != '' && $book->cover_img !== null){
                    if(file_exists(public_path()."/uploads/books/".$book->id)){
                        rename(public_path()."/uploads/books/".$book->id, public_path()."/uploads/books/doqregfile");
                        $filedh  = opendir(public_path()."/uploads/books/doqregfile");
                        while (false !== ($filename1 = readdir($filedh))) {
                            if ($filename1 != "." && $filename1 != "..") { 
                                unlink(public_path()."/uploads/books/doqregfile/".$filename1);
                            }
                        }
                        rmdir(public_path()."/uploads/books/doqregfile");
                    }
                }
                //upload file
                $authfile->move(public_path().'/uploads/books/'.$book->id.'/',$authfilename);

                $book->coverimg_date = date_format(now(), "Y-m-d");
                $book->cover_img = '/uploads/books/'.$book->id."/".$authfilename;
                $book->save();
            }
        }
                
        
        $validator = Validator::make($data, $rule, $message);

        if($validator->fails()){
            return Redirect::to('/admin/bookdata/'.$request->input('id'))
                ->withErrors($validator)
                ->withInput();
        }
       
        $book->title = $request->input("title");
        $book->title_furi = $request->input("title_furi");
        $book->firstname_nick = $request->input("firstname_nick");
        $book->lastname_nick = $request->input("lastname_nick");
        $book->firstname_yomi = $request->input("firstname_yomi");
        $book->lastname_yomi = $request->input("lastname_yomi");
        $book_point = floor($request->input("point")*100)/100;
        if($book->point != $book_point){
            $userquizes = UserQuiz::where('book_id', $book->id)->where('point', '<>', 0)->get();
            foreach ($userquizes as $key => $userquiz) {
                if($userquiz->type == 0 || $userquiz->type == 1)
                    $userquiz->point = floor($book_point * 0.1 * 100) / 100;
                elseif ($userquiz->type == 2) {
                    if($userquiz->point > floor($book->point*100)/100)
                        $userquiz->point = floor($book_point*100)/100 + floor($book_point * 0.1 * 100) / 100;
                    else
                        $userquiz->point = floor($book_point*100)/100;
                }
                $userquiz->save(); 
            }

            $userquiz_histories = UserQuizesHistory::where('book_id', $book->id)->where('point', '<>', 0)->where('point', '<>', null)->get();
            foreach ($userquiz_histories as $key => $userquiz_history) {
                if($userquiz_history->type == 0 || $userquiz_history->type == 1){
                    if($userquiz_history->point < 0)
                        $userquiz_history->point = floor((0 - $book_point) * 0.1 * 100) / 100;
                    else
                        $userquiz_history->point = floor($book_point * 0.1 * 100) / 100;
                }
                elseif ($userquiz_history->type == 2) {
                    if($userquiz_history->point < 0){
                        $abs_bookpoint = 0 - $userquiz_history->point;
                        if($abs_bookpoint > floor($book->point*100)/100)
                            $userquiz_history->point = floor((0 - $book_point)*100)/100 + floor((0 - $book_point) * 0.1 * 100) / 100;
                        else
                            $userquiz_history->point = floor((0 - $book_point)*100)/100;
                    }
                    else{
                        if($userquiz_history->point > floor($book->point*100)/100)
                            $userquiz_history->point = floor($book_point*100)/100 + floor($book_point * 0.1 * 100) / 100;
                        else
                            $userquiz_history->point = floor($book_point*100)/100;
                    }
                }
                $userquiz_history->save(); 
            }
                
        }
        $book->point = $book_point;
        $book->quiz_count = $request->input("quiz_count");
        $book->test_short_time = $request->input("test_short_time");
        $book->recommend = $request->input("recommend");
        $book->recommend_coefficient = floor($request->input("recommend_coefficient")*10)/10;
        $book->publish = $request->input("publish");
        $book->isbn = $request->input("isbn");
        $book->url = $request->input("url");
        $book->type = $request->input("type");
        $book->recog_total_chars = $request->input("recog_total_chars");
        $book->categories()->detach();
        $book->categories()->attach($request->input('categories'));

        $author = User::where('firstname_nick', $book->firstname_nick)->where('lastname_nick', $book->lastname_nick)->where('role', config('consts')['USER']['ROLE']['AUTHOR'])->where('users.active','>=', 1)->first();
        
        if($author){
            $book->writer_id = $author->id;
            
        }else{
            $book->writer_id = null;
            $book->author_overseer_flag = 0;
        }
                
        /*$bookauthor = User::find($book->writer_id);
        if(count($bookauthor) > 0 )
            $book->username = $bookauthor->username;*/
        
        if($request->input("recommend_flag") !== null && $request->input("recommend_flag") != '0000-00-00')
            $book->recommend_flag = $request->input("recommend_flag");
      
        if($request->input("author_overseer_flag") == 'on' && (isset($book->writer_id) && $book->writer_id !== null)){
            $book->author_overseer_flag = 1;
            //admin
            $personadminHistory = new PersonadminHistory();
            $personadminHistory->user_id = Auth::id();
            $personadminHistory->username = Auth::user()->username;
            $personadminHistory->item = 0;
            $personadminHistory->work_test = 10;
            $personadminHistory->book_id = $book->id;
            if($book->register_id != 0 && $book->register_id !== null)
                $personadminHistory->bookregister_name = User::find($book->register_id)->username;
            $personadminHistory->title = $book->title;
            $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
            $personadminHistory->content = User::find($book->writer_id)->username;
            $personadminHistory->save();     
        }else{
            $book->author_overseer_flag = 0;
        }
        
        if($request->input("coverimge_check") == 'on')
            $book->coverimge_check = 1;
        else
            $book->coverimge_check = 0;
       
        $book->save();
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/admin/bookdata/'.$request->input('id'));
    }

    //delete article by admin
    public function deleteArticleByAdmin(Request $request) {
        $book_id = $request->input("book_id");
        $delete_id = $request->input("delete_id");
        $book = Books::find($book_id);
        $article = Article::where("id", $delete_id)->first();
        Article::where("id", $delete_id)->update(['junior_visible' => 1]);
        //admin
        $personadminHistory = new PersonadminHistory();
        $personadminHistory->user_id = Auth::id();
        $personadminHistory->username = Auth::user()->username;
        $personadminHistory->item = 0;
        $personadminHistory->work_test = 6;
        $personadminHistory->book_id = $book->id;
        if($book->register_id != 0 && $book->register_id !== null)
            $personadminHistory->bookregister_name = User::find($book->register_id)->username;
        $personadminHistory->title = $book->title;
        $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
        $personadminHistory->content = $article->content;
        $personadminHistory->save();


        $articles = Article::where("book_id", $book_id)->where("junior_visible", 0)->get();
        $response = array(
                'articles' => $articles,
                'status' => 'success'
        );
        return response()->json($response);
    }

    public function exportPersonalData(Request $request, $id=null){
        if($id == null) return;

        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        
        $header = "読Ｑネーム,現有効期限,パスワード,姓,名,姓よみがな,名よみがな,姓ローマ字,名ローマ字,生年月日,性別,メールアドレス,保護者メアド,現住所〒1,現住所〒2,都道府県,市区町村,町名,番地１,番地2,番地3,建物名,部屋番号・階,電話番号,入会日時,本人確認書類画像,資格書類画像,現　顔登録,顔登録日,前回顔登録,前回顔登録日,現表示名,現ポイント,現在の級,本棚公開非公開,著者ペンネーム,ﾍﾟﾝﾈｰﾑよみがな,所属先(教員) 役職名 所属日 担任学年 担任学級 異動転出日,";
        $header .= "所属先(生徒) 現　学年 現　学級 現　担任 入学・転入日 卒業・転出日,監修本の数,ﾌﾟﾛﾌｨｰﾙ写真,監修読Ｑ本,登録読Ｑ本,試験監督回数,試験監督実質人数,適性検査合格日,著書読Ｑ本";
        $header = mb_convert_encoding($header, 'shift_jis');
        fwrite($pFile, $header.PHP_EOL);

        $user = User::find($id); 
        //$users = User::getAllMembers();
        //foreach ($users as $key => $user) {

            $content = "";
            $user->total_point = UserQuiz::TotalPoint($user->id);
            $user->rank = 10;
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
                if ($user->total_point >= $ranks[$i] && $user->total_point < $ranks[$i - 1]) {
                    $user->rank = $i;
                }
            }
            $user->allowedbooks = UserQuiz::AllowedBooks($user->id)->get();
            $user->allowedquizes = UserQuiz::AllUserQuizes($user->id)->get()->count();
            $user->testquizes = UserQuizesHistory::testQuizes($user->id)->get()->count();
            $user->testallowedquizes = UserQuiz::testAllowedQuizes($user->id)->get()->count();
            $user->testoverseer = UserQuizesHistory::testOverseer($user->id)->get()->count();
            $user->testoverseers = UserQuizesHistory::testOverseers($user->id)->get()->count();
            $user->overseerbooks = Books::where('active', '<>', 7)->where('overseer_id', $user->id)->get();
            $authorbooks = Books::where('active','>=', 1)->where('active', '<', 7);
            if($user->fullname_nick() != '' && $user->fullname_nick() !== null && $user->fullname_nick() != ' '){
                $authorbooks = $authorbooks->where('firstname_nick', $firstname_nick)->where('lastname_nick', $lastname_nick);
            }
            $user->authorbooks = $authorbooks->get();

            if($user->role == config('consts')['USER']['ROLE']["PUPIL"]){
                $user->pupilHistories = PupilHistory::GetPupilHistories($user->id);
            }
            if($user->isSchoolMember()){
                $user->teacherHistories = TeacherHistory::GetTeacherHistories($user->id);
            }
            $date=date_create($user->created_at);
            date_add($date,date_interval_create_from_date_string("1 years"));
            $user->period = date_format($date,"Y-m-d");

            $content .= $user->username.",";
            $content .= $user->period.",";
            $content .= $user->r_password.",";
            $content .= $user->firstname.",";
            $content .= $user->lastname.",";
            $content .= $user->firstname_yomi.",";
            $content .= $user->lastname_yomi.",";
            $content .= $user->firstname_roma.",";
            $content .= $user->lastname_roma.",";
            $content .= $user->birthday.",";
            $content .= config('consts')['USER']['GENDER'][$user->gender].",";
            $content .= $user->email.",";
            $content .= $user->teacher.",";
            $content .= $user->address4.",";
            $content .= $user->address5.",";
            $content .= $user->address1.",";
            $content .= $user->address2.",";
            $content .= $user->address3.",";
            $content .= $user->address6.",";
            $content .= $user->address7.",";
            $content .= $user->address8.",";
            $content .= $user->address9.",";
            $content .= $user->address10.",";
            $content .= $user->phone.",";
            $content .= $user->replied_date3.",";
            $content .= $user->file.",";
            $content .= $user->certifile.",";
            $content .= $user->image_path.",";
            $content .= $user->imagepath_date.",";
            $content .= ","; //前回顔登録
            $content .= ","; //前回顔登録日
            if($user->fullname_is_public) $content .= $user->fullname().",";
            else $content .= $user->username.",";
            $content .= $user->total_point.",";
            $content .= $user->rank.",";
            if($user->book_allowed_record_is_public == 1) $content .= "公開,"; else $content .= "非公開,";
            $content .= $user->fullname_nick().",";
            $content .= $user->fullname_nick_yomi().",";
            if($user->isSchoolMember()){
                foreach ($user->teacherHistories as $key => $teacherHistory) {
                    $content .= $teacherHistory->group_name." ";
                    if($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['TEACHER']) $content .= "教員 ";
                    elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['LIBRARIAN']) $content .= "司書 ";
                    elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['REPRESEN']) $content .= "代表（校長、教頭等） ";
                    elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['ITMANAGER']) $content .= "IT担当者 ";
                    elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['OTHER']) $content .= "その他 ";
                    $content .= $teacherHistory->created_at." ";
                    if($teacherHistory->grade != 0)  $content .= $teacherHistory->grade."年";
                    else $content .= "";
                    $content .= $teacherHistory->class_number."組 ";

                    $content .= $teacherHistory->updated_at."、 ";
                    if($key + 1 == count($user->teacherHistories))
                        $content .= $teacherHistory->updated_at."";
                    else
                        $content .= $teacherHistory->updated_at."、 ";
                }
            }
            //else $content .= ",";
            $content .= ",";
            if($user->role == config('consts')['USER']['ROLE']["PUPIL"]){
                foreach($user->pupilHistories as $key=>$pupilHistory){
                    $content .= $pupilHistory->group_name." ";
                    if($pupilHistory->grade != 0) $content .= $pupilHistory->grade."年";
                    else $content .= "";
                    $content .= $pupilHistory->class_number."組 ";
                    $content .= $pupilHistory->teacher_name." ";
                    $content .= $pupilHistory->created_at." ";
                    
                    if($key + 1 == count($user->pupilHistories))
                        $content .= $pupilHistory->updated_at."";
                    else
                        $content .= $pupilHistory->updated_at."、 ";
                }
            }
            //else $content .= ",";
            $content .= ",";
            $content .= $user->overseerbooks->count().",";
            $content .= $user->myprofile.",";
            foreach($user->overseerbooks as $key=>$overseerbook){
                //$content .= "dq".$overseerbook->id.",";
                if($key + 1 == count($user->overseerbooks))
                    $content .= "dq".$overseerbook->id." ".$overseerbook->title."";
                else
                    $content .= "dq".$overseerbook->id." ".$overseerbook->title."、 ";
            }
            $content .= ",";
            foreach($user->allowedbooks as $key=>$allowedbook){
                //$content .= "dq".$allowedbook->id.",";
                if($key + 1 == count($user->allowedbooks))
                    $content .= "dq".$allowedbook->bookid." ".$allowedbook->title."";
                else
                    $content .= "dq".$allowedbook->bookid." ".$allowedbook->title."、 ";
            }   
            $content .= ","; 
            $content .= $user->testoverseer.",";
            $content .= $user->testoverseers.",";
            
            if($user->replied_date4) {
                $replied_date4 = date_format(date_create($user->replied_date4), "Y-m-d");
                $content .= $replied_date4.",";
            }else $content .= ",";
            foreach($user->authorbooks as $key=>$authorbook) {
                //$content .= "dq".$authorbook->id.",";
                if($key + 1 == count($user->authorbooks))
                    $content .= "dq".$authorbook->id." ".$authorbook->title.",";
                else
                    $content .= "dq".$authorbook->id." ".$authorbook->title."、 ";
            }
            $content .= ",";
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        //}
        
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);

        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '会員情報.csv');

    }

    public function savePersonalData(Request $request){
        $data = $request->all();
        $rule = array(
            'username' => 'required|unique:users,username,'.$request->input('id'),
            'r_password' => 'required|max:15|min:8',
            'firstname' => 'required',
            'lastname' => 'required',
            'firstname_yomi' => 'required',
            'lastname_yomi' => 'required',
            'firstname_roma' => 'required',
            'lastname_roma' => 'required',
            'email' => 'required'
        );
        $user = User::find($request->input('id'));
        if($user->role == config('consts')['USER']['ROLE']['AUTHOR']) {
            $rule['firstname_nick'] = 'required';
            $rule['lastname_nick'] = 'required';
            $rule['firstname_nick_yomi'] = 'required';
            $rule['lastname_nick_yomi'] = 'required';
            $rule['email'] = 'required';
        }
        $message = array(
            'r_password.min' => config('consts')['MESSAGES']['PASSWORD_LENGTH'],
            'r_password.max' => config('consts')['MESSAGES']['PASSWORD_MAXLENGTH'],
            'r_password.unique' => config('consts')['MESSAGES']['PASSWORD_EXIST'],
            'username.unique' => config('consts')['MESSAGES']['USERNAME_UNIQUE'],
            'required' => config('consts')['MESSAGES']['REQUIRED']
        );

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
                
                $user->fileno = 'no';
                $view = 'group';

                return Redirect::to('/admin/personaldata/'.$request->input('id'))
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
                $user->save();
            }
        }
                
        //資格書類アップロード 
        $certifile = $request->file("certificatefile");
        if($certifile){
            $ext = $certifile->getClientOriginalExtension();
            $authfilename = $certifile->getClientOriginalName();
            $realfilename = time().md5($authfilename);

            $authfilesize = $certifile->getClientSize();
            $maxfilesize = $certifile->getMaxFilesize();
            $maxfilesize1 = round($maxfilesize / 1024 / 1024, 0);
            if($authfilesize == 0 || $authfilesize > $maxfilesize){
                
                $user->fileno = 'no';
                return Redirect::to('/admin/personaldata/'.$request->input('id'))
                ->withErrors(["filemaxsize1" => 'ファイルは'.$maxfilesize1.'MB以下でしてください。'])
                ->withInput()
                ->withTitle($title);
            }else{
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
                $user->save();
            }
        }

        $validator = Validator::make($data, $rule, $message);

        if($validator->fails()){
            return Redirect::to('/admin/personaldata/'.$request->input('id'))
                ->withErrors($validator)
                ->withInput();
        }

        /*if($request->input("r_password") == 'sayonaradq'){
            $error = config('consts')['MESSAGES']['PASSWORD_NO_USE'];
            return Redirect::to('/admin/personaldata/'.$request->input('id'))->withErrors(["password" => $error])->withInput();
        }*/

        if($request->input("r_password") == 'sayonaradq'){
            $user->active = 3;
            $user->escape_date = now();
        }else{
            $password_others = User::where('r_password', '=', $request->input("r_password"))
                                ->where('id', '<>', $user->id)
                                ->count();
            if($password_others != 0){
                $error = config('consts')['MESSAGES']['PASSWORD_EXIST'];
                return Redirect::to('/admin/personaldata/'.$request->input('id'))->withErrors(["r_password" => $error])->withInput();
            }
        }
        $email_other = User::where('email', '=', $request->input("email"))
                            ->where('id', '<>', $user->id)
                            ->count();
        if($email_other != 0){
            $error = config('consts')['MESSAGES']['EMAIL_EXIST'];
            return Redirect::to('/admin/personaldata/'.$request->input('id'))->withErrors(["email" => $error])->withInput();
        }
        

        $user->r_password = $request->input("r_password");
        $user->password = md5($request->input("r_password"));
        $user->firstname = $request->input("firstname");
        $user->lastname = $request->input("lastname");
        $user->firstname_yomi = $request->input("firstname_yomi");
        $user->lastname_yomi = $request->input("lastname_yomi");
        $user->firstname_roma = $request->input("firstname_roma");
        $user->lastname_roma = $request->input("lastname_roma");
        $user->gender = $request->input("gender");
        $user->memo = $request->input("memo");
        $user->email = $request->input('email');
        
        if($user->period != $request->input("period")){
            $user->period = $request->input("period");
            //admin
            $personadminHistory = new PersonadminHistory();
            $personadminHistory->user_id = Auth::id();
            $personadminHistory->username = Auth::user()->username;
            $personadminHistory->item = 0;
            $personadminHistory->work_test = 12;
            $personadminHistory->period = $request->input("period");
            $personadminHistory->save();
        }
        if($user->role == config('consts')['USER']['ROLE']['AUTHOR']) {
            $user->firstname_nick = $request->input("firstname_nick");
            $user->lastname_nick = $request->input("lastname_nick");
            $user->firstname_nick_yomi = $request->input("firstname_nick_yomi");
            $user->lastname_nick_yomi = $request->input("lastname_nick_yomi");
        }
        if($request->input("authfile_check") == 'on')
            $user->authfile_check = 1;
        else
            $user->authfile_check = 0;
        if($request->input("certifile_check") == 'on')
            $user->certifile_check = 1;
        else
            $user->certifile_check = 0;
        if($request->input("imagepath_check") == 'on')
            $user->imagepath_check = 1;
        else
            $user->imagepath_check = 0;

        $username = $request->input("username");
        $adminmake_flag = false;
        $username_ary = str_split($username);
        if($username_ary[sizeof($username_ary)-1] == 'k'){
            
            foreach ($username_ary as $key => $value) {

                if($value == 8){
                    $item = sizeof($username_ary) -1 - $key -1;
                    $sub_value = substr($username, $key+1, $item);
                    
                    
                    switch ($item) {
                        case '4':
                            if($sub_value >= 8000 && $sub_value < 8999)
                                $adminmake_flag = true;
                            break;
                        case '5':
                            if($sub_value >= 80000 && $sub_value < 89999)
                                $adminmake_flag = true;
                            break;
                        case '6':
                            if($sub_value >= 800000 && $sub_value < 899999)
                                $adminmake_flag = true;
                            break;
                        case '7':
                            if($sub_value >= 8000000 && $sub_value < 8999999)
                                $adminmake_flag = true;
                            break;
                    }
                }

                if($adminmake_flag) break;
            }
        }
        
        if($adminmake_flag){
            $user->role = config('consts')['USER']['ROLE']['ADMIN'];
            $user->username = $username;

            $user->save();

            $message = new Messages();
            $message->type = 0;
            $message->from_id = Auth::user()->id;
            $message->to_id = $user->id;
            $message->name = Auth::user()->username;
            $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_ADIN_REGISTER'], date_format(now(), 'm月d日'));
            $message->save();
            $request->session()->flash('status', config('consts')['MESSAGES']['ADMIN_REGISTER_SUCCEED']);
            
        }else{
            $user->username = $username;
            $user->save();
            $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        }

        $books = Books::where('writer_id', $user->id)->where('active', '>=', 3)->get();
        foreach ($books as $key => $book) {
            if($book->fullname_nick() != $user->fullname_nick()){
                $book->writer_id = null;
                $book->author_overseer_flag = 0;
                $book->save();
            }
        }
        return Redirect::to('/admin/personaldata/'.$request->input('id'));
    }

    public function messagesend(Request $request){
        $ids = $request->input('ids');
        $to_id = explode(',', $ids);
        
        foreach ($to_id as $key => $id) {
            $message = new Messages();
            $message->type = 0;
            $message->from_id = Auth::user()->id;
            $message->to_id = $id;
            // $message->name = Auth::user()->username;
            $message->name = '協会';
            $message->search_flag = 1;
            $message->content = $request->input('msg_txt');
            if($request->input('onesearch_flag') == 1){
                if($request->input('username') !== null)
                    $message->search_username = $request->input('username');
                if($request->input('firstname') !== null && $request->input('lastname') !== null)
                    $message->search_name = $request->input('firstname').' '.$request->input('firstname');
            }else{
                if($request->input('address1') !== null)
                    $message->search_address1 = $request->input('address1');
                if($request->input('address2') !== null)
                    $message->search_address2 = $request->input('address2');
                
                if($request->input('gender') == 1)
                    $message->search_gender = '女';
                elseif ($request->input('gender') == 2) 
                    $message->search_gender = '男';
                
                if($request->input('rank') == 1)
                    $message->search_rank = '初段';
                elseif ($request->input('rank') == 2) 
                    $message->search_rank = '1級';
                elseif ($request->input('rank') == 3) 
                    $message->search_rank = '2級';
                elseif ($request->input('rank') == 4) 
                    $message->search_rank = '3級';
                elseif ($request->input('rank') == 5) 
                    $message->search_rank = '4級';
                elseif ($request->input('rank') == 6) 
                    $message->search_rank = '5級';
                elseif ($request->input('rank') == 7) 
                    $message->search_rank = '6級';
                elseif ($request->input('rank') == 8) 
                    $message->search_rank = '7級';
                elseif ($request->input('rank') == 9) 
                    $message->search_rank = '8級';
                elseif ($request->input('rank') == 10) 
                    $message->search_rank = '9級';
                elseif ($request->input('rank') == 11) 
                    $message->search_rank = '10級';

                if($request->input('action') == 1)
                    $message->search_action = '一般';
                elseif ($request->input('rank') == 2) 
                    $message->search_action = '監修者';
                elseif ($request->input('rank') == 3) 
                    $message->search_action = '著者';
                elseif ($request->input('rank') == 4) 
                    $message->search_action = '生徒';
                elseif ($request->input('rank') == 5) 
                    $message->search_action = '教師（代表、IT担当、司書を除く）';
                elseif ($request->input('rank') == 6) 
                    $message->search_action = '代表（校長など）';
                elseif ($request->input('rank') == 7) 
                    $message->search_action = 'IT担当者';
                elseif ($request->input('rank') == 8) 
                    $message->search_action = '司書';
                elseif ($request->input('rank') == 9) 
                    $message->search_action = '団体（学校）';

                if($request->input('years') == 1)
                    $message->search_year = '小学生';
                elseif ($request->input('rank') == 2) 
                    $message->search_year = '中学生';
                elseif ($request->input('rank') == 3) 
                    $message->search_year = '高校生';
                elseif ($request->input('rank') == 4) 
                    $message->search_year = '大学生';
                elseif ($request->input('rank') == 5) 
                    $message->search_year = '１０代';
                elseif ($request->input('rank') == 6) 
                    $message->search_year = '2０代';
                elseif ($request->input('rank') == 7) 
                    $message->search_year = '3０代';
                elseif ($request->input('rank') == 8) 
                    $message->search_year = '4０代';
                elseif ($request->input('rank') == 9) 
                    $message->search_year = '5０代';
                elseif ($request->input('rank') == 10) 
                    $message->search_year = '6０代';
                elseif ($request->input('rank') == 11) 
                    $message->search_year = '7０代';
                elseif ($request->input('rank') == 12) 
                    $message->search_year = '８０代以降全ての年代';
                
            }
            $message->save();
        }
        
        $onesearch_flag = $request->input('onesearch_flag');
        if($onesearch_flag)
            return Redirect::to('/admin/mem_search_result?address1='.$request->input('address1').'&address2='.$request->input('address2')
                            .'&gender='.$request->input('gender').'&rank='.$request->input('rank')
                            .'&action='.$request->input('action').'&years='.$request->input('years')
                            .'&username='.$request->input('username').'&firstname='.$request->input('firstname')
                            .'&lastname='.$request->input('lastname').'&onesearch_flag='.$request->input('onesearch_flag'));
        else
            return Redirect::to('/admin/several_search_result?address1='.$request->input('address1').'&address2='.$request->input('address2')
                            .'&gender='.$request->input('gender').'&rank='.$request->input('rank')
                            .'&action='.$request->input('action').'&years='.$request->input('years')
                            .'&username='.$request->input('username').'&firstname='.$request->input('firstname')
                            .'&lastname='.$request->input('lastname').'&onesearch_flag='.$request->input('onesearch_flag'));



    }

    public function messagesend1(Request $request){
        $ids = $request->input('ids');
        $to_id = explode(',', $ids);
        
        foreach ($to_id as $key => $id) {
            $message = new Messages();
            $message->type = 1;
            $message->from_id = Auth::user()->id;
            $message->to_id = $id;
            // $message->name = Auth::user()->username;
            $message->name = '協会';
            $message->content = $request->input('msg_txt');
            $message->search_flag = 1;
            if($request->input('onesearch_flag') == 1){
                if($request->input('username') !== null)
                    $message->search_username = $request->input('username');
                if($request->input('firstname') !== null && $request->input('lastname') !== null)
                    $message->search_name = $request->input('firstname').' '.$request->input('firstname');
            }else{
                if($request->input('address1') !== null)
                    $message->search_address1 = $request->input('address1');
                if($request->input('address2') !== null)
                    $message->search_address2 = $request->input('address2');
                
                if($request->input('gender') == 1)
                    $message->search_gender = '女';
                elseif ($request->input('gender') == 2) 
                    $message->search_gender = '男';
                
                if($request->input('rank') == 1)
                    $message->search_rank = '初段';
                elseif ($request->input('rank') == 2) 
                    $message->search_rank = '1級';
                elseif ($request->input('rank') == 3) 
                    $message->search_rank = '2級';
                elseif ($request->input('rank') == 4) 
                    $message->search_rank = '3級';
                elseif ($request->input('rank') == 5) 
                    $message->search_rank = '4級';
                elseif ($request->input('rank') == 6) 
                    $message->search_rank = '5級';
                elseif ($request->input('rank') == 7) 
                    $message->search_rank = '6級';
                elseif ($request->input('rank') == 8) 
                    $message->search_rank = '7級';
                elseif ($request->input('rank') == 9) 
                    $message->search_rank = '8級';
                elseif ($request->input('rank') == 10) 
                    $message->search_rank = '9級';
                elseif ($request->input('rank') == 11) 
                    $message->search_rank = '10級';

                if($request->input('action') == 1)
                    $message->search_action = '一般';
                elseif ($request->input('rank') == 2) 
                    $message->search_action = '監修者';
                elseif ($request->input('rank') == 3) 
                    $message->search_action = '著者';
                elseif ($request->input('rank') == 4) 
                    $message->search_action = '生徒';
                elseif ($request->input('rank') == 5) 
                    $message->search_action = '教師（代表、IT担当、司書を除く）';
                elseif ($request->input('rank') == 6) 
                    $message->search_action = '代表（校長など）';
                elseif ($request->input('rank') == 7) 
                    $message->search_action = 'IT担当者';
                elseif ($request->input('rank') == 8) 
                    $message->search_action = '司書';
                elseif ($request->input('rank') == 9) 
                    $message->search_action = '団体（学校）';

                if($request->input('years') == 1)
                    $message->search_year = '小学生';
                elseif ($request->input('rank') == 2) 
                    $message->search_year = '中学生';
                elseif ($request->input('rank') == 3) 
                    $message->search_year = '高校生';
                elseif ($request->input('rank') == 4) 
                    $message->search_year = '大学生';
                elseif ($request->input('rank') == 5) 
                    $message->search_year = '１０代';
                elseif ($request->input('rank') == 6) 
                    $message->search_year = '2０代';
                elseif ($request->input('rank') == 7) 
                    $message->search_year = '3０代';
                elseif ($request->input('rank') == 8) 
                    $message->search_year = '4０代';
                elseif ($request->input('rank') == 9) 
                    $message->search_year = '5０代';
                elseif ($request->input('rank') == 10) 
                    $message->search_year = '6０代';
                elseif ($request->input('rank') == 11) 
                    $message->search_year = '7０代';
                elseif ($request->input('rank') == 12) 
                    $message->search_year = '８０代以降全ての年代';
                
            }
            $message->save();
        }
        $onesearch_flag = $request->input('onesearch_flag');
        if($onesearch_flag)
            return Redirect::to('/admin/mem_search_result?address1='.$request->input('address1').'&address2='.$request->input('address2')
                            .'&gender='.$request->input('gender').'&rank='.$request->input('rank')
                            .'&action='.$request->input('action').'&years='.$request->input('years')
                            .'&username='.$request->input('username').'&firstname='.$request->input('firstname')
                            .'&lastname='.$request->input('lastname').'&onesearch_flag='.$request->input('onesearch_flag'));
        else
            return Redirect::to('/admin/several_search_result?address1='.$request->input('address1').'&address2='.$request->input('address2')
                            .'&gender='.$request->input('gender').'&rank='.$request->input('rank')
                            .'&action='.$request->input('action').'&years='.$request->input('years')
                            .'&username='.$request->input('username').'&firstname='.$request->input('firstname')
                            .'&lastname='.$request->input('lastname').'&onesearch_flag='.$request->input('onesearch_flag'));

        /*$response = array(
            'status' => 'success',
            
        );
       
        return response()->json($response);*/
    }

    public function teachertop(Request $request, $id=null) {
        if($id == null) return;
        $user = User::find($id);
        $messages = Messages::where(DB::raw("concat(',',to_id, ',')"),'like','%,'.$id.',%')->where('type',1)->orderBy("updated_at", "desc")->take(3)->get();
            
        //get classes on current year
        if($user->isTeacher()){
            //$classes = Auth::user()->School->classes->where('teacher_id',Auth::id());
            $classes = $user->School->classes->where('member_counts','>',0);
        }
        elseif($user->isRepresen() || $user->isItmanager()){
             
             $classes = $user->School->classes->where('member_counts','>',0);
        }elseif($user->isOther()){
             
             $classes = $user->School->classes->where('member_counts','>',0);
        }
        
        $totalClassNames = array();
        $totalClassPoints = array();
        $i = 0;
        $current_season = AdminController::CurrentSeaon_Pupil(now());
        
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
        $this->page_info['side'] = 'search';
        $this->page_info['subside'] = 'mem_search';
       
        return view('teacher.home')
            //->withPage($this->page)
            ->withMessages($messages)
            ->with('school_classes',[])
            ->with('page_info',$this->page_info)
            ->with('total_class_names', $totalClassNames)
            ->with('total_class_points', $totalClassPoints)
            ->with('top_class_names', $topClassNames)
            ->with('top_student_names', $topStudentsNames)
            ->with('curQuartDateString', $curQuartDateString)
            ->with('classes', $classes)
            ->withNoSideBar(true);
    }

    public function recommend_change(Request $request){
        $items = $request->input('items');
        $ids = explode(",",$items);
        
        foreach ($ids as $key => $id) {
            $user = User::find($id);
            $user->role = config('consts')['USER']['ROLE']['OVERSEER'];
            $username = $user->username;
            $user->username = $username.'k';
            $user->recommend_flag = 0;
            $user->replied_date4 = now();
            $user->save(); 

            $message = new Messages();
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = $id;
            $message->name = "協会";
            $message->content = config('consts')['MESSAGES']['RECOMMEND_REGISTER'];
            $message->save();
        }
        
         $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::back();
    }

    public function recommend_nochange(Request $request){
        $items = $request->input('items');
        $ids = explode(",",$items);
        
        foreach ($ids as $key => $id) {
            $user = User::find($id);
            $user->recommend_flag = 0;
            $user->replied_date4 = now();
            $user->save(); 

            $message = new Messages();
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = $id;
            $message->name = "協会";
            $message->content = config('consts')['MESSAGES']['RECOMMEND_NOREGISTER'];
            $message->save();
        }
        
         $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::back();
    }

    //delete book by admin
    public function deletebookByAdmin(Request $request) {
        $book_id = $request->input("id"); 
        $book = Books::find($book_id);
        //$book->active = 7;
        //$book->save();

        $angates = Angate::where('book_id', $book_id)->delete();
        $vote = Vote::join('articles','articles.id', DB::raw('votes.article_id and articles.book_id='.$book_id))->delete();
        $article = Article::where('book_id', $book_id)->delete();
        $bookCategory = BookCategory::where('book_id', $book_id)->delete();
        $demand = Demand::where('book_id', $book_id)->delete();
        $personadminHistory = PersonadminHistory::where('book_id', $book_id)->delete();
        $personbooksearchHistory = PersonbooksearchHistory::where('book_id', $book_id)->delete();
        $personcontributionHistory = PersoncontributionHistory::where('book_id', $book_id)->delete();
        $personoverseerHistory = PersonoverseerHistory::where('book_id', $book_id)->delete();
        $personquizHistory = PersonquizHistory::where('book_id', $book_id)->delete();
        $persontestHistory = PersontestHistory::where('book_id', $book_id)->delete();
        $persontestoverseeHistory = PersontestoverseeHistory::where('book_id', $book_id)->delete();
        $quizes = Quizes::where('book_id', $book_id)->delete();
        $quizesTemp = QuizesTemp::where('book_id', $book_id)->delete();
        $userQuiz = UserQuiz::where('book_id', $book_id)->delete();
        $userQuizesHistory = UserQuizesHistory::where('book_id', $book_id)->delete();
        $wishlists = WishLists::where('book_id', $book_id)->delete();

        //admin
        $personadminHistory = new PersonadminHistory();
        $personadminHistory->user_id = Auth::id();
        $personadminHistory->username = Auth::user()->username;
        $personadminHistory->item = 0;
        $personadminHistory->work_test = 15;
        $personadminHistory->book_id = $book->id;
        if($book->register_id != 0 && $book->register_id !== null)
            $personadminHistory->bookregister_name = User::find($book->register_id)->username;
        $personadminHistory->title = $book->title;
        $personadminHistory->writer = $book->firstname_nick.' '.$book->lastname_nick;
        $personadminHistory->content = '';
        $personadminHistory->save();

        $message = new Messages();
        $message->type = 0;
        $message->from_id = Auth::id();
        $message->to_id = $book->register_id;
        $message->name = "協会";
        $message->content = sprintf(config('consts')['MESSAGES']['BOOK_DELETE_SUCCESS'],
                            date_format(now(), 'm月d日'),
                            "<a>".$book->title."</a>");
        $message->save();

        $book->delete();

        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/top');
    }

    //delete user by admin
    public function deleteperByAdmin(Request $request) {

        $user_id = $request->input("id"); 
        $user = User::find($user_id);

        if(isset($user)){
            try{
                Mail::to($user)->send(new UserescapeByadmin($user));

                $writerbooks = Books::where('writer_id', $user_id)->get();
                foreach ($writerbooks as $key => $writerbook) {
                    $writerbook->writer_id = 0;
                    $writerbook->author_overseer_flag = 0;
                    if($writerbook->overseer_id == 0 || $writerbook->overseer_id === null){
                        if($writerbook->active > 3 && $writerbook->active < 6)
                            $writerbook->active = 3;
                    }
                    $writerbook->save();
                    
                }
                $overseerbooks = Books::where('overseer_id', $user_id)->get();
                foreach ($overseerbooks as $key => $overseerbook) {
                    $overseerbook->overseer_id = 0;
                    if($overseerbook->writer_id !== null && $overseerbook->writer_id != 0 && $overseerbook->author_overseer_flag == 1){
                        
                    }else{
                        if($overseerbook->active > 3 && $overseerbook->active < 6)
                            $overseerbook->active = 3; 
                    }
                    
                    $overseerbook->save();
                }
                $registerbooks = Books::where('register_id', $user_id)->update(['register_id' => 0]);
                $angates = Angate::where('user_id', $user_id)->delete();
                $article = Article::where('register_id', $user_id)->delete();
                $certiBackup = CertiBackup::where('user_id', $user_id)->delete();
                $classes = Classes::where('teacher_id', $user_id)->update(['teacher_id' => null]);
                $history_access = AccessHistory::where('user_id', $user_id)->delete();
                $history_login = LoginHistory::where('user_id', $user_id)->delete();
                $history_pwd = PwdHistory::where('user_id', $user_id)->delete();
                //$history_pwdoverseer = PwdHistory::where('overseer_id', $user_id)->update(['overseer_id' => 0]);
                $messages = Messages::where('to_id', $user_id)->delete();
                $orgworkHistory = OrgworkHistory::where('user_id', $user_id)->delete();
                $demand = Demand::where('overseer_id', $user_id)->delete();
                $personadminHistory = PersonadminHistory::where('user_id', $user_id)->delete();
                $personbooksearchHistory = PersonbooksearchHistory::where('user_id', $user_id)->delete();
                $personcontributionHistory = PersoncontributionHistory::where('user_id', $user_id)->delete();
                $personoverseerHistory = PersonoverseerHistory::where('user_id', $user_id)->delete();
                $personquizHistory = PersonquizHistory::where('user_id', $user_id)->delete();
                $persontestHistory = PersontestHistory::where('user_id', $user_id)->delete();
                $persontestoverseeHistory = PersontestoverseeHistory::where('user_id', $user_id)->delete();
                $personworkHistory = PersonworkHistory::where('user_id', $user_id)->delete();
                $pupilHistory = PupilHistory::where('pupil_id', $user_id)->delete();
                $quizes = Quizes::where('register_id', $user_id)->delete();
                $quizesTemp = QuizesTemp::where('user_id', $user_id)->delete();
                $reportBackup = ReportBackup::where('user_id', $user_id)->delete();
                $reportGraphBackup = ReportGraphBackup::where('user_id', $user_id)->delete();
                $teacherHistory = TeacherHistory::where('teacher_id', $user_id)->delete();
                $userQuiz = UserQuiz::where('user_id', $user_id)->delete();
                $userQuiz1 = UserQuiz::where('org_id', $user_id)->update(['org_id' => null]);
                $userQuizesHistory = UserQuizesHistory::where('user_id', $user_id)->delete();
                $userQuizesHistory1 = UserQuizesHistory::where('user_id', $user_id)->update(['org_id' => null]);
                $vote = Vote::where('voter_id', $user_id)->delete();
                $wishlists = WishLists::where('user_id', $user_id)->delete();
                $users = User::where('id', $user_id)->delete();
                //admin
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 16;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->save();
                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '会員データ削除';
                $personadminHistory->save();

                /*$user->active = 4;
                $user->r_password = 'sayonaradq';
                $user->password = md5('sayonaradq');
                $user->save();*/
            }catch(Swift_TransportException $e){
                         
                return Redirect::to('/admin/personaldata/'.$user_id)
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']]);
            }
        }
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/admin/data_work_sel');
    }

    //delete group by admin
    public function deleteorgByAdmin(Request $request) {

        $user_id = $request->input("id"); 
        $user = User::find($user_id);

        if(isset($user)){
            try{
                $puiple_1 = User::where(['org_id' => $user_id, 'properties' => 0, 'role' => 9])->update(['active' => 2, 'org_id' => 0, 'group_name' => "", 'group_yomi' => ""]);
                $puiple_2 = User::where(['org_id' => $user_id, 'properties' => 1, 'role' => 9])->update(['role' => 1, 'org_id' => 0, 'group_name' => "", 'group_yomi' => ""]);
                $teacher = User::where(['org_id' => $user_id, 'role' => 4])->update(['active' => 2, 'org_id' => 0, 'group_name' => "", 'group_yomi' => ""]);
                $person = User::where(['org_id' => $user_id, 'role' => 1])->update(['active' => 2, 'org_id' => 0, 'group_name' => "", 'group_yomi' => ""]);
                $registerbooks = Books::where('register_id', $user_id)->update(['register_id' => 0]);
                $angates = Angate::where('user_id', $user_id)->delete();
                $article = Article::where('register_id', $user_id)->delete();
                $certiBackup = CertiBackup::where('user_id', $user_id)->delete();
                $classes = Classes::where('teacher_id', $user_id)->update(['teacher_id' => null]);
                $history_access = AccessHistory::where('user_id', $user_id)->delete();
                $history_login = LoginHistory::where('user_id', $user_id)->delete();
                $history_pwd = PwdHistory::where('user_id', $user_id)->delete();
                //$history_pwdoverseer = PwdHistory::where('overseer_id', $user_id)->update(['overseer_id' => 0]);
                $messages = Messages::where('to_id', $user_id)->delete();
                $orgworkHistory = OrgworkHistory::where('user_id', $user_id)->delete();
                $demand = Demand::where('overseer_id', $user_id)->delete();
                $personadminHistory = PersonadminHistory::where('user_id', $user_id)->delete();
                $personbooksearchHistory = PersonbooksearchHistory::where('user_id', $user_id)->delete();
                $personcontributionHistory = PersoncontributionHistory::where('user_id', $user_id)->delete();
                $personoverseerHistory = PersonoverseerHistory::where('user_id', $user_id)->delete();
                $personquizHistory = PersonquizHistory::where('user_id', $user_id)->delete();
                $persontestHistory = PersontestHistory::where('user_id', $user_id)->delete();
                $persontestoverseeHistory = PersontestoverseeHistory::where('user_id', $user_id)->delete();
                $personworkHistory = PersonworkHistory::where('user_id', $user_id)->delete();
                $pupilHistory = PupilHistory::where('pupil_id', $user_id)->delete();
                $quizes = Quizes::where('register_id', $user_id)->delete();
                $quizesTemp = QuizesTemp::where('user_id', $user_id)->delete();
                $reportBackup = ReportBackup::where('user_id', $user_id)->delete();
                $reportGraphBackup = ReportGraphBackup::where('user_id', $user_id)->delete();
                $teacherHistory = TeacherHistory::where('teacher_id', $user_id)->delete();
                $userQuiz = UserQuiz::where('user_id', $user_id)->delete();
                $userQuiz1 = UserQuiz::where('org_id', $user_id)->update(['org_id' => null]);
                $userQuizesHistory = UserQuizesHistory::where('user_id', $user_id)->delete();
                $userQuizesHistory1 = UserQuizesHistory::where('user_id', $user_id)->update(['org_id' => null]);
                $vote = Vote::where('voter_id', $user_id)->delete();
                $wishlists = WishLists::where('user_id', $user_id)->delete();
                $users = User::where('id', $user_id)->delete();
                //admin
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 16;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->save();
                //admin
                $admin = User::find(1);
                $personadminHistory = new PersonadminHistory();
                $personadminHistory->user_id = Auth::id();
                $personadminHistory->username = Auth::user()->username;
                $personadminHistory->item = 0;
                $personadminHistory->work_test = 13;
                $personadminHistory->bookregister_name = $user->username;
                $personadminHistory->content = '会員データ削除';
                $personadminHistory->save();

                /*$user->active = 4;
                $user->r_password = 'sayonaradq';
                $user->password = md5('sayonaradq');
                $user->save();*/
            }catch(Swift_TransportException $e){
                         
                return Redirect::to('/admin/personaldata/'.$user_id)
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['ORG_DELETE_ERROR']]);
            }
        }
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::to('/admin/data_work_sel');
    }

    public function quizData(Request $request, $id=null){

        if($id == null) return;

        $book = Books::find($id);
        $quizshorttime = floor($book->test_short_time/$book->quiz_count);

        $quizes = Quizes::where('book_id',$id)->where('active', 2)->get();
        foreach ($quizes as $key => $quiz) {
            $quiz->quizanswerright = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->get()->count();
            $quiz->quizanswerwrong = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 3)->get()->count(); 
            $quiz->quizanswer = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->orwhere('work_test', 3)->get()->count();
            $quiz->quizanswershorttime = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->where('tested_time', '<', $quizshorttime)->get()->count();
            
        }
        return view('admin.data_card_quiz')
            ->with('page_info', $this->page_info)
            ->withBookid($id)
            ->withQuizes($quizes);
    }

    public function quizdata_view(Request $request){

        $quiz_id = $request->input('username');
        if(!isset($quiz_id))
             return;

        $quiz = Quizes::where('doq_quizid',$quiz_id)->where('active', 2)->first();
        
        if(!isset($quiz) || count($quiz) == 0){
            return Redirect::back()->withErrors(["nouser" => '検索結果0件です。'])->withInput();
        }

        //$quizes = Quizes::where('book_id',$id)->where('active', 2)->get();
        //foreach ($quizes as $key => $quiz) {
            $book = Books::find($quiz->book_id);
            $book_id = $quiz->book_id;
            $quizshorttime = floor($book->test_short_time/$book->quiz_count);
            $quiz->quizanswerright = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->get()->count();
            $quiz->quizanswerwrong = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 3)->get()->count(); 
            $quiz->quizanswer = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->orwhere('work_test', 3)->get()->count();
            $quiz->quizanswershorttime = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->where('tested_time', '<', $quizshorttime)->get()->count();
            
        //}
        return view('admin.data_card_quiz')
            ->with('page_info', $this->page_info)
            ->withBookid($book_id)
            ->withQuizid($quiz->id)
            ->withQuiz($quiz);
    }

    //=========booktype = data_card_per ===========================//
    public function exportPersonalList(Request $request){
        $period_sel = $request->input('period_sel');
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        
        $header = "読Q入会日, 読Ｑネーム, 属性, 現有効期限(教師生徒は所属先に準ずる), 月額年額, パスワード, 姓, 名, 姓よみがな, 名よみがな, 姓ローマ字, 名ローマ字, 著者ペンネーム姓, 著者ペンネーム名, ペンネーム姓よみがな, ペンネーム名よみがな, 性別, 生年月日, 電話, メールアドレス, 保護者メアド, 現住所〒1, 現住所〒2, 都道府県, 市区町村, 町名, 番地１, 番地2, 番地3, 建物名, 部屋番号・階, 入会日時, 現表示名(本名・読Qネーム), 顔登録日, 顔の書類画像の照合, 前回顔登録日, 現ポイント, 現在の級, 登録した本の数, 認定されたクイズ数, 受検回数, 合格回数, 試験監督した回数, 試験監督した実人数, 適性検査合格日, 監修本の数, 著書読Q本の数, 本棚公開非公開, 所属学校(教員), 役職名, 所属日, 現担任学年, 現担任学級, 所属学校(生徒), 現　学年, 現　学級, 現　担任, 入学・転入日, メモ";
        $header = mb_convert_encoding($header, 'shift_jis');
        fwrite($pFile, $header.PHP_EOL);

        $users = User::where('role', '>', 0)
                    ->orderby('id', 'desc');

        switch ($period_sel) {
            case '1':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("12 hours")));
                break;
            case '2':
                $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
                if(isset($users) && $users !== null)
                    $users = $users->where("created_at" , "like", $yesterday . "%");
                break;
            case '3':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 weeks")));
                break;
            case '4':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 months")));
                break;
            case '5':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("3 months")));
                break;
            case '6':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("6 months")));
                break;
            case '7':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 years")));
                break;    
            default:
                break;
        }

        $users = $users->get();
        //$users = User::getAllMembers();
        foreach ($users as $user) {

            $content = "";
            $user->total_point = UserQuiz::TotalPoint($user->id);
            $user->rank = 10;
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
                if ($user->total_point >= $ranks[$i] && $user->total_point < $ranks[$i - 1]) {
                    $user->rank = $i;
                }
            }
            $user->allowedbooks = UserQuiz::AllowedBooks($user->id)->get();
            $user->allowedquizes = UserQuiz::AllUserQuizes($user->id)->get()->count();
            $user->testquizes = UserQuizesHistory::testQuizes($user->id)->get()->count();
            $user->testallowedquizes = UserQuiz::testAllowedQuizes($user->id)->get()->count();
            $user->testoverseer = UserQuizesHistory::testOverseer($user->id)->get()->count();
            $user->testoverseers = UserQuizesHistory::testOverseers($user->id)->get()->count();
            $user->overseerbooks = Books::where('active', '<>', 7)->where('overseer_id', $user->id)->get();
            $authorbooks = Books::where('active','>=', 1)->where('active', '<', 7);
            if($user->fullname_nick() != '' && $user->fullname_nick() !== null && $user->fullname_nick() != ' '){
                $authorbooks = $authorbooks->where('firstname_nick', $user->firstname_nick)->where('lastname_nick', $user->lastname_nick);
            }
            $user->authorbooks = $authorbooks->get();

            if($user->role == config('consts')['USER']['ROLE']["PUPIL"]){
                $user->pupilHistories = PupilHistory::GetPupilHistories($user->id);
            }
            $date=date_create($user->created_at);
            // date_add($date,date_interval_create_from_date_string("1 years"));
            // $user->period = date_format($date,"Y-m-d");

            $content .= date_format(date_create($user->created_at), "Y-n-j H:i:s").",";
            $content .= $user->username.",";
            if($user->isPupil() && $user->properties != 2 && $user->active == 1){
                $content .= config('consts')['PROPERTIES'][$user->properties].",";
            }
            elseif($user->active == 1){
                $content .= config('consts')['USER']['TYPE'][$user->role]."会員,";
            }
            elseif($user->active >= 2){
                $content .= config('consts')['USER']['TYPE'][$user->role]."準会員,";
            }
            if($user->period !== null && $user->period !== ""){
                $content .= date_format(date_create($user->period), "Y.n.j").",";
            }
            else{
                $content .= ",";
            }
            $content .= $user->pay_content." ".$user->pay_amount.",";
            $content .= $user->r_password.",";
            $content .= $user->firstname.",";
            $content .= $user->lastname.",";
            $content .= $user->firstname_yomi.",";
            $content .= $user->lastname_yomi.",";
            $content .= $user->firstname_roma.",";
            $content .= $user->lastname_roma.",";
            $content .= $user->firstname_nick.",";
            $content .= $user->lastname_nick.",";
            $content .= $user->firstname_nick_yomi.",";
            $content .= $user->lastname_nick_yomi.",";
            $content .= config('consts')['USER']['GENDER'][$user->gender].",";
            $content .= $user->birthday.",";
            $content .= $user->phone.",";
            $content .= $user->email.",";
            $content .= $user->teacher.",";
            $content .= $user->address4.",";
            $content .= $user->address5.",";
            $content .= $user->address1.",";
            $content .= $user->address2.",";
            $content .= $user->address3.",";
            $content .= $user->address6.",";
            $content .= $user->address7.",";
            $content .= $user->address8.",";
            $content .= $user->address9.",";
            $content .= $user->address10.",";
            $content .= $user->replied_date2.",";
            if($user->fullname_is_public) $content .= $user->fullname().",";// 現表示名(本名・読Qネーム)
            else $content .= $user->username.",";// 現表示名(本名・読Qネーム)
            $content .= $user->imagepath_date.","; //顔登録日
            $content .= $user->imagepath.","; // 顔の書類画像の照合
            $content .= $user->imagepath_date.","; //前回顔登録
            $content .= $user->total_point.",";
            $content .= $user->rank.",";
            $content .= $user->allowedbooks->count().",";
            $content .= $user->allowedquizes.",";
            $content .= $user->testquizes.",";
            $content .= $user->testallowedquizes.",";
            $content .= $user->testoverseer.",";
            $content .= $user->testoverseers.",";
            if($user->replied_date4) {
                $replied_date4 = date_format(date_create($user->replied_date4), "Y-m-d");
                $content .= $replied_date4.",";
            }else $content .= ",";  // 適性検査合格日
            $content .= $user->overseerbooks->count().",";
            $content .= count($user->allowedbooks).",";
            if($user->book_allowed_record_is_public == 1) $content .= "公開,"; else $content .= "非公開,";
            if($user->isSchoolMember()){
                $user->teacherHistories = TeacherHistory::GetTeacherHistories($user->id)->first();
                if(!is_null($user->teacherHistories)){
                    $content .= $user->teacherHistories->group_name.",";
                    if($user->teacherHistories->teacher_role == config('consts')['USER']['ROLE']['TEACHER']) $content .= "教員, ";
                    elseif($user->teacherHistories->teacher_role == config('consts')['USER']['ROLE']['LIBRARIAN']) $content .= "司書 ,";
                    elseif($user->teacherHistories->teacher_role == config('consts')['USER']['ROLE']['REPRESEN']) $content .= "代表（校長、教頭等）, ";
                    elseif($user->teacherHistories->teacher_role == config('consts')['USER']['ROLE']['ITMANAGER']) $content .= "IT担当者, ";
                    elseif($user->teacherHistories->teacher_role == config('consts')['USER']['ROLE']['OTHER']) $content .= "その他 ,";  
                    $content .= $user->teacherHistories->created_at." ,";
                    if($user->teacherHistories->grade != 0)  $content .= $user->teacherHistories->grade."年,";
                    else $content .= "";
                    $content .= $user->teacherHistories->class_number."組 ,";
                }
                else{
                    $content .= ","; //所属学校(教員)
                    $content .= ","; //役職名
                    $content .= ","; //所属日
                    $content .= ","; //現担任学年
                    $content .= ","; //現担任学級
                }
            }
            else{
                $content .= ","; //所属学校(教員)
                $content .= ","; //役職名
                $content .= ","; //所属日
                $content .= ","; //現担任学年
                $content .= ","; //現担任学級
            }
            if($user->role == config('consts')['USER']['ROLE']["PUPIL"]){
                $user->pupilHistories = PupilHistory::GetPupilHistories($user->id)->first();
                if(!is_null($user->pupilHistories)){
                    $content .= $user->pupilHistories->group_name." ,";
                    if($user->pupilHistories->grade != 0) $content .= $user->pupilHistories->grade."年";
                    else $content .= "";
                    $content .= $user->pupilHistories->class_number."組 ,";
                    $content .= $user->pupilHistories->teacher_name.", ";
                    $content .= $user->pupilHistories->created_at." ";
                    $content .= $user->pupilHistories->updated_at." ,";
                }
                else{
                    $content .= ",";
                    $content .= ",";
                    $content .= ",";
                    $content .= ",";
                    $content .= ",";
                }
            }
            else{
                $content .= ",";
                $content .= ",";
                $content .= ",";
                $content .= ",";
                $content .= ",";
            } 
            $content .= $user->memo."";
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);

        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '会員情報.csv');

    }

    //=========booktype = data_card_org ===========================//
    public function exportGrouplList(Request $request){
        $period_sel = $request->input('period_sel');
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        
        $header = "入会年月日, 読Ｑネーム, パスワード, 団体名, よみがな, ローマ字, 代表者, ＩＴ担当者, 担当者メアド, 〒3桁, 〒4桁, 都道府県, 市区町村, 町名, 番地, 電話番号, 団体形態, 代表本人確認人書類, 学校IPアドレス, ネットマスク, 現有効期限, 現 教職員人数, 現 児童生徒人数, メモ";
        $header = mb_convert_encoding($header, 'shift_jis');
        fwrite($pFile, $header.PHP_EOL);

        $users = User::where('role', '=', 0)
                    ->orderby('id', 'desc');

        switch ($period_sel) {
            case '1':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("12 hours")));
                break;
            case '2':
                $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
                if(isset($users) && $users !== null)
                    $users = $users->where("created_at" , "like", $yesterday . "%");
                break;
            case '3':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 weeks")));
                break;
            case '4':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 months")));
                break;
            case '5':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("3 months")));
                break;
            case '6':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("6 months")));
                break;
            case '7':
                if(isset($users) && $users !== null)
                    $users = $users->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 years")));
                break;    
            default:
                break;
        }

        $users = $users->get();
        //$users = User::getAllMembers();
        foreach ($users as $user) {

            $content = "";

            $content .= date_format(date_create($user->created_at), "Y-n-j H:i:s").",";
            $content .= $user->username.",";
            $content .= $user->r_password.",";
            $content .= $user->group_name.",";
            $content .= $user->group_yomi.",";
            $content .= $user->group_roma.",";
            $content .= $user->rep_name.",";
            if(!is_null($user->getITmanager($user->id))){
                $content .= $user->getITmanager($user->id)->firstname." ".$user->getITmanager($user->id)->lastname.",";
            }
            else{
                $content .= ",";
            }
            $content .= $user->email.",";
            $content .= $user->address4.",";
            $content .= $user->address5.",";
            $content .= $user->address1.",";
            $content .= $user->address2.",";
            $content .= $user->address3.",";
            $content .= $user->address6.",";
            $content .= $user->phone.",";
            $content .= config('consts')['USER']['GROUP_TYPE'][1][$user->group_type].",";
            $content .= ",";
            $content .= $user->ip_address.",";
            $content .= $user->mask.",";
            $content .= ",";
            $content .= $user->totalTeacherCounts().",";
            $content .= $user->totalMemberCounts().",";
            $content .= $user->memo.",";
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);

        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '団体情報.csv');

    }
    
    public function exportOrguseData(Request $request, $id=null){

        if($id == null) return;
       
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "";
        $header = "タイムスタンプ,読Qネーム,団体読Ｑネーム,項目,作業/判定,対象 読Qﾈｰﾑ,現 対象学年、クラス,内容、文面,新年度,point";
        $header = mb_convert_encoding($header, 'shift_jis');
        fwrite($pFile, $header.PHP_EOL);

        $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
        foreach ($orgworkHistories as $key => $orgworkHistory) {
            $content = "";
            $content .= $orgworkHistory->created_at.",";
            $content .= $orgworkHistory->username.",";
            $content .= $orgworkHistory->group_name.",";
            $content .= config('consts')['HISTORY']['ORGWORK_HISTORY'][$orgworkHistory->item]['ITEM'].",";
            $content .= config('consts')['HISTORY']['ORGWORK_HISTORY'][$orgworkHistory->item]['WORK'][$orgworkHistory->work_test].",";
            $content .= $orgworkHistory->objuser_name.",";
            $content .= $orgworkHistory->class.",";
            $content .= $orgworkHistory->content.",";
            $content .= $orgworkHistory->newyear.",";
            $content .= $orgworkHistory->point.",";
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '団体会員履歴.csv');
    }


    public function exportOrgData(Request $request){
        $period_sel = $request->input('period_sel');
        $data_usehistory_sel = $request->input('data_usehistory_sel'); 
        //$usetype_sel = $request->input('usetype_sel');

        switch ($data_usehistory_sel) {
            case '1':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
            case '2':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
            case '3':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
            case '4':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
            case '5':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
            case '6':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
            case '7':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break; 
            case '8':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;    
            default:
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
                break;
        }

        switch ($period_sel) {
            case '1':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                    
                break;
            case '2':
                $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where("created_at" , "like", $yesterday . "%");
                break;
            case '3':
                
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                
                break;
            case '4':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                
                break;
            case '5':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                
                break;
            case '6':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                
                break;
            case '7':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                
                break;    
            default:
               
                break;
        }

        if(isset($orgworkHistories) && $orgworkHistories !== null){

            $filename = time().".csv";
            $pFile = fopen($filename, "wb");
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,団体読Ｑネーム,対象 読Qﾈｰﾑ,現 対象学年、クラス,内容、文面,新年度,point";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
            foreach ($orgworkHistories as $key => $orgworkHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['ORGWORK_HISTORY'][$orgworkHistory->item]['WORK'][$orgworkHistory->work_test].",";
                $content .= $orgworkHistory->created_at.",";
                $content .= $orgworkHistory->username.",";
                $content .= $orgworkHistory->group_name.",";
                $content .= $orgworkHistory->objuser_name.",";
                $content .= $orgworkHistory->class.",";
                $content .= $orgworkHistory->content.",";
                $content .= $orgworkHistory->newyear.",";
                $content .= $orgworkHistory->point.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }

            //fwrite($pFile, "1,2,3" . PHP_EOL);
            fclose($pFile);
            $output = new PHPExcel_Output();
            $output->_send($filename, "csv", '団体会員履歴.csv');
        }

        if($data_usehistory_sel == 2 || $data_usehistory_sel == 3 || $data_usehistory_sel == 4 || $data_usehistory_sel == 5 || $data_usehistory_sel == 6 || $data_usehistory_sel == 7 || $data_usehistory_sel == 8){
        
               
            $filename = time().".csv";
            //$filename = "csv/temp.csv";
            //if(copy($filename, $new_filename))

            $pFile = fopen($filename, "wb");
            $header = "読Ｑネーム,団体名,よみがな,ローマ字,パスワード,代表者,代表者役職,ＩＴ担当者,担当者メアド,〒3桁,〒4桁,都道府県,市区町村,町名,電話番号,団体形態,入会年月日,代表本人確認人書類,書類画像,ＷｉＦｉ,有効期限,教頭,司書,教員情報,生徒情報,全生徒平均読Ｑポイント今年度通算,市区町村内順位,都道府県内順位,全国順位";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);
            
            $users = User::getAllGroups();
            foreach ($users as $key => $user) {
                $content = "";
                $user = User::find($user->id);
                //$user = User::find($id);
                $sql_represen="(select * from users where role=".config('consts')['USER']['ROLE']["REPRESEN"]." and active=1 and org_id=".$user->id.") as table1";
                $sql_librarian="(select * from users where role=".config('consts')['USER']['ROLE']["LIBRARIAN"]." and active=1 and org_id=".$user->id.") as table1";
                
                $represen_number = DB::table(DB::raw($sql_represen))
                    ->count();
                $librarian_number = DB::table(DB::raw($sql_librarian))
                    ->count();
                $classes = DB::table('classes') 
                        ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"),"a.username")
                        ->leftJoin('users as a','classes.teacher_id','=','a.id')
                        //->leftJoin('users as b','classes.teacher_id','=','b.id')
                        ->where('classes.group_id', $user->id)
                        ->where('classes.member_counts','>',0)
                        ->where('classes.active','=',1)
                        ->where( function ($query) {
                             $query->whereNotNull('class_number')
                             ->orWhere('grade', '>', 0);
                         })
                        ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                        ->get();   
                 $pupils = DB::table('classes') 
                     ->select("classes.*", DB::raw("concat(a.firstname, ' ', a.lastname) as teacher_name"),"a.username")
                     ->leftJoin('users as a','classes.id','=','a.org_id')
                     ->where('a.role', config('consts')['USER']['ROLE']["PUPIL"])
                    //->leftJoin('users as b','classes.teacher_id','=','b.id')
                    ->where('classes.group_id', $user->id)
                    ->where('classes.active','=',1)
                    ->where( function ($query) {
                         $query->whereNotNull('class_number')
                         ->orWhere('grade', '>', 0);
                     })
                    ->orderBy(DB::raw("classes.grade asc, classes.class_number"), 'asc')
                    ->get();  
                $date=date_create($user->created_at);
                date_add($date,date_interval_create_from_date_string("1 years"));
                $user->period = date_format($date,"Y-m-d"); 

                $content .= $user->username.",";
                $content .= $user->group_name.",";
                $content .= $user->group_yomi.",";
                $content .= $user->group_roma.",";
                $content .= $user->r_password.",";
                $content .= $user->rep_name.",";
                $content .= $user->rep_post.",";
                $content .= $user->teacher.",";
                $content .= $user->email.",";
                $content .= $user->address4.",";
                $content .= $user->address5.",";
                $content .= $user->address1.",";
                $content .= $user->address2.",";
                $content .= $user->address3.",";
                $content .= $user->phone.",";
                $content .= config('consts')['USER']['GROUP_TYPE'][1][$user->group_type].",";
                $content .= $user->replied_date3.",";
                $content .= config('consts')['USER']['AUTH_TYPE'][0]['CONTENT'][$user->auth_type].",";
                $content .= $user->file.",";
                $content .= $user->wifi.",";
                $content .= $user->period.",";
                $content .= $represen_number.",";
                $content .= $librarian_number.",";
                
                foreach($classes as $key=>$class){
                    $classname = "";
                    if($class->grade == 0)                                 
                        $classname .= $class->class_number."組";
                    elseif($class->class_number == '' || $class->class_number == null)
                        $classname .= $class->grade."年";
                    else
                        $classname .= $class->grade."年".$class->class_number."組"; 
                    $classname .= "担任";
                    //$header .= $classname.","; 
                    //$content .= $class->teacher_name.",";
                    
                    if($key + 1 == count($classes))
                        $content .= $classname." ".$class->teacher_name." ";
                    else
                        $content .= $classname." ".$class->teacher_name."、";
                }   
                
                $content .= ",";
                foreach($classes as $class){
                    $classname = "";
                    if($class->grade == 0)                                 
                        $classname .= $class->class_number."組 ";
                    elseif($class->class_number == '' || $class->class_number == null)
                        $classname .= $class->grade."年";
                    else
                        $classname .= $class->grade."年".$class->class_number."組 "; 
                    //$classname .= "全生徒読Qネーム";
                    //$header .= $classname.","; 
                    foreach($pupils as $pupil){
                        if($class->id == $pupil->id)
                            $content .= $classname." ".$pupil->username."、";
                    }
                }
                
                //$header .= "全生徒平均読Ｑポイント今年度通算,市区町村内順位,都道府県内順位,全国順位"; 
                $content .= ",";
                $content .= GroupController::Calc_school_avg($user->id, 'year').",";
                $content .= GroupController::School_rank1($user->id, $user, 'year', 'city').",";
                $content .= GroupController::School_rank1($user->id, $user, 'year', 'province').",";
                $content .= GroupController::School_rank1($user->id, $user, 'year', 'overall').",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            
            //fwrite($pFile, "1,2,3" . PHP_EOL);
            fclose($pFile);
            $output = new PHPExcel_Output();
            $output->_send($filename, "csv", '団体情報.csv');
        }

    }

    //=========booktype = data_card_book ===========================//
    public function exportBookData(Request $request, $id=null){

        // if($id == null) return;
        $period_sel = $request->input('period_sel');
        
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "読Ｑ本ＩＤ, タイトル, タイトルよみがな, 著者ペンネーム姓, 著者ペンネーム名, 著者よみがな姓, 著者よみがな名, 著者読Ｑネーム, 出版社, ＩＳＢＮ, 読Q認定日 ,読Ｑ本ポイント, 出題数, 時短最大秒数, 読Q推薦図書か, 書店URL, 紙or青空電子, 推奨年代, 係数, ジャンル１, ジャンル２, ジャンル３, ジャンル４, 行数, 1行字数, 本文頁数, 空白頁数, 3/4空白頁数, 1/2空白頁数, 1/4空白頁数, p30短行数, p50短行数, p70短行数, p90短行数, p110短行数, 総字数, 参考字数, 登録者読Ｑネーム, 監修者読Ｑネーム, 著者監修者読Qネーム, 保有クイズ数, 受検回数, 受検者実数, 合格者数, 帯文数, 良書と認めた人数, 前年度合格者数順位/全登録冊数";
        $header = mb_convert_encoding($header, 'shift_jis');
        fwrite($pFile, $header.PHP_EOL);
        
        $books = Books::where('active', '<>', 7)->orderby('created_at', 'desc')->get();
        switch ($period_sel) {
            case '1':
                if(isset($books) && $books !== null)
                    $books = $books->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("12 hours")));
                break;
            case '2':
                $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
                if(isset($books) && $books !== null)
                    $books = $books->where("created_at" , "like", $yesterday . "%");
                break;
            case '3':
                if(isset($books) && $books !== null)
                    $books = $books->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 weeks")));
                break;
            case '4':
                if(isset($books) && $books !== null)
                    $books = $books->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 months")));
                break;
            case '5':
                if(isset($books) && $books !== null)
                    $books = $books->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("3 months")));
                break;
            case '6':
                if(isset($books) && $books !== null)
                    $books = $books->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("6 months")));
                break;
            case '7':
                if(isset($books) && $books !== null)
                    $books = $books->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:s")),date_interval_create_from_date_string("1 years")));
                break;    
            default:
                break;
        }
       foreach ($books as $book) {
            $content = "";
            $book = Books::find($book->id);
            $author = User::where('firstname_nick', $book->firstname_nick)->where('lastname_nick', $book->lastname_nick)->where('role', config('consts')['USER']['ROLE']['AUTHOR'])->where('users.active','>=', 1)->first();
        
            if(!is_null($author) && count(get_object_vars($author)) > 0 ){
                $book->username = $author->username;
            }
            else{
                $book->username = "";
            }
            
            $book->angate = Angate::where('book_id', $id)->where('value', 1)->get()->count();
            $categories = $book->categories()->get();

            $content .= "dq".$book->id.","; //読Ｑ本ＩＤ
            $content .= $book->title.","; //タイトル
            $content .= $book->title_furi.","; //タイトルよみがな
            $content .= $book->firstname_nick.","; //著者ペンネーム姓
            $content .= $book->lastname_nick.","; //著者ペンネーム名
            $content .= $book->firstname_yomi.","; //著者よみがな姓
            $content .= $book->lastname_yomi.","; //著者よみがな名
            $content .= $book->username.","; //著者読Ｑネーム
            $content .= $book->publish.","; //出版社
            $content .= $book->isbn.","; //ＩＳＢＮ
            if($book->replied_date1 && $book->replied_date1 != "0000-00-00 00:00:00") {
                $replied_date1 = date_format(date_create($book->replied_date1), "Y-m-d");
                $content .= $replied_date1.","; //読Q認定日
            }else $content .= ","; //読Q認定日
            $content .= $book->point.","; //読Ｑ本ポイント
            $content .= $book->quiz_count.","; //出題数
            $content .= $book->test_short_time.","; //時短最大秒数
            if($book->recommend_flag !== null && $book->recommend_flag != '0000-00-00')
                $content .= "推薦図書,"; //読Q推薦図書か
            else
                $content .= ","; //読Q推薦図書か
            $content .= $book->url.","; //書店URL
            $content .= config('consts')['BOOK']['TYPE'][$book->type].","; //紙or青空電子
            $content .= config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE'].","; //推奨年代
            $content .= $book->recommend_coefficient.","; //係数
            if(isset($categories[0])) $content .= $categories[0]['name'].","; //ジャンル１
            else $content .= ","; //ジャンル１
            if(isset($categories[1])) $content .= $categories[1]['name'].","; //ジャンル2
            else $content .= ","; //ジャンル2
            if(isset($categories[2])) $content .= $categories[2]['name'].","; //ジャンル3
            else $content .= ","; //ジャンル3
            if(isset($categories[3])) $content .= $categories[3]['name'].","; //ジャンル4
            else $content .= ","; //ジャンル4
            $content .= $book->max_rows.","; //行数
            $content .= $book->max_chars.","; //1行字数
            $content .= $book->pages.","; //本文頁数
            $content .= $book->entire_blanks.","; //空白頁数
            $content .= $book->quarter_filled.","; //3/4空白頁数
            $content .= $book->half_blanks.","; //1/2空白頁数
            $content .= $book->quarter_blanks.","; //1/4空白頁数
            $content .= $book->p30.","; //p30短行数
            $content .= $book->p50.","; //p50短行数
            $content .= $book->p70.","; //p70短行数
            $content .= $book->p90.","; //p90短行数
            $content .= $book->p110.","; //p110短行数
            $content .= $book->total_chars.","; //総字数
            $content .= ","; //参考字数
            if(isset($book->Register) && $book->Register !== null && $book->register_id != 0)
                $content .= $book->Register->username.","; // 登録者読Ｑネーム
            else
                $content .= ","; // 登録者読Ｑネーム
            if(isset($book->Overseer)) $content .= $book->Overseer->username.",";  // 監修者読Ｑネーム
            else $content .= ","; // 監修者読Ｑネーム
            $content .= ",";//著者監修者読Qネーム
            $content .= $book->ActiveQuizes->count().","; //保有クイズ数
            $content .= $book->TestedNums->count().","; //受検回数
            $content .= $book->TestedRealNums->count().","; //受検者実数
            $content .= $book->passedNums->count().","; //合格者数
            $content .= $book->Articles->count().","; //帯文数
            $content .= $book->angate.","; //良書と認めた人数
            $content .= $book->Rank_tested_lastyear($book->id)."/".$book->Registered_book_counter()->count().","; //前年度合格者数順位/全登録冊数
            $content .= ",";
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '読Ｑ本情報.csv');
    }
    
    //=========  data_card_quiz ===========================//
    public function exportQuizData(Request $request, $id=null, $quizid=null){

        if($id == null) return;
       
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");
        $header = "クイズ№,文面,出典,認定日,作成者,認定した監修者ID,出題回数,正答数,誤答数,時短正答数";
        $header = mb_convert_encoding($header, 'shift_jis');
        fwrite($pFile, $header.PHP_EOL);
        
        if($quizid !== null && $quizid != 'null')
            $quizes = Quizes::where('id', $quizid)->where('active', 2)->orderby('book_id', 'desc')->get();
        else
            $quizes = Quizes::where('book_id', $id)->where('active', 2)->orderby('book_id', 'desc')->get();
        
        foreach ($quizes as $key => $quiz) {
            $content = "";
            $book = Books::find($quiz->book_id);
            $quizshorttime = floor($book->test_short_time/$book->quiz_count);
            $quiz->quizanswerright = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->get()->count();
            $quiz->quizanswerwrong = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 3)->get()->count(); 
            $quiz->quizanswer = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->orwhere('work_test', 3)->get()->count();
            $quiz->quizanswershorttime = PersontestHistory::where('quiz_id',$quiz->id)->where('item', 0)->where('work_test', 2)->where('tested_time', '<', $quizshorttime)->get()->count();

            $content .= $quiz->doq_quizid.",";
            $content .= $quiz->question.",";
            $content .= config('consts')['QUIZ']['APP_RANGES'][$quiz->app_range].",";
            $content .= date_format(date_create($quiz->published_date),'Y-m-d').",";
            $content .= $quiz->RegisterShow().",";
            $content .= $quiz->OverseerShow().",";
            $content .= $quiz->quizanswer.",";
            $content .= $quiz->quizanswerright.",";
            $content .= $quiz->quizanswerwrong.",";
            $content .= $quiz->quizanswershorttime.",";
         
            $content = mb_convert_encoding($content, 'shift_jis');
            fwrite($pFile, $content.PHP_EOL);
        }
        
        //fwrite($pFile, "1,2,3" . PHP_EOL);
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", 'クイズ情報.csv');
    }

    //=========booktype = per_use_history ===========================//
    public function exportPersonaluseData(Request $request){
        $period_sel = $request->input('period_sel');
        $per_usehistory_sel = $request->input('per_usehistory_sel');
        $usetype_sel = $request->input('usetype_sel');

        switch ($per_usehistory_sel) {
            case '1':
                $persontestHistories = PersontestHistory::orderby('created_at', 'asc');
                break;
            case '2':
                $personworkHistories = PersonworkHistory::orderby('created_at', 'asc');
                break;
            case '3':
                $personcontributionHistories = PersoncontributionHistory::orderby('created_at', 'asc');
                break;
            case '4':
                $personquizHistories = PersonquizHistory::orderby('created_at', 'asc');
                break;
            case '5':
                $personoverseerHistories = PersonoverseerHistory::orderby('created_at', 'asc');
                break;
            case '6':
                $persontestoverseeHistories = PersontestoverseeHistory::orderby('created_at', 'asc');
                break;
            case '7':
                $personbooksearchHistories = PersonbooksearchHistory::orderby('created_at', 'asc');
                break; 
            case '8':
                $personadminHistories = PersonadminHistory::orderby('created_at', 'asc');
                break;    
            default:
                $persontestHistories = PersontestHistory::orderby('created_at', 'asc');
                $personworkHistories = PersonworkHistory::orderby('created_at', 'asc');
                $personcontributionHistories = PersoncontributionHistory::orderby('created_at', 'asc');
                $personquizHistories = PersonquizHistory::orderby('created_at', 'asc');
                $personoverseerHistories = PersonoverseerHistory::orderby('created_at', 'asc');
                $persontestoverseeHistories = PersontestoverseeHistory::orderby('created_at', 'asc');
                $personbooksearchHistories = PersonbooksearchHistory::orderby('created_at', 'asc');
                $personadminHistories = PersonadminHistory::orderby('created_at', 'asc');
                break;
        }

        switch ($period_sel) {
            case '1':
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                break;
            case '2':
                $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where("created_at" , "like", $yesterday . "%");
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where("created_at" , "like", $yesterday . "%");
                break;
            case '3':
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                break;
            case '4':
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                break;
            case '5':
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                break;
            case '6':
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                break;
            case '7':
                if(isset($persontestHistories) && $persontestHistories !== null)
                    $persontestHistories = $persontestHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($personworkHistories) && $personworkHistories !== null)
                    $personworkHistories = $personworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                    $personcontributionHistories = $personcontributionHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($personquizHistories) && $personquizHistories !== null)
                    $personquizHistories = $personquizHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                    $personoverseerHistories = $personoverseerHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                    $persontestoverseeHistories = $persontestoverseeHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                    $personbooksearchHistories = $personbooksearchHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                if(isset($personadminHistories) && $personadminHistories !== null)
                    $personadminHistories = $personadminHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                break;    
            default:
               
                break;
        }
        if(isset($usetype_sel) && $usetype_sel !== null){
            if(isset($persontestHistories) && $persontestHistories !== null)
                $persontestHistories = $persontestHistories->whereIn('work_test',$usetype_sel);
            if(isset($personworkHistories) && $personworkHistories !== null)
                $personworkHistories = $personworkHistories->whereIn('work_test',$usetype_sel);
            if(isset($personcontributionHistories) && $personcontributionHistories !== null)
                $personcontributionHistories = $personcontributionHistories->whereIn('work_test',$usetype_sel);
            if(isset($personquizHistories) && $personquizHistories !== null)
                $personquizHistories = $personquizHistories->whereIn('work_test',$usetype_sel);
            if(isset($personoverseerHistories) && $personoverseerHistories !== null)
                $personoverseerHistories = $personoverseerHistories->whereIn('work_test',$usetype_sel);
            if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null)
                $persontestoverseeHistories = $persontestoverseeHistories->whereIn('work_test',$usetype_sel);
            if(isset($personbooksearchHistories) && $personbooksearchHistories !== null)
                $personbooksearchHistories = $personbooksearchHistories->whereIn('work_test',$usetype_sel);
            if(isset($personadminHistories) && $personadminHistories !== null)
                $personadminHistories = $personadminHistories->whereIn('work_test',$usetype_sel);
        }
        $filename = time().".csv";
        $pFile = fopen($filename, "wb");

        if(isset($persontestHistories) && $persontestHistories !== null){
        
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,年齢,都道府県,市町村,読Q本ID,書籍名,著者,クイズ№,出題順番,試験監督,かかった秒数,獲得読Q本point,獲得時短point,現在の生涯point,現時点の級,現時点の今年度point";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$persontestHistories = PersontestHistory::orderby('created_at', 'asc')->get();
            $persontestHistories = $persontestHistories->get();
            foreach ($persontestHistories as $key => $persontestHistory) {
                $content = "";
                if($persontestHistory->work_test >= 4){
                    $testnumber = $persontestHistory->work_test-3;
                    $content .= '不合格'.$testnumber.'度目'.",";
                }
                else{
                   $content .= config('consts')['HISTORY']['QUIZTEST_HISTORY'][$persontestHistory->item]['WORK'][$persontestHistory->work_test].",";
                }
                $content .= $persontestHistory->created_at.",";
                $content .= $persontestHistory->username.",";
                if($persontestHistory->age != 0 && $persontestHistory->age !== null)
                    $content .= $persontestHistory->age.",";
                else
                    $content .= ",";
                $content .= $persontestHistory->address1.",";
                $content .= $persontestHistory->address2.",";
                if($persontestHistory->book_id) $content .= "dq".$persontestHistory->book_id.",";
                else $content .= ",";
                $content .= $persontestHistory->title.",";
                $content .= $persontestHistory->writer.",";
                $content .= $persontestHistory->doq_quizid.",";
                $content .= $persontestHistory->quiz_order.",";
                $content .= $persontestHistory->testoversee_username.",";
                $content .= $persontestHistory->tested_time.",";
                $content .= $persontestHistory->tested_point.",";
                $content .= $persontestHistory->tested_short_point.",";
                $content .= $persontestHistory->point.",";
                $content .= $persontestHistory->rank.",";
                $content .= $persontestHistory->thisyear_point.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }  

        if(isset($personworkHistories) && $personworkHistories !== null){  
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,会員種別,年齢,都道府県,市町村,所属団体読Qネーム,内容,金額,有効期限更新";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$personworkHistories = PersonworkHistory::orderby('created_at', 'asc')->get();
            $personworkHistories = $personworkHistories->get();
            foreach ($personworkHistories as $key => $personworkHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['USERWORK_HISTORY'][$personworkHistory->item]['WORK'][$personworkHistory->work_test].",";
                $content .= $personworkHistory->created_at.",";
                $content .= $personworkHistory->username.",";
                $content .= $personworkHistory->user_type.",";
                if($personworkHistory->age != 0 && $personworkHistory->age !== null)
                    $content .= $personworkHistory->age.",";
                else
                    $content .= ",";
                $content .= $personworkHistory->address1.",";
                $content .= $personworkHistory->address2.",";
                $content .= $personworkHistory->org_username.",";
                $content .= $personworkHistory->content.",";
                $content .= $personworkHistory->pay_point.",";
                $content .= $personworkHistory->period.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }

        if(isset($personcontributionHistories) && $personcontributionHistories !== null){  
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,年齢,読Q本ID,書籍名,著者,内容,対象 読Qﾈｰﾑ,いいね！した帯文";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$personcontributionHistories = PersoncontributionHistory::orderby('created_at', 'asc')->get();
            $personcontributionHistories = $personcontributionHistories->get();
            foreach ($personcontributionHistories as $key => $personcontributionHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['CONTRIBUTION_HISTORY'][$personcontributionHistory->item]['WORK'][$personcontributionHistory->work_test].",";
                $content .= $personcontributionHistory->created_at.",";
                $content .= $personcontributionHistory->username.",";
                if($personcontributionHistory->age != 0 && $personcontributionHistory->age !== null)
                    $content .= $personcontributionHistory->age.",";
                else
                    $content .= ",";
                if($personcontributionHistory->book_id) $content .= "dq".$personcontributionHistory->book_id.",";
                else $content .= ",";
                $content .= $personcontributionHistory->title.",";
                $content .= $personcontributionHistory->writer.",";
                $content .= $personcontributionHistory->content.",";
                $content .= $personcontributionHistory->bookregister_name.",";
                $content .= $personcontributionHistory->ok_content.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }

        if(isset($personquizHistories) && $personquizHistories !== null){  
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,年齢,読Q本ID,書籍名,著者,クイズ№,獲得point,現在の生涯point,現在の級,内容";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$personquizHistories = PersonquizHistory::orderby('created_at', 'asc')->get();
            $personquizHistories = $personquizHistories->get();
            foreach ($personquizHistories as $key => $personquizHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['BOOKQUIZ_HISTORY'][$personquizHistory->item]['WORK'][$personquizHistory->work_test].",";
                $content .= $personquizHistory->created_at.",";
                $content .= $personquizHistory->username.",";
                if($personquizHistory->age != 0 && $personquizHistory->age !== null)
                    $content .= $personquizHistory->age.",";
                else
                    $content .= ",";
                if($personquizHistory->book_id) $content .= "dq".$personquizHistory->book_id.",";
                 else $content .= ",";
                $content .= $personquizHistory->title.",";
                $content .= $personquizHistory->writer.",";
                $content .= $personquizHistory->doq_quizid.",";
                $content .= $personquizHistory->quiz_point.",";
                $content .= $personquizHistory->point.",";
                $content .= $personquizHistory->rank.",";
                $content .= $personquizHistory->content.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }

        if(isset($personoverseerHistories) && $personoverseerHistories !== null){  
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,年齢,読Q本ID,書籍名,著者,クイズ№,対象 読Qﾈｰﾑ,内容";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$personoverseerHistories = PersonoverseerHistory::orderby('created_at', 'asc')->get();
            $personoverseerHistories = $personoverseerHistories->get();
            foreach ($personoverseerHistories as $key => $personoverseerHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['OVERSEER_HISTORY'][$personoverseerHistory->item]['WORK'][$personoverseerHistory->work_test].",";
                $content .= $personoverseerHistory->created_at.",";
                $content .= $personoverseerHistory->username.",";
                if($personoverseerHistory->age != 0 && $personoverseerHistory->age !== null)
                    $content .= $personoverseerHistory->age.",";
                else
                    $content .= ",";
                if($personoverseerHistory->book_id) $content .= "dq".$personoverseerHistory->book_id.",";
                else $content .= ",";
                $content .= $personoverseerHistory->title.",";
                $content .= $personoverseerHistory->writer.",";
                $content .= $personoverseerHistory->doq_quizid.",";
                $content .= $personoverseerHistory->bookregister_name.",";
                $content .= $personoverseerHistory->content.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }

        if(isset($persontestoverseeHistories) && $persontestoverseeHistories !== null){  
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,年齢,都道府県,市町村,読Q本ID,書籍名,著者,対象 読Qﾈｰﾑ,監督回数";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$persontestoverseeHistories = PersontestoverseeHistory::orderby('created_at', 'asc')->get();
            $persontestoverseeHistories = $persontestoverseeHistories->get();
            foreach ($persontestoverseeHistories as $key => $persontestoverseeHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['TESTOVERSEE_HISTORY'][$persontestoverseeHistory->item]['WORK'][$persontestoverseeHistory->work_test].",";
                $content .= $persontestoverseeHistory->created_at.",";
                $content .= $persontestoverseeHistory->username.",";
                if($persontestoverseeHistory->age != 0 && $persontestoverseeHistory->age !== null)
                    $content .= $persontestoverseeHistory->age.",";
                else
                    $content .= ",";
                $content .= $persontestoverseeHistory->address1.",";
                $content .= $persontestoverseeHistory->address2.",";
                if($persontestoverseeHistory->book_id) $content .= "dq".$persontestoverseeHistory->book_id.",";
                else $content .= ",";
                $content .= $persontestoverseeHistory->title.",";
                $content .= $persontestoverseeHistory->writer.",";
                $content .= $persontestoverseeHistory->test_username.",";
                $content .= $persontestoverseeHistory->overseer_num.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }

        if(isset($personbooksearchHistories) && $personbooksearchHistories !== null){ 
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,年齢,都道府県,市町村,読Q本ID,検出書籍名,著者,ジャンルから,検索方法,アクション";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$personbooksearchHistories = PersonbooksearchHistory::orderby('created_at', 'asc')->get();
            $personbooksearchHistories = $personbooksearchHistories->get();
            foreach ($personbooksearchHistories as $key => $personbooksearchHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['BOOKSEARCH_HISTORY'][$personbooksearchHistory->item]['WORK'][$personbooksearchHistory->work_test].",";
                $content .= $personbooksearchHistory->created_at.",";
                $content .= $personbooksearchHistory->username.",";
                if($personbooksearchHistory->age != 0 && $personbooksearchHistory->age !== null)
                    $content .= $personbooksearchHistory->age.",";
                else
                    $content .= ",";
                $content .= $personbooksearchHistory->address1.",";
                $content .= $personbooksearchHistory->address2.",";
                if($personbooksearchHistory->book_id) $content .= "dq".$personbooksearchHistory->book_id.",";
                else $content .= ",";
                $content .= $personbooksearchHistory->title.",";
                $content .= $personbooksearchHistory->writer.",";
                $content .= $personbooksearchHistory->jangru.",";
                $content .= $personbooksearchHistory->content.",";
                $content .= $personbooksearchHistory->action.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }

        if(isset($personadminHistories) && $personadminHistories !== null){ 
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,読Q本ID,書籍名,著者,対象 読Qﾈｰﾑ,文面/内容,新有効期限,アクセス数（PV）,ログインのべ人数,受検数,合格数,登録申請書籍数(急務）,正式認定書籍数,作成クイズ数,認定クイズ数,新規団体数,新規個人会員数";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$personadminHistories = PersonadminHistory::orderby('created_at', 'asc')->get();
            $personadminHistories = $personadminHistories->get();
            foreach ($personadminHistories as $key => $personadminHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['ADMIN_HISTORY'][$personadminHistory->item]['WORK'][$personadminHistory->work_test].",";
                $content .= $personadminHistory->created_at.",";
                $content .= $personadminHistory->username.",";
                if($personadminHistory->book_id) $content .= "dq".$personadminHistory->book_id.",";
                else $content .= ",";
                $content .= $personadminHistory->title.",";
                $content .= $personadminHistory->writer.",";
                $content .= $personadminHistory->bookregister_name.",";
                $content .= $personadminHistory->content.",";
                $content .= $personadminHistory->period.",";
                $content .= $personadminHistory->access_num.",";
                $content .= $personadminHistory->login_num.",";
                $content .= $personadminHistory->test_num.",";
                $content .= $personadminHistory->success_num.",";
                $content .= $personadminHistory->readybook_num.",";
                $content .= $personadminHistory->successbook_num.",";
                $content .= $personadminHistory->quiz_num.",";
                $content .= $personadminHistory->successquiz_num.",";
                $content .= $personadminHistory->org_num.",";
                $content .= $personadminHistory->users_num.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }
            fwrite($pFile, ",".PHP_EOL);
            fwrite($pFile, ",".PHP_EOL);
        }
        
        fclose($pFile);
        $output = new PHPExcel_Output();
        $output->_send($filename, "csv", '個人会員利用履歴.csv');
    }

    //=========booktype = org_use_history ===========================//
    public function exportSchoolData(Request $request){
        $period_sel = $request->input('period_sel');
        $data_usehistory_sel = $request->input('data_usehistory_sel'); 
        $usetype_sel = $request->input('usetype_sel');
        switch ($data_usehistory_sel) {
            case '1':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
            case '2':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
            case '3':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
            case '4':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
            case '5':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
            case '6':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
            case '7':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break; 
            case '8':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;    
            default:
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
        }

        switch ($period_sel) {
            case '1':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("12 hours")));
                    
                break;
            case '2':
                $yesterday = date_format(date_sub(date_create(), date_interval_create_from_date_string('1 days')), "Y-m-d");
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where("created_at" , "like", $yesterday . "%");
                break;
            case '3':
                
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 weeks")));
                
                break;
            case '4':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 months")));
                
                break;
            case '5':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("3 months")));
                
                break;
            case '6':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("6 months")));
                
                break;
            case '7':
                if(isset($orgworkHistories) && $orgworkHistories !== null)
                    $orgworkHistories = $orgworkHistories->where('created_at','>=',date_sub(date_create(date("Y-m-d h:i:sa")),date_interval_create_from_date_string("1 years")));
                
                break;    
            case '8':
                $orgworkHistories = OrgworkHistory::orderby('created_at', 'asc');
                break;
        }

        if(isset($usetype_sel) && $usetype_sel !== null){
            if(isset($orgworkHistories) && $orgworkHistories !== null){
                if($data_usehistory_sel != 8)
                    $orgworkHistories = $orgworkHistories->whereIn('work_test', $usetype_sel);
            }
        }
        $orgworkHistories = $orgworkHistories->get();

        if(isset($orgworkHistories) && $orgworkHistories !== null){

            $filename = time().".csv";
            $pFile = fopen($filename, "wb");
            $header = "";
            $header = "作業/判定,タイムスタンプ,読Qネーム,団体読Ｑネーム,対象 読Qﾈｰﾑ,現 対象,内容、文面,新,point,会員数 生徒,会員数 教員";
            $header = mb_convert_encoding($header, 'shift_jis');
            fwrite($pFile, $header.PHP_EOL);

            //$orgworkHistories = OrgworkHistory::orderby('created_at', 'asc')->get();
            foreach ($orgworkHistories as $key => $orgworkHistory) {
                $content = "";
                $content .= config('consts')['HISTORY']['ORGWORK_HISTORY'][$orgworkHistory->item]['WORK'][$orgworkHistory->work_test].",";
                $content .= $orgworkHistory->created_at.",";
                $content .= $orgworkHistory->username.",";
                $content .= $orgworkHistory->group_name.",";
                $content .= $orgworkHistory->objuser_name.",";
                $content .= $orgworkHistory->class.",";
                $content .= $orgworkHistory->content.",";
                $content .= $orgworkHistory->newyear.",";
                $content .= $orgworkHistory->point.",";
                $teacher_numbers = 0;
                $pupil_numbers = 0;
                $group_row = USER::where('id', '=', $orgworkHistory->group_id)->get();
                foreach($group_row as $group_item){
                    $teacher_numbers += $group_item->totalTeacherCounts();
                    $pupil_numbers += $group_item->totalMemberCounts();
                }

                $content .= $teacher_numbers.",";
                $content .= $pupil_numbers.",";
                $content = mb_convert_encoding($content, 'shift_jis');
                fwrite($pFile, $content.PHP_EOL);
            }

            //fwrite($pFile, "1,2,3" . PHP_EOL);
            fclose($pFile);
            $output = new PHPExcel_Output();
            $output->_send($filename, "csv", '団体会員履歴.csv');
        }

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
            $current_season['year'] = (Date('Y'));
            $current_season['from_num'] = (Date('Y')) . '.' . '1.1';
            $current_season['to_num'] = Date('Y') . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y")), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")), 3, 31,23,59,59);
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
        }*/ 

        return $current_season;
    }

    public function ad_save(Request $request){
        $advertise = DB::table('advertise')->first();
        if(!is_null($advertise)){
            $advertise = Advertise::first();
            $advertise->update($request->all());
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
            // $advertise->top_page_left = $request->input('top_page_left');
        }
        else{
            $advertise = Advertise::create($request->all());
        }
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::back();
    }
}