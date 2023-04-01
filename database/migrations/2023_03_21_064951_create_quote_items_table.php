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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->mediumInteger('quantity');
            $table->double('rate');
            $table->double('amount');
            $table->foreign('quote_id')
                ->references('id')->on('quotes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tax_id')
                ->references('id')->on('taxes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('item_id')
                ->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_items');
    }
};
