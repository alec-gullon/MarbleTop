<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\ItemLocation;

class CreateItemLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        ItemLocation::create(['name' => 'Fresh']);
        ItemLocation::create(['name' => 'Chilled']);
        ItemLocation::create(['name' => 'Pantry']);
        ItemLocation::create(['name' => 'Sundry']);
        ItemLocation::create(['name' => 'Frozen']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_locations');
    }
}
