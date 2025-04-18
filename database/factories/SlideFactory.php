<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

final class SlideFactory extends Factory
{
    protected $model = Slide::class;

    public function definition()
    {
        $backgrounds = [
            'bg-white',
            'bg-gray-100',
            'bg-blue-50',
            'bg-indigo-50',
            'bg-purple-50',
        ];

        $textColors = [
            'text-gray-900',
            'text-gray-800',
            'text-blue-900',
            'text-indigo-900',
            'text-purple-900',
        ];

        return [
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(3),
            'background' => $this->faker->randomElement($backgrounds),
            'text_color' => $this->faker->randomElement($textColors),
            'order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
