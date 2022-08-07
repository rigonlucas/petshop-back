<?php

namespace App\Http\Controllers\Pet\Registers;

use App\Http\Controllers\Controller;
use App\Services\Application\PetsRegisters\DTO\PetRegisterDeleteData;
use App\Services\Application\PetsRegisters\PetRegisterDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PetRegisterDeleteController extends Controller
{
    public function __invoke(Request $request, int $id, int $registerId, PetRegisterDeleteService $service): Response
    {
        $data = new PetRegisterDeleteData();
        $data->id = $registerId;
        $data->pet_id = $id;
        $data->account_id = $request->user()->account_id;

        $result = $service->delete($data);

        return response()->noContent();
    }
}
