<?php

namespace Solvrtech\LogbookClient;

use Psr\Log\LoggerInterface;

interface LogbookInterface extends LoggerInterface
{
    /**
     * Set logger channel
     *
     * @param  string  $channel
     * @return self
     */
    public function channel(string $channel): self;
}
