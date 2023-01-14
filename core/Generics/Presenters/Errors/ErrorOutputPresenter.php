<?php

namespace Core\Generics\Presenters\Errors;

use Core\Generics\Outputs\Errors\ErrorOutput;

class ErrorOutputPresenter
{
    private array $presenter;
    private ErrorOutput $errorOutput;

    public function __construct(ErrorOutput $errorOutput)
    {
        $this->errorOutput = $errorOutput;
    }

    public function present(): self
    {
        $errors = [];
        if ($this->errorOutput->getErrors() !== []) {
            $errors = [
                'errors' => $this->errorOutput->getErrors()
            ];
        }
        $this->presenter = [
            'status' => [
                'code' => $this->errorOutput->getStatus()->getCode(),
                'message' => $this->errorOutput->getStatus()->getMessage(),
                'error_code' => $this->errorOutput->getErrorCode()
            ],
            'error' => $this->errorOutput->getMessage(),
        ];
        $this->presenter = array_merge($this->presenter, $errors);
        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}
