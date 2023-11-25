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
        Schema::create('exercise_progress_body_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('body_part_id')->nullable()->index();
            $table->unsignedBigInteger('exercise_progress_id')->nullable()->index();

            $table->timestamps();


            $table->foreign('body_part_id')->references('id')->on('body_parts')->onDelete('cascade');
            $table->foreign('exercise_progress_id')->references('id')->on('exercise_progress')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_progress_body_parts');
    }
};
