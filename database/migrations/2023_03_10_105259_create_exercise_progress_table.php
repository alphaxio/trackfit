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
        Schema::create('exercise_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_schedule_id')->nullable()->index();
            $table->unsignedBigInteger('schedule_id')->nullable()->index();
            $table->enum('exercise_status', ['MISS', 'PASS'])->nullable();
            $table->enum('diet_control_status', ['MISS', 'PASS'])->nullable();
            $table->bigInteger('exercise_time_span')->nullable();
            $table->enum('exercise_time_span_unit', ['SEC', 'MIN', 'HOUR'])->nullable();
            $table->integer('weight_loss')->nullable();
            $table->longText('note')->nullable();

            $table->timestamps();


            $table->foreign('daily_schedule_id')->references('id')->on('daily_schedules')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_progress');
    }
};
