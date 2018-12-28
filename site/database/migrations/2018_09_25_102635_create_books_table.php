<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('publisher_id');
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->date('publish_date')->nullable();
            $table->integer('isbn');
            $table->unsignedBigInteger('isbn_thirteen');
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('highlight')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('books');
    }
}
