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
            $table->unsignedBigInteger('muscle_group_id')->nullable()->index();

            $table->foreign('muscle_group_id')->references('id')->on('muscle_groups')->onDelete('cascade');
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
