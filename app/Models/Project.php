<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the towers for the project.
     */
    public function towers(): HasMany
    {
        return $this->hasMany(Tower::class);
    }
}
