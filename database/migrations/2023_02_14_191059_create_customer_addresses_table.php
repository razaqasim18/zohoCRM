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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('attention', 100)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('fax', 100)->nullable();
            $table->boolean('is_shipping'); // 0 for biiling 1 for shipping address
            $table->foreign('customer_id')
                ->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('country_id')
                ->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
};
