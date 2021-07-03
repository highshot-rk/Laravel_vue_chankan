<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAboutLoginChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            // $table->string('email')->after('name');
            $table->string('password')->nullable()->after('name');
            $table->rememberToken();
            $table->integer('edit_type')->default(0)->after('password');
            $table->timestamp('last_logined_at')->nullable()->after('edit_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
