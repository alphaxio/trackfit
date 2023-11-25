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
        Schema::create('faq_queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_topic_id')->nullable()->index();
            $table->string('question')->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();



            $table->foreign('faq_topic_id')->references('id')->on('faq_topics')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_queries');
    }
};
