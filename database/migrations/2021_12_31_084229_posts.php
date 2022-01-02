<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Posts',function(Blueprint $table){
            $table->bigIncrements('Id');
            $table->string('Title');
            $table->string('Description');
            $table->string('Category');
            $table->string('Status')->default('no');
            $table->string('Author');
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
        //
        Schema::dropIfExists('Posts');
    }
}
