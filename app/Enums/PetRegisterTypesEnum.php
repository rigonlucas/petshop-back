<?php

namespace App\Enums;

enum PetRegisterTypesEnum: int
{
    case HEALTH = 1;
    case BEHAVIOR = 2;
    case OBSERVATION = 3;
}