<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapping_fields', function (Blueprint $table) {
            $table->id();
            $table->string('input_field_type');
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('input_field'); // TODO make a difference between step and model fields
            $table->unsignedBigInteger('output_field');
            $table->unsignedBigInteger('mapping_id');
            
        });

        Schema::table('mapping_fields', function (Blueprint $table) { 
            $table->foreign('output_field')
                  ->references('id')
                  ->on('data_model_fields')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('mapping_id')
                  ->references('id')
                  ->on('mappings')
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
        Schema::dropIfExists('mapping_fields');
    }
}
