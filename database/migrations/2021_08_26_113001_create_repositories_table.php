<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->string('repoTitle');
            $table->longText('repoDescription')->nullable();
            $table->string('baseURL')->unique();
            $table->string('repoThumnail')->nullable();
            $table->string('abbreviation')->nullable();
            $table->string('adminEmail')->nullable();
            $table->string('printISSN')->nullable();
            $table->string('onlineISSN')->nullable();
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
        Schema::dropIfExists('repositories');
    }
}
