<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create('restaurants', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->unsignedInteger('owner_id');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('owner_id')->references('id')->on('users');
                $table->index('owner_id', 'index_restaurants_owner_id');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
