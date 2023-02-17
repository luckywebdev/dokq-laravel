<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class TeacherHistory extends Model
{
    protected $table = 'teacher_history';
    protected $fillable = ['id','teacher_id','group_name','grade','class_number','teacher_role','class_id', 'created_at', 'updated_at'];
    public $timestamps = false;

    //get all groups
    public function scopeGetTeacherHistories($query, $teacher_id){
        return $query->where('teacher_id', $teacher_id)
        ->orderBy(DB::raw("year asc, group_name asc, created_at"), 'desc');
    }
}
