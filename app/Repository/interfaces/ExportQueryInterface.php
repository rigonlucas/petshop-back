<?php

namespace App\Repository\interfaces;

use Illuminate\Database\Query\Builder;

interface ExportQueryInterface
{
    public function getQuery(): Builder;
}