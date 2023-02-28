<?php

namespace App\Enums\Exports;

enum StatusJobEnum: string
{
    case OPEN = 'OPEN';
    case PROCESSING = 'PROCESSING';
    case ERROR = 'ERROR';
    case FINISHED = 'FINISHED';
}
