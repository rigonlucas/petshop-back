<?php

namespace Core\Modules\Examples\List\Inputs;

class EntityInput
{
    private ?string $email;

    public function __construct(?string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}