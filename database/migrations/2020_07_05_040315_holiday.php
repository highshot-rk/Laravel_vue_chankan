<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Holiday extends Migration {
    public function up() {
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->string('description');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::drop('holidays');
    }
}