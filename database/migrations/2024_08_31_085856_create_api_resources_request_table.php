<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_resources_request', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('status_code');
            $table->string('response_json');
            $table->string('request_details');
            $table->string('sender_ip_address');
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
        Schema::dropIfExists('api_resources_request');
    }
};
