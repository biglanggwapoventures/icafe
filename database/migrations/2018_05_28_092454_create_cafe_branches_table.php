<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCafeBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafe_branches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cafe_id');
            $table->text('address');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('contact_number')->nullable();
            $table->timestamps();
            $table->foreign('cafe_id')->references('id')->on('cafes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cafe_branches');
    }
}
