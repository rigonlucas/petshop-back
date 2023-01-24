<?php

namespace Core\Projeto\Salvar\Exceptions;

use Core\Generics\Collections\HasDataCollection;
use Core\Generics\Enums\ResponseEnum;
use Core\Generics\UseCases\UseCaseExceptionInterface;
use Core\Generics\UseCases\ValidationException;
use Core\Projeto\Salvar\Enums\ErrorCodeEnum;
use Exception;
use Throwable;

class EditalNaoEncontradoException  extends Exception implements UseCaseExceptionInterface, ValidationException
{
  use HasDataCollection;

  public function __construct(
      Throwable $previous,
      ?string $message = null,
      int $code = 0
  ) {
      if (!$message) {
          $message = ErrorCodeEnum::XXXXXXXXXXXXXXXXXX->value;
      }
      parent::__construct($message, $code, $previous);
  }

  public function getResponseEnum(): string|int
  {
      return ResponseEnum::UNPROCESSABLE_ENTITY->value;
  }

  public function getErrorCodeEnumValue(): string
  {
      return ErrorCodeEnum::XXXXXXXXXXXXXXXXXX->value;
  }

  public function getValidationErrors(): array
  {
      return [
          'algum_erro' => [
              'mensagem..'
          ]
      ];
  }
}