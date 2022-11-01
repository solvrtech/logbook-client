<?php

namespace Solvrtech\LogbookClient;

use Monolog\Logger as Monolog;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;
use Stringable;

class Logbook implements LoggerInterface
{
    protected const CHANNEL = "default-channel";

    private LogHandler $logHandler;

    /**
     * The logging channel
     *
     * @var string|null
     */
    private ?string $name = null;

    public function __construct(LogHandler $logHandler)
    {
        $this->logHandler = $logHandler;
    }

    /**
     * Set logger channel
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->driver()->emergency($message, $context);
    }

    /**
     * Create an instance of any handler available in Monolog.
     *
     * @return Monolog
     */
    private function driver(): Monolog
    {
        $logger = new Monolog($this->getName());
        $logger->pushHandler($this->logHandler);
        $logger->pushProcessor(new PsrLogMessageProcessor());

        return $logger;
    }

    /**
     * Return current logger channel.
     *
     * @return string
     */
    private function getName(): string
    {
        if (null === $this->name) {
            return self::CHANNEL;
        }

        return $this->name;
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->driver()->alert($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     *
     */
    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->driver()->critical($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function error(Stringable|string $message, array $context = []): void
    {
        $this->driver()->error($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->driver()->warning($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->driver()->notice($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function info(Stringable|string $message, array $context = []): void
    {
        $this->driver()->info($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->driver()->debug($message, $context);
    }

    /**
     * @inheritDoc
     *
     * @param $level
     * @param Stringable|string $message
     *
     * @param array $context
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        $this->driver()->log($message, $context);
    }
}