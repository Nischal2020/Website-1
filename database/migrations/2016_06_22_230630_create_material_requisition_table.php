<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_requisition', function (Blueprint $table) {
            $table->integer('material_id')->unsigned()->index();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->integer('requisition_id')->unsigned()->index();
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('material_requisition');
    }
}
