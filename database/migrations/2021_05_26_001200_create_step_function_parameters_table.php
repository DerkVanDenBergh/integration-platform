<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepFunctionParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_function_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('parameter_name');
            $table->string('data_type');
            $table->boolean('is_nullable')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('step_function_id');
        });

        Schema::table('step_function_parameters', function (Blueprint $table) { 
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
        Schema::dropIfExists('step_function_parameters');
    }
}
