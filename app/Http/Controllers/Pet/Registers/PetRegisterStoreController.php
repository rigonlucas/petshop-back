<?php

namespace App\Http\Controllers\Pet\Registers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Pet\Register\PetRegisterStoreRequest;
use App\Services\Application\PetsRegisters\DTO\PetRegisterStoreData;
use App\Services\Application\PetsRegisters\PetRegisterStoreService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PetRegisterStoreController extends Controller
{
    public function __invoke(PetRegisterStoreRequest $request, int $id, PetRegisterStoreService $service)
    {
        $data = PetRegisterStoreData::fromRequest($request);
        $data->pet_id = $id;
        $data->account_id = $request->user()->account_id;
        $result = $service->store($data);
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}
