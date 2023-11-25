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
        Schema::table('exercise_progress_body_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('daily_schedule_id')->nullable()->index();


            $table->foreign('daily_schedule_id')->references('id')->on('daily_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercise_progress_body_parts', function (Blueprint $table) {
            //
        });
    }
};
