<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramminglanguageProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programminglanguage_project', function (Blueprint $table) {
            $table->integer('programminglanguage_id')->unsigned()->index();
            $table->foreign('programminglanguage_id')->references('id')->on('programminglanguages')->onDelete('cascade');
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('programminglanguage_project');
    }
}
