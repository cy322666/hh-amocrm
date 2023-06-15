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
        Schema::table('managers', function (Blueprint $table) {
            $table->integer('account_id')->default(1);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->date('many_request')->nullable();
            $table->integer('app')->nullable();
        });

        Schema::table('responds', function (Blueprint $table) {
            $table->integer('app_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
