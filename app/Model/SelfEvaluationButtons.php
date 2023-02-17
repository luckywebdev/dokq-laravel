<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SelfEvaluationButtons extends Model
{
    protected $table = 'self_evaluation_buttons';
    protected $fillable = ['id', 'self_button_show', 'self_evaluation_sheet','other_self_button_show' ,'other_self_evaluation_sheet'];
}
