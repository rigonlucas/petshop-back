<?php

namespace Core\Modules\Examples\List\Exceptions;

use Core\Generics\Collections\HasDataCollection;
use Core\Generics\Enums\ResponseEnum;
use Core\Generics\UseCases\UseCaseExceptionInterface;
use Core\Generics\UseCases\ValidationException;
use Core\Modules\Examples\List\Enums\ErrorCodeEnum;
use Exception;
use Throwable;

class EntityValidationException extends Exception implements UseCaseExceptionInterface, ValidationException
{
    use HasDataCollection;

    public function __construct(
        Throwable $previous,
        ?string $message = null,
        int $code = 0
    ) {
        if (!$message) {
            $message = ErrorCodeEnum::ENTITY__LIST__VALIDATION_EXCEPTION->value;
        }
        parent::__construct($message, $code, $previous);
    }

    public function getResponseEnum(): string|int
    {
        return ResponseEnum::UNPROCESSABLE_ENTITY->value;
    }

    public function getErrorCodeEnumValue(): string
    {
        return ErrorCodeEnum::ENTITY__LIST__VALIDATION_EXCEPTION->value;
    }

    public function getValidationErrors(): array
    {
        return [
            'senha' => [
                'Senha incorreta..'
            ]
        ];
    }
}