<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\JsonResponse;
use Log;

final class PresentationController extends Controller
{
    public function index(): JsonResponse
    {
        $slides = Slide::orderBy('order')->get();

        // Debug the data
        Log::info('Slides data:', $slides->toArray());

        return response()->json([
            'slides' => $slides,
            'currentSlide' => 0,
            'totalSlides' => $slides->count(),
        ]);
    }
}
