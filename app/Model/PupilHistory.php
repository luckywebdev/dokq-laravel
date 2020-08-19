<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class PupilHistory extends Model
{
    protected $table = 'pupil_history';
    protected $fillable = ['id','pupil_id','group_name','grade','class_number','teacher_name','class','class_id', 'created_at', 'updated_at'];
    public $timestamps = false;

    //get all groups
    public function scopeGetPupilHistories($query, $pupil_id){
        return $query->where('pupil_id', $pupil_id)->orderBy("created_at", "desc")->get();
    }
}
