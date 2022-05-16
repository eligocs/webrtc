<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  protected $fillable = [
    'institute_assigned_class_subject_id', 'type', 'title', 'per_q_mark', 'description', 'timer', 'show_ans', 'amount','publish_date', 'unit', 'testType'
  ];

  public function question()
  {
    return $this->hasOne('App\Models\Question');
  }

  public function questions()
  {
    return $this->hasMany('App\Models\Question');
  }

  public function answer()
  {
    return $this->hasOne('App\Models\Answer');
  }

  public function answers()
  {
    return $this->hasMany('App\Models\Answer');
  }

  public function user()
  {
    return $this->belongsToMany('App\Models\User', 'topic_user')
      ->withPivot('amount', 'transaction_id', 'status')
      ->withTimestamps();
  }
}
