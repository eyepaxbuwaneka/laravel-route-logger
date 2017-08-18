<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrnRouteLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn_route_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->mediumText('url');
            $table->string('method');
            $table->string('user_agent');
            $table->mediumText('query_values');
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
        Schema::drop('trn_route_log');
    }
}
