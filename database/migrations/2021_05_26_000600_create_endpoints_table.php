<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('endpoint');
            $table->string('protocol');
            $table->string('method');
            $table->integer('port')->nullable();
            $table->boolean('template')->default(false); // TODO check if this is used
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('connection_id');    
            $table->unsignedBigInteger('authentication_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();  
        });

        Schema::table('endpoints', function (Blueprint $table) {
            $table->foreign('connection_id')
                  ->references('id')
                  ->on('connections')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('authentication_id')
                  ->references('id')
                  ->on('authentications')
                  ->onUpdate('cascade');

            $table->foreign('model_id')
                  ->references('id')
                  ->on('data_models')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endpoints');
    }
}
