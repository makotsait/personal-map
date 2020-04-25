<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceUserPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_user_preferences', function (Blueprint $table) {
            $table->increments('place_user_preference_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('place_id');
            $table->unsignedInteger('place_type_id');
            $table->timestamps();
            $table->unsignedInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_user_preferences');
    }
}
