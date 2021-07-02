<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('label')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('project_orderer_id')->unsigned();
            // $table->foreign('project_orderer_id')->references('id')->on('project_orderers');
            $table->string('name');
            $table->string('charge_id');
            $table->date('work_on')->nullable();
            $table->string('zip', 8)->nullable();
            $table->string('address');
            $table->string('tel', 16)->nullable();
            $table->tinyInteger('project_type')->unsigned();
            $table->tinyInteger('time_type')->unsigned();
            $table->tinyInteger('road')->unsigned();
            $table->text('remark')->nullable();;
            $table->timestamp('last_messaged_at')->nullable();
            $table->boolean('is_notified')->default(0);
            $table->timestamp('notified_at')->nullable();
            $table->boolean('is_surveyed')->default(0);
            $table->timestamp('surveyed_at')->nullable();
            $table->boolean('is_started')->default(0);
            $table->string('scheduled_arrival_time_from', 5)->nullable();
            $table->string('scheduled_arrival_time_to', 5)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->boolean('is_finished')->default(0);
            $table->timestamp('finished_at')->nullable();
            $table->string('finish_img')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_send_to_user')->default(0);
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
        Schema::dropIfExists('projects');
    }
}





