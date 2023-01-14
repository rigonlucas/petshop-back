<?php

namespace Core\Generics\Outputs\Interfaces;

use Core\Generics\Outputs\StatusOutput;

interface OutputInterface
{
    public function getStatus(): StatusOutput;
}
