<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('email_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('phone', 16)->unique()->nullable();
            $table->string('company')->nullable();
            $table->tinyInteger('prefecture_id')->unsigned()->nullable();
            $table->integer('manager_id')->unsigned();
            $table->integer('limit_login')->unsigned();
            // $table->integer('contract_price')->default(0)->unsigned();
            $table->boolean('is_active')->default(1);
            $table->timestamp('last_logined_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
