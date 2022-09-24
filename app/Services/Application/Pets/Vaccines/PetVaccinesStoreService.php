<?php

namespace App\Services\Application\Pets\Vaccines;

use App\Models\Clients\Pet;
use App\Models\Clients\PetVaccine;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Pets\DTO\PetStoreData;
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
        if ($data->applied_at) {
            $data->applied_at = Carbon::createFromFormat('d/m/Y', $data->applied_at)->format('Y-m-d');
        }
        return PetVaccine::query()->create($data->toArray());
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
                'vaccine_id' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'min:1',
                    'exists:vaccines,id'
                ],
                'applied' => ['required', 'boolean'],
                'applied_at' => ['nullable', 'date_format:d/m/Y', 'before_or_equal:today']
            ]
        )->validate();
    }
}