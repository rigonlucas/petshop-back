<?php

namespace App\Actions;

class BaseAction
{
    protected function shortNameClass(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}