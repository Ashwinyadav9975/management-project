<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function storeLog(Request $request)
    {
        // Example log data
        $logData = [
            'level' => 'info', // Log level (e.g., info, error)
            'message' => 'This is a custom log message.',
            'context' => json_encode($request->all()), // Encode the request data as JSON for additional context
        ];

        // Insert the log data into the logs table
        DB::table('logs')->insert($logData);

        return response()->json(['status' => 'Log stored successfully!']);
    }
}
