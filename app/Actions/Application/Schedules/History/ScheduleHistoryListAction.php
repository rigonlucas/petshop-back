<?php

namespace App\Actions\Application\Schedules\History;

use App\Actions\Application\Schedules\History\DTO\ScheduleHistoryListData;
use App\Actions\BaseAction;
use App\Actions\Ordinations\ApplyOrdination;
use App\Actions\Ordinations\OrderBy;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHistory;
use App\Rules\AccountHasEntityRule;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleHistoryListAction extends BaseAction
{

    public function list(ScheduleHistoryListData $data, int $accountId): CursorPaginator
    {
        $this->validate($data, $accountId);

        $ordination = [
            $data->order_by => new OrderBy($data->order_direction)
        ];

        $query = ScheduleHistory::query()
            ->where('schedule_id', '=', $data->schedule_id);
        ApplyOrdination::apply($query, $ordination);
        return $query->cursorPaginate($data->per_page);
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleHistoryListData $data, int $accountId): void
    {
        Validator::make(
            $data->toArray(),
            [
                'schedule_id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Schedule::class, $accountId),
                ],
            ]
        )->validate();
    }
}