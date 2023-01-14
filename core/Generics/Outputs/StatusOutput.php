<?php

namespace Core\Generics\Outputs;

use Core\Generics\Enums\ResponseEnum;

class StatusOutput
{
    private int $code;
    private string $message;

    public function __construct(ResponseEnum $codeEnum, string $message)
    {
        $this->code = $codeEnum->value;
        $this->message = $message;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
