<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_analysis_log', function(Blueprint $table){
            $table->increments('id');
            $table->char('image_path',255);
            $table->char('success',255);
            $table->char('message',255);
            $table->integer('class');
            $table->decimal('confidence');
            $table->timestamp('request_timestamp');
            $table->timestamp('response_timestamp');
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
        Schema::dropIfExists('ai_analysis_log');
    }
};
