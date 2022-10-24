<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaveArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('article_id')->references('article_records')->on('id');
            $table->integer('user_id')->references('users')->on('id');
            $table->ipAddress('address');
            $table->string('countryName')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_articles');
    }
}
