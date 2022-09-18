<?php

namespace App\Services\Application\Exports\Schedules;

use App\Enums\Exports\StorageExportEnum;
use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\User;
use App\Notifications\Schedules\ExportScheduleNotify;
use App\Repository\Application\Exports\Schedules\SchedulesByStatusRepository;
use App\Repository\interfaces\ExportQueryInterface;
use App\Services\Application\Exports\ExportationManager\CreateManagerFilesService;
use App\Services\BaseService;
use App\Services\Interfaces\Export\ExportInterface;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class SchedulesStatusExportService extends BaseService implements ExportInterface
{
    private array $header_args = [
        'id do agendamento',
        'client_id',
        'client_name',
        'client_phone',
        'pet_id',
        'pet_name',
        'user_id',
        'user_name',
        'type',
        'status',
        'start_at',
        'duration',
        'finish_at'
    ];

    public function export(User $user, SchedulesStatusEnum $enumStatus): void
    {
        $schedulesQuery = new SchedulesByStatusRepository($user, $enumStatus);
        $output = $this->setHeaders();
        $output = $this->createFile($schedulesQuery, $output);
        $filePath = $this->getFileGenerator($user, $output);
        if ($filePath) {
            Notification::route('mail', $user->email)->notify(new ExportScheduleNotify($user, $filePath));
            CreateManagerFilesService::create(
                $user,
                $this->shortNameClass(),
                $filePath
            );
        }
    }

    public function setHeaders(): mixed
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=csv_export.csv');

        $output = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+');

        if (ob_get_contents()) ob_end_clean();

        fputcsv($output, $this->header_args);

        return $output;
    }

    public function createFile(ExportQueryInterface $exportQuery, mixed $output): mixed
    {
        foreach ($exportQuery->getQuery()->cursor() as $schedule) {
            $dados = [
                'id do agendamento' => $schedule->id,
                'client_id' => $schedule->client_id,
                'client_name' => $schedule->client_name,
                'client_phone' => $schedule->client_phone,
                'pet_id' => $schedule->pet_id,
                'pet_name' => $schedule->pet_name,
                'user_id' => $schedule->user_id,
                'user_name' => $schedule->user_name,
                'type' => SchedulesTypesEnum::from($schedule->type)->name,
                'status' => SchedulesStatusEnum::from($schedule->status)->name,
                'start_at' => $schedule->start_at,
                'duration' => $schedule->duration,
                'finish_at' => $schedule->finish_at,
            ];
            fputcsv($output, $dados);
        }
        return $output;
    }

    public function getFileGenerator(User $user, mixed $output): string
    {
        $path = StorageExportEnum::SCHEDULES_PATH->pathFileGenerator(
            $user->account->uuid,
            StorageExportEnum::SCHEDULES_FILE_NAME_BASE,
            'csv'
        );
        Storage::disk('public')->put(
            $path,
            $output
        );

        return $path;
    }
}