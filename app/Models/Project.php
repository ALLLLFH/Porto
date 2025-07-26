<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'portfolio_id',
        'title',
        'description',
        'technologies',
        'image',
        'project_link',
    ];
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
