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
        DB::statement("ALTER TABLE `dynamic_contents` CHANGE `type` `type` ENUM('FAQ', 'TERMS', 'POLICY', 'CONTACT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        // Schema::table('dynamic_contents', function (Blueprint $table) {
        //     //
        // });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dynamic_contents', function (Blueprint $table) {
            //
        });
    }
};
