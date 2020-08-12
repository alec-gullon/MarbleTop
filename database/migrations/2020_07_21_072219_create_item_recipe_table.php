<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class CreateItemRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_recipe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('item_id');
            $table->float('amount');
            $table->string('precise_amount');
            $table->integer('order');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_recipe');
    }
}
