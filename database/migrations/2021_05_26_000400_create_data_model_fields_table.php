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
            $table->string('name');
            $table->string('node_type');
            $table->string('data_type')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('model_id');    
            $table->unsignedBigInteger('parent_id')->nullable();    
        });

        Schema::table('data_model_fields', function (Blueprint $table) {
            $table->foreign('model_id')
                  ->references('id')
                  ->on('data_models')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('data_model_fields')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
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
