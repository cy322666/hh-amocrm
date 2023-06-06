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
        Schema::table('responds', function (Blueprint $table) {
            $table->integer('contact_id')->nullable();
            $table->integer('lead_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responds', function (Blueprint $table) {
            $table->dropColumn('contact_id');
            $table->dropColumn('lead_id');
        });
    }
};
