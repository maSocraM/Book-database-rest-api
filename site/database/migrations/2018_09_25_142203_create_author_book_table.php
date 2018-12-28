<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_book', function (Blueprint $table) {
            
            $table->integer('book_id')->unsigned()->nullable();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->integer('author_id')->unsigned()->nullable();
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
;        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_author');
    }
}