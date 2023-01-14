<?php

namespace Core\Generics\Enums\Interfaces;

interface CodeNameEnum
{
    public function getCodeName(): string;

    public function getCodeNameByValue(string|int $value): string;
}