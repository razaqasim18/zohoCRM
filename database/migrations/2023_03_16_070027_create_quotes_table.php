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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('sales_person_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('tax_id')->nullable();

            $table->string('quote_number', 100);
            $table->string('reference_number', 100)->nullable();
            $table->date('quote_date');
            $table->date('expiry_date')->nullable();
            $table->text('subject')->nullable();
            $table->text('note')->nullable();
            $table->text('terms_condition')->nullable();
            $table->text('image')->nullable();
            $table->double('sub_total')->default(0);
            $table->double('discount')->default(0);
            $table->boolean('discount_is_percentage')->default(0)->comment("0 for amount , 1 for percentage");
            $table->double('shipping_charges')->default(0);
            $table->string('adjustment_name')->nullable();
            $table->double('adjustment_value')->default(0);
            $table->double('total_amount')->default(0);
            $table->timestamps();

            $table->foreign('business_id')
                ->references('id')->on('businesses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sales_person_id')
                ->references('id')->on('sales_people')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('customer_id')
                ->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tax_id')
                ->references('id')->on('taxes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
