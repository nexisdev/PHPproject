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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('discord')->nullable();
            $table->string('twitter')->nullable();
            $table->string('telegram_group')->nullable();
            $table->string('telegram_channel')->nullable();
            $table->string('facebook')->nullable();
            $table->string('reddit')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('medium')->nullable();
            $table->string('slack')->nullable();
            $table->string('github')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('white_paper')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
