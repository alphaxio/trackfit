<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE `exercise_progress` CHANGE `progress_status` `progress_status` ENUM('MSD','EXD','NEND', 'NDC', 'NDCE', 'ND', 'TD', 'NDCPE', 'ENDC') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        Schema::table('exercise_progress', function (Blueprint $table) {
            $table->string('type')->nullable();
            // $table->enum('progress_status', ['MSD', 'EXD', 'NEND', 'ND', 'TD', 'NDCPE', 'NDC'])->nullable();

        });

        //EXD = EXERCISED
        //MSD = MISSED
        //NEND = NO EXERCISE, NO DIET.
        //NDC = NO DIET CONTROL
        //NDCE = NO DIET CONTROL, EXERCISED
        //ND = NORMAL DAY
        //TD = TODAY
        //'NDCPE' = NO DIET CONTROL + PERSONAL EXERCISE
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
