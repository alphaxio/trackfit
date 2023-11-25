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
        Schema::table('exercise_progress', function (Blueprint $table) {
            DB::statement("ALTER TABLE `exercise_progress` CHANGE `progress_status` `progress_status` ENUM('MSD','EXD','NEND', 'NDC', 'NDCE', 'ND', 'TD', 'NDCPE', 'ENDC') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
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
