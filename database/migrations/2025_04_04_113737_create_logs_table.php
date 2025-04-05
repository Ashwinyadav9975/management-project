<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('log_time')->default(DB::raw('CURRENT_TIMESTAMP')); // Add this line
            $table->string('level')->index();  // Log level (e.g., INFO, ERROR)
            $table->text('message');  // The log message
            $table->text('context')->nullable();  // Additional context/data (e.g., user data, request details)
            $table->timestamps();  // Store the created timestamp
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}

