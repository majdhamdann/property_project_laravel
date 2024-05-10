<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string("governoraty");
            $table->string("city");
           $table->string("country");
            $table->timestamps();
        });
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("direction");
            $table->string("number");
            $table->string("purpose");
            $table->text("description");
            $table->integer("price");
            $table->string("space");
            $table->unsignedInteger("auth_id");
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('Category_id');
            $table->foreign('Category_id')->references('id')->on('categories');
            $table->boolean('available');
           $table->timestamps();
        });
      
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('path');
            $table->json('images');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
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
        Schema::dropIfExists('cities');
        Schema::dropIfExists('images');
    }
}
