<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('cafe_branch_id');
            $table->unsignedInteger('loaded_by')->nullable();
            $table->unsignedInteger('pc_reservation_id')->nullable();
            $table->double('debit')->default(0);
            $table->double('credit')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('client_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cafe_branch_id')->references('id')->on('cafe_branches')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('loaded_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pc_reservation_id')->references('id')->on('pc_reservations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_logs');
    }
}
