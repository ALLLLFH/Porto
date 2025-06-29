<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    protected $table = 'social_links';
    protected $fillable = [
        'portfolio_id',
        'platform',
        'url',
    ];

    /**
     * Get the portfolio that owns the social link.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
