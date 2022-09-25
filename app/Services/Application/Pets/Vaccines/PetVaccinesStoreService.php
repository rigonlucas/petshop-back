<?php

namespace App\Services\Application\Pets\Vaccines;

use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Clients\PetVaccine;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Pets\Vaccines\DTO\PetVaccineStoreData;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetVaccinesStoreService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function store(PetVaccineStoreData $data, int $accountId): Model|Builder
    {
        $this->validate($data, $accountId);
        if (Carbon::canBeCreatedFromFormat($data->applied_at, 'd/m/Y')) {
            $data->applied_at = Carbon::createFromFormat('d/m/Y', $data->applied_at)->format('Y-m-d');
        }
        return PetVaccine::query()->create($data->except('schedule_new', 'schedule_date')->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(PetVaccineStoreData $data, int $accountId): void
    {
        Validator::make(
            $data->toArray(),
            [
                'pet_id' => [
                    'required',
                    'int',
                    'min:1',
                    new AccountHasEntityRule(Pet::class, $accountId),
                ],
                'client_id' => [
                    'required',
                    'int',
                    'min:1',
                    new AccountHasEntityRule(Client::class, $accountId),
                ],
                'vaccine_id' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'min:1',
                    'exists:vaccines,id'
                ],
                'applied' => ['required', 'boolean'],
                'applied_at' => ['nullable', 'date_format:d/m/Y', 'before_or_equal:today'],
                'schedule_new' => ['required','boolean'],
                'schedule_date' => ['nullable', 'date_format:d/m/Y', 'after:today'],
            ]
        )->validate();
    }
}