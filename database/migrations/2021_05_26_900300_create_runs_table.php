<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('input');
            $table->text('output');
            $table->string('status');
            $table->timestamps();

            // Foreign keys

            $table->unsignedBigInteger('processable_id');
        });

        Schema::table('runs', function (Blueprint $table) {
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
        Schema::dropIfExists('runs');
    }
}
