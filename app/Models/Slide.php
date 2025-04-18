<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'presentation_id',
        'title',
        'content',
        'type',
        'page',
        'background',
        'text_color',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'page' => 'integer',
    ];

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }
}
