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
        Schema::table('schedules', function (Blueprint $table) {
            $table->bigInteger('session_total_count')->change();
            $table->bigInteger('session_current_count')->change();
            $table->bigInteger('number_of_months')->change();
            $table->bigInteger('weight_before')->change();
            $table->bigInteger('target_weight')->change();
            $table->bigInteger('weight_after')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            //
        });
    }
};
