<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mappings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('input_model')->nullable();
            $table->unsignedBigInteger('input_endpoint')->nullable();
            $table->unsignedBigInteger('output_endpoint')->nullable();
            $table->unsignedBigInteger('processable_id');
        });

        Schema::table('mappings', function (Blueprint $table) {
            $table->foreign('input_model')
                  ->references('id')
                  ->on('data_models')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
            
            $table->foreign('input_endpoint')
                  ->references('id')
                  ->on('endpoints')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreign('output_endpoint')
                  ->references('id')
                  ->on('endpoints')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->foreign('processable_id')
                  ->references('id')
                  ->on('processables')
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
        Schema::dropIfExists('mappings');
    }
}
