<?php

namespace Core\Modules\App\Vaccine\List\Exceptions;

use Core\Generics\Collections\HasDataCollection;
use Core\Generics\Enums\ResponseEnum;
use Core\Generics\UseCases\UseCaseExceptionInterface;
use Core\Modules\App\Vaccine\List\Enums\ErrorCodeEnum;
use Exception;
use Throwable;

class VaccineListDatabaseException extends Exception implements UseCaseExceptionInterface
{
    use HasDataCollection;

    public function __construct(
        Throwable $previous,
        ?string $message = null,
        int $code = 0
    ) {
        $message = $message ?? ErrorCodeEnum::VACCINES__LIST__DATA_BASE_EXCEPTION->value;
        parent::__construct($message, $code, $previous);
    }

    public function getResponseEnum(): string|int
    {
        return ResponseEnum::INTERNAL_SERVER_ERROR->value;
    }

    public function getErrorCodeEnumValue(): string
    {
        return ErrorCodeEnum::VACCINES__LIST__DATA_BASE_EXCEPTION->value;
    }
}