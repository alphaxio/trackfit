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
        Schema::create('payments', function (Blueprint $table) {
            //NOTE: they are nullable for now
            $table->id();
            $table->unsignedBigInteger('subscription_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string("transaction_id")->nullable();
            $table->decimal("amount");
            $table->enum("status", ['PENDING', 'PAID', 'FAILED'])->nullable();
            $table->string("payment_method")->nullable();
            $table->string("payment_type")->nullable();
            $table->json("payment_response")->nullable();
            $table->timestamps();

            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
