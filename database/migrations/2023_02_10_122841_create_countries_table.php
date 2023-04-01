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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->char('iso3', 3)->nullable()->default(null);
            $table->char('numeric_code', 3)->nullable()->default(null);
            $table->char('iso2', 2)->nullable()->default(null);
            $table->string('phonecode')->nullable()->default(null);
            $table->string('capital')->nullable()->default(null);
            $table->string('currency')->nullable()->default(null);
            $table->string('currency_name')->nullable()->default(null);
            $table->string('currency_symbol')->nullable()->default(null);
            $table->string('tld')->nullable()->default(null);
            $table->string('native')->nullable()->default(null);
            $table->string('region')->nullable()->default(null);
            $table->string('subregion')->nullable()->default(null);
            $table->text('timezones')->nullable()->default(null);
            $table->text('translations')->nullable()->default(null);
            $table->decimal('latitude', 10, 8)->nullable()->default(null);
            $table->decimal('longitude', 11, 8)->nullable()->default(null);
            $table->string('emoji', 191)->nullable()->default(null);
            $table->string('emojiU', 191)->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP')
            );
            $table->string('flag', 1)->default("1");
            $table->string('wikiDataId')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
