<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
 * criado com
 * php artisan make:migration create_projects_table --create="projects"
 * na consola no diretório do projecto
 */
class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable(); //Poderá não ter descrição
            $table->dateTime('start_date');
            $table->integer('coordenator_id')->unsigned()->nullable(); //Poderá (temporáriamente) não ter coordenador, caso o actual deixe de o ser
            $table->foreign('coordenator_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->string('logo')->nullable(); //Poderá não ter logo
            $table->string('version_control');
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
        Schema::drop('projects');
    }
}
