<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Organizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('Organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('URLLogo');
            $table->string('URLorg');
            $table->boolean('intradepartment');
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
        Schema::drop('Organizations');
    }
}
