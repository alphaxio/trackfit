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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('exercise_type_id')->index();
            $table->enum('exercise_type',['PT','PE'])->nullable();
            $table->enum('gender',['MALE','FEMALE'])->nullable();
            $table->string('location_name');
            $table->integer('session_total_count')->nullable();
            $table->integer('session_current_count')->nullable();
            $table->integer('number_of_months')->nullable();
            $table->string('trainers_name')->nullable();
            $table->integer('weight_before');
            $table->integer('target_weight')->nullable();
            $table->integer('weight_after')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('amount_per_session')->nullable();
            $table->bigInteger('amount_per_month')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exercise_type_id')->references('id')->on('exercise_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
