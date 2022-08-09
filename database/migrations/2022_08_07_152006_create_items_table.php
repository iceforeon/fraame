<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable()->unique();
            $table->string('type')->nullable();
            $table->string('title')->index();
            $table->string('slug')->nullable();
            $table->text('overview')->nullable();
            $table->date('release_date')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('genres')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('imdb_rank')->nullable();
            $table->string('imdb_rating')->nullable();
            $table->string('poster_image')->nullable();
            $table->datetime('posted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
