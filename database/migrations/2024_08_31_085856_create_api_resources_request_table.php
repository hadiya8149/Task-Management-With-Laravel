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
            $table->string('controller_action');
            $table->string('middleware');
            $table->string('path');
            $table->string('status');
            $table->string('duration');
            $table->string('ip_address');
            $table->text('request_headers');
            $table->text('response_headers');
            $table->text('response_json');
            $table->string('memory_usage');
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
