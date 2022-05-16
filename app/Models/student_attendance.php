<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_attendance extends Model
{
    protected $table = 'student_attendances';
    protected $fillable = [
        'meeting_id',
        'topic',
        'name',
        'join_time',
        'leave_time'
    ];
}
