<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class CreateIngredientMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_meal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('meal_id');
            $table->integer('ingredient_id');
            $table->float('amount');
            $table->string('preciseAmount');
            $table->integer('order');
            $table->timestamps();
        });

        DB::table('ingredient_meal')->insert(['id' => 1, 'ingredient_id' => 1, 'meal_id' => 1, 'amount' => 0.5, 'preciseAmount' => '100g', 'order' => 0]);
        DB::table('ingredient_meal')->insert(['id' => 2, 'ingredient_id' => 2, 'meal_id' => 1, 'amount' => 2, 'preciseAmount' => '1 Tsp', 'order' => 1]);
        DB::table('ingredient_meal')->insert(['id' => 3, 'ingredient_id' => 3, 'meal_id' => 1, 'amount' => 1.5, 'preciseAmount' => 'x2', 'order' => 2]);

        DB::table('ingredient_meal')->insert(['id' => 4, 'ingredient_id' => 1, 'meal_id' => 2, 'amount' => 1, 'preciseAmount' => '100g', 'order' => 0]);
        DB::table('ingredient_meal')->insert(['id' => 5, 'ingredient_id' => 2, 'meal_id' => 2, 'amount' => 1, 'preciseAmount' => '1/2 Pack', 'order' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_meal');
    }
}
