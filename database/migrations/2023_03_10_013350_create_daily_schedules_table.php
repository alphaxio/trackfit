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
        Schema::create('daily_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id')->index();
            $table->enum('day',['SUNDAY','MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY']);
            $table->enum('month',['JANUARY','FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'])->nullable();
            $table->enum('status', ['REGULAR', 'IRREGULAR'])->nullable();
            $table->enum('type', ['PT', 'PE'])->nullable();
            $table->integer('week');
            $table->integer('year')->nullable();
            $table->timestamp('date');
            $table->timestamps();

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
        Schema::dropIfExists('daily_schedules');
    }
};
