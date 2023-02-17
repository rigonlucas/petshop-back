<?php

namespace App\Enums\Exports;

use Illuminate\Support\Str;

enum StorageExportEnum: string
{
    /**
     * Return path to store files
     *
     * @param string $accountId
     * @param StorageExportEnum $enum
     * @param $extension
     * @return string
     */
    public function pathFileGenerator(string $accountId, StorageExportEnum $enum, $extension): string
    {
        $fileName = $enum->value . Str::random(4) . '-' . now()->format('d-m-Y') . '.' . $extension;
        $accountValuesSearch = [
            ':ACCOUNT_ID:'
        ];
        $accountValuesReplace = [
            $accountId
        ];

        return str_replace($accountValuesSearch, $accountValuesReplace, $this->value) . $fileName;
    }

    public function getFileName(): string
    {
        return $this->value . Str::random(4) . '-' . now()->format('d-m-Y');
    }

    public function getPath(string $accountId): string
    {
        $accountValuesSearch = [
            ':ACCOUNT_ID:'
        ];
        $accountValuesReplace = [
            $accountId
        ];

        return str_replace($accountValuesSearch, $accountValuesReplace, $this->value);
    }

    case PRIVATE_DISK = 'private';


    /**
     * Files names
     */
    case PRODUCTS_FILE_NAME_BASE = 'produtos_';
    case SCHEDULES_FILE_NAME_BASE = 'schedules_';
    case COMPACT_FILE_NAME_BASE = 'compact_';


    /**
     * Path
     */
    case PRODUCTS_PATH = 'accounts/:ACCOUNT_ID:/products/';
    case SCHEDULES_PATH = 'accounts/:ACCOUNT_ID:/schedules/';
    case COMPACT_FILE_PATH = 'accounts/:ACCOUNT_ID:/zips/';
}
