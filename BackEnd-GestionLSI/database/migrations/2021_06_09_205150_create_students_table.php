<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('cne')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('semestre_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('semestre_id')->references('id')->on('semestres');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
