<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrlChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_checks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id');
            $table->integer('status_code')->nullable();
            $table->text('h1')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at');
            $table->foreign('url_id')->references('id')->on('urls')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('url_checks');
    }
}
