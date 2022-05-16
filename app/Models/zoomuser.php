<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class zoomuser extends Model
{
    
    protected $table = 'zoomusers';
    protected $fillable = [
        'institute_id',
        'institute_Name',
        'institute_email'
    ];
}
