<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location_id');
            $table->integer('user_id');
            $table->timestamps();
        });

        App\Models\Ingredient::create(['name' => 'Beans', 'location_id' => 3, 'user_id' => 1]);
        App\Models\Ingredient::create(['name' => 'Cheese', 'location_id' => 2, 'user_id' => 1]);
        App\Models\Ingredient::create(['name' => 'Bread', 'location_id' => 3, 'user_id' => 1]);

        App\Models\Ingredient::create(['name' => 'Bread', 'location_id' => 3, 'user_id' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
