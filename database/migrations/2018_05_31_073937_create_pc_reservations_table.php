<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePCReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pc_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('floor_plan_id');
            $table->unsignedInteger('user_id');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->float('duration_in_hours');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('floor_plan_id')->references('id')->on('floor_plans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pc_reservations');
    }
}
