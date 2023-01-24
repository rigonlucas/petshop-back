<?php

namespace Core\Projeto\Salvar;

use Core\Generics\UseCases\AbstractUseCase;
use Core\Projeto\Salvar\Enums\ErrorCodeEnum;
use Core\Projeto\Salvar\Inputs\SalvarProjetoInput;
use Core\Projeto\Salvar\Rulesets\SalvarProjetoRuleset;
use Exception;
use Psr\Log\LoggerInterface;

class SalvarProjetoUseCase extends AbstractUseCase
{
    private const LOG_NAME = 'SalvarProjeto::AlgumaCoisa';

    public function __construct(
        LoggerInterface $logger,
    ) {
        $this->logger = $logger;
    }

    public function execute(SalvarProjetoInput $input): void
    {
        try {
            $this->logger->info('[' . self::LOG_NAME . '] Init use case.');
            $this->output = (new SalvarProjetoRuleset($input))->apply();
            $this->logger->info('[' . self::LOG_NAME . '] Finish use case.');
        } catch (Exception $exception) {
            $this->handleException(
                $exception,
                '[' . self::LOG_NAME . '] ',
                ErrorCodeEnum::ENTITY__LIST__GENERIC_EXCEPTION->value,
                ErrorCodeEnum::ENTITY__LIST__GENERIC_EXCEPTION
            );
        }
    }
}