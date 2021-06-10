<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order');
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('processable_id');
            $table->unsignedBigInteger('step_function_id');
        });

        Schema::table('steps', function (Blueprint $table) { 
            $table->foreign('processable_id')
                  ->references('id')
                  ->on('processables')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('step_function_id')
                  ->references('id')
                  ->on('step_functions')
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
        Schema::dropIfExists('steps');
    }
}
