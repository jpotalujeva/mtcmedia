<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('country', 50)->nullable();
            $table->string('town', 50)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('address', 50)->nullable();
            $table->string('image', 50)->nullable();
            $table->string('thumbnail', 50)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longtitude', 50)->nullable();
            $table->integer('number_of_bedrooms')->nullable();
            $table->integer('number_of_bathrooms')->nullable();
            $table->decimal('price', 11)->nullable()->default(0.00);
            $table->string('property_type', 50)->nullable();
            $table->string('sale_rent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
