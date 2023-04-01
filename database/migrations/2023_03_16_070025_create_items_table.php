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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('account_type_id');
            $table->string('name', 100);
            $table->double('selling_price');
            $table->text('description')->nullable();
            $table->boolean('is_service')->default(0)->comment("0 goods,1 service");

            $table->foreign('business_id')
                ->references('id')->on('businesses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('unit_id')
                ->references('id')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tax_id')
                ->references('id')->on('taxes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('account_type_id')->references('id')->on('account_types')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
