<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'topic_id',
        'question',
        'a',
        'b',
        'c',
        'd',
        'answer',
        'code_snippet',
        'answer_exp',
        'question_img',
        'question_video_link',
        'testType',
        'questions_no'

    ];
    public function answers()
    {
        return $this->hasOne('App\Models\Answer');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }
}
