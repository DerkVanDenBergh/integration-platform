<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataModelFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_model_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id');
            $table->integer('parent_id')->nullable();
            $table->string('name');
            $table->string('node_type');
            $table->string('data_type')->nullable();
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
        Schema::dropIfExists('data_model_fields');
    }
}
