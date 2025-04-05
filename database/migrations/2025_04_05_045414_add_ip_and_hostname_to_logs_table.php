<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpAndHostnameToLogsTable extends Migration
{
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('context'); // IP address (IPv4 or IPv6)
            $table->string('hostname')->nullable()->after('ip_address'); // Hostname of the machine
        });
    }

    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'hostname']);
        });
    }
}
