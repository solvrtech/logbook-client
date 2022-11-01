<?php

namespace Solvrtech\LogbookClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Psr\Log\LogLevel;

class LogHandler extends AbstractProcessingHandler
{
    public function __construct(
        int|string|LogLevel $level = LogLevel::DEBUG,
        bool                $bubble = true
    )
    {
        parent::__construct($level, $bubble);
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    protected function write(LogRecord|array $record): void
    {
        $httpClient = new Client(['base_uri' => $this->getUrl()]);
        try {
            $httpClient->request(
                'POST',
                "log/save",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'token' => $this->getToken()
                    ],
                    'json' => $record->formatted
                ]
            );
        } catch (Exception|GuzzleException $e) {
            throw new Exception("Save log was failed");
        }
    }

    /**
     * Get logbook API url from environment.
     *
     * @return string
     *
     * @throws Exception
     */
    private function getUrl(): string
    {
        $url = config('logbook.option.url');

        if (null === $url) {
            throw new Exception("Logbook url not found");
        }

        return $url;
    }

    /**
     * Get logbook API token from environment.
     *
     * @return string
     *
     * @throws Exception
     */
    private function getToken(): string
    {
        $token = config('logbook.option.token');

        if (null === $token) {
            throw new Exception("Logbook token not found");
        }

        return $token;
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new JsonFormatter();
    }
}