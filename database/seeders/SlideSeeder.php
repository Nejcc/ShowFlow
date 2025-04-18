<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

final class SlideSeeder extends Seeder
{
    public function run()
    {
        // Clear existing slides
        Slide::truncate();

        // Create specific slides in order
        $slides = [
            [
                'title' => 'Welcome to Our Presentation',
                'type' => 'component',
                'page' => 1,
                'background' => 'bg-gradient-to-r from-blue-500 to-purple-600',
                'text_color' => 'text-white',
                'order' => 0,
            ],
            [
                'title' => 'Key Features',
                'type' => 'component',
                'page' => 2,
                'background' => 'bg-gradient-to-r from-indigo-500 to-purple-600',
                'text_color' => 'text-white',
                'order' => 1,
            ],
            [
                'title' => 'Our Services',
                'type' => 'component',
                'page' => 3,
                'background' => 'bg-gradient-to-r from-green-500 to-blue-600',
                'text_color' => 'text-white',
                'order' => 2,
            ],
            [
                'title' => 'Project Timeline',
                'type' => 'component',
                'page' => 4,
                'background' => 'bg-gradient-to-r from-purple-500 to-pink-600',
                'text_color' => 'text-white',
                'order' => 3,
            ],
        ];

        foreach ($slides as $slide) {
            Slide::create($slide);
        }
    }
}
