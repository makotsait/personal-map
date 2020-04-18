<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('place_id');
            $table->text('google_place_id');
            $table->text('place_name');
            $table->text('formatted_address')->nullable();
            $table->double('latitude', 12, 7);
            $table->double('longitude', 12, 7);
            $table->unsignedInteger('default_place_type_id');
            $table->text('default_header_img_url')->nullable();
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
        Schema::dropIfExists('places');
    }
}
