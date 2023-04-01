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
        Schema::create('customer_contact_person', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('salutation_id')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100);
            $table->string('contact_phone', 100)->nullable();
            $table->string('contact_mobile', 100)->nullable();
            $table->string('skype', 100)->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('department', 100)->nullable();

            $table->foreign('customer_id')
                ->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('salutation_id')
                ->references('id')->on('salutations')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_contact_people');
    }
};
