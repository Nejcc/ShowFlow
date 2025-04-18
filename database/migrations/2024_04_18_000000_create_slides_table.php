<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presentation_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('type')->default('text'); // text, html, or component
            $table->integer('page')->nullable(); // page number for component type
            $table->string('background')->default('bg-white');
            $table->string('text_color')->default('text-gray-900');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slides');
    }
};
