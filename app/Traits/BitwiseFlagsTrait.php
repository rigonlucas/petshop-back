<?php

namespace App\Traits;

trait BitwiseFlagsTrait
{
    public function isFlagActive(int $flag, string $attr = 'flags'): bool
    {
        return (($this->$attr & $flag) == $flag);
    }

    public function addFlag(int $flag, string $attr = 'flags'): void
    {
        $this->$attr |= $flag;
    }

    public function delFlag(int $flag, string $attr = 'flags'): void
    {
        $this->$attr &= ~$flag;
    }
}