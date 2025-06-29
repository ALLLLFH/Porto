<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $table = 'educations';
    protected $fillable = [
        'portfolio_id',
        'institution',
        'degree',
        'start_year',
        'end_year',
        'description',
    ];

    /**
     * Get the portfolio that owns the education.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
