<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Auth;
use View;
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
use DB;

class MessageController extends Controller
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

    public function create(Request $request) {
//        if($request->input('id') !== null && $request->input('id') != "") {
//            return $this->update($request);
//        }
        $to_ids = preg_split('/,/', $request->input('to_id'));
        foreach ($to_ids as $key => $to_id) {
            $message = new Messages();
            $message->type = $request->input('type');
            $message->from_id = $request->input('from_id');
            $message->to_id = $to_id;
            $message->content = $request->input('content');
            $message->save();
        }

        if(Auth::user()->isGroup() || Auth::user()->isSchoolMember()){
                        
            $orgworkHistory = new OrgworkHistory();
            if(Auth::user()->isSchoolMember()){
                $orgworkHistory->user_id = Auth::user()->id;
                $orgworkHistory->username = Auth::user()->username;
                $orgworkHistory->group_id = Auth::user()->org_id;
                if(!Auth::user()->isLibrarian())
                    $orgworkHistory->group_name = User::find(Auth::user()->org_id)->username; 
            }
            if(Auth::user()->isGroup()){
                $orgworkHistory->user_id = Auth::user()->id;
                $orgworkHistory->username = Auth::user()->id;
                $orgworkHistory->group_id = Auth::user()->id;
                $orgworkHistory->group_name = Auth::user()->username;
            }
                                                       
            $orgworkHistory->item = 4;
            $orgworkHistory->work_test = 0;
            $orgworkHistory->class = '全教員';
            $orgworkHistory->content = $request->input('content');
            $orgworkHistory->save();
        }
    	return Redirect::back();
    }
    public function delete(Request $request){
        if($request->input('chbItem') !== null && $request->input('chbItem') != "") {
            Messages::destroy($request->input('chbItem'));
//            Messages::destroy($request->input('id'));
        }
    	return Redirect::back();
    }
    public function update(Request $request){
    	$message = Messages::find($request->input('id'));
    	$message->content = $request->input('content');
    	$message->save();
        return Redirect::back();
    }
    public function messageAPI(Request $request){
        $id=$request->input('id');
        $messages = Messages::where(DB::raw("concat(',',to_id, ',')"),'like','%,'.$id.',%');

        // $users = DB::table('user_quizes')->select(DB::raw ('sum(user_quizes.point) as sumpoint'))
        //     ->where('user_id',"=", $id)
        //     ->where(function ($query){
        //         $query->where('type', 0)
        //             ->where('status', 1);
        //     })
        //     ->orWhere(function ($query){
        //         $query->where('type', 1)
        //             ->where('status', 1);
        //     })
        //     ->orWhere(function ($query){
        //         $query->where('type', 2);
        //     })->groupby('user_id');//->first();
        // return $users->get();
        $users = DB::table('user_quizes')->where("user_id","=", $id);
        $users = $users->select(DB::raw ('sum(user_quizes.point) as sumpoint'));
        $return = array($messages->get(), $users->get());
        return $return;
    }

}
