<?php

namespace App\Services\Interfaces\Export;

use App\Models\User;
use App\Repository\interfaces\ExportQueryInterface;

interface ExportInterface
{
    public function setHeaders(): mixed;

    public function createFile(ExportQueryInterface $exportQuery, mixed $output): mixed;

    public function getFileGenerator(User $user, mixed $output): array;
}