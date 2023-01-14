<?php

namespace Core\Dependencies\Testing;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class LoggerFake extends AbstractLogger implements LoggerInterface
{

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        // TODO: Implement log() method.
    }
}
