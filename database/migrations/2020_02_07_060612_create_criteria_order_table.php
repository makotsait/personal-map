<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriaOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_order', function (Blueprint $table) {
            $table->increments('criteria_order_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('place_type_id');
            $table->unsignedInteger('criterion_id');
            $table->unsignedInteger('display_order');
            $table->timestamps();
            $table->unsignedInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criteria_order');
    }
}
