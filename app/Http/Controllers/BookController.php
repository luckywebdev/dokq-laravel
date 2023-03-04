<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Pagination\Paginator;

use App\Mail\ForgotPassword;
use App\Mail\ResetPwdSuccess;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

use Carbon\Carbon;
use Auth;
use Redirect;
use View;
use Session;
use App\User;
use App\Model\Advertise;
use App\Model\Angate;
use App\Model\Books;
use App\Model\Messages;
use App\Model\Categories;
use App\Model\Demand;
use App\Model\WishLists;
use App\Model\PwdHistory;
use App\Model\PersonadminHistory;
use App\Model\PersoncontributionHistory;
use App\Model\PersontestoverseeHistory;
use App\Model\PersonbooksearchHistory;
use App\Model\PersonoverseerHistory;
use App\Model\PersonquizHistory;
use App\Model\PersontestHistory;
use App\Model\PersonworkHistory;
use App\Model\OrgworkHistory;
use DB;

use App\Model\UserQuiz;
use App\Model\UserQuizesHistory;
use App\Model\Article;
use App\Model\Vote;
use App\Model\Quizes;
use App\Model\QuizesTemp;
use DateInterval;

class BookController extends Controller
{
    
     public $page_info = [
        'top' =>'search_book',
        'subtop' =>'search_book',
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
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

    public function index() {
        $categories = Categories::all();
        $user = Auth::user();
        $logined = true;
        if ($user == NULL) $logined = false;
        $advertise = Advertise::first();
        return view('books.index')
            ->with('page_info', $this->page_info)
            ->with('logined', $logined)
            ->with('advertise', $advertise)
            ->withNosidebar(true)
            ->withCategories($categories);
    }
    //search books and render result
    public function search(Request $request){
        $sort = $request->input("sort");
        if(isset($sort)){ 
            
            if($sort != 3){
                return Redirect::to('/book/search/sort?key=A');
            }else{
                return Redirect::to('/book/search/sort?key=B');
            }
        }
        $books = Books::select('books.*', 'users.id as author_id')->where('books.active', '>=', 2)->where('books.active', '<', 7)
                       ->leftjoin('users', function($join){
                           $join->on('users.firstname_nick', '=', 'books.firstname_nick')
                           ->where('users.firstname_nick_yomi', '=', 'books.firstname_yomi');
                        })
                       ->groupby('books.id')->orderBy('books.replied_date1', 'desc');        
        $counts = 0;

        if($request->input('page')){
            if ($request->session()->has("book_search_key")){
                $book_search_key = $request->session()->get('book_search_key');
                
                if($book_search_key['title'] != '' && $book_search_key['title'] !== null){
                    $books = $books->SearchbyTitle($book_search_key['title'], $book_search_key['title_mode']);
                }
                
                if(($book_search_key['firstname_nick'] !== '' && $book_search_key['firstname_nick'] !== null) || ($book_search_key['lastname_nick'] != '' && $book_search_key['lastname_nick'] !== null)){
                    $books = $books->SearchbyWriter($book_search_key['firstname_nick'], $book_search_key['lastname_nick'], $book_search_key['writer_mode']);   
                }
                if($book_search_key['isbn'] != '' && $book_search_key['isbn'] !== null){
                    $books = $books->where('isbn', 'like','%'.$book_search_key['isbn'].'%');
                }
                if($book_search_key['keyword'] != '' && $book_search_key['keyword'] !== null){
                    $books = $books->SearchbyKeyword($book_search_key['keyword'], $book_search_key['keyword_mode']);
                }
            }
        }else{
            if($request->input('title')){
                $books = $books->SearchbyTitle($request->input('title'), $request->input('title_mode'));
            }
            
            if($request->input('firstname_nick') || $request->input('lastname_nick')){
                $books = $books->SearchbyWriter($request->input('firstname_nick'), $request->input('lastname_nick'), $request->input('writer_mode'));   
            }
            if($request->input('isbn')){
                $books = $books->where('isbn', 'like','%'.$request->input('isbn').'%');
            }
            if($request->input('keyword')){
                $books = $books->SearchbyKeyword($request->input('keyword'),$request->input('keyword_mode'));
            }
            $request->session()->remove('book_search_key');

            $request->session()->put('book_search_key',$request->all());
        }
        
        $counts = count($books->get());
        
        if ($counts == 0) {
            /*$books = Books::where('active', '=', 2)->where('active', '<', 7);
            if($request->input('title')){
                $books = $books->SearchbyTitle($request->input('title'), $request->input('title_mode'));
            }
            if($request->input('firstname_nick') || $request->input('lastname_nick')){
                $books = $books->SearchbyWriter($request->input('firstname_nick'), $request->input('lastname_nick'), $request->input('writer_mode'));   
            }
            if($request->input('isbn')){
                $books = $books->where('isbn', 'like',$request->input('isbn'));
            }
            if($request->input('keyword')){
                $books = $books->SearchbyKeyword($request->input('keyword'),$request->input('keyword_mode'));
            }
            $counts = count($books->get());
            if ($counts > 0)
                $counts = -1;*/
        } else {
            $books = $books->paginate(20);
        }
        $keyword_only = false;
        if($request->input('title')=="" && $request->input('firstname_nick')=="" && $request->input('lastname_nick')=="" && $request->input('isbn')=="" && $request->input('keyword'))
            $keyword_only = true;

        if($request->has('keyword') && $request->input('keyword') != ""){
            $work_test = 6;
            $content = $request->input('keyword');
        }
        else if($request->has('isbn') && $request->input('isbn') != ""){
            $work_test = 8;
            $content = $request->input('isbn');
        }
        else if(($request->has('firstname_nick') && $request->input('firstname_nick') != "") || ($request->has('lastname_nick') && $request->input('lastname_nick') != "")){
            $work_test = 1;
            $content = '';
            if($request->has('firstname_nick') && $request->input('firstname_nick') != "")
                $content .= $request->input('firstname_nick');
            if($request->has('lastname_nick') && $request->input('lastname_nick') != "")
                $content .= $request->input('lastname_nick');
        }
        else if($request->has('title') && $request->input('title') != ""){
            $work_test = 0;
            $content = $request->input('title');
        }
        else{
            $work_test = 7;
            $content = '';
        }
        
        return view('books.book.search_result.index')
                ->withNosidebar(true)
                ->withBooks($books)
                ->withCounts($counts)
                ->withKeywordSearch($keyword_only)
                ->with('page_info', $this->page_info)
                ->with('work_test', $work_test)
                ->with('content', $content);
    }

    //search books by author
    public function searchbooksbyauthor(Request $request){
        $books = [];
              
        if($request->input('page')){
            /*if ($request->session()->has("book_search_key")){
                $book_search_key = $request->session()->get('book_search_key');
                
                if($book_search_key['writer_id'] == 0){
                    $fullname_nick_ary = explode (' ', $book_search_key['fullname']); 
                    
                    $books = Books::where('firstname_nick', $fullname_nick_ary[0])
                                    ->where('active', '>=', 2)
                                    ->where('active', '<', 7)
                                    ->orderBy('replied_date1', 'desc');
                    if(sizeof($fullname_nick_ary) > 1)
                        $books = $books->where('lastname_nick', $fullname_nick_ary[1]);
                                    
                }else{
                    if($book_search_key['writer_id'] != '' && $book_search_key['writer_id'] !== null){
                        $books = Books::where('writer_id', $book_search_key['writer_id'])
                                ->where('active', '>=', 2)
                                ->where('active', '<', 7)
                                ->orderBy('replied_date1', 'desc');
                        
                    }
                }
            }*/
        }else{
            if($request->input('writer_id') == 0){
                $fullname_nick_ary = explode (' ', $request->input('fullname')); 
                
                $books = Books::where('firstname_nick', $fullname_nick_ary[0])
                                ->where('active', '>=', 2)
                                ->where('active', '<', 7)
                                ->orderBy('replied_date1', 'desc');
                if(sizeof($fullname_nick_ary) > 1)
                    $books = $books->where('lastname_nick', $fullname_nick_ary[1]);
                                
            }else{
                if($request->input('writer_id') != '' && $request->input('writer_id') !== null){
                    $books = Books::where('writer_id', $request->input('writer_id'))
                                ->where('active', '>=', 2)
                                ->where('active', '<', 7)
                                ->orderBy('replied_date1', 'desc');
                    
                }
            }
           
            //$request->session()->remove('book_search_key');
            //$request->session()->put('book_search_key',$request->all());
        }

        $counts = count($books->get());
        $books = $books->paginate(100);
        return view('books.book.search_result.index')
                ->withNosidebar(true)
                ->withBooks($books)
                ->withCounts($counts)
                ->with('page_info', $this->page_info);
    }

    public function searchById(Request $request, $id){
        $books = Books::where('active', '>=', 3)->where('active', '<', 7);
        $books = $books->SearchbyId($id);
        $counts = count($books->get());

        $books = $books->paginate(100);

        return view('books.book.search_result.index')
            ->withNosidebar(true)
            ->withBooks($books)
            ->withCounts($counts)
            ->with('page_info', $this->page_info);
    }
        
    public function searchBySort(Request $request){
        if($request->input('key') == 'A'){
            $categories = Categories::all();
            return view('books.book.search.sortA')
                ->withCategories($categories)
                ->with('page_info', $this->page_info)
                ->withNosidebar(true);
        }elseif($request->input('key') == 'B'){
            return view('books.book.search.sortB')
                ->with('page_info', $this->page_info)
                ->withNosidebar(true);
        }else{
            return Redirect::to('/book/index');
        }
    }
    //search by recommend generation
    public function searchByGene(Request $request){
        $books = Books::select('books.*')->where('active', '>=', 3)->where('active', '<', 7);
        $pageTitle ="読Qと先生が推薦する、全部の本一覧";

        if($request->input('page')){
            if ($request->session()->has("book_search_key")){
                $book_search_key = $request->session()->get('book_search_key');
                
                if($book_search_key['gene'] != '' && $book_search_key['gene'] !== null){
                    $books = $books->searchByGene($book_search_key['gene']);
                    $pageTitle = config('consts')['BOOK']['SEARCH_RECOMMENDS'][$book_search_key['gene']];
                }
            }
        }else{
            if($request->input('gene') != '' && $request->input('gene') !== null){
                
                $books = $books->searchByGene($request->input('gene'));
        
                $pageTitle = config('consts')['BOOK']['SEARCH_RECOMMENDS'][$request->input('gene')];
            }
                                                  
            $request->session()->remove('book_search_key');
            $request->session()->put('book_search_key',$request->all());
        }

       
        $counts = count($books->get());
        
        $books = $books->paginate(20);
        $type = 'gene';
        $work_test = 2;

        if($counts == 0){
            return view('books.book.search_result.index')
            ->withNosidebar(true)
            ->withBooks($books)
            ->withCounts($counts)
            ->withSpecSearch(1)
            ->with('page_info', $this->page_info);    
        }
        return view('books.book.result.result')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->withBooks($books)
            ->withType($type)
            ->withCounts($counts)
            ->with('page_title', $pageTitle)
            ->with('work_test', $work_test);
    }
    //SEARCH By category
    public function searchByCategory(Request $request){
        $pageTitle ="検索結果";
        $books = Books::select('books.*')->where('books.active', '>=', 3)->where('active', '<', 7);  
        if($request->input('page')){
            if ($request->session()->has("book_search_key")){
                $book_search_key = $request->session()->get('book_search_key');
                
                if($book_search_key['categories'] != '' && $book_search_key['categories'] !== null){
                    $categories = $book_search_key['categories'];
                }
            }
        }else{
            if($request->input('categories')){
                $categories = $request->input('categories');
            }
           
            $request->session()->remove('book_search_key');
            $request->session()->put('book_search_key',$request->all());
        }
                            
        $books = $books->join(DB::raw('book_category as t'), 'books.id', '=', DB::raw('t.book_id'))
                           ->whereIn('t.category_id', $categories);
                               
        $pageTitle="検索結果";
        $counts = count($books->get());
        $books = $books->paginate(20);
        $type = 'category';
        $work_test = 3;
        $content = '';
        $categories_all = Categories::all();
        foreach($categories_all as $i => $category){
            if(isset($categories) && $categories !== null)
            foreach($categories as $key => $category_id){
                if($category->id == $category_id){
                    if($key + 1 == count($categories))
                        $content .= $category->name;
                    else
                        $content .= $category->name.'、';
                    break;
                }
            }
        }

        if($counts == 0){
            return view('books.book.search_result.index')
            ->withNosidebar(true)
            ->withBooks($books)
            ->withCounts($counts)
            ->withSpecSearch(1)
            ->with('page_info', $this->page_info);    
        }
      
        return view('books.book.result.result')
            ->with('page_info', $this->page_info)
            ->withCounts($counts)
            ->withNosidebar(true)
            ->withBooks($books)
            ->withType($type)
            ->with('page_title', $pageTitle)
            ->with('work_test', $work_test)
            ->with('content', $content);
    }
    //search recently QC passed books
    public function searchLatest1(Request $request){
        $pageTitle = '新しく認定された読Q本リスト';
        $type = "latest";

        $books = Books::select('books.*')->where('active', '=', 6)
                       ->orderBy('qc_date', 'desc');
        $counts = count($books->get());
        $work_test = 4;

        $books = $books->paginate(20);
        if($counts == 0){
            return view('books.book.search_result.index')
            ->withNosidebar(true)
            ->withBooks($books)
            ->withCounts($counts)
            ->withSpecSearch(1)
            ->with('page_info', $this->page_info);    
        }
        return view('books.book.search.result')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->withCounts($counts)
            ->withBooks($books)
            ->withType($type)
            ->with('page_title', $pageTitle)
            ->with('work_test', $work_test);

    }

    public function searchLatest(Request $request){
        $pageTitle = '新しく認定された読Q本リスト';
        $type = "latest";

        $books = Books::select('books.*')->where('qc_date', '>', Carbon::now()->subMonth())
            ->where('qc_date', '<', Carbon::now())
            ->where('active', '=', 6)
            ->orderBy('qc_date', 'desc');
       
        $counts = count($books->get());
        $work_test = 4;
        $books = $books->paginate(20);
        if($counts == 0){
            return view('books.book.search_result.index')
            ->withNosidebar(true)
            ->withBooks($books)
            ->withCounts($counts)
            ->withSpecSearch(1)
            ->with('page_info', $this->page_info);    
        }
        return view('books.book.search.result')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->withCounts($counts)
            ->withBooks($books)
            ->withType($type)
            ->with('page_title', $pageTitle)
            ->with('work_test', $work_test);

    }

  ///search by ranking 5.2b engine
    public function searchByRanking(Request $request){
        $pageTitle = '新しく認定された読Q本リスト';
        $type = "ranking";
        $rank = $request->input("rank");
        $gender = $request->input("gender");
        $period = $request->input("period");


        $current_season = BookController::CurrentSeaon_Pupil(now());
        //$books = Books::SearchbyRanking($rank,$gender,$period);
        $books = Books::select('books.*', DB::raw('count(user_quizes.user_id) as ranking'))
                    ->join('user_quizes', 'user_quizes.book_id', DB::raw('books.id and (user_quizes.type = 2 and user_quizes.status = 3)'))
                    ->where('books.active', '<>', 7)
                    ->groupby('books.id')
                    ->orderby('ranking', 'desc'); 
        $pupil_flag  = false;
        $today = now();
        // check rankingId
        switch($rank){
            case "0":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->join('classes', 'users.org_id','=','classes.id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL'])
                                ->whereIn('classes.grade', array(1, 2))
                                ->where('classes.year','=', $current_season['year']);
                $pupil_flag = true;
                break;
            case "1":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->join('classes', 'users.org_id','=', 'classes.id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL'])
                                ->whereIn('classes.grade', array(3, 4))
                                ->where('classes.year','=', $current_season['year']);
                $pupil_flag = true;
                break;
            case "2":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->join('classes', 'users.org_id','=','classes.id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type=0'))
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL'])
                                ->whereIn('classes.grade', array(5, 6))
                                ->where('classes.year','=', $current_season['year']);
                $pupil_flag = true;
                break;
            case "3":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->join('classes', 'users.org_id','=', 'classes.id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type in(1,2)'))
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL'])
                                ->where('classes.year','=', $current_season['year']);
                $pupil_flag = true;
                break;              
            case "4":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->join('classes', 'users.org_id','=', 'classes.id')
                                ->join('users as org', 'classes.group_id',DB::raw('org.id and org.group_type in(1,2)'))
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL'])
                                ->where('classes.year','=', $current_season['year']);
                $pupil_flag = true;                  
                break;
            case "5":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-10), 3, 31), "Y-m-d")));
                else
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-9), 3, 31), "Y-m-d")));
                break;
            case "6":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 12, 31), "Y-m-d")));
                break;
            case "7":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                break;              
            case "8":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                break;              
            case "9":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                break;              
            case "10": 
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                break;
            case "11":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                break;
            case "12":
                $books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                break;
            case "13":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->where('users.org_id', Auth::user()->org_id)
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL']);
                break;
            case "14":
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                                ->join('classes','users.org_id','=','classes.id')
                                ->where('classes.grade', Auth::user()->PupilsClass->grade)
                                ->where('users.role', config('consts')['USER']['ROLE']['PUPIL']);
                break;

        }
        $books = $books->whereIn('users.active', [1,2,3,4]);
        //check gender
        if($gender == 1 || $gender == 2)
            $books = $books->where('users.gender', $gender);
        
        //check duration
        if($period == "0"){
            $date = date_sub(now(), date_interval_create_from_date_string("3 months"));
            if($pupil_flag)
                $before_season = BookController::CurrentSeaon_Pupil($date);
            else
                $before_season = BookController::CurrentSeaon($date);

            $books = $books->whereBetween('user_quizes.created_date', array($before_season['begin_season'], $before_season['end_season']));
        }else if($period == "1"){
            if($pupil_flag){
                $current_season = BookController::CurrentSeaon_Pupil(now());
                $books = $books->whereBetween('user_quizes.created_date', array(Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0), Carbon::create($current_season['end_thisyear'],3, 31,23,59,59)));
            }
            else{
                $current_season = BookController::CurrentSeaon(now());
                $books = $books->whereBetween('user_quizes.created_date', array(Carbon::create($current_season['begin_thisyear'],4, 1,0,0,0), Carbon::create($current_season['end_thisyear'],3, 31,23,59,59)));
            }
        }     
        
        $books = $books->take(50)->get(); 
        $counts = count($books);
        $work_test = 5;

        if($counts == 0){
            return view('books.book.search_result.index')
            ->withNosidebar(true)
            ->withBooks($books)
            ->with('page_info', $this->page_info)
            ->withCounts($counts)
            ->withSpecSearch(1);

        }
        return view('books.book.search.result')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->withBooks($books)
            ->withType($type)
            ->with('page_info', $this->page_info)
            ->with('page_title', $pageTitle)
            ->with('rank', $rank)
            ->with('gender', $gender)
            ->with('period', $period)
            ->with('pupil_flag', $pupil_flag)
            ->with('work_test', $work_test);
    }
    //render search help page 5.1a
    public function searchHelp(){
        return view('books.help.search')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }
    //render search result help page 5.1b
    public function resultHelp(){
        return view('books.help.result')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }

        //      for ($i = 0; $i < count($groups); $i ++){
        //          $group_sums[$i] = GroupController::Calc_school_avg($groups[$i]->id, $delta);
        //      }
        //      
        //      for ($i = 0; $i < count($groups); $i ++){
        //          for ($j = $i + 1; $j < count($groups); $j ++){
        //              if ($group_sums[$j] > $group_sums[$i]){
        //                  $tmp1 = $group_sums[$i]; $group_sums[$i] = $group_sums[$j]; $group_sums[$j] = $tmp1;
        //                  $tmp2 = $groups[$i]; $groups[$i] = $groups[$j]; $groups[$j] = $tmp2;
        //              }
        //          }
        //      }
        //      
        //      for ($i = 0; $i < count($groups); $i ++){
        //          if ($i == 5) break;
        //          $top_schools[$i]['name'] = $groups[$i]->group_name;
        //          $top_schools[$i]['point'] = $group_sums[$i];
        //      }
    
    public function showDetail(Request $request, $id=null){
        if(!isset($id) || $id == null) {
            $id = $request->input('book_id');
        }
        $advertise = Advertise::first();
        $book = Books::find($id);
        $wishlist = Angate::where('book_id', '=', $id)->where('value','=', 1)->get();
        $wishlist1 = Angate::where('book_id', '=', $id)->where('value','=', 1)->count();
        $current_season = BookController::CurrentSeaon(now());
        $wishlist2 = Angate::where('book_id', '=', $id)->where('value','=', 1)->where("updated_at", ">=", Carbon::create($current_season['begin_thisyear']-1,4, 1,0,0,0))->where("updated_at", "<=", Carbon::create($current_season['end_thisyear']-1,3, 31,23,59,59))->count();
        if(Auth::check())
            $already = WishLists::where('user_id', '=' , Auth::user()->id)->where('book_id', '=', $id)->count();
        else
            $already = 1;
        $is_passed = 0; $is_checked = 0; $is_article = 0;
        //$articleData = [];       
        if (Auth::check()){
            $is_checked = 1;
            if (count(UserQuiz::where('book_id', $book->id)->where('user_id', Auth::user()->id)->where('status', 3)->where('type', 2)->get())){
                $is_passed = 1;
            }

            if (count(Article::where('book_id', $book->id)->where('register_id', Auth::user()->id)->where('junior_visible', 0)->get())){
                $is_article = 1;
            }
        }

        $articles = $book->ArticlesOfBook->take(2);
                
        $quizMakers = "";
        $quizMaker_ary = array();
        $fiften = 1;
        foreach($book->ActiveQuizes as $key=>$quiz) {
            
            if($quiz->register){

                if($quiz->register->age() < 15){
                    $equal = false;
                    foreach ($quizMaker_ary as $key => $quizMaker) {
                        if($quizMaker[1] == $quiz->register->id){
                            $equal = true;
                            break;
                        }
                    }
                    if(!$equal){
                        $one = '中学生以下ー'.$fiften;
                        $fiften++;

                        $quizMakers .= $one. "、";
                        $quiz_ary = array();
                        $quiz_ary[0] = $one;
                        $quiz_ary[1] = $quiz->register->id;
                        array_push($quizMaker_ary, $quiz_ary);
                    }
                }else{
                    
                    if($quiz->register_visi_type == 1){
                        if($quiz->register->role == config('consts')['USER']['ROLE']["AUTHOR"])
                            $one = $quiz->register->fullname_nick();
                        else
                            $one = $quiz->register->fullname();
                    }elseif($quiz->register_visi_type == 2)
                        $one = $quiz->register->username;
                    else
                        $one = '';
                    if($one != ''){
                        if(stristr($quizMakers, $one)) {
                            continue;
                        }

                        $quizMakers .= $one. "、";
                        $quiz_ary = array();
                        $quiz_ary[0] = $one;
                        $quiz_ary[1] = $quiz->register->id;
                        array_push($quizMaker_ary, $quiz_ary);
                    }

                    
                }
            }

            
        }

        $sql1="(select tester_number
                from 
                (SELECT book_id,count(book_id) as tester_number
                from angate
                where angate.value='1' and "."updated_at between '".Carbon::create($current_season['begin_thisyear']-1,4, 1,0,0,0)."' and '". Carbon::create($current_season['end_thisyear']-1,3, 31,23,59,59)."'
                and book_id in (select books.id
                from books
                where books.active='6' and "."replied_date3 between '".Carbon::create($current_season['begin_thisyear']-1,4, 1,0,0,0)."' and '".Carbon::create($current_season['end_thisyear']-1,3, 31,23,59,59)."')
                group by book_id 
                order by tester_number desc) as table2
                group by table2.tester_number
                order by table2.tester_number desc) as table1";
        $rank1 = DB::table(DB::raw($sql1))
                ->select('*')
                ->get();
        $popular_rank1 = 0;
        foreach($rank1 as $i => $rank){
           $num = $rank->tester_number;
           if($wishlist2 == $num){
             $popular_rank1 = $i + 1;
             break;
           }           
        }
        $total1 = Books::where("active", 6)->where("replied_date3", ">=", Carbon::create($current_season['begin_thisyear']-1,4, 1,0,0,0))->where("replied_date3", "<=", Carbon::create($current_season['end_thisyear']-1,3, 31,23,59,59))->count();
        $sql="(select tester_number
                from 
                (SELECT book_id,count(book_id) as tester_number
                from angate
                where angate.value='1'and book_id in (select books.id
                from books
                where books.active='6')
                group by book_id 
                order by tester_number desc) as table2
                group by table2.tester_number
                order by table2.tester_number desc) as table1";
        
        $rank2 = DB::table(DB::raw($sql))
                ->select('*')
                ->get();
        $popular_rank = 1;
        foreach($rank2 as $i=>$rank){
           $num = $rank->tester_number;
           if($wishlist1 == $num){
             $popular_rank=$i+1;
             break;
           }           
        }

        $total2 = Books::where("active", 6)->count();

        //$quizCnt = Quizes::where("book_id", $book->id)->where("active", 2)->count();
        $quizCnt = $book->quiz_count;

        $passCnt1 = UserQuiz::where('type', 2)->where('status', 3)->where('book_id', $book->id)
                            ->where("created_date", ">=", Carbon::create($current_season['begin_thisyear']-1,4, 1,0,0,0))->where("created_date", "<=", Carbon::create($current_season['end_thisyear']-1,3, 31,23,59,59))
                            ->count();
        $passCnt2 = UserQuiz::where('type', 2)->where('status', 3)->where('book_id', $book->id)->count();

        $year_from = array(0,7, 9,11,13,16,20,30,40,50,60,70,80,150);
        //$year_to   = array(6,8,10,12,15,19,29,39,49,59,60,70,80);
        $today=now();
        for ($year_ind = 0; $year_ind < 13; $year_ind +=1){
            
            if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59)){
                $start_date=Carbon::create(Date("Y")-($year_from[$year_ind+1]-1)-1,4, 1,0,0,0);
                $end_date=Carbon::create(Date("Y")-($year_from[$year_ind]-1)-1,3, 31,23,59,59);
            }
            else{
                $start_date=Carbon::create(Date("Y")-($year_from[$year_ind+1]-1),4, 1,0,0,0);
                $end_date=Carbon::create(Date("Y")-($year_from[$year_ind]-1),3, 31,23,59,59);
            }          
       
           $sql_female="(select count(users.id) as number
                from users
                where users.id in
                (select DISTINCT(user_quizes.user_id)
                from user_quizes
                where user_quizes.book_id=" . $book->id . " AND user_quizes.type=2 and user_quizes.`status`=3)
                and gender=1 and birthday between '". $start_date ."' and '".$end_date."') as table1";
          
            $female[$year_ind] = DB::table(DB::raw($sql_female))
                ->select('*')
                ->get();   

            $sql_male="(select count(users.id) as number
                from users
                where users.id in
                (select DISTINCT(user_quizes.user_id)
                from user_quizes
                where user_quizes.book_id=" . $book->id . " AND user_quizes.type=2 and user_quizes.`status`=3)
                and gender=2 and birthday between '". $start_date ."' and '".$end_date."') as table1";
           
            $male[$year_ind] = DB::table(DB::raw($sql_male))
                ->select('*')
                ->get();   
        }

        $personbooksearchHistory = new PersonbooksearchHistory();
        if(Auth::check()){
            $personbooksearchHistory->user_id = Auth::id();
            $personbooksearchHistory->username = Auth::user()->username;
            $personbooksearchHistory->age = Auth::user()->age();
            $personbooksearchHistory->address1 = Auth::user()->address1;
            $personbooksearchHistory->address2 = Auth::user()->address2;
        }else
            $personbooksearchHistory->username = '非会員';
        
        $personbooksearchHistory->item = 0;
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
        $personbooksearchHistory->action = '詳細を見る';
        $personbooksearchHistory->device = $this->get_device();
        $personbooksearchHistory->save();

        /*
         for ($year = 2; $year < 8; $year ++){
            
            $age_to=$year*10+9;
            $start_date=Carbon::create(Date("Y")-$age_to,4, 1,0,0,0);
            $end_date=Carbon::create(Date("Y")-$age_to+10,3, 31,0,0,0);
            
           $sql_female="(select count(users.id) as number
                from users
                where users.id in
                (select DISTINCT(user_quizes.user_id)
                from user_quizes
                where user_quizes.book_id=" . $book->id . " AND user_quizes.type=2 and user_quizes.`status`=3)
                and gender=1 and birthday between '". $start_date ."' and '".$end_date."') as table1";
           
            $female[$year] = DB::table(DB::raw($sql_female))
                ->select('*')
                ->get();   

            $sql_male="(select count(users.id) as number
                from users
                where users.id in
                (select DISTINCT(user_quizes.user_id)
                from user_quizes
                where user_quizes.book_id=" . $book->id . " AND user_quizes.type=2 and user_quizes.`status`=3)
                and gender=2 and birthday between '". $start_date ."' and '".$end_date."') as table1";
           
            $male[$year] = DB::table(DB::raw($sql_male))
                ->select('*')
                ->get();   
                  
        }
        $end_date=Carbon::create(Date("Y")-89+10,3, 31,0,0,0);//larger than 80 years
         $sql_female="(select count(users.id) as number
                from users
                where users.id in
                (select DISTINCT(user_quizes.user_id)
                from user_quizes
                where user_quizes.book_id=" . $book->id . " AND user_quizes.type=2 and user_quizes.`status`=3)
                and gender=1 and birthday <='".$end_date."') as table1";
           
            $female[8] = DB::table(DB::raw($sql_female))
                ->select('*')
                ->get();   

            $sql_male="(select count(users.id) as number
                from users
                where users.id in
                (select DISTINCT(user_quizes.user_id)
                from user_quizes
                where user_quizes.book_id=" . $book->id . " AND user_quizes.type=2 and user_quizes.`status`=3)
                and gender=2 and birthday <='".$end_date."') as table1";
           
            $male[8] = DB::table(DB::raw($sql_male))
                ->select('*')
                ->get();   
    */
        
        return view('books.book.detail.index')
            ->withBook($book)
            ->with('already', $already)            
            ->with('page_info', $this->page_info)
            ->with('is_passed', $is_passed)
            ->with('is_checked', $is_checked)
            ->with('is_article', $is_article)
            ->with('articles', $articles)
            ->with('quizMaker_ary', $quizMaker_ary)
            ->with('rank1', $rank1)
            ->with('total1', $total1)
            ->with('rank2', $rank2)
            ->with('male',$male)
            ->with('female',$female)
            ->with('total2', $total2)
            ->with('quizCnt', $quizCnt)
            ->with('passCnt1', $passCnt1)
            ->with('passCnt2', $passCnt2)
            ->with('popular_rank', $popular_rank)
            ->with('popular_rank1', $popular_rank1)
            ->with('overseer', $book->overseer)
            ->with('wishCount', count($wishlist))
            ->with('advertise', $advertise)
            ->withNosidebar(true);
    }

    public function register(Request $request){

        $categories = Categories::all();
        $view = view('books.book.register')
            ->withCategories($categories)
            ->with('page_info', $this->page_info)
            ->with('act', "")
            ->with('cautionflag', $request->input('cautionflag'))
            ->withMsgId(0)
            ->withNosidebar(true);
       
        if ($request->session()->has("act"))
            $view = $view->withAct('confirm');
        if ($request->session()->has("beforefile"))
            $view = $view->with('beforefile', $request->session()->get('beforefile'));
        if ($request->session()->has("beforefilename"))
            $view = $view->with('beforefilename', $request->session()->get('beforefilename'));
        if ($request->session()->has("book"))
            $view = $view->with('book', $request->session()->get('book'));
        if ($request->session()->has("book_id"))
            $view = $view->with('book_id', $request->session()->get('book_id'));
        return $view;
    }

    public function caution(Request $request){
        
        $view = view('books.book.caution')
            ->with('page_info', $this->page_info)
           // ->with('page_info', $request->all())
            ->withNosidebar(true);
        if ($request->input('cautionflag') == 1)
            $view = $view->withCautionflag($request->input('cautionflag'));
        return $view;
    }

    public function create_update(Request $request){
        
        $rule = array(
            'type' => 'required',
            'title' => 'required',
            'title_furi' => 'required',
            //'cover_img' => 'required',
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
                $rule['isbn'] = 'required|unique:books,isbn,NULL,'. $request->input('book_id');
            }else{
                $rule['isbn'] = 'required|unique:books';
            }
            $rule['publish'] = 'required';


        }else{
            $totalChars_val = $request->input('total_chars');
            if($totalChars_val == '' || $totalChars_val < 1){
                $rule['total_chars'] = 'required|confirmed';
            }
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
            'categories.max' => '4つまで選択できます。',
            'total_chars.confirmed' => '１以上の値を入力してください。'
        );
       
        $bookcreate_flag = 0;
        //却下本
         if($request->input('title') !== null && $request->input('firstname_nick') !== null && $request->input('lastname_nick') !== null)
            $bookout = Books::where('firstname_nick','=',$request->input('firstname_nick'))->where('lastname_nick','=',$request->input('lastname_nick'))->where('title','=', $request->input('title'))->where('active', 2)
                           ->get();
           
        if (isset($bookout) && count($bookout)>0){
            return Redirect::back()
                ->withErrors(["bookouterr" => config('consts')['MESSAGES']['BOOKOUT_UNIQUE']])->withInput()
                ->with("act", $request->input('act'));
        }

        $validator = Validator::make($request->all(), $rule, $messages);
        
        if ($validator->fails()){

            return Redirect::back()->withErrors($validator)
                    ->withInput()->with("act", $request->input('act'));
        }
        
        if ($request->input('action') == ""){
            
            $view = Redirect::back()->withErrors($validator)->withInput()
                            ->with("act", "confirm");
            if ($request->session()->has("book_id"))
                $view = $view->with('book_id', $request->session()->get('book_id'));
            return $view;
        }
            
        if ($request->input('book_id') != "") {
            $book = Books::find($request->input('book_id'));
            $book->update($request->all());
        } else {
            $book = Books::create($request->all());
            $bookcreate_flag = 1;
        }
        if($request->input('active') !== null && $request->input('active') != 0)
            $book->active = $request->input('active');
        else $book->active = 1;

        $book->type = $request->input('type');
        $book->image_url = $request->input('image_url');
        $book->rakuten_url = $request->input('rakuten_url');
        $book->honto_url = $request->input('honto_url');
        $book->seven_net_url = $request->input('seven_net_url');

        $book->categories()->detach();
        $book->categories()->attach($request->input('categories'));
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
        $book->test_short_time = ($book->quiz_count * 30) / 2;
        $book->recommend_coefficient = config('consts')['BOOK']['RECOMMEND'][$book->recommend]['POINT'];
        $book->save();
        
        //if($bookcreate_flag == 1){
            //create user activity
            $user_quizes = new UserQuiz();
            $user_quizes->user_id = Auth::id();
            $user_quizes->book_id = $book->id;
            $user_quizes->type  = 0;
            $user_quizes->point = floor($book->point * 0.1 * 100) / 100;
            $user_quizes->status = 3;
            $user_quizes->published_date = now();
            $user_quizes->created_date = now();
            $user_quizes->save();

            //create quiz history
            $userquiz_history = new UserQuizesHistory();
            $userquiz_history->user_id = Auth::id();
            $userquiz_history->book_id = $book->id;
            $userquiz_history->type = 0;
            $userquiz_history->status = 3;         
            //$userquiz_history->point = floor($book->point * 0.1 * 100) / 100;
            $userquiz_history->created_date = now();
            $userquiz_history->finished_date = now();
            $userquiz_history->published_date = now();
            $userquiz_history->save();

            $PersonquizHistory = new PersonquizHistory();
            $PersonquizHistory->user_id = Auth::id();
            $PersonquizHistory->username = Auth::user()->username;
            $PersonquizHistory->item = 0;
            $PersonquizHistory->work_test = 0;
            $PersonquizHistory->age = Auth::user()->age();
            $PersonquizHistory->book_id = $book->id;
            $PersonquizHistory->quiz_point = floor($book->point * 100) / 100;
            $cur_point = UserQuiz::TotalPoint(Auth::id());
            if(isset($cur_point))
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
            $PersonquizHistory->device = $this->get_device();

            //$PersonquizHistory->isbn = $book->isbn;
            $PersonquizHistory->save();
        //}
        if($request->has('msg_id') && $request->input('msg_id') !== null && $request->input('msg_id') != 0){
            $message = Messages::find($request->input('msg_id'));
            $message->content = View::make('partials.save_noti')
                ->withType("")
                ->with('id', $book->id)
                ->with('msgId', $request->input('msg_id'))
                ->render();
            $message->save();
        }
        

        
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        
        if($request->input('action')=='quiz'){
            return view('books.book.completed')
                ->with('page_info', $this->page_info)
                ->withNosidebar(true)
                ->withBook($book);
        }elseif ($request->input('action') == 'close') {
              return Redirect::to('/quiz/make/caution?book_id='.$book->id);
        }elseif ($request->input('book_form_flag') == 'issetflag') {
              return Redirect::to('/quiz/make/caution1?book_id='.$book->id);
        }elseif ($request->input('action') == 'recreate') {
            return Redirect::to('/book/register');
        }
    }

    public function subsave(Request $request){
        $user = Auth::user();
        if($user->role != 15){
            if($request->input('book_id')!="")
                $savebook = Books::where('id', '<>',$request->input('book_id'))->where('register_id', Auth::id())->where('active', 0)->first();
            else
                $savebook = Books::where('register_id', Auth::id())->where('active', 0)->first();

            if(!is_null($savebook) && count(get_object_vars($savebook)) > 0)
                return Redirect::back()
                    ->withErrors(["savebookerr" => '途中保存できるのは1冊だけです。'])->withInput();
        }

        if(($request->input('title') !== null && $request->input('title') !== '') && ($request->input('firstname_nick') !== null && $request->input('firstname_nick') != '') && ($request->input('lastname_nick') !== null && $request->input('lastname_nick') != ''))
            $book = Books::where('firstname_nick','=',$request->input('firstname_nick'))->where('lastname_nick','=',$request->input('lastname_nick'))->where('title','=', $request->input('title'))->where('active', 2)
                           ->get();
           
        if (isset($book) && count($book)>0){
            return Redirect::back()
                ->withErrors(["bookouterr" => config('consts')['MESSAGES']['BOOKOUT_UNIQUE']])->withInput();
        }

        $rule = array(
                //'type' => 'required',
                //'title' => 'required',
                //'title_furi' => 'required',
                //'firstname_nick' => 'required',
                //'lastname_nick' => 'required',
                //'firstname_yomi' => 'required',
                //'lastname_yomi' => 'required',
                //'isbn' => 'required|unique:books',
                //'categories' => 'required|max:4',
                //'recommend' => 'required',
                //'total_chars' => 'required',
                //'register_visi_type' => 'required',
            );
       /* if($request->input('type') == 0){
            $rule['max_rows'] = 'required|min:1';
            $rule['max_chars'] = 'required';
            //$rule['cover_img'] = 'required';
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
        }*/
        if($request->input('type') !== null)
            $res['type'] = $request->input('type');
        if($request->input('title') !== null)
            $res['title'] = $request->input('title');
        if($request->input('title_furi') !== null)
            $res['title_furi'] = $request->input('title_furi');
        if($request->input('firstname_nick') !== null)
            $res['firstname_nick'] = $request->input('firstname_nick');
         if($request->input('lastname_nick') !== null)
            $res['lastname_nick'] = $request->input('lastname_nick');
        if($request->input('firstname_yomi') !== null)
            $res['firstname_yomi'] = $request->input('firstname_yomi');
        if($request->input('lastname_yomi') !== null)
            $res['lastname_yomi'] = $request->input('lastname_yomi');
        if($request->input('isbn') !== null)
            $res['isbn'] = $request->input('isbn');
        if($request->input('categories') !== null)
            $res['categories'] = $request->input('categories');
        if($request->input('recommend') !== null)
            $res['recommend'] = $request->input('recommend');
        if($request->input('publish') !== null)
            $res['publish'] = $request->input('publish');
        if($request->input('max_rows') !== null)
            $res['max_rows'] = $request->input('max_rows');
        if($request->input('max_chars') !== null)
            $res['max_chars'] = $request->input('max_chars');
        if($request->input('entire_blanks') !== null)
            $res['entire_blanks'] = $request->input('entire_blanks');
        if($request->input('p30') !== null)
            $res['p30'] = $request->input('p30');
        if($request->input('quarter_filled') !== null)
            $res['quarter_filled'] = $request->input('quarter_filled');
        if($request->input('p50') !== null)
            $res['p50'] = $request->input('p50');
        if($request->input('half_blanks') !== null)
            $res['half_blanks'] = $request->input('half_blanks');
        if($request->input('p70') !== null)
            $res['p70'] = $request->input('p70');
        if($request->input('quarter_blanks') !== null)
            $res['quarter_blanks'] = $request->input('quarter_blanks');
        if($request->input('p90') !== null)
            $res['p90'] = $request->input('p90');
        if($request->input('p110') !== null)
            $res['p110'] = $request->input('p110');
        if($request->input('pages') !== null)
            $res['pages'] = $request->input('pages');
        if($request->input('total_chars') !== null)
            $res['total_chars'] = $request->input('total_chars');
        if($request->input('register_visi_type') !== null)
            $res['register_visi_type'] = $request->input('register_visi_type');
        if($request->input('register_id') !== null)
            $res['register_id'] = $request->input('register_id');
        if($request->input('image_url') !== null)
            $res['image_url'] = $request->input('image_url');
        if($request->input('rakuten_url') !== null)
            $res['rakuten_url'] = $request->input('rakuten_url');
        if($request->input('honto_url') !== null)
            $res['honto_url'] = $request->input('honto_url');
        if($request->input('seven_net_url') !== null)
            $res['seven_net_url'] = $request->input('seven_net_url');
        if($request->input('active') !== null)
            $res['active'] = $request->input('active');
    
        $messages = array(
            'required' => '入力してください。',
            'type.required' => '選択してください。',
            'categories.required' => '選択してください。',
            'recommend.required' => '選択してください。',
            'register_visi_type.required' => '選択してください。',
            'isbn.unique' => 'この本は、既に他の人が登録申請をしているため登録できません。',
            'categories.max' => '4つまで選択できます。'
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
            if($request->input('book_id')!=""){
                $rule['isbn'] = 'required|unique:books,isbn, '. $request->input('book_id');
            }else{
                $rule['isbn'] = 'required|unique:books';
            }
        }
        
        $validator = Validator::make($request->all(), $rule, $messages);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)
                    ->withInput();
        }
        $book->image_url = $request->input('image_url');
        $book->rakuten_url = $request->input('rekuten_url');
        $book->honto_url = $request->input('honto_url');
        $book->seven_net_url = $request->input('seven_net_url');

        if ($request->input('book_id') != "") {
            $book = Books::find($request->input('book_id'));
            $book->update($res);
        } else {
            $book = Books::create($res);
        }
             
        if($request->input('book_id') == ""){
            if($request->input('active') !== null && $request->input('active') != 0)
                $book->active = $request->input('active');
            else $book->active = 0;
            $book->categories()->detach();
            $book->categories()->attach($request->input('categories'));

            $book->save();
        }


        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);

        if($request->input('book_id') == ""){
            $message = Messages::find($request->input('msg_id'));
            $msgId = 1;
            if(!$message) {
                $message = new Messages;
                $msgId = Messages::max('id') + 1;
            } else {
                $msgId = $message->id;
            }
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = Auth::id();
            $message->name = "協会";
            $message->content = View::make('partials.save_noti')
                ->withType("subsave")
                ->with('id', $book->id)
                ->with('msgId', $msgId)
                ->render();
            $message->save();
        }
        return Redirect::back()->withInput()->with("book", $book);
    }
    public function edit(Request $request, $id, $msgId){
        $book = Books::find($id);
        $categories = Categories::all();
        
        $view = view('books.book.edit')
            ->withCategories($categories)
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->withMsgId($msgId)
            ->withNosidebar(true);
        
        if ($request->session()->has("act"))
            $view = $view->withAct('confirm');
        if ($request->session()->has("beforefile"))
            $view = $view->with('beforefile', $request->session()->get('beforefile'));
        if ($request->session()->has("beforefilename"))
            $view = $view->with('beforefilename', $request->session()->get('beforefilename'));
        if ($request->session()->has("book"))
            $view = $view->with('book', $request->session()->get('book'));
         if ($request->session()->has("book_id"))
            $view = $view->with('book_id', $request->session()->get('book_id'));
        return $view;
    }

    public function bookEditConfirm(Request $request){
        $book_id = $request->input('book_id');
        $msgId = $request->input('msg_id');

        $book = Books::find($book_id);
        $categories = Categories::all();

        $view = view('books.book.editConfirm')
            ->withCategories($categories)
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->with('data', $request->all())
            ->withMsgId($msgId)
            ->withNosidebar(true);
        
        if ($request->session()->has("act"))
            $view = $view->withAct('confirm');
        if ($request->session()->has("beforefile"))
            $view = $view->with('beforefile', $request->session()->get('beforefile'));
        if ($request->session()->has("beforefilename"))
            $view = $view->with('beforefilename', $request->session()->get('beforefilename'));
        if ($request->session()->has("book"))
            $view = $view->with('book', $request->session()->get('book'));
         if ($request->session()->has("book_id"))
            $view = $view->with('book_id', $request->session()->get('book_id'));
        return $view;
    }

    public function delete_book(Request $request, $id = null){
        if($id == null){
            return Redirect::back();
        }
        $book = Books::find($id);
        $book->delete();
        
        $request->session()->flash('status', config('consts')['MESSAGES']['SUCCEED']);
        return Redirect::back();
    }
    //reg book to my wishlist
    public function regWishlist(Request $request){
        $user_id = $request->input('user_id');
        $book_id = $request->input('book_id');
        $book = Books::find($book_id);
        $already = WishLists::where('user_id', '=' , $user_id)->where('book_id', '=', $book_id)->count();
        if($already > 0 ){
            $response = array(
                'message' => '既に読みたい本に登録されたほんです。', 
                'status' => 'failed'
            );
        }else{
            $wishlist = new WishLists;
            $wishlist->user_id = $user_id;
            $wishlist->book_id = $book_id;
            $wishlist->finished_date = null;
            $wishlist->save();
            $response = array(
                'message' => $wishlist,
                'status' => 'success'
            );
        }

        $personbooksearchHistory = new PersonbooksearchHistory();
        if(Auth::check()){
            $personbooksearchHistory->user_id = Auth::id();
            $personbooksearchHistory->username = Auth::user()->username;
            $personbooksearchHistory->age = Auth::user()->age();
            $personbooksearchHistory->address1 = Auth::user()->address1;
            $personbooksearchHistory->address2 = Auth::user()->address2;
        }else
            $personbooksearchHistory->username = '非会員';
        
        $personbooksearchHistory->item = 0;
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
        $personbooksearchHistory->action = '読みたい本に追加';
        
        $personbooksearchHistory->save(); 
        
        return response()->json($response);
    }
    //render create article form
    public function createArticle($book_id){
        //check rights and return redirect if have no rights
        $book = Books::find($book_id);
        $is_passed = 0; $is_checked = 0; $is_article = 0;    
        if (Auth::check()) {
            $is_checked = 1;
            if (count(UserQuiz::where('book_id', $book->id)->where('user_id', Auth::user()->id)->where('status', 3)->where('type', 2)->get())){
                $is_passed = 1;
            }

            if (count(Article::where('book_id', $book->id)->where('register_id', Auth::user()->id)->where('junior_visible', 0)->get())){
                $is_article = 1;
            }
        }
        //        $articleData = [];
        $articles = Article::where('book_id', $book->id)->where("junior_visible", 0)->orderby('created_at', 'desc')->get();
        //        for ($i = 0; $i < count($articles); $i ++){
        //            $articleData[$i]['created_at'] = date_format($articles[$i]['created_at'], "Y/m/d");
        //            $articleData[$i]['vote_name'] = $articles[$i]['register_visi_type'] == 0 ?
        //                                            $articles[$i]->User->username : $articles[$i]->User->fullname();
        //            $articleData[$i]['content'] = $articles[$i]['content'];
        //            $articleData[$i]['id'] = $articles[$i]['id'];
        //            $articleData[$i]['vote_num'] = count($articles[$i]->Votes);
        //            $articleData[$i]['vote_status'] = count(Vote::where('voter_id', Auth::user()->id)->where('article_id', $articles[$i]['id'])->get()) > 0 ? 1 : 0;
        //        }
       
        $view = view('books.book.article.create')
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->with('is_passed', $is_passed)
            ->with('is_checked',$is_checked)
            ->with('is_article',$is_article)
            ->with('articles', $articles)
        //            ->with('articleData', $articleData)
            ->withNosidebar(true);
        return $view;
    }
    
    public function UpdateArticleVote($article_id){
        $book_id = Article::find($article_id)->book_id;
        $book = Books::find($book_id);
        $rlt = Vote::where('article_id', $article_id)->where('voter_id', Auth::user()->id)->get();
        if (count($rlt) > 0){
            
            /* $PersoncontributionHistory = new PersoncontributionHistory();
            $PersoncontributionHistory->user_id = Auth::id();
            $PersoncontributionHistory->username = Auth::user()->username;
            $PersoncontributionHistory->item = 0;
            $PersoncontributionHistory->work_test = 3;
            $PersoncontributionHistory->age = $user->age();
            $PersoncontributionHistory->book_id = $book_id;
            $PersoncontributionHistory->title = $book->title;
            $PersoncontributionHistory->writer = $book->fullname_nick();
            if($book->register_id != 0 && $book->register_id !== null)
                $PersoncontributionHistory->bookregister_name = User::find($book->register_id)->username;
            $PersoncontributionHistory->ok_content = Article::find($article_id)->content;
            $PersoncontributionHistory->save();*/

            $rlt[0]->delete();

        }
        else {
            $vote = new Vote;
            $vote->article_id = $article_id;
            $vote->voter_id = Auth::user()->id;
            $vote->status = 0;
            $vote->voter_visi_type = 0;
            $vote->save();
            
            $PersoncontributionHistory = new PersoncontributionHistory();
            $PersoncontributionHistory->user_id = Auth::id();
            $PersoncontributionHistory->username = Auth::user()->username;
            $PersoncontributionHistory->item = 0;
            $PersoncontributionHistory->work_test = 1;
            $PersoncontributionHistory->age = Auth::user()->age();
            $PersoncontributionHistory->book_id = $book_id;
            $PersoncontributionHistory->title = $book->title;
            $PersoncontributionHistory->writer = $book->fullname_nick();
            $PersoncontributionHistory->ok_content = Article::find($article_id)->content;
            if($book->register_id != 0 && $book->register_id !== null)
                $PersoncontributionHistory->bookregister_name = User::find($book->register_id)->username;
            $PersoncontributionHistory->save();
        }
        
        return Redirect::to('/book/' . $book_id . '/article/create');
    }
    
    public function AddArticle($book_id, Request $request){
        $article = Article::where('book_id',$book_id)
                            ->where('register_id',Auth::user()->id)
                            ->where("junior_visible", 0)->first();
        if($article==null)
            $article = new Article();
        $article->content = $request->input('content');
        $article->book_id = $book_id;
        $article->register_id = Auth::user()->id;
        $article->register_visi_type = $request->input('mode_disp_name');
        $article->junior_visible = 0;
        $article->save();
        $book = Books::find($book_id);

        $PersoncontributionHistory = new PersoncontributionHistory();
        $PersoncontributionHistory->user_id = Auth::id();
        $PersoncontributionHistory->username = Auth::user()->username;
        $PersoncontributionHistory->item = 0;
        $PersoncontributionHistory->work_test = 0;
        $PersoncontributionHistory->age = Auth::user()->age();
        $PersoncontributionHistory->book_id = $book_id;
        $PersoncontributionHistory->title = $book->title;
        $PersoncontributionHistory->writer = $book->fullname_nick();
        $PersoncontributionHistory->content = $request->input('content');
        if($book->register_id != 0 && $book->register_id !== null)
            $PersoncontributionHistory->bookregister_name = User::find($book->register_id)->username;
        $PersoncontributionHistory->save();

        $request->session()->flash('status', config('consts')['MESSAGES']['ARTICLE_SUCCEED']);
        
        return Redirect::to('/book/' . $book_id . '/article/create');
    }
    //render create article form
    public function manageArticle($book_id){
        //check rights and return redirect if have no rights
        if (Auth::check() && !Auth::user()->isOverseerAll() && !Auth::user()->isAdmin()) {
            return Redirect::to('/');
        }
        $book = Books::find($book_id);
        $this->page_info['top'] = 'mypage';
        $this->page_info['subtop'] = 'mypage';
        $this->page_info['side'] = 'mypage';
        $this->page_info['subside'] = 'overseer_books';
        $articles = Article::where("book_id", $book_id)->where("junior_visible", 0)->orderBy("created_at")->get();

        return view('books.book.article.manage')
            ->with('page_info', $this->page_info)
            ->withBook($book)
            ->withArticles($articles);
    }
    //delete article by overseer
    public function deleteArticle(Request $request) {
        $bookId = $request->input("book_id");
        $ids = $request->input("checkboxes");
        if(is_array($ids)) {
            Article::whereIn("id", $ids)->update(['junior_visible' => 1]);
        }
        return Redirect::back()->withInput();
    }

    public function search_passer($id){
        $book = Books::find($id);
        return view('books.book.detail.search_passer')
            ->withBook($book)
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }
    public function res_passer($id, Request $request){
        $first_name = $request->input("first_name");
        $last_name = $request->input("last_name");
        $username = $request->input("username");        
        $book = Books::find($id);
        $temp = null;
        $count = 0;
        $user = Auth::user();
        $schoolmember = 0;

        $bookPasses = User::select("users.id", "users.birthday",DB::raw("concat(users.firstname, ' ', users.lastname) as fullname"),"users.username", "b.title","a.finished_date")
                ->leftJoin('user_quizes as a','users.id', DB::raw('a.user_id and a.type=2 and a.status=3'))
                ->leftJoin('books as b','a.book_id', DB::raw('b.id and b.active <> 7'))
                ->leftJoin('classes as c','users.org_id','=','c.id')
                ->where('b.id', $id)
                ->where('users.firstname','like','%'.$first_name.'%')
                ->where('users.lastname','like','%'.$last_name.'%')
                ->where('users.username','like','%'.$username.'%');
        
        if (Auth::user()->isGroup()){
            $bookPasses = $bookPasses->where( function ($query) {
                             $query->where('a.is_public', 1)
                                   ->where('users.birthday', '<' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                   ->orWhere( function ($query1) {
                                        $query1->where('users.birthday', '>=' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                               ->where('c.group_id', Auth::id());
                                    });
                             })
                        ->get(); 
            $schoolmember = 1;
        }else if(Auth::user()->isTeacher()){
            $bookPasses = $bookPasses->where( function ($query) {
                             $query->where('a.is_public', 1)
                                   ->where('users.birthday', '<' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                   ->orWhere( function ($query1) {
                                        $query1->where('users.birthday', '>=' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                               ->where('c.teacher_id', Auth::id());
                                    });
                             })
                        ->get(); 
            $schoolmember = 1;
        }else if(Auth::user()->isRepresen() && Auth::user()->isItmanager() && Auth::user()->isOther()){
            $school = Auth::user()->School;
            $bookPasses = $bookPasses->where( function ($query) {
                             $query->where('a.is_public', 1)
                                   ->where('users.birthday', '<' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                   ->orWhere( function ($query1) {
                                        $query1->where('users.birthday', '>=' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                               ->where('c.group_id', $school->id);
                                    });
                             })
                        ->get();
            $schoolmember = 1; 
        }else if(Auth::user()->isLibrarian()){
            $recs = Auth::user()->SchoolOfLibrarian;

            $bookPasses = $bookPasses->where( function ($query) use ($recs) {
                             $query->where('a.is_public', 1)
                                   ->where('users.birthday', '<' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'));
                                for ($i=0;$i<count($recs);$i++) {
                                    $query = $query->orWhere( function ($query1) use ($recs, $i) {
                                                            $query1->where('users.birthday', '>=' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                                                   ->where('c.group_id', $recs[$i]->group_id);
                                                        });
                                }     
                             });  
            
             $bookPasses = $bookPasses->get();
             $schoolmember = 1;
        }else{
            $bookPasses = $bookPasses->where( function ($query) {
                             $query->where('a.is_public', 1)
                                   ->where('users.birthday', '<' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                   ->orWhere( function ($query1) {
                                        $query1->where('users.birthday', '>=' ,DB::raw('DATE_SUB(now(), INTERVAL 15 YEAR)'))
                                               ->where('c.teacher_id', Auth::id());
                                    });
                             })
                        ->get(); 
        }

        return view('books.book.detail.res_passer')
            ->withBook($book)
            ->withBookPasses($bookPasses)
            ->with('page_info', $this->page_info)
            ->with('schoolmember', $schoolmember)
            ->withNosidebar(true);
    }
    public function openTest(Request $request){
        $user = Auth::user();
        //      $birthyear = date_format($user->birthday,"Y");
        //      $today = new Date();
        $today = now();
        $today_time = date_create(date("Y-n-d H:i:s"));
        /* $birthday=date_create($user->birthday);
        $diff=date_diff($today,$birthday);
        $age = $diff->format("%Y");
        if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
            $age -= 1;
        if($birthday < Carbon::create((Date("Y")-$age), 3, 31,23,59,59))
            $age += 1;*/
        $id = $request->input('book_id');
        $book = Books::find($id);
        $mode = "before_recog";
        $category = Books::find($id)->categories()->first();
       
        $user_quiz = UserQuiz::where('user_id','=',$user->id)->where('book_id','=',$id)->where('type','=','2')->first(); 
        /*if($category->limit > $age){
            $errors ="false";
            return Redirect::back()->with('errors',$errors);
        }
        else{*/
            if($user_quiz){
                if($user_quiz->status == 3 && $user_quiz->type == 2){
                    $errors = "pass";
                    return Redirect::back()->with('errors',$errors);
                }
                else{
                    if($user_quiz->status == 4 && $user_quiz->type == 2){
                        $created_at = date_create($user_quiz->published_date);
                        $difday = date_diff($created_at, $today_time);
                        $day = $difday->format("%d");    
                        if($day < 3){
                            $errors = "alert";
                            return Redirect::back()->with('errors',$errors);
                        }
                        $user_quiz->test_num = 0;
                    }
                }
            }

        $quiz_overseer = User::find($book->overseer_id);

        $personbooksearchHistory = new PersonbooksearchHistory();
        if(Auth::check()){
            $personbooksearchHistory->user_id = Auth::id();
            $personbooksearchHistory->username = Auth::user()->username;
            $personbooksearchHistory->age = Auth::user()->age();
            $personbooksearchHistory->address1 = Auth::user()->address1;
            $personbooksearchHistory->address2 = Auth::user()->address2;
        }else
            $personbooksearchHistory->username = '非会員';
        
        $personbooksearchHistory->item = 0;
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
        $personbooksearchHistory->action = '受検する';
        
        $personbooksearchHistory->save(); 
        
        return view('books.book.test.index')
            ->withBook($book)
            ->with('mode', $mode)
            ->with('quiz_overseer', $quiz_overseer)
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
        //}
    }
    public function deleteWishBook($book_id){
        $wishbook = WishLists::where('book_id',$book_id)->where('user_id',Auth::id());
        $wishbook->delete();
        return Redirect::back();
    }
    public function viewTestCaution(Request $request){
        
        $book = Books::find($request->input('book_id'));
        return view('books.book.test.caution')
            ->withBook($book)
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }

    public function agreeCaution(Request $request) {
        $bookId = $request->input("book_id");
        $user = Auth::user();
        $user->verifyface_flag = 1;
        $user->save();
        if(isset($user->image_path) && strlen($user->image_path) > 0 && file_exists(public_path().$user->image_path)) {
            // 2019-12-9 chloe wirte
            // return Redirect::to('/book/test/mode_recog?book_id='.$bookId);
            // 2019-12-9 chloe wirte
            return view('books.book.test.verify_face')
                ->withTitle('顔認証')
                ->with('bookId',$bookId)
                ->with('userId',$user->id)
                ->with('user',$user)
                ->with('page_info', $this->page_info)
                ->withNosidebar(true);
        } else {
            // 2019-12-9 chloe wirte
            // return Redirect::to('/book/test/mode_recog?book_id='.$bookId);
            // 2019-12-9 chloe wirte
            return view('books.book.test.signin')
                ->with('page_info', $this->page_info)
                ->withBookId($bookId)
                ->with('user',$user)
                ->withMode(0)
                ->withNosidebar(true);
        }
    }

    public function deletefaceverify(Request $request) {
        $bookId = $request->input("book_id");
        $user = Auth::user();
        if(isset($user->image_path) && strlen($user->image_path) > 0){
           if(file_exists(public_path().$user->image_path)){
                //unlink(public_path().$user->image_path);
                if(isset($user->image_path) && $user->image_path !== null && $user->image_path != ''){
                    if(file_exists(public_path().$user->beforeimage_path) && $user->beforeimage_path !== null && $user->beforeimage_path != ''){
                       unlink(public_path().$user->beforeimage_path);
                    } 
                    $user->beforeimage_path = $user->image_path;
                    $user->beforeimagepath_date = $user->imagepath_date;
                }
           } 
           $user->image_path = "";
           $user->imagepath_date = date_format(now(), "Y-m-d");
           $user->save();
        }
        
        return view('books.book.test.register_face')
            ->with('page_info', $this->page_info)
            ->withBookId($bookId)
            ->withMode(0)
            ->withNosidebar(true);
       
    }

    public function viewForgetPwd(){
        return view('books.book.test.forget_pwd')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }
    public function sendMail(){
        $user = Auth::user();
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
                $personadminHistory->content = 'パスワード再登録';
                $personadminHistory->save();
            }catch(Swift_TransportException $e){
                        
                return Redirect::back()
                    ->withErrors(["servererr" => config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']]);
            }
        }
       
        return Redirect::back();
    }
    public function testSignin(Request $request){
        $bookId = $request->input("book_id");
        $mode = $request->input("mode");
        $password = $request->input('password');
        if ($request->session()->has("errors")){
            $bookId = $request->session()->get("book_id");
            $mode = $request->session()->get("mode");
            $password = $request->session()->get('password');
        }

        $rule = array(
            'password' => 'required'
        );
        $message = array(
            'password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED']
        );

        if($mode==3 && $request->input('passed_point')){
            $request->session()->put('passed_point',$request->input('passed_point'));
            $request->session()->put('passed_quiz_count',$request->input('passed_quiz_count'));
            $request->session()->put('passed_test_time',$request->input('passed_test_time'));
            $request->session()->put('page_count',$request->input('page_count'));
            //$request->session()->put('answer',$request->input('answer'));
        }
        if (!$request->session()->has("errors")){
            $validator = Validator::make($request->all(), $rule, $message);
            if($validator->fails()) {
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors($validator);
            }
        }

        if($mode == 0) { // tester
            if (Auth::user()->r_password != $password) {                
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('invalid_pwd' => 'true'));
            }            
            return view('books.book.test.register_face')
                ->with('page_info', $this->page_info)
                ->withBookId($bookId)
                ->withMode($mode)
                ->withNosidebar(true);
        } elseif($mode == 1) { // overseer
            $request->session()->put('password',$request->input('password'));
            $user = User::where('r_password','=',$password)->first();
            $overseer_check = User::where('r_password','=',$password)
                                    ->where('firstname', '=', Auth::user()->firstname)
                                    ->where('address1', '=', Auth::user()->address1)
                                    ->where('address2', '=', Auth::user()->address2)
                                    ->where('address3', '=', Auth::user()->address3)
                                    ->where('address4', '=', Auth::user()->address4)
                                    ->where('address5', '=', Auth::user()->address5)
                                    ->where('address6', '=', Auth::user()->address6)
                                    ->where('address7', '=', Auth::user()->address7)
                                    ->where('address8', '=', Auth::user()->address8)
                                    ->get();
            $overseer_check_num = 0;
            
            if(!is_null($overseer_check)){
                $overseer_check_num = count($overseer_check);
            }
            if(isset($user) && ($user->isGroup() || $user->isSchoolMember())){
                        
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
                                                           
                $orgworkHistory->item = 1;
                $orgworkHistory->work_test = 0;
                $orgworkHistory->objuser_name = Auth::user()->username;
                $orgworkHistory->save();
            }

            if(!isset($user) || $user == null) {
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('invalid_pwd' => 'true'));
            }else if(isset($user) && $user->aptitude == 0){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('aptitude_no' => 'true'));
            }else if(Auth::user()->r_password == $password){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('tester_oneself' => 'true'));
            }else if($overseer_check_num > 0){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('tester_family' => 'true'));
            }else if(is_null($user->address1) || $user->address1 == "" || is_null($user->address2) || $user->address2 == "" || is_null($user->address4) || $user->address4 == "" || is_null($user->address5) || $user->address5 == ""){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('tester_address' => 'true'));
            }else if(Auth::user()->active == 2 && (($user->address3 == "" || is_null($user->address3)) || ($user->address6 == "" || is_null($user->address6)))){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('tester_address' => 'true'));
            }



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
                                                           
                $orgworkHistory->item = 1;
                $orgworkHistory->work_test = 1;
                $orgworkHistory->objuser_name = Auth::user()->username;
                $orgworkHistory->save();
            }
            // return Redirect::to('/book/test/start');
            return view('books.book.test.verify_face_overseer')
                ->with('page_info', $this->page_info)
                ->withTitle('顔認証')
                ->withBookId($bookId)
                ->withUserId($user->id)
                ->withUser($user)
                ->withPassword($password)
                ->withNosidebar(true);
        }
        else{ // overseer last confirm
            $password = $request->session()->get('password');
            $user = User::where('r_password','=',$password)->first();
           /* if(!isset($user) || $user == null) {
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('invalid_pwd' => 'true'));
            }else if(isset($user) && $user->aptitude == 0){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('aptitude_no' => 'true'));
            }else if(Auth::user()->r_password == $password){
                return Redirect::to('/book/test/signin_overseer?mode='.$mode.'&book_id='.$bookId)->withErrors(array('tester_oneself' => 'true'));
            } */

            return view('books.book.test.verify_face_overseer')
                ->with('page_info', $this->page_info)
                ->withTitle('顔認証')
                ->withBookId($bookId)
                ->withMode($mode)
                ->withUser($user)
                ->withUserId($user->id)
                ->withPassword($password)
                ->withNosidebar(true);
        }
    }

    public function successSignin(Request $request){
        $bookId = $request->input("book_id");
        $mode = $request->input("mode");
        $password = $request->session()->get('password');
        
        if($mode==3 && $request->input('passed_point')){
            $request->session()->put('book_id',$request->input('book_id'));
            $request->session()->put('passed_point',$request->input('passed_point'));
            $request->session()->put('passed_quiz_count',$request->input('passed_quiz_count'));
            $request->session()->put('passed_test_time',$request->input('passed_test_time'));
            $request->session()->put('page_count',$request->input('page_count'));
            //$request->session()->put('answer',$request->input('answer'));
        }
       
        $user = User::where('r_password','=',$password)->first();
        // $this->regTestSuccess_general($request, $bookId, $request->input('passed_test_time'));
        return view('books.book.test.verify_face_overseer')
            ->with('page_info', $this->page_info)
            ->withTitle('顔認証')
            ->withBookId($bookId)
            ->withMode($mode)
            ->withUser($user)
            ->withUserId($user->id)
            ->withPassword($password)
            ->with('passed_test_time', $request->input('passed_test_time'))
            ->with('passed_point', $request->input('passed_point'))
            ->with('passed_quiz_count', $request->input('passed_quiz_count'))
            ->with('page_count', $request->input('page_count'))
            ->withNosidebar(true);
        
    }

    public function signinOverseer(Request $request){
        $mode = $request->input('mode'); 
        return view('books.book.test.signin')
            ->with('page_info', $this->page_info)
            ->withBookId($request->input('book_id'))
            ->withMode($mode)
            ->withNosidebar(true);
    }

    public function signinTeacher(Request $request){
        $mode = $request->input('mode');
        $book_id = $request->input('book_id');
        if ($request->session()->has("errors")){
            $book_id = $request->session()->get("book_id");
            $mode = $request->session()->get("mode");
            $password = $request->session()->get('password');
        }
        
        return view('books.book.test.signin_teacher')
            ->with('page_info', $this->page_info)
            ->with('mode', $mode)
            ->with('book_id', $book_id)
            ->withNosidebar(true);
    }

    public function passwordTeacherVerify(Request $request){
        $book_id = $request->input("book_id");
        $mode = $request->input("mode");
        $password = $request->input('password');
        if ($request->session()->has("errors")){
            $book_id = $request->session()->get("book_id");
            $mode = $request->session()->get("mode");
            $password = $request->session()->get('password');
        }
        $rule = array(
            'password' => 'required'
        );
        $message = array(
            'password.required' => config('consts')['MESSAGES']['PASSWORD_REQUIRED']
        );

        if (!$request->session()->has("errors")){
            $validator = Validator::make($request->all(), $rule, $message);
            if($validator->fails()) {
                return Redirect::to('/book/test/signin_teacher')
                            ->with('mode', $mode)
                            ->with('book_id', $book_id)
                           ->withErrors($validator);
            }
        }

        $pupilclass = Auth::user()->PupilsClass;
       
        $user = User::where('r_password','=',$password)->first();
        if(isset($user) && $user !== null) {
            if($pupilclass->teacher_id == $user->id){

                 return view('books.book.test.register_face')
                        ->with('page_info', $this->page_info)
                        ->with('mode', $mode)
                        ->with('bookId', $book_id)
                        ->withNosidebar(true);
            }
        }

        return Redirect::to('/book/test/signin_teacher')
                            ->with('page_info', $this->page_info)
                           ->with('mode', $mode)
                            ->with('book_id', $book_id)->withErrors(array('invalid_pwd' => 'true'));
    }

    public function viewRecogMode(Request $request){
        $user = Auth::user();
        
        if(!isset($user)){
            return response('Unauthorized.', 401);
        }
        if($user->verifyface_flag == 0){
            return Redirect::to('/mypage/top');
        }
        $user->verifyface_flag = 0;
        $user->save();
        
        $useId = Auth::id();
        $bookId = $request->input('book_id');
        //$examinemethod = 0;
        //$method = $request->input('examinemethod');
        //if(isset($method) && $method !== null) $examinemethod = $method;
        $user_quiz = UserQuiz::where('user_id', $useId)->where('book_id',$bookId)->where('type',2)->first();
        if($user_quiz) {
            $user_quiz->status = 0;
           // $user_quiz->examinemethod = $method;
            $user_quiz->save();
        } else {
            $user_quiz = new UserQuiz();
            $user_quiz -> user_id = $useId;
            $user_quiz -> book_id = $bookId;
            $user_quiz -> status = 0;
            $user_quiz -> type = 2;
           // $user_quiz-> examinemethod = $method;
            $user_quiz->save();
        }
        $userquiz_history = new UserQuizesHistory();
        $userquiz_history -> user_id = $useId;
        $userquiz_history -> book_id = $bookId;
        $userquiz_history -> status = 0;
        $userquiz_history -> type = 2;
        $userquiz_history->created_date = now();
        $userquiz_history->finished_date = now();
        //$userquiz_history->published_date = now();
        $userquiz_history->save();

        $book = Books::find($request->input('book_id'));
        
        return view('books.book.test.mode_recog')
            ->withBook($book)
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }

    public function startTest(Request $request){
        $org = User::where('r_password',$request->input('password'))->first(); //試験監督
        //if web back, go to fail test page
        /*if($request->session()->get('page_count') !== null){
            $page_count = $request->session()->get('page_count');
            //session remove
            $request->session()->remove("test_time");
            $request->session()->remove("passed_point");
            $request->session()->remove("passed_quiz_count");
            $request->session()->remove("passed_test_time");
            $request->session()->remove("page_count");
            return Redirect::to('/book/test/failed?book_id='.$request->input('book_id').'&page_count='.$page_count);
        }*/
        // $org = User::where('id',$request->input('user_id'))->first(); //試験監督
        $user = Auth::user();
        $record = UserQuiz::where('user_id',$user->id)->where('book_id',$request->input('book_id'))->where('type','2')->first();
        $record->status = 1;
        $record->created_date = $record->created_date;
        if($org){
            $record->org_id = $org->id;
        }
      
        $method = $request->input('examinemethod'); //chloe write
        // $method = 0;
        if(isset($method) && $method !== null && $method != '') {
            $record->examinemethod =  $method;
        }
        $record->save();

        $record_history = UserQuizesHistory::where('user_id',$user->id)->where('book_id',$request->input('book_id'))->where('type','2')->orderby('id', 'desc')->first();
        $record_history->status = 1;
        $record_history->created_date = date_create($record_history->created_date);
        if($org)
            $record_history->org_id = $org->id;
      
        if(isset($method) && $method !== null && $method != '') {
            $record_history->examinemethod =  $method;
        }
        $record_history->save();

        $book = Books::find($request->input('book_id'));

        // add password history from teacher
        $pwdHistory = new PwdHistory;
        if($org){
            $pwdHistory->overseer_id = $org->id;
        }
        else{
            $pwdHistory->overseer_id = $record->id;
        }
        $pwdHistory->user_id = Auth::id();
        $pwdHistory->type = 1;
        $pwdHistory->save();
        $this->preTestQuiz($book);
        $mode = "after_recog";


        //session remove
        $request->session()->remove("test_time");
        $request->session()->remove("passed_point");
        $request->session()->remove("passed_quiz_count");
        $request->session()->remove("passed_test_time");
        $request->session()->remove("page_count");

        return view('books.book.test.index')
            ->withBook($book)
            ->with('mode', $mode)
            ->with('page_info', $this->page_info)
            ->withNosidebar(true);
    }

    private function preTestQuiz($book) {
        $quizList = Quizes::where('book_id',$book->id)->where('active','=',2)->get();
        $quizTemp = QuizesTemp::where('book_id',$book->id)->where('user_id', Auth::id())->count();
        $quiz_count = count($quizList);
        $quiz_other = $quiz_count % $book->quiz_count;
        $k = 0; $temp = []; $i = 0;
        if($quizTemp == 0){
            for($q = 0; $q < count($quizList); $q++){
                $r = rand(0,count($quizList)-1);
                if(!in_array($r, $temp)) {
                    if($q < 3 && $quizList[$r]->app_range == 0){
                        $i = $i - 1;
                        $q = $q - 1;
                    }else{
                        $temp[$q] = $r;
                        $quizOne = new QuizesTemp;
                        $quizOne->book_id = $book->id;
                        $quizOne->user_id = Auth::id();
                        $quizOne->idx = $i;
                        $quizOne->quiz_block_num = $k;
                        $quizOne->quiz_id = $quizList[$r]->id;
                        $quizOne->save(); 
                    }
                } else{
                    $i = $i - 1;
                    $q = $q - 1;
                }
                if($i == ($book->quiz_count - 1)){
                    $i = 0;
                    $k++;
                }
                else{
                    $i++;
                }
            }
            if($quiz_other != 0){
                $quiz_temp = QuizesTemp::where('book_id',$book->id)->where('quiz_block_num','=',0)->where('user_id', Auth::id())->take($quiz_other)->get();
                foreach($quiz_temp as $row){
                    $quizOne = new QuizesTemp;
                    $quizOne->book_id = $book->id;
                    $quizOne->user_id = Auth::id();
                    $quizOne->idx = $i;
                    $quizOne->quiz_block_num = $k;
                    $quizOne->quiz_id = $row->quiz_id;
                    $quizOne->save(); 
                    $i++;
                }
            }
        }

    }

    public function testQuizAjax(Request $request){
        /*$book = Books::find($request->input('book_id'));
        $page_count = 0;
        $point = 0;
        $test_time =0;
        $answer = -1;
        $mode = 3;
        $quiz = '';
       
        $current_season = BookController::CurrentSeaon(now());

        if($request->has("page_count")){
            $page_count = $request->input("page_count");
        }
        
        if($request->has('test_time')){
            $test_time = $request->input('test_time');
        }
         
        if($request->session()->get('test_time') !== null && $request->session()->get('test_time') != 0)
            $quiztesttime = $test_time - $request->session()->get('test_time');
        else
            $quiztesttime = $test_time;
        
        if($test_time != $request->session()->get('test_time')){
            $request->session()->put('quiztime', 30);
        }
        $request->session()->put('test_time',$test_time);
        
        if($request->has('point')){
            $point = $request->input("point");
        }
        if($request->has('answer')){
            $answer = $request->input("answer");
        }

        $user_quiz = UserQuiz::where('book_id',$request->input('book_id'))->where('type', 2)->where('user_id',Auth::user()->id)->first();
        $quiz_overseer = User::find($book->overseer_id);
       
        $names['quiz_overseer'] = $quiz_overseer->firstname . ' ' . $quiz_overseer->lastname;
        $names['test_id'] = $quiz_overseer->id;
        
        if($page_count < $book->quiz_count){
            $quizTemp = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count)->first();
            $quiz = Quizes::find($quizTemp->quiz_id);
            $answer_right = false;

            if($page_count > 0){
                $quizTemp1 = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-1)->first();
                $quiz1 = Quizes::find($quizTemp1->quiz_id);
                
                if ($answer == $quiz1->answer) {
                    $point++;
                    $answer_right = true;
                    //$request->session()->put('point',$point);
                }
            }

            if ($page_count - $point >= $book->quiz_count * 0.2) {
                
                return $this->viewTestFailed($request);
            }
            $page_count ++;

            $request->session()->put('page_count', $page_count);

            if($request->session()->get('quiztime') == 30){
                //誤答,正答
                if($page_count > 1){
                    $persontestHistory = new PersontestHistory();
                    $persontestHistory->user_id = Auth::id();
                    $persontestHistory->username = Auth::user()->username;
                    $persontestHistory->item = 0;
                    
                    if($answer_right)
                        $persontestHistory->work_test = 2;
                    else
                        $persontestHistory->work_test = 1;
                    $persontestHistory->tested_time = $quiztesttime;
                    $persontestHistory->age = Auth::user()->age();
                    $persontestHistory->address1 = Auth::user()->address1;
                    $persontestHistory->address2 = Auth::user()->address2;
                    $persontestHistory->book_id = $book->id;
                    $persontestHistory->quiz_id = $quiz1->id;
                    if($quiz1->doq_quizid !== null)
                        $persontestHistory->doq_quizid = $quiz1->doq_quizid;
                    $persontestHistory->quiz_order = $page_count-1;
                    $persontestHistory->testoversee_id = $quiz_overseer->id;
                    $persontestHistory->testoversee_username = $quiz_overseer->username;


                    $cur_point = UserQuiz::TotalPoint(Auth::id());
                    if(isset($cur_point))
                        $persontestHistory->point = floor($cur_point*100)/100;
                    else
                        $persontestHistory->point = 0;

                    $persontestHistory->rank = 10;
                    $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                    for ($i = 0; $i < 11; $i++) {
                      if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
                          $persontestHistory->rank = $i;
                       }
                    }
                    $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(), $current_season, Auth::user()->role)->first();
                    if(isset($thisyear_point))
                        $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
                    else
                         $persontestHistory->thisyear_point = 0;
                    $persontestHistory->save();
                }
                //開始
                $persontestHistory = new PersontestHistory();
                $persontestHistory->user_id = Auth::id();
                $persontestHistory->username = Auth::user()->username;
                $persontestHistory->item = 0;
                $persontestHistory->work_test = 0;
                $persontestHistory->age = Auth::user()->age();
                $persontestHistory->address1 = Auth::user()->address1;
                $persontestHistory->address2 = Auth::user()->address2;
                $persontestHistory->book_id = $book->id;
                $persontestHistory->quiz_id = $quiz->id;
                if($quiz->doq_quizid !== null)
                    $persontestHistory->doq_quizid = $quiz->doq_quizid;
                $persontestHistory->quiz_order = $page_count;
                $persontestHistory->testoversee_id = $quiz_overseer->id;
                $persontestHistory->testoversee_username = $quiz_overseer->username;


                $cur_point = UserQuiz::TotalPoint(Auth::id());
                if(isset($cur_point))
                    $persontestHistory->point = floor($cur_point*100)/100;
                else
                    $persontestHistory->point = 0;

                $persontestHistory->rank = 10;
                $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                for ($i = 0; $i < 11; $i++) {
                  if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
                      $persontestHistory->rank = $i;
                   }
                }
                $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(), $current_season, Auth::user()->role)->first();
                if(isset($thisyear_point))
                    $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
                else
                     $persontestHistory->thisyear_point = 0;
                $persontestHistory->save();
                
            }
        }
       
        $response = array(
            'status' => 'success',
            'book' => $book,
            'point' => $point,
            'quiz' => $quiz,
            'mode' => $mode,
            'names' => $names,
            'page_count' => $page_count,
        );
        
        return response()->json($response);*/
    }

    public function viewTestQuiz(Request $request){
        if($request->input('book_id')){
            $book = Books::find($request->input('book_id'));
        }
        else if($request->session()->has('book_id') && $request->session()->get('book_id') != null){
            $book = Books::find($request->session()->get('book_id'));
        }
        $page_count = 0;
        $point = 0;
        $test_time =0;
        $answer = -1;
        $mode = 3;
        $quiz = '';
        $test_success = 0;
        
        if(Auth::user()->isPupil() && Auth::user()->active == 1)
            $current_season = BookController::CurrentSeaon_Pupil(now());
        else
            $current_season = BookController::CurrentSeaon(now());

        if($request->has("page_count")){
            // var_dump('page count check 1', $request->input("page_count"));
            $page_count = (int)$request->input("page_count");
        }
        else if($request->session()->has('page_count')) {
            // var_dump('page count check 2', $request->session()->get('page_count'));
            $page_count = (int)$request->session()->get('page_count');
        }

        // echo ('<br>');
        // var_dump('request session check %d \n', $request->session()->get('page_count'));
        // echo ('<br>');
        // var_dump('page count check %d \n', $page_count);
        // echo ('<br>');
        // var_dump('session check %d \n', Session::get('page_count'));
        // echo ('<br>');

        if($request->session()->get('page_count') !== null){
            if($page_count != $request->session()->get('page_count')) {
                // var_dump('page count error', $page_count, $request->session()->get('page_count'));
                // exit();
                return Redirect::to('/book/test/failed?book_id='.$book->id.'&page_count='.$request->session()->get('page_count'));
            }
        }
        
        if($request->has('test_time')){
            $test_time = $request->input('test_time');
        }
        else if($request->session()->has('passed_test_time')){
            $test_time = $request->session()->get('passed_test_time');
        }
         
        if($request->session()->get('test_time') !== null && $request->session()->get('test_time') != 0)
            $quiztesttime = $test_time - $request->session()->get('test_time');
        else
            $quiztesttime = $test_time;
        
        if($test_time != $request->session()->get('test_time')){
            $request->session()->put('quiztime', 30);
        }
        $request->session()->put('test_time',$test_time);
        
        if($request->has('point')){
            $point = $request->input("point");
        }
        else if($request->session()->has('passed_point')){
            $point = $request->session()->get('passed_point');
        }

        if($request->has('answer')){
            $answer = $request->input("answer");
        }

        if($request->session()->get('quiz_block_num') !== null){
            $quiz_block_num = $request->session()->get('quiz_block_num');
        }
        else{
            $quiz_block_num = 0;
            $request->session()->put('quiz_block_num', 0);
        }

        $user_quiz = UserQuiz::where('book_id',$request->input('book_id'))->where('type', 2)->where('user_id',Auth::user()->id)->first();
        $quiz_overseer = User::find($book->overseer_id);
        
        //$names['quiz_overseer'] = $quiz_overseer->firstname . ' ' . $quiz_overseer->lastname;
        //$names['test_id'] = $quiz_overseer->id;
        
        if($page_count <= $book->quiz_count){
            if($page_count < $book->quiz_count){
                $quizTemp = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count)->where('quiz_block_num', $quiz_block_num)->first();
                $quiz = Quizes::find($quizTemp->quiz_id);
            }
            $answer_right = false;

            if($page_count > 0){
                $quizTemp1 = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-1)->where('quiz_block_num', $quiz_block_num)->first();
                $quiz1 = Quizes::find($quizTemp1->quiz_id);
                
                if ($answer == $quiz1->answer) {
                    $point++;
                    $answer_right = true;
                    //$request->session()->put('point',$point);
                }
            }

            if ($page_count - $point > $book->quiz_count * 0.2) {
                //return $this->viewTestFailed($request);
                //$page_count = $book->quiz_count;
                $quizTemp = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-1)->where('quiz_block_num', $quiz_block_num)->first();
                $quiz = Quizes::find($quizTemp->quiz_id);
                $test_success = 1;
            }elseif ($point >= $book->quiz_count * 0.8) {
                $quizTemp = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-1)->where('quiz_block_num', $quiz_block_num)->first();
                $quiz = Quizes::find($quizTemp->quiz_id);
                $test_success = 2;
                //$page_count = $book->quiz_count;
            }
            

            if($request->session()->get('quiztime') == 30){
                
                if($page_count < $book->quiz_count){
                    //開始
                    $persontestHistory = new PersontestHistory();
                    $persontestHistory->user_id = Auth::id();
                    $persontestHistory->username = Auth::user()->username;
                    $persontestHistory->item = 0;
                    $persontestHistory->work_test = 0;
                    $persontestHistory->age = Auth::user()->age();
                    $persontestHistory->address1 = Auth::user()->address1;
                    $persontestHistory->address2 = Auth::user()->address2;
                    $persontestHistory->book_id = $book->id;
                    $persontestHistory->quiz_id = $quiz->id;
                    if($quiz->doq_quizid !== null)
                        $persontestHistory->doq_quizid = $quiz->doq_quizid;
                    $persontestHistory->quiz_order = $page_count;
                    if(isset($quiz_overseer) && $quiz_overseer !== null){
                        $persontestHistory->testoversee_id = $quiz_overseer->id;
                        $persontestHistory->testoversee_username = $quiz_overseer->username;
                    }

                    $cur_point = UserQuiz::TotalPoint(Auth::id());
                    if(isset($cur_point))
                        $persontestHistory->point = floor($cur_point*100)/100;
                    else
                        $persontestHistory->point = 0;

                    $persontestHistory->rank = 10;
                    $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                    for ($i = 0; $i < 11; $i++) {
                      if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
                          $persontestHistory->rank = $i;
                       }
                    }
                    $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(), $current_season, Auth::user()->role)->first();
                    if(isset($thisyear_point))
                        $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
                    else
                         $persontestHistory->thisyear_point = 0;
                    $persontestHistory->save();
                }

                //誤答,正答
                if($page_count > 1){
                    $persontestHistory = new PersontestHistory();
                    $persontestHistory->user_id = Auth::id();
                    $persontestHistory->username = Auth::user()->username;
                    $persontestHistory->item = 0;
                    
                    if($answer_right)
                        $persontestHistory->work_test = 2;
                    else
                        $persontestHistory->work_test = 1;
                    $persontestHistory->tested_time = $quiztesttime;
                    $persontestHistory->age = Auth::user()->age();
                    $persontestHistory->address1 = Auth::user()->address1;
                    $persontestHistory->address2 = Auth::user()->address2;
                    $persontestHistory->book_id = $book->id;
                    $persontestHistory->quiz_id = $quiz1->id;
                    if($quiz1->doq_quizid !== null)
                        $persontestHistory->doq_quizid = $quiz1->doq_quizid;
                    $persontestHistory->quiz_order = $page_count-1;
                    if(isset($quiz_overseer) && $quiz_overseer !== null){
                        $persontestHistory->testoversee_id = $quiz_overseer->id;
                        $persontestHistory->testoversee_username = $quiz_overseer->username;
                    }

                    $cur_point = UserQuiz::TotalPoint(Auth::id());
                    if(isset($cur_point))
                        $persontestHistory->point = floor($cur_point*100)/100;
                    else
                        $persontestHistory->point = 0;

                    $persontestHistory->rank = 10;
                    $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                    for ($i = 0; $i < 11; $i++) {
                      if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
                          $persontestHistory->rank = $i;
                       }
                    }
                    $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(), $current_season, Auth::user()->role)->first();
                    if(isset($thisyear_point))
                        $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
                    else
                         $persontestHistory->thisyear_point = 0;
                    $persontestHistory->save();
                }
            }
        }
        if($request->session()->has('password')){
            $password = $request->session()->get('password');
        }
        else{
            $password = "";
        }
        $page_count++;
        $request->session()->put('page_count', $page_count);
        $request->session()->save();
        // var_dump('page count check last', $page_count, $request->session()->get('page_count'));
       
        return view('books.book.test.quiz')
            ->with('page_info', $this->page_info)
            ->with('title', '受検')
            ->withNosidebar(true)
            ->withBook($book)
            ->withPoint($point)
            ->withQuiz($quiz)
            ->withMode($mode)
            ->with('password', $password)
            ->with('quiz_block_num', $quiz_block_num)
            ->with('quiz_overseer',$quiz_overseer)
            ->with('page_count', $page_count)
            ->with('test_success', $test_success);
    }
    public function regTestSuccess(Request $request){
        $beforebookRegister_totalpoint = UserQuiz::TotalPoint(Auth::id());
        $beforebookRegister_rank = 10;
        
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
            if ($beforebookRegister_totalpoint >= $ranks[$i] && $beforebookRegister_totalpoint < $ranks[$i - 1]) {
                $beforebookRegister_rank = $i;
            }
        }

        if(Auth::user()->isPupil() && Auth::user()->active == 1)
            $current_season = BookController::CurrentSeaon_Pupil(now());
        else
            $current_season = BookController::CurrentSeaon(now());
        //by ajax
        $record = UserQuiz::where('user_id','=',Auth::id())->where('book_id','=',$request->input('book_id'))->where('type','=','2')->first();
        $record->status = 3;
        $record->finished_date = date_create();
        $record->published_date = date_create();
        $record->created_date = date_create($record->created_date);
        
        $book = Books::find($request->input('book_id'));
        $point = floor($book->point*100)/100;
       

        $savetime = 0;
               
        QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->delete();
        //if($request->input('passed_test_time') < $quiz_time)
        if($request->input('passed_test_time') <= $book->test_short_time)
        {
            $savetime = 1;
            $point += floor(($book->point/10)*100)/100;
        }
        $record->point = $point;
        $record->passed_test_time = $request->input('passed_test_time');
        $record->save();

        $record_history = UserQuizesHistory::where('user_id','=',Auth::id())->where('book_id','=',$request->input('book_id'))->where('type','=','2')->orderby('id','desc')->first();
        $record_history->status = 3;
        $record_history->finished_date = $record->finished_date;
        $record_history->published_date = $record->published_date;
        $record_history->created_date = date_create($record_history->created_date);
        $record_history->point = $record->point;
        $record_history->passed_test_time = $request->input('passed_test_time');
        $record_history->save();

        // add password history from teacher
        $pwdHistory = new PwdHistory;
        $pwdHistory->overseer_id = $record->org_id;
        $pwdHistory->user_id = $record->user_id;
        $pwdHistory->type = 2;
        $pwdHistory->save();

        $message = new Messages;
        $message->type = 0;
        $message->from_id = 0;
        $message->to_id = Auth::id();
        $message->name = "協会";
        if($book->active >= 3)
            $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_SUCCESS'],
                date_format(now(), 'H時i分'),
                "<a href='/book/".$book->id."/detail'>".$book->title."</a>");
        else
            $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_SUCCESS'],
                date_format(now(), 'H時i分'),
                "<a>".$book->title."</a>");

        $message->save();

        $afterbookRegister_totalpoint = UserQuiz::TotalPoint(Auth::id());
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
            $message1->to_id = Auth::id();
            $message1->name = "協会";
            $message1->content = config('consts')['MESSAGES']['AUTOMSG_LEVEL_UP'];
            $message1->save();
        }

        $persontestHistory = new PersontestHistory();
        $persontestHistory->user_id = Auth::id();
        $persontestHistory->username = Auth::user()->username;
        $persontestHistory->item = 0;
        $persontestHistory->work_test = 3;
        $persontestHistory->tested_time = $request->session()->get('test_time');
        $persontestHistory->age = Auth::user()->age();
        $persontestHistory->address1 = Auth::user()->address1;
        $persontestHistory->address2 = Auth::user()->address2;
        $persontestHistory->book_id = $book->id;
        $persontestHistory->testoversee_id = $record->org_id;
        $persontestHistory->testoversee_username = User::find($record->org_id)->username;
        $persontestHistory->tested_point = floor($book->point*100)/100;
        if($savetime == 1)
            $persontestHistory->tested_short_point = floor(($book->point/10)*100)/100;
        $cur_point = UserQuiz::TotalPoint(Auth::id());
        if(isset($cur_point))
            $persontestHistory->point = floor($cur_point*100)/100;
        else
            $persontestHistory->point = 0;

        $persontestHistory->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
          if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
              $persontestHistory->rank = $i;
           }
        }
        $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(),$current_season, Auth::user()->role)->first();
        if(isset($thisyear_point))
            $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
        else
             $persontestHistory->thisyear_point = 0;
        $persontestHistory->save();
        
        $response = array(
            'status' => 'success',
            
        );
       
        return response()->json($response);
    }
    public function regTestSuccess_general(Request $request, $book_id = 0, $passed_test_time = 0){
        $book_id = $request->input('book_id');
        $passed_test_time = $request->input('passed_test_time');
        $beforebookRegister_totalpoint = UserQuiz::TotalPoint(Auth::id());
        $beforebookRegister_rank = 10;
        
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
            if ($beforebookRegister_totalpoint >= $ranks[$i] && $beforebookRegister_totalpoint < $ranks[$i - 1]) {
                $beforebookRegister_rank = $i;
            }
        }

        if(Auth::user()->isPupil() && Auth::user()->active == 1)
            $current_season = BookController::CurrentSeaon_Pupil(now());
        else
            $current_season = BookController::CurrentSeaon(now());
        //by ajax
        $record = UserQuiz::where('user_id','=',Auth::id())->where('book_id','=',$book_id)->where('type','=','2')->first();
        $record->status = 3;
        $record->finished_date = date_create();
        $record->published_date = date_create();
        $record->created_date = date_create($record->created_date);
        
        $book = Books::find($book_id);
        $point = floor($book->point*100)/100;
       

        $savetime = 0;
               
        QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->delete();
        //if($request->input('passed_test_time') < $quiz_time)
        if($passed_test_time <= $book->test_short_time)
        {
            $savetime = 1;
            $point += floor(($book->point/10)*100)/100;
        }
        $record->point = $point;
        $record->passed_test_time = $passed_test_time;
        $record->save();

        $record_history = UserQuizesHistory::where('user_id','=',Auth::id())->where('book_id','=',$book_id)->where('type','=','2')->orderby('id','desc')->first();
        $record_history->status = 3;
        $record_history->finished_date = $record->finished_date;
        $record_history->published_date = $record->published_date;
        $record_history->created_date = date_create($record_history->created_date);
        $record_history->point = $record->point;
        $record_history->passed_test_time = $passed_test_time;
        $record_history->save();

        // add password history from teacher
        $pwdHistory = new PwdHistory;
        $pwdHistory->overseer_id = $record->org_id;
        $pwdHistory->user_id = $record->user_id;
        $pwdHistory->type = 2;
        $pwdHistory->save();

        $message = new Messages;
        $message->type = 0;
        $message->from_id = 0;
        $message->to_id = Auth::id();
        $message->name = "協会";
        if($book->active >= 3)
            $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_SUCCESS'],
                date_format(now(), 'H時i分'),
                "<a href='/book/".$book->id."/detail'>".$book->title."</a>");
        else
            $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_SUCCESS'],
                date_format(now(), 'H時i分'),
                "<a>".$book->title."</a>");

        $message->save();

        $afterbookRegister_totalpoint = UserQuiz::TotalPoint(Auth::id());
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
            $message1->to_id = Auth::id();
            $message1->name = "協会";
            $message1->content = config('consts')['MESSAGES']['AUTOMSG_LEVEL_UP'];
            $message1->save();
        }

        $persontestHistory = new PersontestHistory();
        $persontestHistory->user_id = Auth::id();
        $persontestHistory->username = Auth::user()->username;
        $persontestHistory->item = 0;
        $persontestHistory->work_test = 3;
        $persontestHistory->tested_time = $request->session()->get('test_time');
        $persontestHistory->age = Auth::user()->age();
        $persontestHistory->address1 = Auth::user()->address1;
        $persontestHistory->address2 = Auth::user()->address2;
        $persontestHistory->book_id = $book->id;
        $persontestHistory->testoversee_id = $record->org_id;
        $persontestHistory->testoversee_username = User::find($record->org_id)->username;
        $persontestHistory->tested_point = floor($book->point*100)/100;
        if($savetime == 1)
            $persontestHistory->tested_short_point = floor(($book->point/10)*100)/100;
        $cur_point = UserQuiz::TotalPoint(Auth::id());
        if(isset($cur_point))
            $persontestHistory->point = floor($cur_point*100)/100;
        else
            $persontestHistory->point = 0;

        $persontestHistory->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
          if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
              $persontestHistory->rank = $i;
           }
        }
        $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(),$current_season, Auth::user()->role)->first();
        if(isset($thisyear_point))
            $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
        else
             $persontestHistory->thisyear_point = 0;
        $persontestHistory->save();
        
        $response = array(
            'status' => 'success',
            
        );
       
        return response()->json($response);
    }
    public function viewTestSuccess(Request $request) {
        
        $passed_point = $request->session()->get('passed_point');
        
        if($request->has('passed_point'))
            $passed_point = $request->input('passed_point');
        $passed_quiz_count = $request->session()->get('passed_quiz_count');
        if($request->input('passed_quiz_count'))
            $passed_quiz_count = $request->input('passed_quiz_count');

        $passed_test_time = $request->session()->get('passed_test_time');
        if($request->has('passed_test_time'))
            $passed_test_time = $request->input('passed_test_time');

        $book = Books::find($request->input('book_id'));
        QuizesTemp::where('book_id', $request->input('book_id'))->where('user_id', Auth::id())->delete();
        $quiz_block_num = 0;
        $request->session()->forget('quiz_block_num');

        $savetime = 0;
        //$quiz_time = $passed_quiz_count*$book->quiz_count;

        //if($passed_test_time < $quiz_time)
        if($passed_test_time <= $book->test_short_time)
        {
            $savetime = 1;
           
        }

        return view('books.book.test.success')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->withBook($book)
            ->with('passed_point',$passed_point)
            ->with('quiz_count',$passed_quiz_count)
            ->with('test_time',$passed_test_time)
            ->with('savetime',$savetime)
            ->with('bookId',$book->id);
        
    }

    public function viewTestFailed(Request $request){
        $request->session()->put('point',0);
        $status=1;
        $bookId = $request->input('book_id');
        $book = Books::find($bookId);
        $record = UserQuiz::where('user_id','=',Auth::id())->where('book_id','=',$bookId)->where('type','=','2')->first();
        $quizList = Quizes::where('book_id',$book->id)->where('active','=',2)->get();
        $quiz_count = count($quizList);
        $quiz_block_count = ceil($quiz_count / $book->quiz_count);
        if($request->session()->get('quiz_block_num') !== null && $request->session()->get('quiz_block_num') < $quiz_block_count - 1){
            $quiz_block_num_old = $request->session()->get('quiz_block_num');
            $quiz_block_num = $quiz_block_num_old + 1;
            $request->session()->put('quiz_block_num', $quiz_block_num);
        }
        else{
            $quiz_block_num_old = 0;
            $quiz_block_num = 0;
            $request->session()->put('quiz_block_num', $quiz_block_num);
        }
        $record->finished_date = date_create();
        $record->published_date = date_create();
        $record->created_date = date_create($record->created_date);
        $record->status = 4;
        $teacher_id = $record->org_id;
        //誤答
        $persontestHistory = new PersontestHistory();
        $persontestHistory->user_id = Auth::id();
        $persontestHistory->username = Auth::user()->username;
        $persontestHistory->item = 0;
        $persontestHistory->work_test = 1;
        $persontestHistory->tested_time = 30 - $request->session()->get('quiztime');
        $persontestHistory->age = Auth::user()->age();
        $persontestHistory->address1 = Auth::user()->address1;
        $persontestHistory->address2 = Auth::user()->address2;
       
        $persontestHistory->book_id = $book->id;
        $page_count = $request->input('page_count');
        
        if($page_count > $book->quiz_count)
            $quizTemp1 = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-2)->where('quiz_block_num', $quiz_block_num_old)->first();
        else
            $quizTemp1 = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-1)->where('quiz_block_num', $quiz_block_num_old)->first();
        $quiz1 = Quizes::find($quizTemp1->quiz_id);
       
        $persontestHistory->quiz_id = $quiz1->id;
        if($quiz1->doq_quizid !== null)
            $persontestHistory->doq_quizid = $quiz1->doq_quizid;
        $persontestHistory->quiz_order = $page_count;
        $persontestHistory->testoversee_id = $record->org_id;
        $persontestHistory->testoversee_username = User::find($record->org_id)->username;

        if(Auth::user()->isPupil() && Auth::user()->active == 1)
            $current_season = BookController::CurrentSeaon_Pupil(now());
        else
            $current_season = BookController::CurrentSeaon(now());
        
        $cur_point = UserQuiz::TotalPoint(Auth::id());
        if(isset($cur_point))
            $persontestHistory->point = floor($cur_point*100)/100;
        else
            $persontestHistory->point = 0;

        $persontestHistory->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
          if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
              $persontestHistory->rank = $i;
           }
        }
        $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(), $current_season, Auth::user()->role)->first();
        if(isset($thisyear_point))
            $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
        else
             $persontestHistory->thisyear_point = 0;
        $persontestHistory->save();
        
        // 不合格
        $persontestHistory = new PersontestHistory();
        $persontestHistory->user_id = Auth::id();
        $persontestHistory->username = Auth::user()->username;
        $persontestHistory->item = 0;
        $work_test = PersontestHistory::where('user_id', Auth::id())->where('item', 0)->where('work_test', '>',3)->orderby('created_at', 'desc')->first();
        if(isset($work_test))
            $persontestHistory->work_test = $work_test->work_test+1;
        else $persontestHistory->work_test = 4;
        $persontestHistory->tested_point = 0;
        $persontestHistory->tested_short_point = 0;
        $persontestHistory->book_id = $book->id;
       
        $persontestHistory->tested_time = $request->session()->get('test_time');
        $persontestHistory->age = Auth::user()->age();
        $persontestHistory->address1 = Auth::user()->address1;
        $persontestHistory->address2 = Auth::user()->address2;
        $persontestHistory->testoversee_id = $record->org_id;
        $persontestHistory->testoversee_username = User::find($record->org_id)->username;
        $cur_point = UserQuiz::TotalPoint(Auth::id());
        if(isset($cur_point))
            $persontestHistory->point = floor($cur_point*100)/100;
        else
            $persontestHistory->point = 0;

        $persontestHistory->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
          if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
              $persontestHistory->rank = $i;
           }
        }
        $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(),$current_season, Auth::user()->role)->first();
        if(isset($thisyear_point))
            $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
        else
             $persontestHistory->thisyear_point = 0;
        $persontestHistory->save();


        if($record->test_num == 0) {
            $record->test_num = 1;
        } else {
            $status = 0;
            QuizesTemp::where('book_id', $bookId)->where('user_id', Auth::id())->delete();
            $quiz_block_num = 0;
            $request->session()->forget('quiz_block_num');
            $message = new Messages;
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = Auth::id();
            $message->name = "協会";
            $date = $record->created_date;
            $date1 = now();
            $date2 = date_add(now(), date_interval_create_from_date_string("3 days"));
            if($book->active >= 3)
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_FAILED'],
                    date_format($date1, 'm月d日H時'),
                    "<a href='/book/".$book->id."/detail'>".$book->title."</a>",
                    date_format($date2, 'm月d日H時'));
            else
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_FAILED'],
                    date_format($date1, 'm月d日H時'),
                    "<a>".$book->title."</a>",
                    date_format($date2, 'm月d日H時'));
            $message->save();
        }
        
        $record->save();

        $record_history = UserQuizesHistory::where('user_id','=',Auth::id())->where('book_id','=',$bookId)->where('type','=','2')->orderby('id','desc')->first();
        
        $record_history->finished_date = $record->finished_date;
        $record_history->published_date = $record->published_date;
        $record_history->created_date = date_create($record_history->created_date);
        $record_history->status = 4;
        $record_history->save();
        return view('books.book.test.failed')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->with('quiz_block_num', $quiz_block_num)
            ->with('book_id',$bookId)
            ->with('teacher_id',$teacher_id)
            ->with('status', $status);
    }

    public function viewTestStoped(Request $request){
        $request->session()->put('point',0);
        $status=1;
        $bookId = $request->input('book_id');
        $book = Books::find($bookId);
        $quizList = Quizes::where('book_id',$book->id)->where('active','=',2)->get();
        $quiz_count = count($quizList);
        $quiz_block_count = ceil($quiz_count / $book->quiz_count);
        if($request->session()->get('quiz_block_num') !== null && $request->session()->get('quiz_block_num') < $quiz_block_count - 1){
            $quiz_block_num = $request->session()->get('quiz_block_num');
        }
        else{
            $quiz_block_num = 0;
            $request->session()->put('quiz_block_num', 0);
        }

        $record = UserQuiz::where('user_id','=',Auth::id())->where('book_id','=',$bookId)->where('type','=','2')->first();
        
        $record->finished_date = date_create();
        $record->published_date = date_create();
        $record->created_date = date_create($record->created_date);
        $record->status = 4;
        $teacher_id = $record->org_id;
        //誤答
        $persontestHistory = new PersontestHistory();
        $persontestHistory->user_id = Auth::id();
        $persontestHistory->username = Auth::user()->username;
        $persontestHistory->item = 0;
        $persontestHistory->work_test = 1;
        $persontestHistory->tested_time = 30 - $request->session()->get('quiztime');
        $persontestHistory->age = Auth::user()->age();
        $persontestHistory->address1 = Auth::user()->address1;
        $persontestHistory->address2 = Auth::user()->address2;
       
        $persontestHistory->book_id = $book->id;
        $page_count = $request->input('page_count');
        
        if($page_count > $book->quiz_count)
            $quizTemp1 = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-2)->where('quiz_block_num', $quiz_block_num)->first();
        else
            $quizTemp1 = QuizesTemp::where('book_id', $book->id)->where('user_id', Auth::id())->where('idx', $page_count-1)->where('quiz_block_num', $quiz_block_num)->first();
        $quiz1 = Quizes::find($quizTemp1->quiz_id);
       
        $persontestHistory->quiz_id = $quiz1->id;
        if($quiz1->doq_quizid !== null)
            $persontestHistory->doq_quizid = $quiz1->doq_quizid;
        $persontestHistory->quiz_order = $page_count;
        $persontestHistory->testoversee_id = $record->org_id;
        $persontestHistory->testoversee_username = User::find($record->org_id)->username;

        if(Auth::user()->isPupil() && Auth::user()->active == 1)
            $current_season = BookController::CurrentSeaon_Pupil(now());
        else
            $current_season = BookController::CurrentSeaon(now());
        
        $cur_point = UserQuiz::TotalPoint(Auth::id());
        if(isset($cur_point))
            $persontestHistory->point = floor($cur_point*100)/100;
        else
            $persontestHistory->point = 0;

        $persontestHistory->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
          if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
              $persontestHistory->rank = $i;
           }
        }
        $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(), $current_season, Auth::user()->role)->first();
        if(isset($thisyear_point))
            $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
        else
             $persontestHistory->thisyear_point = 0;
        $persontestHistory->save();
        
        // 不合格
        $persontestHistory = new PersontestHistory();
        $persontestHistory->user_id = Auth::id();
        $persontestHistory->username = Auth::user()->username;
        $persontestHistory->item = 0;
        $work_test = PersontestHistory::where('user_id', Auth::id())->where('item', 0)->where('work_test', '>',3)->orderby('created_at', 'desc')->first();
        if(isset($work_test))
            $persontestHistory->work_test = $work_test->work_test+1;
        else $persontestHistory->work_test = 4;
        $persontestHistory->tested_point = 0;
        $persontestHistory->tested_short_point = 0;
        $persontestHistory->book_id = $book->id;
       
        $persontestHistory->tested_time = $request->session()->get('test_time');
        $persontestHistory->age = Auth::user()->age();
        $persontestHistory->address1 = Auth::user()->address1;
        $persontestHistory->address2 = Auth::user()->address2;
        $persontestHistory->testoversee_id = $record->org_id;
        $persontestHistory->testoversee_username = User::find($record->org_id)->username;
        $cur_point = UserQuiz::TotalPoint(Auth::id());
        if(isset($cur_point))
            $persontestHistory->point = floor($cur_point*100)/100;
        else
            $persontestHistory->point = 0;

        $persontestHistory->rank = 10;
        $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

        for ($i = 0; $i < 11; $i++) {
          if ($persontestHistory->point >= $ranks[$i] && $persontestHistory->point < $ranks[$i - 1]) {
              $persontestHistory->rank = $i;
           }
        }
        $thisyear_point = UserQuiz::CurrentYearUserQuiz(Auth::id(),$current_season, Auth::user()->role)->first();
        if(isset($thisyear_point))
            $persontestHistory->thisyear_point = floor($thisyear_point->cur_point*100)/100;
        else
             $persontestHistory->thisyear_point = 0;
        $persontestHistory->save();


        if($record->test_num == 0) {
            $record->test_num = 1;
        } else {
            $status = 0;
            QuizesTemp::where('book_id', $bookId)->where('user_id', Auth::id())->delete();
            $quiz_block_num = 0;
            $request->session()->forget('quiz_block_num');
            $message = new Messages;
            $message->type = 0;
            $message->from_id = 0;
            $message->to_id = Auth::id();
            $message->name = "協会";
            $date = $record->created_date;
            $date1 = now();
            $date2 = date_add(now(), date_interval_create_from_date_string("3 days"));
            if($book->active >= 3)
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_FAILED'],
                    date_format($date1, 'm月d日H時'),
                    "<a href='/book/".$book->id."/detail'>".$book->title."</a>",
                    date_format($date2, 'm月d日H時'));
            else
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_TEST_FAILED'],
                    date_format($date1, 'm月d日H時'),
                    "<a>".$book->title."</a>",
                    date_format($date2, 'm月d日H時'));
            $message->save();
        }
        
        $record->save();

        $record_history = UserQuizesHistory::where('user_id','=',Auth::id())->where('book_id','=',$bookId)->where('type','=','2')->orderby('id','desc')->first();
        
        $record_history->finished_date = $record->finished_date;
        $record_history->published_date = $record->published_date;
        $record_history->created_date = date_create($record_history->created_date);
        $record_history->status = 4;
        $record_history->save();

        //overseer
        $overseer = User::find($record->org_id);

        $PersontestoverseeHistory = new PersontestoverseeHistory();
        $PersontestoverseeHistory->user_id = $overseer->id;
        $PersontestoverseeHistory->username = $overseer->username;
        $PersontestoverseeHistory->item = 0;
        $PersontestoverseeHistory->work_test = 2; //検定中止
        $PersontestoverseeHistory->age = $overseer->age();
        $PersontestoverseeHistory->address1 = $overseer->address1;
        $PersontestoverseeHistory->address2 = $overseer->address2;
        $PersontestoverseeHistory->book_id = $book->id;
        $PersontestoverseeHistory->test_username = Auth::user()->username;
        $PersontestoverseeHistory->title = $book->title;
        $PersontestoverseeHistory->writer = $book->fullname_nick();
        $PersontestoverseeHistory->overseer_num = UserQuizesHistory::testOverseer($overseer->id)->get()->count();
        //$PersontestoverseeHistory->overseer_real = UserQuizesHistory::testOverseers($user->id)->get()->count();
                   
        $PersontestoverseeHistory->save();
        

        return view('books.book.test.failed')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->with('book_id',$bookId)
            ->with('quiz_block_num', $quiz_block_num)
            ->with('teacher_id',$teacher_id)
            ->with('status', $status);
    }

    public function postTestSuccess(Request $request){
        $bookId = $request->input("book_id");
        $angateVal = $request->input("angate");

        $angate = new Angate;
        $angate->book_id = $bookId;
        $angate->user_id = Auth::id();
        $angate->value = $angateVal;
        $angate->save();

        return response()->json(array('result'=>"ok"), 200);
    }
    
    public function accept_book(Request $request){
        $book_id = $request->input("bookId");
    	$book  = Books::find($book_id);
        //        $acceptQuiz = $request->input('accept_quiz');
        //        $rejectQuiz = $request->input('reject_quiz');
        //        print_r($acceptQuiz);
        $acceptCnt = 0;
        //$idx = 1;
        foreach($book->PendingQuizes as $key => $quiz) {
            $book  = Books::find($book_id);
            $acceptQuiz = $request->input('accept_quiz' . $quiz->id);
            if($acceptQuiz !== null && $acceptQuiz && $acceptQuiz == 1) {
                $quiz->active = 2;
                $quiz->overseer_id = Auth::id();
                $quiz->published_date = now();

                if($book->active != 6){
                    $value = $acceptCnt + 1;
                    $quiz->doq_quizid = 'dq'.$quiz->book_id.'-'.$value;
                }else{
                    if($quiz->doq_quizid == '' || $quiz->doq_quizid == null){
                        $temp = 0;
                        
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

                $quiz->save();
                $quiz->refresh();
                
                $beforebookRegister_totalpoint = UserQuiz::TotalPoint($quiz->register_id);
                $beforebookRegister_rank = 10;
                
                $ranks = [29070, 14070, 6070, 2070, 870, 370, 220, 120, 60, 20, 0];

                for ($i = 0; $i < 11; $i++) {
                    if ($beforebookRegister_totalpoint >= $ranks[$i] && $beforebookRegister_totalpoint < $ranks[$i - 1]) {
                        $beforebookRegister_rank = $i;
                    }
                }
                $activequizCt = 0;
                //change user activity
                $user_activity = UserQuiz::where('quiz_id', $quiz->id)->where('type', 1)->where('status', 3)->first();
                if($user_activity){
                    $user_activity->status = 1;
                    $user_activity->finished_date = now();
                    $user_activity->created_date = date_create($user_activity->created_date);
                    $activequizCt = $book->ActiveQuizesForUser($user_activity->user_id)->count();
                    if($activequizCt > 10) //10問限度    
                        $user_activity->point = 0;
                    $user_activity->save();

                    //create quiz history
                    $userquiz_history = new UserQuizesHistory();
                    $userquiz_history->user_id = $user_activity->user_id;
                    $userquiz_history->book_id = $user_activity->book_id;
                    $userquiz_history->type = 1;
                    $userquiz_history->status = 1;         
                    $userquiz_history->quiz_id = $quiz->id;
                   // if($quiz->doq_quizid) 
                   //     $userquiz_history->doq_quizid = $quiz->doq_quizid;  
                    if($activequizCt <= 10) //10問限度    
                        $userquiz_history->point = floor($user_activity->point*100)/100;
                    else
                        $userquiz_history->point = 0;
                    $userquiz_history->finished_date = now();
                    $userquiz_history->published_date = date_create($user_activity->published_date);
                    $userquiz_history->created_date = now();
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
                $quizregister = User::find($quiz->register_id);
                //quiz
                $personquizHistory = new PersonquizHistory();
                $personquizHistory->user_id = $quiz->register_id;
                $personquizHistory->username = $quizregister->username;
                $personquizHistory->item = 0;
                $personquizHistory->work_test = 4;
               
                $personquizHistory->age = $quizregister->age();
                $personquizHistory->book_id = $book_id;
                $personquizHistory->quiz_id = $quiz->id;
                if($quiz->doq_quizid !== null)
                    $personquizHistory->doq_quizid = $quiz->doq_quizid;
                if($activequizCt <= 10) //10問限度    
                    $personquizHistory->quiz_point = floor(($book->point/10)*100)/100; 
                else
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
                $personoverseerHistory->work_test = 0;
                $personoverseerHistory->age = Auth::user()->age();
                $personoverseerHistory->book_id = $book_id;
                $personoverseerHistory->quiz_id = $quiz->id;
                if($quiz->doq_quizid !== null)
                    $personoverseerHistory->doq_quizid = $quiz->doq_quizid;
                if($book->register_id != 0 && $book->register_id !== null)
                    $personoverseerHistory->bookregister_name = User::find($book->register_id)->username;
                $personoverseerHistory->title = $book->title;
                $personoverseerHistory->writer = $book->fullname_nick();
                $personoverseerHistory->content = $quiz->question;
                //$personoverseerHistory->overseer_num = UserQuizesHistory::testOverseer(Auth::id())->get()->count();
                //$personoverseerHistory->overseer_real = UserQuizesHistory::testOverseers(Auth::id())->get()->count();
                $personoverseerHistory->save();

                $acceptCnt ++;
            } else {
                $quiz->reason = $request->input('reason' . $quiz->id);
                $quiz->active = 3;
                $quiz->save();

                //change user activity
                $user_activity = UserQuiz::where('quiz_id', $quiz->id)->where('type', 1)->where('status', 3)->first();
                if($user_activity){
                    $user_activity->status = 2;
                    $user_activity->finished_date = now();
                    $user_activity->created_date = date_create($user_activity->created_date);
                    $user_activity->point = 0;
                    $user_activity->save();

                    //create quiz history
                    $userquiz_history = new UserQuizesHistory();
                    $userquiz_history->user_id = $user_activity->user_id;
                    $userquiz_history->book_id = $user_activity->book_id;
                    $userquiz_history->type = 1;
                    $userquiz_history->status = 2;         
                    $userquiz_history->quiz_id = $quiz->id;   
                    if($quiz->doq_quizid !== null)
                        $userquiz_history->doq_quizid = $quiz->doq_quizid; 
                    $userquiz_history->point = 0;
                    $userquiz_history->finished_date = now();
                    $userquiz_history->published_date = date_create($user_activity->published_date);
                    $userquiz_history->created_date = now();
                    $userquiz_history->save();
                }
                $quizregister = User::find($quiz->register_id);
                //quiz
                $personquizHistory = new PersonquizHistory();
                $personquizHistory->user_id = $quiz->register_id;
                $personquizHistory->username = $quizregister->username;
                $personquizHistory->item = 0;
                $personquizHistory->work_test = 5;
               
                $personquizHistory->age = $quizregister->age();
                $personquizHistory->book_id = $book_id;
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
                $personoverseerHistory->book_id = $book_id;
                $personoverseerHistory->quiz_id = $quiz->id;
                if($quiz->doq_quizid !== null)
                    $personoverseerHistory->doq_quizid = $quiz->doq_quizid;
                if($book->register_id != 0 && $book->register_id !== null)
                    $personoverseerHistory->bookregister_name = User::find($book->register_id)->username;
                $personoverseerHistory->title = $book->title;
                $personoverseerHistory->writer = $book->fullname_nick();
                $personoverseerHistory->content = $quiz->question;
                //$personoverseerHistory->overseer_num = UserQuizesHistory::testOverseer(Auth::id())->get()->count();
                //$personoverseerHistory->overseer_real = UserQuizesHistory::testOverseers(Auth::id())->get()->count();
                $personoverseerHistory->save();
            }
            
        }
        $quizMakers =  $book->QuizMakers()->get();
        foreach ($quizMakers as $key => $quizMaker) {
            $activequizes = $book->ActiveQuizesForUser($quizMaker->register_id)->get();
            if(count($activequizes)){
                $message = new Messages;
                $message->type = 0;
                $message->from_id = 0;
                $message->to_id = $quizMaker->register_id;
                $message->name = "協会";
                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_QUIZMAKE_ACCEPT'], $book->title, count($activequizes));
                $message->save();
            }
            
            $unactivequizes = $book->UnActiveQuizesForUser($quizMaker->register_id)->get();
            if(count($unactivequizes)){
                $message1 = new Messages;
                $message1->type = 0;
                $message1->from_id = 0;
                $message1->to_id = $quizMaker->register_id;
                $message1->name = "協会";
                $message1->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_QUIZMAKE_REJECT'], $book->title, count($unactivequizes));
                $message1->save();
            }
        }
        $book  = Books::find($book_id);
    	if(isset($book)){
            //認定後 doq quiz id
            foreach($book->ActiveQuizes as $key => $quiz) {
                if($book->active != 6){
                    $value = $key + 1;
                    $quiz->doq_quizid = 'dq'.$quiz->book_id.'-'.$value;
                }else{
                    if($quiz->doq_quizid == '' || $quiz->doq_quizid == null){
                        $temp = 0;
                        $book  = Books::find($book_id);
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
                $quiz->save();
            }

            $book  = Books::find($book_id);

            if(count($book->ActiveQuizes) >= $book->quiz_count * 3){
                $book->active = 6;
                $book->qc_date = now();
               // $book->quiz_count = round($acceptCnt / 3, 0);
                $book->save();
                $request->session()->flash('status', config('consts')['MESSAGES']['REGISTER_FINISHIED']);
            }
    	}

    	return redirect('/mypage/quiz_store/1/'.$book->id);
    }

    public function quizfinish(Request $request){
        $book_id = $request->input("book_id");
        $book  = Books::find($book_id);

        if(isset($book)){
            $book->active = 6;
            $book->qc_date = now();
           
            $book->save();
            //未認定
            foreach($book->PendingQuizes as $key => $quiz) {
                $message = new Messages;
                $message->type = 0;
                $message->from_id = 0;
                $message->to_id = $quiz->register_id;
                $message->name = "協会";
                //$quiz->reason = $request->input('reason' . $quiz->id);
                $quiz->active = 3;
                $quiz->save();

                $message->content = sprintf(config('consts')['MESSAGES']['AUTOMSG_QUIZMAKE_REJECT'], $book->title, $quiz->question);
                $message->save();

                //change user activity
                $user_activity = UserQuiz::where('quiz_id', $quiz->id)->where('type', 1)->where('status', 3)->first();
                if($user_activity){
                    $user_activity->status = 2;
                    $user_activity->finished_date = now();
                    $user_activity->created_date = date_create($user_activity->created_date);
                    $user_activity->save();

                    //create quiz history
                    $userquiz_history = new UserQuizesHistory();
                    $userquiz_history->user_id = $user_activity->user_id;
                    $userquiz_history->book_id = $user_activity->book_id;
                    $userquiz_history->type = 1;
                    $userquiz_history->status = 2;         
                    $userquiz_history->quiz_id = $quiz->id;  
                    if($quiz->doq_quizid !== null)
                        $userquiz_history->doq_quizid = $quiz->doq_quizid;  
                    $userquiz_history->point = 0;
                    $userquiz_history->finished_date = now();
                    $userquiz_history->published_date = date_create($user_activity->published_date);
                    $userquiz_history->created_date = date_create($user_activity->created_date);
                    $userquiz_history->save();
                }
                
                //quiz
                $personquizHistory = new PersonquizHistory();
                $personquizHistory->user_id = $quiz->register_id;
                $personquizHistory->username = User::find($quiz->register_id)->username;
                $personquizHistory->item = 0;
                $personquizHistory->work_test = 5;
                $personquizHistory->age = User::find($quiz->register_id)->age();
                $personquizHistory->book_id = $book_id;
                //$personquizHistory->quiz_id = $quiz->id;
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
                $personoverseerHistory->book_id = $book_id;
                //$personoverseerHistory->quiz_id = $quiz->id;
                if($book->register_id != 0 && $book->register_id !== null)
                    $personoverseerHistory->bookregister_name = User::find($book->register_id)->username;
                $personoverseerHistory->title = $book->title;
                $personoverseerHistory->writer = $book->fullname_nick();
                $personoverseerHistory->content = $quiz->question;
                //$personoverseerHistory->overseer_num = UserQuizesHistory::testOverseer(Auth::id())->get()->count();
                //$personoverseerHistory->overseer_real = UserQuizesHistory::testOverseers(Auth::id())->get()->count();
                $personoverseerHistory->save();
            }
            //認定後 doq quiz id
            foreach($book->ActiveQuizes as $key => $quiz) {
                $value = $key + 1;
                $quiz->doq_quizid = 'dq'.$quiz->book_id.'-'.$value;
                $quiz->save();
            }
            //overseer 認定
            $personoverseerHistory = new PersonoverseerHistory();
            $personoverseerHistory->user_id = Auth::id();
            $personoverseerHistory->username = Auth::user()->username;
            $personoverseerHistory->item = 0;
            $personoverseerHistory->work_test = 2;
            $personoverseerHistory->age = Auth::user()->age();
            $personoverseerHistory->book_id = $book_id;
            //$personoverseerHistory->quiz_id = $quiz->doq_quizid;
            if($book->register_id != 0 && $book->register_id !== null)
                $personoverseerHistory->bookregister_name = User::find($book->register_id)->username;
            $personoverseerHistory->title = $book->title;
            $personoverseerHistory->writer = $book->fullname_nick();
            //$personoverseerHistory->content = $quiz->question;
            //$personoverseerHistory->overseer_num = UserQuizesHistory::testOverseer(Auth::id())->get()->count();
            //$personoverseerHistory->overseer_real = UserQuizesHistory::testOverseers(Auth::id())->get()->count();
            $personoverseerHistory->save();

            
            $response = array(
                'status' => 'success',
                'book_id' => $book_id
            );
        }else{
            $response = array(
               'status' => 'no',
               'id' => $book_id,
            );
        }
        return response()->json($response);
    }

    public function observerDemand($bookId) {
        $demand = new Demand;

        $demand->book_id = $bookId;
        $demand->observer_id = Auth::id();
        $demand->save();

        return redirect('/mypage/bid_history');
    }

    public function bookSearchAPI(Request $request){
        $title = $request->input("title");
        $isbn = $request->input("isbn");
        $title_mode = 1;
        $writer_mode = 1;
        $keyword_mode = 1;

        $books = Books::where('active', '>=', 3)->where('active', '<', 7);
        if($request->input('title')){
            $books = $books->SearchbyTitle($request->input('title'), $title_mode);
        }
        if($request->input('firstname_nick') || $request->input('lastname_nick')){
            $books = $books->SearchbyWriter($request->input('firstname_nick'), $request->input('lastname_nick'), $request->input('writer_mode'));   
        }
        if($request->input('isbn')){
            $books = $books->where('isbn', 'like','%'.$request->input('isbn').'%');
        }
        if($request->input('keyword')){
            $books = $books->SearchbyKeyword($request->input('keyword'), $keyword_mode);
        }
        return $books->get();
    }

    public function booksRegisterAPI(Request $request){
        $book = Books::create($request->all());
        $book->save();
        return;
    }
    public function searchByIsbn(Request $request){

        $isbn=$request->input('isbn');
        
        $book = Books::where('active', '>=', 3)->where('active', '<', 7)->where('isbn','=',$isbn)->whereNotNull('isbn')
                ->get();
        

        if (count($book)>0){
            
            $response = array(
                'hasISBN' => true           
            );
        }
        else{
           $response = array(
                'hasISBN' => false           
            );     
        }   
            
        return response()->json($response);
    }
    //却下本
    public function bookoutAjax(Request $request){

        $title = $request->input('title');
        
        $book = Books::where('firstname_nick','=',$firstname_nick)->where('lastname_nick','=',$lastname_nick)->where('title','=',$title)->where('active', 2)
                ->get();

        if (count($book)>0){
            
            $response = array(
                'hasbookout' => true           
            );
        }
        else{
           $response = array(
                'hasbookout' => false           
            );     
        }   
            
        return response()->json($response);
    }


    public function bookregisterAjax(Request $request){

        if(!Auth::check())
            $request->session()->put('bookregister',1); 
        $response = array(
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function quizbook(Request $request){
        
       $books = Books::where('active','>=', 3)->where('active','<', 6)->orderby('updated_at', 'desc')->get();
        return view('books.quiz.quizbook')
            ->with('page_info', $this->page_info)
            ->withNosidebar(true)
            ->withBooks($books);
    }
    public function sessionquiztime(Request $request){

        $quiztime = $request->input('quiztime');
        
        $quiztime = $request->session()->put('quiztime', $quiztime);
        
        $response = array(
            'success' => true           
        );
            
        return response()->json($response);
    }

    public function CurrentSeaon($date){
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
            $current_season['end_thisyear'] = Date('Y');
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
            $current_season['end_thisyear'] = Date('Y');
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
            $current_season['end_thisyear'] = Date('Y');
        } else if ($date >= Carbon::create((Date("Y")), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y")), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y')) . '年冬期' . '1月1日';
            $current_season['to'] = Date('Y') . '年' . '3月31日';
            $current_season['term'] = 3; // this year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = Date('Y');
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
        }*/ else if ($date >= Carbon::create((Date("Y") - 1), 4, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 1), 6, 30,23,59,59)){
            $current_season['from'] = (Date('Y') - 1) . '年春期' . '4月1日';
            $current_season['to'] = (Date('Y') - 1) . '年' . '6月31日';
            $current_season['term'] = 5; // last year spring
            $current_season['season'] = '春期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y') - 1) . '.' . '4.1';
            $current_season['to_num'] = (Date('Y') - 1) . '.' . '6.30';
            $current_season['begin_season']= Carbon::create((Date("Y") - 1), 4, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-1), 6, 30,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
            $current_season['end_thisyear'] = Date('Y')-1;
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
            $current_season['end_thisyear'] = Date('Y')-1;
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
            $current_season['end_thisyear'] = Date('Y')-1;
        } else if($date >= Carbon::create((Date("Y") - 1), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 1), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 1) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 1) . '年' . '3月31日';
            $current_season['term'] = 8; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 1);
            $current_season['from_num'] = (Date('Y') - 1) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 1) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 1), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-1), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-1;
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
            $current_season['end_thisyear'] = Date('Y')-2;
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
            $current_season['end_thisyear'] = Date('Y')-2;
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
            $current_season['end_thisyear'] = Date('Y')-2;
        }else if($date >= Carbon::create((Date("Y") - 2), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 2), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 2) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 2) . '年' . '3月31日';
            $current_season['term'] = 12; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 2);
            $current_season['from_num'] = (Date('Y') - 2) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 2) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 2), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-2), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-2;
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
            $current_season['end_thisyear'] = Date('Y')-3;
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
            $current_season['end_thisyear'] = Date('Y')-3;
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
            $current_season['end_thisyear'] = Date('Y')-3;
        }else if($date >= Carbon::create((Date("Y") - 3), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 3), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 3) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 3) . '年' . '3月31日';
            $current_season['term'] = 16; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 3);
            $current_season['from_num'] = (Date('Y') - 3) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 3) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 3), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-3), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-3;
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
            $current_season['end_thisyear'] = Date('Y')-4;
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
            $current_season['end_thisyear'] = Date('Y')-4;
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
            $current_season['end_thisyear'] = Date('Y')-4;
        }else if($date >= Carbon::create((Date("Y") - 4), 1, 1,0,0,0) && $date <= Carbon::create((Date("Y") - 4), 3, 31,23,59,59)){
            $current_season['from'] = (Date('Y') - 4) . '年冬期' . '1月1日';
            $current_season['to'] = (Date('Y') - 4) . '年' . '3月31日';
            $current_season['term'] = 20; // last year winter
            $current_season['season'] = '冬期';
            $current_season['year'] = (Date('Y') - 4);
            $current_season['from_num'] = (Date('Y') - 4) . '.' . '1.1';
            $current_season['to_num'] = (Date('Y') - 4) . '.' . '3.31';
            $current_season['begin_season']= Carbon::create((Date("Y") - 4), 1, 1,0,0,0);
            $current_season['end_season']=Carbon::create((Date("Y")-4), 3, 31,23,59,59);
            $current_season['begin_thisyear'] = Date('Y')-4;
            $current_season['end_thisyear'] = Date('Y')-4;
        }

        return $current_season;
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

