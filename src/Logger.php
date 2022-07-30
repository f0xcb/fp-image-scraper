<?php declare(strict_types=1);

class Logger
{
    /** @var Logger[] */
    private static array $instance = [];

    const LOG_LEVEL_INFO = 'INFO';
    const LOG_LEVEL_WARN = 'WARN';
    const LOG_LEVEL_ERROR = 'ERROR';

    private string $logPath;
    private $file;

    public static function getInstance(string $file): Logger
    {
        if (!array_key_exists($file, self::$instance)) {
            self::$instance[$file] = new Logger($file);
        }
        return self::$instance[$file];
    }

    private function __construct(string $logPath)
    {
        $this->logPath = $logPath;

        if (!is_writable($this->logPath)) {
            throw new RuntimeException(sprintf('can not write to log file: %s', $this->logPath));
        }

        $fileOpen = fopen($this->logPath, 'a');

        if ($fileOpen === false) {
            throw new RuntimeException(sprintf('can not open log file: %s', $this->logPath));
        }

        $this->file = $fileOpen;
    }

    public function __destruct()
    {
        $fileClose = fclose($this->file);

        if ($fileClose === false) {
            trigger_error(sprintf('can not close log file: %s', $this->logPath));
        }
    }

    public function info(string $message): void
    {
        $this->log($message, self::LOG_LEVEL_INFO);
    }

    public function warn(string $message): void
    {
        $this->log($message, self::LOG_LEVEL_WARN);
    }

    public function error(string $message): void
    {
        $this->log($message, self::LOG_LEVEL_ERROR);
    }

    private function log(string $message, string $logLevel): void
    {
        $content = '[' . $this->getDateTimeFormat() . '] ';
        $content .= sprintf('[%5s] ', $logLevel);
        $content .= $message;
        $content .= PHP_EOL;

        echo $content;
        $this->saveFile($content);
    }

    private function saveFile(string $content): void
    {
        $fileWrite = fwrite($this->file, $content);

        if ($fileWrite === false) {
            throw new RuntimeException(sprintf('can not write to log file: %s (%s)', $this->logPath, $content));
        }
    }

    private function getDateTimeFormat(): string
    {
        $now = new DateTimeImmutable();
        return $now->format(DATE_ATOM);
    }
}