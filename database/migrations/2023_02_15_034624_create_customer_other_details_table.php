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
        Schema::create('customer_other_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->string('opening_balance', 100)->nullable();
            $table->string('payment_term', 100)->nullable();
            $table->boolean('enable_portal')->default(0);
            $table->string('facebook_link', 100)->nullable();
            $table->string('twitter_link', 100)->nullable();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_other_details');
    }
};
