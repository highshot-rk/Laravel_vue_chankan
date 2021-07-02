<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectOrderersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_orderers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->string('company');
            $table->string('company_kana')->nullable();
            $table->string('zip', 8)->nullable();
            $table->string('address')->nullable();
            $table->string('president')->nullable();
            $table->string('president_kana')->nullable();
            $table->string('tel', 16)->nullable();
            $table->string('fax', 16)->nullable();
            $table->string('phone', 16)->nullable();
            $table->string('email')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_orderers');
    }
}
