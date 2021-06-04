<?php

namespace PhpYourAdmin\Core\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class FileLogger
{
    /**
     * @var Logger $logger
     */
    public Logger $logger;

    /**
     *Create a Monolog\Logger instance
     */
    public function __construct()
    {
        $logger = new Logger('phpyouradmin');
        $logger->pushHandler(new StreamHandler(getenv('PROJECT_LOG_FILE'), Logger::WARNING));
        $this->logger = $logger;
    }

    /**
     * Saves a alert message in the log file
     * 
     * @param string $message
     * @param array $context
     */
    public function alert(string $message, array $context = [])
    {
        $this->logger->alert($message, $context);
    }

    /**
     * Saves a error message in the log file
     * 
     * @param string $message
     * @param array $context
     */
    public function error(string $message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    /**
     * Saves a warrning message in the log file
     * 
     * @param string $message
     * @param array $context
     */
    public function warning(string $message, array $context = [])
    {
        $this->logger->warning($message, $context);
    }

    /**
     * Saves a notice message in the log file
     * 
     * @param string $message
     * @param array $context
     */
    public function notice(string $message, array $context = [])
    {
        $this->logger->notice($message, $context);
    }

    /**
     * Saves a info message in the log file
     * 
     * @param string $message
     * @param array $context
     */
    public function info(string $message, array $context = [])
    {
        $this->logger->info($message, $context);
    }
}
