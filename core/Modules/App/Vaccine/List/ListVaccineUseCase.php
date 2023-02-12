<?php

namespace Core\Modules\App\Vaccine\List;

use Core\Generics\Pagination\PaginationInput;
use Core\Generics\UseCases\AbstractUseCase;
use Core\Modules\App\Vaccine\List\Enums\ErrorCodeEnum;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\Rulesets\ListRuleset;
use Core\Modules\Generics\App\Vaccine\Gateways\VaccineInterface;
use Exception;
use Psr\Log\LoggerInterface;

class ListVaccineUseCase extends AbstractUseCase
{
    private const LOG_NAME = 'Entity/List::AnyThingYouWant';
    private VaccineInterface $vaccineRepository;

    public function __construct(
        LoggerInterface $logger,
        VaccineInterface $vaccineRepository,
    ) {
        $this->vaccineRepository = $vaccineRepository;
        $this->logger = $logger;
    }

    public function execute(
        VaccineInput $input,
        PaginationInput $paginationInput
    ): void {
        try {
            $this->logger->info('[' . self::LOG_NAME . '] Init use case.');
            $this->output = (new ListRuleset(
                $this->vaccineRepository,
                $input,
                $paginationInput,
            ))->apply();
            $this->logger->info('[' . self::LOG_NAME . '] Finish use case.');
        } catch (Exception $exception) {
            $this->handleException(
                $exception,
                '[' . self::LOG_NAME . '] ',
                ErrorCodeEnum::VACCINES__LIST__GENERIC_EXCEPTION->value,
                ErrorCodeEnum::VACCINES__LIST__GENERIC_EXCEPTION
            );
        }
    }
}