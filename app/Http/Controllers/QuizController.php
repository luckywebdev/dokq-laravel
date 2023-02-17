<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Auth;
use DB;
use Redirect;
use View;
use App\User;
use App\Model\Classes;
use App\Model\Books;
use App\Model\Messages;
use App\Model\Categories;
use App\Model\Quizes;
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
use Carbon\Carbon;

class QuizController extends Controller
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
        'top' =>'quiz_make',
        'subtop' =>'quiz_make',
    ];
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

    //render caution of creating quiz 4.2
    public function caution(Request $request){
    	$view = view('books.quiz.caution')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true); 
    	if($request->input('book_id')){
    		$book = Books::find($request->input('book_id'));
    		$view = $view->withBook($book);

            $personbooksearchHistory = new PersonbooksearchHistory();
            if(Auth::check()){
                $personbooksearchHistory->user_id = Auth::id();
                $personbooksearchHistory->username = Auth::user()->username;
                $personbooksearchHistory->age = Auth::user()->age();
                $personbooksearchHistory->address1 = Auth::user()->address1;
                $personbooksearchHistory->address2 = Auth::user()->address2;
            }else
                $personbooksearchHistory->username = '非会員';
            
            $personbooksearchHistory->item = 1;
            if($request->has('work_test') && $request->input('work_test') != '' && $request->input('work_test') !== null)
                $personbooksearchHistory->work_test = $request->input('work_test');
            else
                $personbooksearchHistory->work_test = 8;

            if($personbooksearchHistory->work_test == 3){
                if($request->has('content') && $request->input('content') != '' && $request->input('content') !== null)
                    $personbooksearchHistory->jangru = $request->input('content');
            }
            else{
                if($request->has('content') && $request->input('content') != '' && $request->input('content') !== null)
                    $personbooksearchHistory->content = $request->input('content');
            }
            
            $personbooksearchHistory->book_id = $book->id;
            $personbooksearchHistory->title = $book->title;
            $personbooksearchHistory->writer = $book->fullname_nick();
            $personbooksearchHistory->action = 'クイズを作る';
            $personbooksearchHistory->created_at = now();
            $personbooksearchHistory->updated_at = now();
            $personbooksearchHistory->device = $this->get_device();
            $personbooksearchHistory->save(); 
    	}
    	return $view;
    }
    //answer
    public function answer(){
        return view('books.quiz.answer')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true); 
    }
    //render quiz creating form 4.2a
    public function create(Request $request){
        $quizmakername = $request->input('quizmakername');
    	if($request->input('book_id')){
            $book = Books::find($request->input('book_id'));

	    	$view = view('books.quiz.create')
	    		->with('page_info', $this->page_info)
	    		->withBook($book)
    			->withNosidebar(true);
            if(isset($quizmakername))
                $view = $view->withQuizmakername($quizmakername);
            return $view;
	    }
	    if($request->input('quiz')){
    		$quiz = Quizes::find($request->input('quiz'));
    		$view = view('books.quiz.create')
	    		->with('page_info', $this->page_info)
	    		->withBook($quiz->Book)
	    		->withQuiz($quiz)
    			->withNosidebar(true);
            if ($request->input('act')) {
                $view = $view->withAct($request->input('act'));
            }
            return $view;
	    }
        $book = Books::find($request->input('book_id'));
        return view('books.quiz.create')
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->withNosidebar(true);
	 //   return Redirect::to('/');
    }
    public function store(Request $request){
    	$rule = array(
			'question' => 'required',
			'answer' => 'required',
			'app_range' => 'required',
    		'register_visi_type' => 'required'
    	);
    	$messages = array(
    		'required' => config('consts')['MESSAGES']['REQUIRED'],
    	);
    	$validator = Validator::make($request->all(), $rule, $messages);
        
    	if($validator->fails()){
            //  return Redirect::back()->withErrors($validator);
    		return Redirect::back()->withErrors($validator)->withInput();
    	}
    	if($request->input('quiz_id')!=0){
            $quiz = Quizes::find($request->input('quiz_id'));
            $register_id = $quiz->register_id;
            $quiz->update($request->all());
            $quiz->register_id = $register_id;
            $quiz->save();
            $request->session()->flash('status', config('consts')['MESSAGES']['EDIT_SUCCEED']);
    	}else{
    		$book = Books::find($request->input("book_id"));
    		if(!$book){
    			return response('Unathorized', 404);
    		}
    		$data = $request->all();
    		$quiz = Quizes::create($request->all());
    		
    		//create user activity
    		$user_quiz = new UserQuiz();
    		$user_quiz->user_id = Auth::id();
    		$user_quiz->book_id = $request->input("book_id");
    		$user_quiz->type = 1;
    		$user_quiz->status = 0;    		
    		$user_quiz->quiz_id = $quiz->id;	
            $user_quiz->point = floor($book->point * 0.1 * 100) / 100;
    		$user_quiz->save();

            //create quiz history
            $userquiz_history = new UserQuizesHistory();
            $userquiz_history->user_id = Auth::id();
            $userquiz_history->book_id = $request->input("book_id");
            $userquiz_history->type = 1;
            $userquiz_history->status = 0;         
            $userquiz_history->quiz_id = $quiz->id;    
            if($quiz->doq_quizid != null)
                $userquiz_history->doq_quizid = $quiz->doq_quizid; 
            //$userquiz_history->point = floor($book->point * 0.1 * 100) / 100;
            $userquiz_history->created_date = now();
            $userquiz_history->finished_date = now();
            $userquiz_history->save();
    	}
    	$quiz->save();
    	$act = $request->input("act");

        //$request->session->put('quizmakername', $request->input('register_visi_type'));

        if($act && $act === "accept") {
            //return Redirect::to('/mypage/accept_quiz_list/'.$quiz->Book->id);
            return Redirect::to('/mypage/quiz_store/1/'.$quiz->Book->id);
        } else {
            return Redirect::to('quiz/store/confirm?book_id='.$quiz->Book->id.'&&quizmakername='.$request->input('register_visi_type'));
        }
    }
    public function confirmStore(Request $request){
    	$quizes = Quizes::where('book_id', $request->input('book_id'))->where('register_id', '=', Auth::id())->where('active', '=', 0)->get();
    	if($request->input('book_id')==="null" || $request->input('book_id')==""){
    		return Redirect::to('/');
    	}
    	$book = Books::find($request->input('book_id'));

    	return view('books.quiz.confirm')
    		->with('page_info', $this->page_info)
    		->withQuizes($quizes)
    		->withBook($book)
            ->withQuizmakername($request->input('quizmakername'))
			->withNosidebar(true);
    }
    public function update(Request $request){
    	$quiz_ids = json_decode($request->input('quiz_ids'));
        $book = Books::find($request->input("book_id"));
    	$completed_ids = array();

    	for ($i=0; $i <count($quiz_ids) ; $i++) { 
            
    		//if ($request->input('act'.$quiz_ids[$i]) == 0){
                $quiz = [];
    			$quiz = Quizes::find($quiz_ids[$i]);
                if(Auth::user()->isOverseerOfBook($request->input("book_id"))){ //$quiz->Register->isAuthor()
                    $quiz->active = 2;
                    $quiz->overseer_id = Auth::id();

                    if($book->active == 6){
                        $quiz->published_date = now();
                        if($quiz->doq_quizid == '' || $quiz->doq_quizid == null){
                            $temp = 0;
                            $book = Books::find($request->input("book_id"));
                            foreach($book->ActiveQuizes as $key1 => $quiz1) {
                                if($quiz1->doq_quizid != '' && $quiz1->doq_quizid !== null){
                                    $splitary = explode('-', $quiz1->doq_quizid);
                                    if($temp < (int)($splitary[1]))
                                        $temp = (int)($splitary[1]);
                                }
                            }
                            $temp = $temp + 1;
                            $quiz->doq_quizid = 'dq'.$quiz->book_id.'-'.$temp;
                           
                        }

                    }
                }else
    			     $quiz->active = 1;
                
    			$quiz->save();
                $quiz->refresh();

    			array_push($completed_ids, $quiz->id);
    			
    			//update user activity
    			UserQuiz::where('user_id', Auth::id())
						  ->where('book_id', $request->input("book_id"))
						  ->where('quiz_id', $quiz_ids[$i])
						  ->where('type', 1)
						  ->where('status', 0)
						  ->update(['status'=> 3,'published_date' => now()]);

                //create quiz history
                UserQuizesHistory::where('user_id', Auth::id())
                                  ->where('book_id', $request->input("book_id"))
                                  ->where('quiz_id', $quiz_ids[$i])
                                  ->where('type', 1)
                                  ->where('status', 0)
                                  ->update(['status'=> 3,'published_date' => now()]);
                //quiz
                $personquizHistory = new PersonquizHistory();
                $personquizHistory->user_id = Auth::id();
                $personquizHistory->username = Auth::user()->username;
                $personquizHistory->item = 0;
                $personquizHistory->work_test = 3;
                $personquizHistory->age = Auth::user()->age();
                $personquizHistory->book_id = $request->input("book_id");
                $personquizHistory->quiz_id = $quiz_ids[$i];
                $personquizHistory->quiz_point = 0;
                $cur_point = UserQuiz::TotalPoint(Auth::id());
                if(isset($cur_point))
                    $personquizHistory->point = floor($cur_point*100)/100;
                else
                    $personquizHistory->point = 0;

                $personquizHistory->rank = 10;
                $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                for ($j = 0; $j < 11; $j++) {
                  if ($personquizHistory->point >= $ranks[$j] && $personquizHistory->point < $ranks[$j - 1]) {
                      $personquizHistory->rank = $j;
                   }
                }
               
                $personquizHistory->title = $book->title;
                $personquizHistory->writer = $book->fullname_nick();
                $personquizHistory->content = $quiz->question;
                $personquizHistory->device = $this->get_device();

                $personquizHistory->save();

                //overseer or author of this book 
                if(Auth::user()->isOverseerOfBook($request->input("book_id"))){
                    $personoverseerHistory = new PersonoverseerHistory();
                    $personoverseerHistory->user_id = Auth::id();
                    $personoverseerHistory->username = Auth::user()->username;
                    $personoverseerHistory->item = 0;
                    $personoverseerHistory->work_test = 1;
                    $personoverseerHistory->age = Auth::user()->age();
                    $personoverseerHistory->book_id = $request->input("book_id");
                    $personoverseerHistory->quiz_id = $quiz->id;
                    if($quiz->doq_quizid !== null)
                        $personoverseerHistory->doq_quizid = $quiz->doq_quizid;
                    $personoverseerHistory->title = $book->title;
                    $personoverseerHistory->writer = $book->fullname_nick();
                    $personoverseerHistory->content = $quiz->question;
                    $personoverseerHistory->device = $this->get_device();
                    $personoverseerHistory->save();
                }
    		//}else{
    		//	Quizes::destroy($quiz_ids[$i]);
    		//}
    	}
    	$completed_ids = implode(",", $completed_ids);
        
    	return Redirect::to('/quiz/store/completed?ids='.$completed_ids.'&book='.$request->input('book_id'));
    }

    //render quiz make completion 4.2c
    public function completed(Request $request){

    //	if($request->input('book')){
    		$quiz_ids = explode(",", $request->input('ids'));
	    	$book = Books::find($request->input('book'));
	    	$quizes = Quizes::find($quiz_ids);
            $status = 'completed';
	    	return view('books.quiz.confirm')
	    		->with('page_info', $this->page_info)
	    		->withQuizes($quizes)
	    		->withBook($book)
                ->withStatus($status)
				->withNosidebar(true);	
    //	}
    //	return Redirect::to('/');
    	
    }
    
    public function rank_by_quiz(Request $request){
    	
    	$userid = Auth::user()->id;
    	$compareYear = $request->input('compareYear');
    	
    	print_r('{');    	
    	
    	//現在まで累計
        $userQuizes1 = UserQuiz::AllUserQuizes();
        //$userQuizes = QuizController::extractQuizesbyYear($userQuizes, $compareYear);
	    $sum = QuizController::TotalPoints($userQuizes1);
		
    	print_r('"allRank":"' . $sum . ',,,",');
    	
    	//四半期 
    	$aryQuarterName = array("春期", "夏期", "秋期", "冬期");
    	$curQuarter = QuizController::getQuarter();
    	
    	$curStartDate = QuizController::getStartEndOfQuarter(0);
    	$curEndDate = QuizController::getStartEndOfQuarter(1);
    	$preStartDate = QuizController::getStartEndOfQuarter(2);
    	$preEndDate = QuizController::getStartEndOfQuarter(3);

    	$curStartDate1 = date_format($curStartDate, "Y.m.d");
    	$curEndDate1 = date_format($curEndDate, "Y.m.d");
    	$preStartDate1 = date_format($preStartDate, "Y.m.d");
    	$preEndDate1 = date_format($preEndDate, "Y.m.d");
    	
    	//今　四半期
    	$startDate = $curStartDate;
    	$endDate = $curEndDate;
    	
    	$userQuizes1 = UserQuiz::AllUserQuizes()->whereBetween('user_quizes.finished_date',array($startDate, $endDate));
	    $sum = QuizController::TotalPoints($userQuizes1);
    	
    	print_r('"curQuarter":"' . $aryQuarterName[$curQuarter-1] . $curStartDate1 . '-' . $curEndDate1 . '<br>(今　四半期)' . ','
    						  . $sum . ','
    						  . ',,",');
    	
    	
    	//前　四半期
    	$preQuarter = 4;
    	if ($curQuarter > 1) $preQuarter = $curQuarter-1;
    	
    	$startDate = $preStartDate;
    	$endDate = $preEndDate;
    	
    	$userQuizes1 = UserQuiz::AllUserQuizes()->whereBetween('user_quizes.finished_date',array($startDate, $endDate));
    	$sum = QuizController::TotalPoints($userQuizes1);
    	
    	print_r('"preQuarter":"' . $aryQuarterName[$preQuarter-1] . $preStartDate1 . '-' . $preEndDate1 . '<br>(前　四半期)' . ','
    						  . $sum . ','
    						  . $startDate . ','
    						  . $endDate . ','
    						  . '",');
    	
    	//年度
    	$curYear = QuizController::getStartEndOfYear(4);
    	
    	$curStartDate = QuizController::getStartEndOfYear(0);
    	$curEndDate = QuizController::getStartEndOfYear(1);
    	$preStartDate = QuizController::getStartEndOfYear(2);
    	$preEndDate = QuizController::getStartEndOfYear(3);

    	$curStartDate1 = date_format($curStartDate, "Y.m.d");
    	$curEndDate1 = date_format($curEndDate, "Y.m.d");
    	$preStartDate1 = date_format($preStartDate, "Y.m.d");
    	$preEndDate1 = date_format($preEndDate, "Y.m.d");
    	
    	//今年度通算
    	$startDate = $curStartDate;
    	$endDate = $curEndDate;
    	
    	$userQuizes1 = UserQuiz::AllUserQuizes()->whereBetween('user_quizes.finished_date',array($startDate, $endDate));
    	$sum = QuizController::TotalPoints($userQuizes1);
    	
    	print_r('"curYear":"' . $curYear . '年度' . $curStartDate1 . '~<br>(今年度通算)' . ','
    						  . $sum . ','
    						  . $startDate . ','
    						  . $endDate . ','
    						  . '",');
    	
    	//前年度通算
    	$startDate = $preStartDate;
    	$endDate = $preEndDate;
    	
    	$userQuizes1 = UserQuiz::AllUserQuizes()->whereBetween('user_quizes.finished_date',array($startDate, $endDate));
    	$sum = QuizController::TotalPoints($userQuizes1);
    	
    	print_r('"lastYear":"' . ($curYear-1) . '年度' . $preStartDate1 . '-' . $preEndDate1 . '<br>(前年度)' . ','
    						  . $sum . ','
    						  . $startDate . ','
    						  . $endDate . ','
    						  . '"');
    	
    	
    	
    	print_r('}');
    	
    	return response(null);
    }
    
    public function extractQuizesbyYear($books, $compareYear) {
    	$today = now();
    	switch($compareYear){
    		case "0":	//小学生
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->where('books.recommend','>=', 0)
    							->where('books.recommend','<',3);
    			break;
    		case "1":	//中学生
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->where('books.recommend','>=', 2)
    							->where('books.recommend','<',5);	
    			break;
    		case "2":	//高校生
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->where('books.recommend','>=', 4)
    							->where('books.recommend','<',7);
    			break;
    		case "3":	//大学生
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->where('books.recommend','>=', 6)
    							->where('books.recommend','<',8);
    			break; 
    		case "4":	//10代
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-20), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-10), 3, 31), "Y-m-d")));
                else
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-9), 3, 31), "Y-m-d")));
                break;
    		case "5":	//20代
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 3, 31), "Y-m-d")));
                else
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-19), 3, 31), "Y-m-d")));
                break;
    		case "6":	//30代
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;    			
    		case "7":	//40代
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;    			
    		case "8":	//50代
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			$books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;    			
    		case "9": 	//60代
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			$books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
    		case "10":	//70代以降
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			$books = $books->where("birthday", '<=', date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d"));
                break;
    		case "11":	//全ての年代
    			
    			break;
    	}
    	
    	return $books;
    }
    
    public function getQuarter($year=null, $month=null, $day=null) {
    	if ($year==null) $year = date("Y");
    	if ($month==null) $month = date("m");
    	if ($day==null) $day = date("d");
    	
    	$aryQuarterDate = array(3, 21,		// 1四半期
    							6, 21,		// 2四半期
    							9, 21,		// 3四半期
    							12, 21);	// 4四半期
    	
    	$curDate = Carbon::createFromDate($year, $month, $day);
    	
    	for($i=0; $i<3; $i++) {
    		$startDateOfQuarter = Carbon::createFromDate($year, $aryQuarterDate[$i*2], $aryQuarterDate[$i*2+1]);
    		$endDateOfQuarter = Carbon::createFromDate($year, $aryQuarterDate[($i+1)*2], $aryQuarterDate[($i+1)*2+1]);
    		
    		if ($startDateOfQuarter <= $curDate && $curDate <$endDateOfQuarter)
    			return $i+1;
    	}
    	return 4;
    }
    
    public function getStartEndOfQuarter($flagDate=0, $curDate=null) {
    	
    	// $flagDate=0: return $curStartDate;
    	// $flagDate=1: return $curEndDate;
    	// $flagDate=2: return $preStartDate;
    	// $flagDate=3: return $preEndDate;
    	
    	$curStartDate = null;		// current quarter start date
    	$curEndDate = null;		// current quarter end date
    	$preStartDate = null;		// previous quarter start date
    	$preEndDate = null;		// previous quarter end date
    	
    	if ($curDate==null) $curDate = getdate();
    
    	$curYear = $curDate["year"];
    	$curMonth = $curDate["mon"];
    	$curDay = $curDate["mday"];
    	
    	$curQuarter = QuizController::getQuarter($curYear, $curMonth, $curDay);
    	
    	switch ($curQuarter) {
    		case 1: {	// 1四半期	    		
	    		$curStartDate = Carbon::createFromDate($curYear, 3, 21);
	    		$curEndDate = Carbon::createFromDate($curYear, 6, 20);
	    		$preStartDate = Carbon::createFromDate($curYear-1, 12, 21);
	    		$preEndDate = Carbon::createFromDate($curYear, 3, 20);
	    	}
    		case 2: {	// 2四半期	    		   		
	    		$curStartDate = Carbon::createFromDate($curYear, 6, 21);
	    		$curEndDate = Carbon::createFromDate($curYear, 9, 20);
	    		$preStartDate = Carbon::createFromDate($curYear, 3, 21);
	    		$preEndDate = Carbon::createFromDate($curYear, 6, 20);
	    	}
    		case 3: {	// 3四半期
	    		$curStartDate = Carbon::createFromDate($curYear, 9, 21);
	    		$curEndDate = Carbon::createFromDate($curYear, 12, 20);
	    		$preStartDate = Carbon::createFromDate($curYear, 6, 21);
	    		$preEndDate = Carbon::createFromDate($curYear, 9, 20);
    		}
    		case 4: {	// 4四半期
    			$deltaMonth = -1;
    			if ($curMonth==12) $deltaMonth = 0;
	    		
	    		$curStartDate = Carbon::createFromDate($curYear+$deltaMonth, 12, 21);
	    		$curEndDate = Carbon::createFromDate($curYear+1+$deltaMonth, 3, 20);
	    		$preStartDate = Carbon::createFromDate($curYear+$deltaMonth, 9, 21);
	    		$preEndDate = Carbon::createFromDate($curYear+$deltaMonth, 12, 20);
	    	}
    	}
    	
    	switch ($flagDate) {
    		case 0: return $curStartDate;
    		case 1: return $curEndDate;
    		case 2: return $preStartDate;
    		case 3: return $preEndDate;
    	}
    }
    
    public function getStartEndOfYear($flagDate=0, $curDate=null) {
    	
    	// $flagDate=0: return $curStartDate;
    	// $flagDate=1: return $curEndDate;
    	// $flagDate=2: return $preStartDate;
    	// $flagDate=3: return $preEndDate;
    	// $flagDate=4: return $preEndDate;
    	
    	$curStartDate = null;		// current year start date
    	$curEndDate = null;		// current year end date
    	$preStartDate = null;		// last year start date
    	$preEndDate = null;		// last year end date
    	
    	if ($curDate==null) $curDate = getdate();
    
    	$year = $curDate["year"];
    	$month = $curDate["mon"];
    	$day = $curDate["mday"];
    	
    	$curYear = $year;
    	if ($month<3 || ($month==3 && $day<21)) $curYear--;
    		
    	$curStartDate = Carbon::createFromDate($curYear, 3, 21);
    	$curEndDate = Carbon::createFromDate($curYear+1, 3, 20);
    	$preStartDate = Carbon::createFromDate($curYear-1, 3, 21);
    	$preEndDate = Carbon::createFromDate($curYear, 3, 20);
    	
    	switch ($flagDate) {
    		case 0: return $curStartDate;
    		case 1: return $curEndDate;
    		case 2: return $preStartDate;
    		case 3: return $preEndDate;
    		case 4: return $curYear;
    	}
    }
    
    public function TotalPoints($userQuizes1) {
    	$userQuizes2 = $userQuizes1->get();
    	$sum = 0;
		for($i = 0; $i < count($userQuizes2); $i++){
			$sum += $userQuizes2[$i]->point;
		}
		return floor($sum * 100) / 100;
    }
    
    public function remove(Request $request){
    	$id = $request->input("id");
    	$quiz = Quizes::find($id);

    	if($quiz){
            //quiz
            $personquizHistory = new PersonquizHistory();
            $personquizHistory->user_id = Auth::id();
            $personquizHistory->username = Auth::user()->username;
            $personquizHistory->item = 0;
            $personquizHistory->work_test = 6;
            $personquizHistory->age = Auth::user()->age();
            $personquizHistory->book_id = $quiz->book_id;
            if($quiz->doq_quizid != null)
                $personquizHistory->doq_quizid = $quiz->doq_quizid; 
            $personquizHistory->quiz_id = $quiz->id;
            //$personquizHistory->quiz_point = 0;
            $cur_point = UserQuiz::TotalPoint(Auth::id());
            if(isset($cur_point))
                $personquizHistory->point = floor($cur_point*100)/100;
            else
                $personquizHistory->point = 0;

            $personquizHistory->rank = 10;
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($j = 0; $j < 11; $j++) {
              if ($personquizHistory->point >= $ranks[$j] && $personquizHistory->point < $ranks[$j - 1]) {
                  $personquizHistory->rank = $j;
               }
            }
            $book = Books::find($quiz->book_id);
            $personquizHistory->title = $book->title;
            $personquizHistory->writer = $book->fullname_nick();
            $personquizHistory->content = $quiz->question;
            $personquizHistory->save();
            
            //$quiz->active = 3;
            //$quiz->save();
    		$quiz->delete();
    		return Redirect::back();
    	}else{
    		return response('Unathorized', 404);
    	}
    }
    //no use
    public function accept_quiz($quiz_id, Request $request){
    	$quiz = Quizes::find($quiz_id);
    	
    	if($quiz){
    		$quiz->active = 2;
    		$quiz->save();
    		
            $beforebookRegister_totalpoint = UserQuiz::TotalPoint($quiz->register_id);
            $beforebookRegister_rank = 10;
            
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
                if ($beforebookRegister_totalpoint >= $ranks[$i] && $beforebookRegister_totalpoint < $ranks[$i - 1]) {
                    $beforebookRegister_rank = $i;
                }
            }

    		//change user activity
    		$user_activity = UserQuiz::where('quiz_id', $quiz->id)->where('type', 1)->where('status', 3)->first();
    		if($user_activity){
	    		$user_activity->status = 1;
	    		$user_activity->save();

                //create quiz history
                $userquiz_history = new UserQuizesHistory();
                $userquiz_history->user_id = $user_activity->user_id;
                $userquiz_history->book_id = $user_activity->book_id;
                $userquiz_history->type = 1;
                $userquiz_history->status = 1;         
                $userquiz_history->quiz_id = $quiz->id;  
                if($quiz->doq_quizid != null)
                    $userquiz_history->doq_quizid = $quiz->doq_quizid;   
                $userquiz_history->point = $user_activity->point;
                $userquiz_history->created_date = now();
                $userquiz_history->finished_date = now();
                $userquiz_history->save();

                $afterbookRegister_totalpoint = UserQuiz::TotalPoint($quiz->register_id);
                $afterbookRegister_rank = 10;
            
                for ($i = 0; $i < 11; $i++) {
                    if ($afterbookRegister_totalpoint >= $ranks[$i] && $afterbookRegister_totalpoint < $ranks[$i - 1]) {
                        $afterbookRegister_rank = $i;
                    }
                }
               
                //昇級
                if($afterbookRegister_rank < $beforebookRegister_rank){
                    $message1 = new Messages;
                    $message1->type = 0;
                    $message1->from_id = 0;
                    $message1->to_id = $quiz->register_id;
                    $message1->name = "協会";
                    $message1->content = config('consts')['MESSAGES']['AUTOMSG_LEVEL_UP'];
                    $message1->save();
                }
    		}
    	}
    	
    	return Redirect::back();
    }
    //no use
    public function reject_quiz($quiz_id, Request $request){
    	$quiz = Quizes::find($quiz_id);
    	
    	if($quiz){
    		$quiz->active = 3;
    		$quiz->save();
    		
    		//change user activity
    		$user_activity = UserQuiz::where('quiz_id', $quiz->id)->where('type', 1)->where('status', 3)->first();
    		if($user_activity){
	    		$user_activity->status = 2;
	    		$user_activity->save();

                //create quiz history
                $userquiz_history = new UserQuizesHistory();
                $userquiz_history->user_id = $user_activity->user_id;
                $userquiz_history->book_id = $user_activity->book_id;
                $userquiz_history->type = 1;
                $userquiz_history->status = 2;         
                $userquiz_history->quiz_id = $quiz->id;
                if($quiz->doq_quizid != null)
                    $userquiz_history->doq_quizid = $quiz->doq_quizid;    
                $userquiz_history->point = 0;
                $userquiz_history->created_date = now();
                $userquiz_history->finished_date = now();
                $userquiz_history->save();
    		}
    	}
    	
    	return Redirect::back();
    }
    
    public function remove_quiz($quiz_id, Request $request){
    	$quiz = Quizes::find($quiz_id);
    	if($quiz){
    		$beforebookRegister_totalpoint = UserQuiz::TotalPoint($quiz->register_id);
            $beforebookRegister_rank = 10;
            
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
                if ($beforebookRegister_totalpoint >= $ranks[$i] && $beforebookRegister_totalpoint < $ranks[$i - 1]) {
                    $beforebookRegister_rank = $i;
                }
            }
            $book = Books::find($quiz->book_id);
            //change user activity
            $user_activity = UserQuiz::where('quiz_id', $quiz->id)->where('type', 1)->where('status', 1)->first();

            if($user_activity){
                $user_activity->status = 4;
                $user_activity->point = 0;
                $user_activity->save();
                
                //create quiz history
                $userquiz_history = new UserQuizesHistory();
                $userquiz_history->user_id = $user_activity->user_id;
                $userquiz_history->book_id = $user_activity->book_id;
                $userquiz_history->type = 1;
                $userquiz_history->status = 4;         
                $userquiz_history->quiz_id = $quiz->id;  
                if($quiz->doq_quizid != null)
                    $userquiz_history->doq_quizid = $quiz->doq_quizid;   
                //$userquiz_history->point = 0 - $user_activity->point;
                $userquiz_history->point = 0;
                $userquiz_history->created_date = now();
                $userquiz_history->finished_date = now();
                $userquiz_history->save();

                $afterbookRegister_totalpoint = UserQuiz::TotalPoint($quiz->register_id);
                $afterbookRegister_rank = 10;
            
                for ($i = 0; $i < 11; $i++) {
                    if ($afterbookRegister_totalpoint >= $ranks[$i] && $afterbookRegister_totalpoint < $ranks[$i - 1]) {
                        $afterbookRegister_rank = $i;
                    }
                }
                $message = new Messages;
                $message->type = 0;
                $message->from_id = 0;
                $message->to_id = $quiz->register_id;
                $message->name = "協会";
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_QUIZMAKE_DELETE'], $book->title, $quiz->question);
                $message->save();
                //昇級
                if($afterbookRegister_rank > $beforebookRegister_rank){
                    $message1 = new Messages;
                    $message1->type = 0;
                    $message1->from_id = 0;
                    $message1->to_id = $quiz->register_id;
                    $message1->name = "協会";
                    $message1->content = config('consts')['MESSAGES']['AUTOMSG_LEVEL_DOWN'];
                    $message1->save();
                }
            }

            //quiz
            $personquizHistory = new PersonquizHistory();
            $personquizHistory->user_id = $quiz->register_id;
            $personquizHistory->username = User::find($quiz->register_id)->username;
            $personquizHistory->item = 0;
            $personquizHistory->work_test = 5;
            $personquizHistory->age = User::find($quiz->register_id)->age();
            $personquizHistory->book_id = $quiz->book_id;
            $personquizHistory->quiz_id = $quiz->id;
            if($quiz->doq_quizid !== null)
                $personquizHistory->doq_quizid = $quiz->doq_quizid;
            $personquizHistory->quiz_point = 0;
            $cur_point = UserQuiz::TotalPoint($quiz->register_id);
            if(isset($cur_point))
                $personquizHistory->point = floor($cur_point*100)/100;
            else
                $personquizHistory->point = 0;

            $personquizHistory->rank = 10;
            $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

            for ($i = 0; $i < 11; $i++) {
              if ($personquizHistory->point >= $ranks[$i] && $personquizHistory->point < $ranks[$i - 1]) {
                  $personquizHistory->rank = $i;
               }
            }
            $personquizHistory->title = $book->title;
            $personquizHistory->writer = $book->fullname_nick();
            $personquizHistory->content = $quiz->question;
            $personquizHistory->save(); 
        	//overseer
            $personoverseerHistory = new PersonoverseerHistory();
            $personoverseerHistory->user_id = Auth::id();
            $personoverseerHistory->username = Auth::user()->username;
            $personoverseerHistory->item = 0;
            $personoverseerHistory->work_test = 7;
            $personoverseerHistory->age = Auth::user()->age();
            $personoverseerHistory->book_id = $quiz->book_id;
            $personoverseerHistory->quiz_id = $quiz->id;
            if($quiz->doq_quizid != null)
                $personoverseerHistory->doq_quizid = $quiz->doq_quizid;
            if($book->register_id != 0 && $book->register_id !== null)
                $personoverseerHistory->bookregister_name = User::find($book->register_id)->username;
            $personoverseerHistory->title = $book->title;
            $personoverseerHistory->writer = $book->fullname_nick();
            $personoverseerHistory->content = $quiz->question;

            //$quiz->delete();
            $quiz->active = 3;
            $quiz->doq_quizid = '';
            $quiz->save();
        }
    	return Redirect::back();
    }

    public function registerQusAPI(Request $request){
        $quiz = Quizes::create($request->all());
        return $request;
    }

    public function receiveQusAPI(Request $request){
        $book_id = $request->input("bookID");
        $books = Books::where("id","=", $book_id);
        $point = $books->select("point");
        $quiz_count = $books->select("quiz_count");
        $quizs = Quizes::where("book_id","=", $book_id);
        $result = array($books->select("point")->get(), $books->select("quiz_count")->get(), $quizs->get());
        return $result;
    }

    public function isOverseerQuizAjax(Request $request) {
        $quizid_ary = $request->input("quizid_ary");
        $quiz_temp = explode(",", $quizid_ary);
        $allOverseerQuiz_flag = true;

        for ($i=0; $i < count($quiz_temp)-1; $i++) {
            $quiz =  Quizes::where('id', $quiz_temp[$i])->where('register_id', Auth::id())->first();
            if(!isset($quiz)) {
                $allOverseerQuiz_flag = false;
                break;
            }
        }
        
        if(!$allOverseerQuiz_flag) {
                      
            $response = array(
                'status' => 'success',
            );
        }else{
            $response = array(
               'status' => 'no',
            );
        }
       
       return response()->json($response);
       
    }
}
