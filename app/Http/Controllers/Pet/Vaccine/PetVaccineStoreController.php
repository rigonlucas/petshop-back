<?php

namespace App\Http\Controllers\Pet\Vaccine;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Pet\Vaccine\PetVaccineStoreRequest;
use App\Services\Application\Pets\Vaccines\DTO\PetVaccineStoreData;
use App\Services\Application\Pets\Vaccines\PetVaccinesStoreService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PetVaccineStoreController extends Controller
{
    public function __invoke(PetVaccineStoreRequest $request, PetVaccinesStoreService $service)
    {
        $this->authorize('client_create');
        $data = PetVaccineStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $result = $service->store($data, $request->user()->account_id);
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
