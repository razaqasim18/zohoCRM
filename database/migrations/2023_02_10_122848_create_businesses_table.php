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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            $table->string('business');
            $table->string('city')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('zipcode')->nullable();
            $table->boolean('is_vat')->default(0);
            $table->string('tax_registration_number_label')->nullable()->default(null);
            $table->string('tax_registration_number_trn')->nullable()->default(null);
            $table->date('tax_registration_number_date')->nullable()->default(null);
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('country_id')
                ->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state_id')
                ->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
