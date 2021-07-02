<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsSentToCharge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smss', function (Blueprint $table) {
            //
            $table->boolean('is_sent_to_charge')->default(0)->after('is_sent_to_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smss', function (Blueprint $table) {
            //
            $table->dropColumn('is_sent_to_charge');
        });
    }
}
