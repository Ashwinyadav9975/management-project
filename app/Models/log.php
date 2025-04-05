<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Define the table name explicitly (optional, as it defaults to plural of the model name)
    protected $table = 'logs';

    // Allow mass assignment on these columns
    protected $fillable = [
        'level',    // Log level (INFO, ERROR, etc.)
        'message',  // Log message
        'context',  // Additional context data (could be a JSON string)
    ];

    // Optional: You can cast the 'context' field to an array if you need to work with it as an array
    protected $casts = [
        'context' => 'array',  // Cast context to an array automatically
    ];
}
