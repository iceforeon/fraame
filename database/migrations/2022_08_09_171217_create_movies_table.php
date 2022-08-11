<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->string('hashid')->nullable()->unique();
            $table->string('title')->index();
            $table->string('slug')->nullable();
            $table->text('overview')->nullable();
            $table->date('release_date')->nullable();
            $table->string('genres')->nullable();
            $table->string('tmdb_id')->nullable()->unique();
            $table->string('tmdb_poster_path')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('imdb_id')->nullable()->unique();
            $table->string('imdb_rating')->nullable();
            $table->datetime('featured_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
