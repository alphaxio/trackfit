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
        Schema::create('exercise_progress_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercise_progress_id')->nullable()->index();
            $table->string('image_url')->nullable();
            $table->timestamps();


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
        Schema::dropIfExists('exercise_progress_images');
    }
};
