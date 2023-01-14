<?php

namespace Core\Generics\UseCases;

interface ValidationException
{
    public function getValidationErrors(): array;
}