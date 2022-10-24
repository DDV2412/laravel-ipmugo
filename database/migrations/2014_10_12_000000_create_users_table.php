<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('saluation')->nullable();
            $table->string('firstname');
            $table->string('midlename')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('orcid')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('publons')->nullable();
            $table->string('linkend_in')->nullable();
            $table->string('interest');
            $table->string('department')->nullable();
            $table->string('address')->nullable();
            $table->mediumText('affiliation');
            $table->longText('bio')->nullable();
            $table->string('country');
            $table->timestamp('last_seen')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('gitHub_id')->nullable();
            $table->string('auth_type')->nullable();
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
        Schema::dropIfExists('users');
    }
}
