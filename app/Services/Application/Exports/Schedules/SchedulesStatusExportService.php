<?php

namespace App\Services\Application\Exports\Schedules;

use App\Enums\Exports\StorageExportEnum;
use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\User;
use App\Notifications\Schedules\ExportScheduleNotify;
use App\Services\ExportBaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SchedulesStatusExportService extends ExportBaseService
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
        $schedules = DB::table('schedules')
            ->select([
                'schedules.id',
                'schedules.account_id',
                'schedules.client_id',
                'schedules.user_id',
                'schedules.pet_id',
                'schedules.type',
                'schedules.status',
                'schedules.start_at',
                'schedules.duration',
                'schedules.finish_at',
                'pets.name as pet_name',
                'clients.name as client_name',
                'clients.phone as client_phone',
                'users.name as user_name',
            ])
            ->addSelect(DB::raw('count(schedules_has_products.id) as products_schedule_count'))
            ->leftJoin(
                'schedules_has_products',
                'schedules.id',
                '=',
                'schedules_has_products.schedule_id'
            )
            ->join('pets', 'schedules.pet_id', '=', 'pets.id')
            ->join('clients', 'schedules.client_id', '=', 'clients.id')
            ->leftJoin('users', 'schedules.user_id', '=', 'users.id')
            ->where('schedules.account_id', '=', $user->account_id)
            ->where('schedules.status', '=', $enumStatus->value)
            ->groupBy('schedules.id');

        $output = $this->csvHeader($this->header_args);

        foreach ($schedules->cursor() as $schedule) {
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
        $filePath = StorageExportEnum::SCHEDULES_PATH->pathFileGenerator(
            $user->account->uuid,
            StorageExportEnum::SCHEDULES_FILE_NAME_BASE,
            'csv'
        );
        $file = $this->storeFile($filePath, $output);
        if ($file) {
            Notification::route('mail', $user->email)->notify(new ExportScheduleNotify($user, $filePath));
        }
    }
}