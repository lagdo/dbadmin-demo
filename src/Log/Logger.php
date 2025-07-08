<?php

namespace Lagdo\DbAdmin\Demo\Log;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @param string $logFileName Log file path
     * @param string $logFileExt  Log file extension
     * @param int    $maxFileSize Log rotation size
     *
     * @return void
     */
    public function __construct(private string $logFileName,
        private string $logFileExt = '.log', private int $maxFileSize = 10 * 1024 * 1024)
    {}

    /**
     * Add the context values into the message.
     *
     * @param string $message               The message.
     * @param array<string, mixed> $context The context array.
     *
     * @return string
     */
    private function addContext(string $message, array $context): string
    {
        return $message . "\n" . json_encode($context, JSON_PRETTY_PRINT);
    }

    /**
     * @return string[]
     */
    private function getLogLevels(): array
    {
        return [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::NOTICE,
            LogLevel::INFO,
            LogLevel::DEBUG,
        ];
    }

    /**
     * Register error and exception handlers.
     *
     * @return void
     */
    public function registerHandlers(): void
    {
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * Handle PHP errors and log them.
     *
     * @param int    $errno   The level of the error raised.
     * @param string $errstr  The error message.
     * @param string $errfile The filename that the error was raised in.
     * @param int    $errline The line number the error was raised at.
     *
     * @return bool Always returns false to allow PHP's default error handler.
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        $errorMessage = "PHP Error [Level $errno]: $errstr in $errfile on line $errline";
        $this->write($errorMessage, 'ERROR');
        return false;
    }

    /**
     * Handle uncaught exceptions and log them.
     *
     * @param \Throwable $exception The uncaught exception.
     *
     * @return void
     */
    public function exceptionHandler(\Throwable $exception): void
    {
        $errorMessage = sprintf(
            "Uncaught Exception: %s in %s on line %d",
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
        $this->write($errorMessage, 'ERROR');
    }

    /**
     * Rotate the log file if it exceeds the maximum size.
     *
     * @return void
     */
    private function rotateLogFile(): void
    {
        $fileName = "{$this->logFileName}.{$this->logFileExt}";
        if (file_exists($fileName) && filesize($fileName) > $this->maxFileSize) {
            rename($fileName, $this->logFileName . '.' . time() . '.' . $this->logFileExt);
        }
    }

    /**
     * Write a message to the log file.
     *
     * @param string|\Stringable $message  $message The message to log.
     * @param string $level   The log level.
     *
     * @return void
     */
    private function write(string|\Stringable $message, string $level = 'INFO'): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$level] $message" . PHP_EOL;
        $fileName = "{$this->logFileName}{$this->logFileExt}";

        file_put_contents($fileName, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * @inheritDoc
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!in_array($level, $this->getLogLevels(), true)) {
            throw new InvalidArgumentException("Invalid log level: $level");
        }

        $message = $this->addContext($message, $context);
        $this->write($message, strtoupper($level));
    }

    /**
     * @inheritDoc
     */
    public function debug(string|\Stringable $message, array $context = []): void
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $traceInfo = array_map(
            function ($trace) {
                $file = $trace['file'] ?? '[internal function]';
                $line = $trace['line'] ?? '?';
                $function = $trace['function'];
                $class = $trace['class'] ?? '';
                return "$file:$line - {$class}{$function}()";
            },
            $backtrace
        );

        $message = $this->addContext($message, $context);
        $message .= "\nTrace:\n" . implode("\n", $traceInfo);
        $this->write($message, 'DEBUG');
    }
}
