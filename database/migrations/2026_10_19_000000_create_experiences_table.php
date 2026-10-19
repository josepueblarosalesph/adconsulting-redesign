<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('title');
            $table->string('source');
            $table->text('summary');
            $table->string('url', 500)->unique();
            $table->string('image_url', 500)->nullable();
            $table->date('published_at');
            $table->boolean('published')->default(true);
            $table->timestamps();

            $table->index(['published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
