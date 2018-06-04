<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cafe_branch_id');
            $table->unsignedInteger('x');
            $table->unsignedInteger('y');
            $table->string('name', 5);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();

            $table->foreign('cafe_branch_id')->references('id')->on('cafe_branches')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floor_plans');
    }
}
