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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('salutation_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('display_name', 100);
            $table->string('email', 100);
            $table->string('company_name', 100)->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('skype')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_business')->default(0); //0 for indiviaual // 1 for business
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('salutation_id')
                ->references('id')->on('salutations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('business_id')
                ->references('id')->on('businesses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
