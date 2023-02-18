<?php

namespace App\Enums\Exports;

enum StatusJobEnum: string
{
    case OPEN = 'OPEN';
    case PROCESSING = 'PROCESSING';
    case FINISHED = 'FINISHED';
}
