<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tower extends Model
{
    protected $fillable = [
        'project_id',
        'tower_name',
        'tower_type',
        'address',
        'latitude',
        'longitude',
        'foundation_progress',
        'tower_erection_progress',
        'stringing_progress',
        'problems',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'foundation_progress' => 'integer',
        'tower_erection_progress' => 'integer',
        'stringing_progress' => 'integer',
    ];

    /**
     * Get the project that owns the tower.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the legs for the tower.
     */
    public function legs(): HasMany
    {
        return $this->hasMany(TowerLeg::class);
    }

    /**
     * Get the overall progress percentage.
     */
    public function getOverallProgressAttribute(): int
    {
        return (int) round(($this->foundation_progress + $this->tower_erection_progress + $this->stringing_progress) / 3);
    }

    /**
     * Check if tower has any issues.
     */
    public function hasIssues(): bool
    {
        return !empty($this->problems);
    }
}
