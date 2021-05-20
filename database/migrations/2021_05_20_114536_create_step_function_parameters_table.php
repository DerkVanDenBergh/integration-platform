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
            $table->integer('step_function_id');
            $table->boolean('is_nullable')->default(false);
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
        Schema::dropIfExists('step_function_parameters');
    }
}
