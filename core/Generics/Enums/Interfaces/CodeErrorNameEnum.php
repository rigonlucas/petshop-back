<?php

namespace Core\Generics\Enums\Interfaces;

interface CodeErrorNameEnum
{
    public function getErrorCode(): string;

    public function getCodeNameByValue(string|int $value): string;
}