<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('recipe');
            $table->integer('user_id');
            $table->timestamps();
        });

        App\Models\Meal::create(['name' => 'Breakfast', 'user_id' => 1, 'recipe' => 'My recipe here!']);
        App\Models\Meal::create(['name' => 'Burgers with Chips', 'user_id' => 1, 'recipe' => 'My recipe here!']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
}
