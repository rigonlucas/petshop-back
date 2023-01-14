<?php

namespace Core\Modules\Examples\List;

use Core\Generics\Pagination\PaginationInput;
use Core\Generics\UseCases\AbstractUseCase;
use Core\Modules\Examples\List\Enums\ErrorCodeEnum;
use Core\Modules\Examples\List\Gateways\EntityInterface;
use Core\Modules\Examples\List\Inputs\ConfigInput;
use Core\Modules\Examples\List\Inputs\EntityInput;
use Core\Modules\Examples\List\Rulesets\Ruleset;
use Exception;
use Psr\Log\LoggerInterface;

class ListUseCase extends AbstractUseCase
{
    private const LOG_NAME = 'Entity/List::AnyThingYouWant';
    private EntityInterface $entityRepository;

    public function __construct(
        LoggerInterface $logger,
        EntityInterface $entityRepository,
    ) {
        $this->entityRepository = $entityRepository;
        $this->logger = $logger;
    }

    public function execute(
        EntityInput $input,
        ConfigInput $configInput,
        PaginationInput $paginationInput
    ): void {
        try {
            $this->logger->info('[' . self::LOG_NAME . '] Init use case.');
            $this->output = (new Ruleset(
                $this->entityRepository,
                $configInput,
                $input,
                $paginationInput,
            ))->apply();
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