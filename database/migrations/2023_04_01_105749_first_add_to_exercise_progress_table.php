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
        Schema::table('exercise_progress', function (Blueprint $table) {
            $table->timestamp('date')->nullable();
            $table->unsignedBigInteger('exercise_day_id')->nullable()->index();
            $table->string('exercise_day')->nullable();
            $table->enum('progress_status', ['MSD', 'EXD', 'NEND', 'ND', 'TD', 'NDCPE', 'NDC', 'PENDC', 'ENDC', 'NDCE'])->nullable();

            $table->foreign('exercise_day_id')->references('id')->on('exercise_days')->onDelete('cascade');


            //NEND = NO EXERCISE, NO DIET.
            //NDC = NO DIET CONTROL
            //MSD = MISSED
            //EXD = EXERCISED
            //ND = NORMAL DAY
            //TD = TODAY
            //'NDCPE' = NO DIET CONTROL + PERSONAL EXERCISE


            //ND = NORMAL DAY
            //TD = TODAY
            //EXD = EXERCISED
            //MSD = MISSED
            //NDC = NO DIET CONTROL
            //NEND = NO EXERCISE, NO DIET CONTROL.
            //ENDC = EXERCISED, NO DIET CONTROL,
            //PENDC = PERSONAL EXERCISE + NO DIET CONTROL


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercise_progress', function (Blueprint $table) {
            //
        });
    }
};
