<?php

namespace Solvrtech\LogbookClient;

use Dotenv\Dotenv;
use Exception;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LogHandler extends AbstractProcessingHandler
{
    private HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface $httpClient,
        int|string|Level    $level = Level::Debug,
        bool                $bubble = true
    )
    {
        $this->httpClient = $httpClient;

        parent::__construct($level, $bubble);
    }

    /**
     * @inheritDoc
     *
     * @throws Exception|TransportExceptionInterface
     */
    protected function write(LogRecord $record): void
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                "{$this->getUrl()}/log/create",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'token' => $this->getToken()
                    ],
                    'json' => $record->formatted
                ]
            );
        } catch (Exception $e) {
            throw new Exception("Save log was failed");
        }

    }

    /**
     * Get logbook API url from environment.
     *
     * @return string
     */
    private function getUrl(): string
    {
        $this->loadEnvironment()->safeLoad();
        $this->loadEnvironment()->required('LOGBOOK_API_URL');

        return $_ENV['LOGBOOK_API_URL'];
    }

    /**
     * Load environment using safe method.
     *
     * @return Dotenv
     */
    private function loadEnvironment(): Dotenv
    {
        return Dotenv::createImmutable(__DIR__);
    }

    /**
     * Get logbook API token from environment.
     *
     * @return string
     */
    private function getToken(): string
    {
        $this->loadEnvironment()->safeLoad();
        $this->loadEnvironment()->required('LOGBOOK_API_TOKEN');

        return $_ENV['LOGBOOK_API_TOKEN'];
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new JsonFormatter();
    }
}