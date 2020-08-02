<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\IngredientLocation;

class CreateIngredientLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        IngredientLocation::create(['name' => 'Fresh']);
        IngredientLocation::create(['name' => 'Chilled']);
        IngredientLocation::create(['name' => 'Pantry']);
        IngredientLocation::create(['name' => 'Sundry']);
        IngredientLocation::create(['name' => 'Frozen']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_locations');
    }
}
