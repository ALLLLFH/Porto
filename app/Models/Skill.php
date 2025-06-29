<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = [
        'portfolio_id',
        'skill_name',
        'level',
    ];

    /**
     * Get the portfolio that owns the skill.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
