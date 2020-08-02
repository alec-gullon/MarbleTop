<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_ingredient', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_id');
            $table->integer('ingredient_id');
            $table->float('amount');
            $table->timestamps();
        });

        DB::table('group_ingredient')->insert(['id' => 1, 'ingredient_id' => 1, 'group_id' => 1, 'amount' => 0.5]);
        DB::table('group_ingredient')->insert(['id' => 2, 'ingredient_id' => 2, 'group_id' => 1, 'amount' => 2]);
        DB::table('group_ingredient')->insert(['id' => 3, 'ingredient_id' => 3, 'group_id' => 1, 'amount' => 1.5]);

        DB::table('group_ingredient')->insert(['id' => 4, 'ingredient_id' => 1, 'group_id' => 2, 'amount' => 1]);
        DB::table('group_ingredient')->insert(['id' => 5, 'ingredient_id' => 2, 'group_id' => 2, 'amount' => 1.5]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_ingredient');
    }
}
