<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presentation;
use App\Models\Slide;

class PresentationSeeder extends Seeder
{
    public function run()
    {
        // Create a presentation
        $presentation = Presentation::create([
            'title' => 'Vue.js & Laravel Presentation',
            'description' => 'A modern presentation system built with Vue.js and Laravel',
            'settings' => [
                'theme' => 'default',
                'transition' => 'slide',
                'auto_advance' => false,
                'auto_advance_delay' => 5000
            ]
        ]);

        // Create slides
        $slides = [
            [
                'title' => 'Welcome to Our Presentation',
                'type' => 'component',
                'page' => '1',
                'content' => null,
                'order' => 1,
                'background' => 'bg-gradient-to-r from-blue-500 to-purple-600',
                'text_color' => 'text-white'
            ],
            [
                'title' => 'Technical Overview',
                'type' => 'component',
                'page' => '2',
                'content' => null,
                'order' => 2,
                'background' => 'bg-gradient-to-r from-green-500 to-teal-600',
                'text_color' => 'text-white'
            ],
            [
                'title' => 'Features',
                'type' => 'component',
                'page' => '3',
                'content' => null,
                'order' => 3,
                'background' => 'bg-gradient-to-r from-yellow-500 to-red-600',
                'text_color' => 'text-white'
            ],
            [
                'title' => 'Demo',
                'type' => 'component',
                'page' => '4',
                'content' => null,
                'order' => 4,
                'background' => 'bg-gradient-to-r from-pink-500 to-rose-600',
                'text_color' => 'text-white'
            ],
            [
                'title' => 'Created By',
                'type' => 'component',
                'page' => '5',
                'content' => null,
                'order' => 5,
                'background' => 'bg-gradient-to-r from-indigo-500 to-purple-600',
                'text_color' => 'text-white'
            ]
        ];

        foreach ($slides as $slideData) {
            $slide = new Slide($slideData);
            $presentation->slides()->save($slide);
        }
    }
} 