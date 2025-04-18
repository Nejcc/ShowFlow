<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class)->orderBy('order');
    }
} 