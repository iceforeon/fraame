<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spreadsheets', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->string('hashid')->nullable()->unique();
            $table->string('filename');
            $table->string('type')->default('movie');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spreadsheets');
    }
};
