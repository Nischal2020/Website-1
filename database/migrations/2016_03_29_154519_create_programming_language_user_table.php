<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingLanguageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //Created new table programming_language_user for the many to many relation (partnership)
    public function up()
    {
        Schema::create('programming_language_user', function (Blueprint $table) {
            $table->integer('programming_language_id')->unsigned()->index();
            $table->foreign('programming_language_id')->references('id')->on('programming_languages')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('programming_language_user');
    }
}
