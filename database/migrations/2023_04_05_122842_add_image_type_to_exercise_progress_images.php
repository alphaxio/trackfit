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
        Schema::table('exercise_progress_images', function (Blueprint $table) {
            $table->enum('image_type',['LUNCH','DINNER', 'BREAKFAST', 'BODY', 'OTHER'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercise_progress_images', function (Blueprint $table) {
            //
        });
    }
};
