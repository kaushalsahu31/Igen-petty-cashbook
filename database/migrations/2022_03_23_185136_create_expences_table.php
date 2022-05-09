<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expences', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('user_name');
            $table->unsignedBigInteger('user_id');
            $table->string('expense_name');
            $table->unsignedBigInteger('expense_amount');
            $table->string('img_name');
            $table->string('img_path');
            $table->string('reject_comment')->default("");
            $table->string('status')->default("Pending");
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
        Schema::dropIfExists('expences');
    }
}
