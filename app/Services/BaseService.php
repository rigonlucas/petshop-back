<?php

namespace App\Services;

class BaseService
{
    protected function shortNameClass(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}