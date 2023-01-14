<?php

namespace Core\Modules\Examples\List\Rulesets;

use Core\Generics\Enums\ResponseEnum;
use Core\Generics\Outputs\StatusOutput;
use Core\Generics\Pagination\PaginationInput;
use Core\Modules\Examples\List\Gateways\EntityInterface;
use Core\Modules\Examples\List\Inputs\ConfigInput;
use Core\Modules\Examples\List\Inputs\EntityInput;
use Core\Modules\Examples\List\Outputs\ListEntitiesOutput;
use Core\Modules\Examples\List\Rules\ListRule;

class Ruleset
{
    private EntityInterface $entityRepository;
    private EntityInput $input;
    private PaginationInput $inputpagination;

    public function __construct(
        EntityInterface $entityRepository,
        ConfigInput $configInput,
        EntityInput $input,
        PaginationInput $inputpagination,
    ) {
        $this->entityRepository = $entityRepository;
        $this->input = $input;
        $this->inputpagination = $inputpagination;
    }

    public function apply(): ListEntitiesOutput
    {
        $entitiesPaginated = (new ListRule(
            $this->entityRepository,
            $this->input,
            $this->inputpagination
        ))->apply();
        return new ListEntitiesOutput(
            new StatusOutput(
                ResponseEnum::OK,
                ResponseEnum::OK->getCodeName()
            ),
            $entitiesPaginated
        );
    }
}