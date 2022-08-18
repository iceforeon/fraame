<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->string('hashid')->nullable()->unique();
            $table->string('name')->index();
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('facebook_id')->nullable()->unique();
            $table->string('role')->nullable();
            $table->boolean('status')->default(true);
            $table->text('description')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
