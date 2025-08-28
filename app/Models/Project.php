<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'project_id',
        'location',
        'voltage',
        'status',
    ];
}
