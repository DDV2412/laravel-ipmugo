<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_records', function (Blueprint $table) {
            $table->id();
            $table->integer('repoId')->references('repositories')->on('id');
            $table->string('identifier');
            $table->string('title');
            $table->longText('description');
            $table->string('publisher');
            $table->string('repoTitle');
            $table->string('issue')->nullable();
            $table->string('volume')->nullable();
            $table->string('nomor')->nullable();
            $table->string('pages')->nullable();
            $table->string('date')->nullable();
            $table->string('year')->nullable();
            $table->string('doi')->nullable();
            $table->string('file_PDF', 255)->nullable();
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
        Schema::dropIfExists('article_records');
    }
}
