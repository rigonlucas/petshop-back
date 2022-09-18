<?php

namespace App\Services\Application\Exports\ExportationManager;

use App\Models\Exports\ExportManager;
use App\Models\User;
use App\Services\BaseService;

class CreateManagerFilesService extends BaseService
{
    public static function create(User $user, string $modelType, string $path): void
    {
        $exportManagerModel = new ExportManager();
        $exportManagerModel->account_id = $user->account_id;
        $exportManagerModel->model_type = $modelType;
        $exportManagerModel->path = $path;
        $exportManagerModel->save();
    }
}