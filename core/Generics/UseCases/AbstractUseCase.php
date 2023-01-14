<?php

namespace Core\Generics\UseCases;

use Core\Generics\Collections\DataCollection;
use Core\Generics\Enums\Interfaces\CodeErrorNameEnum;
use Core\Generics\Enums\ResponseEnum;
use Core\Generics\Outputs\Interfaces\OutputInterface;
use Core\Generics\Outputs\Errors\ErrorOutput;
use Core\Generics\Outputs\StatusOutput;
use Psr\Log\LoggerInterface;

abstract class AbstractUseCase
{
    protected OutputInterface $output;
    protected LoggerInterface $logger;

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    protected function handleException(
        \Throwable $exception,
        string $prefixo,
        string $genericMessage,
        CodeErrorNameEnum $codeErrorNameEnum
    ): void {
        if ($exception instanceof UseCaseExceptionInterface) {
            $this->logError(
                $exception,
                $prefixo,
                $exception->getMessage(),
                $exception->getDataCollection()
            );
            $this->output = new ErrorOutput(
                new StatusOutput(
                    $exception->getResponseEnum(),
                    ResponseEnum::getCodeName($exception->getResponseEnum())
                ),
                $exception->getErrorCodeEnumValue(),
                $codeErrorNameEnum->getErrorCode($codeErrorNameEnum, $exception->getErrorCodeEnumValue()),
                $exception instanceof ValidationException ? $exception->getValidationErrors() : []
            );
            return;
        }

        $this->logError($exception, $prefixo, $genericMessage);
        $this->output = new ErrorOutput(
            new StatusOutput(
                ResponseEnum::INTERNAL_SERVER_ERROR->value,
                ResponseEnum::getCodeName(ResponseEnum::INTERNAL_SERVER_ERROR->value)
            ),
            $genericMessage,
            $codeErrorNameEnum->getErrorCode($codeErrorNameEnum, $genericMessage)
        );
    }

    protected function logError(
        \Throwable $exception,
        string $prefixo,
        string $logMessage,
        ?DataCollection $dataCollection = null
    ): void {
        $this->logger->error(
            $prefixo . $logMessage,
            [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'previous' => [
                    'exception' => $exception->getPrevious() ? get_class($exception->getPrevious()) : null,
                    'message' => !is_null($exception->getPrevious()) ? $exception->getPrevious()->getMessage() : null,
                ],
                'trace' => !app()->runningUnitTests() ? $exception->getTrace() : null,
                'data' => !is_null($dataCollection) ? $dataCollection->all() : null,
            ]
        );

        if (
            config('app.debug')
            && !app()->runningUnitTests()
            && !($exception instanceof ValidationException)
        ) {
            throw $exception;
        }
    }
}
