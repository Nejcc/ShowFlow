<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
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
}
