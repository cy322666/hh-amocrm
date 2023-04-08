<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('body');
            $table->integer('status');
            $table->string('webhook_id')->nullable();
            $table->string('resume_id')->nullable();
            $table->string('vacancy_id')->nullable();
            $table->string('vacancy_name')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('area')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responds');
    }
};
