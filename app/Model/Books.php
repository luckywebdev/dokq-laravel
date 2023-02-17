<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Carbon\Carbon;
class Books extends Model
{
    protected $table="books";
    protected $fillable = [
    	'title', 
    	'title_furi', 
    	'firstname_nick', 
    	'lastname_nick', 
        'firstname_yomi', 
        'lastname_yomi', 
    	'writer_id', 
    	'isbn', 
        'url',
    	'cover_img',
        'coverimg_date',
        'coverimge_check', 
    	'recommend',
        'recommend_coefficient',
        'publish',
        'max_rows',
    	'max_chars', 
    	'pages', 
    	'entire_blanks', 
    	'quarter_filled', 
    	'half_blanks', 
    	'quarter_blanks', 
    	'p30', 
    	'p50', 
    	'p70', 
    	'p90', 
    	'p110',
    	'total_chars', 
        'recog_total_chars', 
    	'point', 
    	'register_visi_type', 
    	'register_id',
        'active',
        'quiz_status',
        'type',
    	'qc_date',
    	'quiz_count',
        'test_short_time',
    	'reason1',
    	'reason2',
        'overseer_id',
        'author_overseer_flag',
        'recommend_flag',
    	'replied_date1',
    	'replied_date2',
        'replied_date3',
        'image_url',
        'rakuten_url',
        'seven_net_url',
        'honto_url'
    ];
	
    
//    if active = 0: registered yourself
//    if active = 1: ready for admin
//    if active = 2: not passed
//    if active = 3: passed
//	  if active = 4: ready for getting overseer, 8.2c ========= no using
//	  if active = 5: checked overseer
//	  if active = 6: completed
//    if active = 7: delete by admin
    /* 'replied_date1': book 承認 by admin: active = 3
       'replied_date3': book 監修者決定 by admin
       qc_date : 認定 date after quiz finished : active = 6
     */
    public function fullname_nick(){
        return $this->firstname_nick . ' ' . $this->lastname_nick;
    }
    public function fullname_yomi(){
        return $this->firstname_yomi . ' ' . $this->lastname_yomi;
    }
    public function categories(){
    	return $this->belongsToMany('App\Model\Categories', 'book_category', 'book_id', 'category_id');
    }
    public function category_ids(){
    	return $this->categories->map(function($category){
    		return $category->id;
    	})->toArray();
    }
    public function category_names(){
        return $this->categories->map(function($category){
            return $category->name;
        })->toArray();
    }
    public function Register(){
        return $this->belongsTo('App\User', 'register_id');
    }

    public function RegisterShow(){
        //return $this->register_visi_type == 0 ? $this->Register->fullname() : $this->register->username;
        $return = '';
        if(isset($this->Register)){
            if($this->Register->age() < 15){
                $return = '中学生以下';
            }else{
                if($this->register_visi_type == 0){
                    if($this->Register->role == config('consts')['USER']['ROLE']['AUTHOR'])
                        $return = $this->Register->fullname_nick();
                    else
                        $return = $this->Register->fullname();
                }else 
                    $return = $this->register->username;
            }
        }
        
        return $return;
    }

    /* quizes table
        active:0 registered yourself
        active:1 ready for admin
        active:2 passed
        active:3 not passed
    */
    public function Quizes(){
        return $this->hasMany('App\Model\Quizes', 'book_id')->where('active', '>', 0 )->where('active', '<', 3 );
    }
    public function Quizelists(){
        return $this->hasMany('App\Model\Quizes', 'book_id')->where('active', '>', 0 )->where('active', '<=', 3 )->orderBy(DB::raw("app_range asc, updated_at"), 'desc');
    }
    
    public function PendingQuizes(){
    	return $this->hasMany('App\Model\Quizes', 'book_id')->where('active', '=', 1 )->orderby('created_at', 'desc', 'app_range','asc');
    }

    public function PendingOverseers(){
        return $this->hasMany('App\Model\Demand', 'book_id')->where('status', '=', 0 );
    }
    
    public function ActiveQuizes(){
        return $this->hasMany('App\Model\Quizes', 'book_id')->where('active', '=', 2 )->orderby('app_range','asc', 'updated_at','asc');
    }
    public function UnActiveQuizes(){
        return $this->hasMany('App\Model\Quizes', 'book_id')
                 ->where( function ($query) {
                     $query->where('active', '=', 1 )->orwhere('active', '=', 3 );
                 })->orderby('app_range','asc');
    }
    public function ActiveQuizesForUser($userId){
        return $this->hasMany('App\Model\Quizes', 'book_id')->where("register_id", $userId)->where('active', '=', 2 );
    }
    public function UnActiveQuizesForUser($userId){
        return $this->hasMany('App\Model\Quizes', 'book_id')->where("register_id", $userId)->where('active', '=', 3 );
    }
    public function QuizMakers(){
        return $this->hasMany('App\Model\Quizes', 'book_id')->groupby('register_id');
    }
    public function TestedNums(){
        return $this->hasMany('App\Model\UserQuizesHistory', 'book_id')
                    ->where('type', '=', 2 );
    }
    public function TestedRealNums(){
        return $this->hasMany('App\Model\UserQuiz', 'book_id')
                    ->where('type', '=', 2 )
                    ->groupby('user_id');
    }
    public function passedNums(){
        return $this->hasMany('App\Model\UserQuiz', 'book_id')
                    ->where('type', '=', 2 )
                    ->where('status','=', 3);
    }
     public function Rank_tested_lastyear($book_id){
        $sql="(select book_cnt,sum(flag) as flag
            from
            (select book_id,count(book_id) as book_cnt,If(book_id=".$book_id.",1,0) as flag
            from user_quizes
            inner join `books` on `user_quizes`.`book_id` = books.id and books.active <> 7 
            where user_quizes.type='2' and user_quizes.status='3' 
            and user_quizes.finished_date between '"
            .Carbon::create(Date("Y")-1, 1, 1,0,0,0)."' and '"
            .Carbon::create(Date("Y")-1, 12, 31,23,59,59)
            ."' group by book_id) as table1
            group by table1.book_cnt
            order by table1.book_cnt desc) as table2";
 
        $rank_books=DB::table(DB::raw($sql))
               ->select('*')
               ->get();
         for($i=0;$i<count($rank_books);$i++){
               if ($rank_books[$i]->flag==1){
                    break;                             
                }
         }
        $rank=$i+1;            
        return $rank;
    }
    public function Registered_book_counter(){
        $books= DB::table('books')
                    ->select('books.*')
                    ->whereBetween('active', [3,6])
                    ->where('updated_at','<', Carbon::create((Date("Y")), 1, 1,0,0,0));
        return $books;
    }
    public function passedmanNum(){
        return $this->hasMany('App\Model\UserQuiz', 'book_id')
                    ->leftJoin('users','user_quizes.user_id','=','users.id')
                    ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7'))
                    ->where('user_quizes.type', '=', 2 )
                    ->where('user_quizes.status','=', 3)
                    ->where('users.gender','=',1)
                    ->groupby('users.gender');
    }
    public function bookname(){
        return $this->hasMany('App\Model\UserQuiz', 'book_id')
                    ->leftJoin('users','user_quizes.user_id','=','users.id')
                    ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7'))
                    ->where('user_quizes.type', '=', 2 )
                    ->where('user_quizes.status','=', 3);
    }
    public function passedwomanNum(){
        return $this->hasMany('App\Model\UserQuiz', 'book_id')
                    ->leftJoin('users','user_quizes.user_id','=','users.id')
                    ->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7'))
                    ->where('user_quizes.type', '=', 2 )
                    ->where('user_quizes.status','=', 3)
                    ->where('users.gender','=',2)
                    ->groupby('users.gender');
    }
    public function Articles(){
        return $this->hasMany('App\Model\Article', 'book_id')
                    ->where("junior_visible", 0);
    }

    public function ArticlesOfBook(){
        return $this->hasMany('App\Model\Article', 'book_id')
                    ->select("articles.content", "articles.register_id","articles.register_visi_type","articles.junior_visible", DB::raw('count(votes.id) as vote_num'))
                    ->leftJoin('votes', 'votes.article_id', '=', 'articles.id')
                    //->leftJoin('users', 'votes.voter_id', '=', 'users.id')
                     ->where("junior_visible", 0)
                     ->groupby("articles.content", "articles.register_id","articles.register_visi_type","articles.junior_visible")
                    ->having(DB::raw('count(votes.id)'), '>', 0)
                    ->orderBy(DB::raw('count(votes.id)'), 'desc') ;
    }
    //

    public function Overseer(){
        return $this->belongsTo('App\User', 'overseer_id');

    }

    public function WishList(){
        return $this->hasMany('App\Model\WishLists', 'book_id');
    }

    public function iswishbook(){
        $WishList = $this->hasMany('App\Model\WishLists', 'book_id')->where('user_id', Auth::id())->get();
        if($WishList->count() > 0) return true;
        else false;
    }

    public function scopeSearchbyId($query,$id){
        return $query->where( function ($query1) use ($id) {
            $query1->where('id', '=', $id);
        });
    }

    public function scopeSearchbyTitle($query,$title, $mode){
    	
        if ($mode == 0){
            $title = $title . '%';
        }elseif ($mode == 1) {
            $title = '%'.$title.'%';
        }elseif ($mode == 2) {
            $title = '%'.$title;
        }
        
        
        return $query->where('books.active', '<>', 7)
            ->where( function ($query1) use ($title) {
                $query1->where('books.title', 'like', $title);        
            })->orWhere(function($query2) use ($title){
                $query2->where('books.title_furi', 'like', $title);
            });
    }
    public function scopeSearchbyWriter($query, $firstname_nick=null, $lastname_nick=null, $mode){
        if ($mode == 0){
            if($firstname_nick != null && $firstname_nick != '')
                $firstname_nick = $firstname_nick . '%';
            if($lastname_nick != null && $lastname_nick != '')
                $lastname_nick = $lastname_nick . '%';
        }elseif ($mode == 1) {
            if($firstname_nick != null && $firstname_nick != '')
                $firstname_nick = '%'.$firstname_nick.'%';
            if($lastname_nick != null && $lastname_nick != '')
                $lastname_nick = '%'.$lastname_nick.'%';
        }elseif ($mode == 2) {
            if($firstname_nick != null && $firstname_nick != '')
                $firstname_nick = '%'.$firstname_nick;
            if($lastname_nick != null && $lastname_nick != '')
                $lastname_nick = '%'.$lastname_nick;
        }
        return $query->where('books.active', '<>', 7)
            ->where( function ($query1) use ($firstname_nick, $lastname_nick) {
                if($firstname_nick != null && $firstname_nick != '')
                    $query1->where('books.firstname_nick', 'like', $firstname_nick);
                if($lastname_nick != null && $lastname_nick != '')
                    $query1->where('books.lastname_nick', 'like', $lastname_nick);        
            })->orWhere(function($query2) use ($firstname_nick, $lastname_nick){
                if($firstname_nick != null && $firstname_nick != '')
                    $query2->where('books.firstname_yomi', 'like', $firstname_nick);
                if($lastname_nick != null && $lastname_nick != '')
                    $query2->where('books.lastname_yomi', 'like', $lastname_nick);
            });
    }
    public function scopeSearchbyKeyword($query,$keyword, $mode){
        if ($mode == 0){
            $keyword = $keyword . '%';
        }elseif ($mode == 1) {
            $keyword = '%'.$keyword.'%';
        }elseif ($mode == 2) {
            $keyword = '%'.$keyword;
        }
        return $query->where('books.active', '<>', 7)
                ->join('articles', 'articles.book_id','=','books.id')
                ->where('articles.content', 'like', $keyword);        
            
    }
    public function scopeSearchbyGene($query, $gene){
        $query = $query->where('books.active', '<>', 7);;
                       //->where('recommend_flag', '<>', '0000-00-00');                       
        if($gene == 0){
            return $query->where('recommend', '<', 3);
        }elseif($gene == 1){
            return $query->where( function ($query1) {
                     $query1->where('recommend', '=', 3)->orWhere('recommend', '=', 4);
                 });
        }elseif($gene == 2){
            return $query->where( function ($query1) {
                     $query1->where('recommend', '=', 5)->orWhere('recommend', '=', 6);
                 });
        }elseif($gene == 3){
            return $query->where('recommend', '>', 6);
        }
    }
    static function SearchbyCategories($categories){
//    	select B.* from book_category  as A left join books as B
//		on(A.book_id = B.id)
//		where A.category_id in (1,3,5) group by B.id
        $books = DB::table('books')
        			->join('book_category', 'book_category.book_id','=','books.id')
        			->select('books.*')
        			->whereIn('book_category.category_id', $categories)
        			->whereBetween('books.active', [3,6])
                    //->leftJoin('user_quizes as a','books.id','=','a.book_id')
                    ->groupby('books.id');       			
    	/*$sql = "(select `books`.*, count(a.id) as passedNums from `book_category` 
                inner join `books` on `book_category`.`book_id` = `books`.`id` 
                left join `user_quizes` as `a` on `book_category`.`book_id` = `a`.`book_id`
                and `a`.`type` = 2 and `a`.`status` = 3
                where `book_category`.`category_id` in (";
        foreach ($categories as $key => $value) {
            $sql .= $value;
            if($key < count($categories)-1)
                $sql .= ",";
        }            
        $sql .= ") and `books`.`active` >= 3  
                group by `books`.`id`) as table1"; 
        $books = DB::table(DB::raw($sql))
                ->select('table1.*'); */ 
        return $books;
    }
    
    public function isAdult(){
    	$categories = $this->categories();
    	foreach($categories as $category){
    		if($category->limit < 20){
    			return false;
    		}
    	}
    	
    	return true;
    }

    public function TopArticle(){
        $articles = $this->hasMany('App\Model\Article', 'book_id')->get();
        $max = 0;
        if(count($articles)){
            $top_article = $articles[0];
            foreach ($articles as $article) {
                $sameArticle=Vote::where('article_id','=',$article->id)->get();
                if($max<count($sameArticle)){
                    $max = count($sameArticle);
                    $top_article = $article;
                }
            }
            return $top_article->content;
        }
        else
            return '';
        
    }
    
	static function MyBooks($current_season, $id = null){
    	// select books.* from user_quizes join books on user_quizes.book_id = books.id where user_quizes.status = 3 and user_quizes.type = 2 group by books.id
    	//return $query->where('register_id', Auth::id())->orderBy('created_at','desc')->take(6);
    	if(!isset($id) || $id == null) {
            $id = Auth::id();
        }
        $books = DB::table('user_quizes')
    				->select('books.*','user_quizes.created_date', 'user_quizes.finished_date', 'user_quizes.is_public', 'user_quizes.point')
    				->join('books', 'user_quizes.book_id', DB::raw('books.id and books.active <> 7'))
    				->where('user_quizes.user_id', $id)
    				->where('user_quizes.type',2)
    				->where('user_quizes.status', 3);
        if($current_season != -1){
    		/*if($current_season['term'] == 0) {
        		$books = $books->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
       		} elseif($current_season['term'] == 1) {
       			$books = $books->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));   			
       		} elseif($current_season['term'] == 2) {
       			$books = $books->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));   			
       		} elseif($current_season['term'] == 3) {
       			$books = $books->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));   			
       		} elseif($current_season['term'] == 4) {
       			$books = $books->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season'])); 
       		}*/
            $books = $books->whereBetween('user_quizes.finished_date',array($current_season['begin_season'], $current_season['end_season']));
        }
    	return $books;
    }
    
    static function scopeSearchbyRanking($query, $rankingId, $gender, $duration){
    	//select books.*, count(user_quizes.user_id) as ranking from user_quizes join books on (user_quizes.book_id = books.id) where user_quizes.status = 3 group by books.id order by ranking desc
    	$books = $query->select('books.*', DB::raw('count(user_quizes.user_id) as ranking'))
    				->join('user_quizes','user_quizes.book_id','=',DB::raw('books.id and user_quizes.type=2 and user_quizes.status=3'))
                    ->where('books.active', '<>', 7)
    				->groupby('books.id')
    				->orderby('ranking', 'desc'); 
        $selRankingId  = false;
        $today = now();
    	// check rankingId
    	switch($rankingId){
    		case "0":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->join('classes', 'users.org_id','=','classes.id')
                                ->where('users.group_type', 0)
    							->whereIn('classes.grade', array(1, 2));
                $selRankingId  = true;
    			break;
    		case "1":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->join('classes', 'users.org_id','=', 'classes.id')
                                ->where('users.group_type', 0)
    							->whereIn('classes.grade', array(3, 4));
                $selRankingId  = true;
    			break;
    		case "2":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->join('classes', 'users.org_id','=','classes.id')
                                ->where('users.group_type', 0)
    							->whereIn('classes.grade', array(5, 6));
                $selRankingId  = true;
    			break;
    		case "3":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->join('classes', 'users.org_id','=', 'classes.id')
    							->join('users as Group', 'classes.group_id','=', 'Group.id')
    							->whereIn('Group.group_type', [1,2]);
                $selRankingId  = true;
    			break;    			
    		case "4":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->join('classes', 'users.org_id','=', 'classes.id')
    							->join('users as Group', 'classes.group_id','=', 'Group.id')
    							->where('Group.group_type', 3);
                $selRankingId  = true;    				
    			break;
    		case "5":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-20), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-10), 3, 31), "Y-m-d")));
                else
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-19), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-9), 3, 31), "Y-m-d")));
                $selRankingId  = true;
                break;
    		case "6":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			if($today <= Carbon::create((Date("Y")), 3, 31,23,59,59))
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-20), 3, 31), "Y-m-d")));
                else
                    $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-29), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-19), 3, 31), "Y-m-d")));
                $selRankingId  = true;
                break;
    		case "7":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			$books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-39), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-30), 12, 31), "Y-m-d")));
                $selRankingId  = true;
                break;    			
    		case "8":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-49), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-40), 12, 31), "Y-m-d")));
                $selRankingId  = true;
                break;    			
    		case "9":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-59), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-50), 12, 31), "Y-m-d")));
                $selRankingId  = true;
                break;    			
    		case "10": 
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-69), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-60), 12, 31), "Y-m-d")));
                $selRankingId  = true;
                break;
    		case "11":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
                $books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-79), 1, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-70), 12, 31), "Y-m-d")));
                $selRankingId  = true;
                break;
    		case "12":
    			$books = $books->join('users','user_quizes.user_id','=','users.id');
    			$books = $books->whereBetween("birthday", array(date_format(Carbon::createFromDate((Date("Y")-89), 4, 1), "Y-m-d"),date_format(Carbon::createFromDate((Date("Y")-80), 12, 31), "Y-m-d")));
                $selRankingId  = true;
                break;
    		case "13":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->where('users.org_id', Auth::user()->org_id)
    							->where('users.role', config('consts')['USER']['ROLE']['PUPIL']);
    			$selRankingId  = true;
                break;
    		case "14":
    			$books = $books->join('users','user_quizes.user_id','=','users.id')
    							->join('classes','users.org_id','=','classes.id')
    							->where('classes.grade', Auth::user()->PupilsClass->grade)
    							->where('users.role', config('consts')['USER']['ROLE']['PUPIL']);
    			$selRankingId  = true;
                break;

        }
        if($selRankingId) {
            //check gender
            if($gender == "1" || $gender == "2")
                $books = $books->where('users.gender', $gender);
                
        }else{
            //check gender
            if($gender == "1" || $gender == "2"){
                // $books = $books->where('users.gender', $gender);
                $books = $books->join('users','user_quizes.user_id','=','users.id')
                        ->where('users.gender', $gender);
            }
        }
        
        //check duration
    	if($duration == "0"){
	    	$m = floor((Date("m") - 1)/ 3);
	    	$m = $m - 1;
	    	if($m >= 0){
	    		$start_date = Carbon::createFromDate(Date("Y"), ($m) * 3 + 1, 1);
	    		$end_date = Carbon::createFromDate(Date("Y"), ($m)*3 + 3, 30);
	    	}else{
	    		$m = $m + 4;
	    		$start_date = Carbon::createFromDate(Date("Y") - 1, ($m) * 3 + 1, 1);
	    		$end_date = Carbon::createFromDate(Date("Y") - 1, ($m)*3 + 3, 30);
	    	}
    		$books = $books->whereBetween('created_date', array($start_date, $end_date));
    	}else if($duration == "1"){
    		$start_date = Carbon::createFromDate(Date("Y") -1, 1, 1);
			$end_date = Carbon::createFromDate(Date("Y") -1,	12,31);
			$books = $books->whereBetween('created_date', array($start_date, $end_date));
    	}    	
    	
    	$books = $books->get();
    	return $books;
    }
}
