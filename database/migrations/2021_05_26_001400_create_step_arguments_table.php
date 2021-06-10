<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepArgumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_arguments', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('parameter_id');
            $table->unsignedBigInteger('step_id');
        });

        Schema::table('step_arguments', function (Blueprint $table) { 
            $table->foreign('parameter_id')
                  ->references('id')
                  ->on('step_function_parameters')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('step_id')
                  ->references('id')
                  ->on('steps')
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
        Schema::dropIfExists('step_arguments');
    }
}
