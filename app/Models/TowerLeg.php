<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TowerLeg extends Model
{
    protected $fillable = [
        'tower_id',
        'leg_name',
        'kitta_no',
        'owner',
        'amount',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the tower that owns the leg.
     */
    public function tower(): BelongsTo
    {
        return $this->belongsTo(Tower::class);
    }
}
