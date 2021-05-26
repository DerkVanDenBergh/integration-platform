<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('oauth1_consumer_key')->nullable();
            $table->string('oauth1_consumer_secret')->nullable();
            $table->string('oauth1_token')->nullable();
            $table->string('oauth1_token_secret')->nullable();
            $table->boolean('template')->default(false); // TODO check if this is used
            $table->timestamps();

            // Foreign keys
            $table->unsignedBigInteger('connection_id');   
        });

        Schema::table('authentications', function (Blueprint $table) {
            $table->foreign('connection_id')
                  ->references('id')
                  ->on('connections')
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
        Schema::dropIfExists('authentications');
    }
}
