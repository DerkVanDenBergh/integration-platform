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
            $table->integer('connection_id');
            $table->boolean('template')->default(false);
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
        Schema::dropIfExists('authentications');
    }
}
