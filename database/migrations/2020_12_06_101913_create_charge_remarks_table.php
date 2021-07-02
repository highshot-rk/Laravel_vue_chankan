<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargeRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false);
            $table->unsignedInteger('charge_id')->nullable(false);
            $table->date('work_on')->nullable(false);
            $table->unsignedTinyInteger('time_type')->nullable(false);
            $table->text('remarks')->nullable(true);
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
        Schema::dropIfExists('charge_remarks');
    }
}
