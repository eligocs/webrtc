<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{

    protected $table = 'meetings';

    protected $fillable = [
        'topic_name',
        'date',
        'duration',
        'schedule',
        'password',
        'join_url',
        'id',
        'host_id',
        'host_email',

    ];
}
