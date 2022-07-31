<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Services\Application\Pets\DTO\PetDeleteData;
use App\Services\Application\Pets\PetDeleteService;
use App\Services\Application\Products\DTO\ProductDeleteData;
use App\Services\Application\Products\ProductDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PetDeleteController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request, int $petId, PetDeleteService $service): Response
    {
        $data = new PetDeleteData();
        $data->id = $petId;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
