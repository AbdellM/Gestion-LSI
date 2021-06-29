<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prof_id')->nullable();
            $table->unsignedBigInteger('module_id');  
        
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('prof_id')->references('id')->on('profs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prof_modules');
    }
}
