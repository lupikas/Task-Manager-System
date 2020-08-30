<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewlogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId');
            $table->timestamp('added_on');
            $table->bigInteger('ownerId')->nullable();
            $table->bigInteger('taskId');
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
        Schema::dropIfExists('viewlogs');
    }
}
