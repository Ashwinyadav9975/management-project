<?php
namespace App\Logging;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class DatabaseLogger
{
    /**
     * The log level.
     *
     * @var string
     */
    protected $level;

    /**
     * Create a custom logger instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $this->level = $config['level'] ?? 'debug';

        // Create a Monolog logger instance
        $logger = new MonologLogger('database');
        
        // Push the custom database handler onto the logger
        $logger->pushHandler($this->getHandler());

        return $logger;
    }

    /**
     * Get the database handler for storing logs in the database.
     *
     * @return AbstractProcessingHandler
     */
    protected function getHandler()
    {
        // Use an anonymous class to extend AbstractProcessingHandler
        return new class($this->level) extends AbstractProcessingHandler {

            /**
             * Constructor to initialize the handler with the level
             */
            public function __construct($level)
            {
                // Call the parent constructor and set the log level
                parent::__construct($level);
            }

            /**
             * Handle the log record.
             *
             * @param LogRecord $record The log record data
             * @return void
             */
            protected function write(LogRecord $record): void
            {
                // Capture the IP address of the request
                $ipAddress = request()->ip(); // Get the client IP address

                // Capture the hostname of the machine where the log is created
                $hostname = gethostname(); // Get the machine's hostname

                // Format the log message as needed
                $formattedMessage = sprintf(
                    '[%s] %s.%s: %s %s',
                    $record->datetime->format('Y-m-d H:i:s'),           // Format the timestamp
                    strtolower($record->channel),                       // Log channel (e.g., 'local')
                    strtoupper($record->level->getName()),               // Get the string name of the log level (e.g., 'INFO')
                    $record->message,                                   // The log message
                    json_encode($record->context)                       // Optional: Context data
                );

                // Insert the formatted log message into the database
                $logData = [
                    'created_at' => $record->datetime,  // Timestamp when the log was created
                    'level' => strtoupper($record->level->getName()), // The level of the log (INFO, ERROR, etc.)
                    'message' => $formattedMessage,     // The formatted log message
                    'context' => json_encode($record->context),  // Optional: Context data
                    'ip_address' => $ipAddress,         // Store the IP address
                    'hostname' => $hostname,            // Store the hostname
                ];

                // Store the log in the 'logs' table
                DB::table('logs')->insert($logData);
            }
        };
    }
}
