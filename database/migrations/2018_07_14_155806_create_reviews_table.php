<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function() {
            Schema::create('reviews', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('restaurant_id');
                $table->unsignedSmallInteger('rating');
                $table->text('comment');
                $table->text('reply');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('restaurant_id')->references('id')->on('restaurants');
                $table->foreign('user_id')->references('id')->on('users');
                $table->index('restaurant_id', 'index_reviews_restaurant_id');
                $table->index('user_id', 'index_reviews_user_id');
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
        Schema::dropIfExists('reviews');
    }
}
