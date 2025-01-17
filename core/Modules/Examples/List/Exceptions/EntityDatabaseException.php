<?php

namespace Core\Modules\Examples\List\Exceptions;

use Core\Generics\Collections\HasDataCollection;
use Core\Generics\Enums\ResponseEnum;
use Core\Generics\UseCases\UseCaseExceptionInterface;
use Core\Modules\Examples\List\Enums\ErrorCodeEnum;
use Exception;
use Throwable;

class EntityDatabaseException extends Exception implements UseCaseExceptionInterface
{
    use HasDataCollection;

    public function __construct(
        Throwable $previous,
        ?string $message = null,
        int $code = 0
    ) {
        if (!$message) {
            $message = ErrorCodeEnum::ENTITY__LIST__GENERIC_EXCEPTION->value;
        }
        parent::__construct($message, $code, $previous);
    }

    public function getResponseEnum(): string|int
    {
        return ResponseEnum::INTERNAL_SERVER_ERROR->value;
    }

    public function getErrorCodeEnumValue(): string
    {
        return ErrorCodeEnum::ENTITY__LIST__GENERIC_EXCEPTION->value;
    }
}