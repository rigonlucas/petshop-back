<?php

namespace Core\Generics\UseCases;

use Core\Generics\Collections\DataCollection;
use Core\Generics\Enums\Interfaces\CodeErrorNameEnum;
use Core\Generics\Enums\ResponseEnum;

interface UseCaseExceptionInterface extends \Throwable
{
    public function getResponseEnum(): string|int;

    public function getErrorCodeEnumValue(): string;

    public function getDataCollection(): ?DataCollection;

    public function setDataCollection(?DataCollection $dataCollection): self;
}
