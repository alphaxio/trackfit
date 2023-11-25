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
    public function up(): void
    {
        Schema::table('daily_schedules', function (Blueprint $table) {
            $table->index(["schedule_id", "date"], "idx_schedule-id_date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_schedules', function (Blueprint $table) {
            $table->dropIndex("idx_schedule-id_date");
        });
    }
};
