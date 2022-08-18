<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->string('hashid')->nullable()->unique();
            $table->string('title')->index();
            $table->string('slug')->nullable();
            $table->text('overview')->nullable();
            $table->date('first_air_date')->nullable();
            $table->string('genres')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->string('tmdb_poster_path')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('imdb_rating')->nullable();
            $table->datetime('featured_at')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tv_shows');
    }
};
