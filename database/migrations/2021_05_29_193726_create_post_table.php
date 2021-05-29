<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //https://laravel.com/docs/8.x/migrations#creating-tables
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('data');
            $table->timestamps();
            $table->foreignId('category_id')->constrained('category');
            //https://laravel.com/docs/8.x/migrations#foreign-key-constraints
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
