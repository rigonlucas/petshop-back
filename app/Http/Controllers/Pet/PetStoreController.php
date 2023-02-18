<?php

namespace App\Http\Controllers\Pet;

use App\Actions\Application\Pets\DTO\PetStoreData;
use App\Actions\Application\Pets\PetStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Pet\PetStoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PetStoreController extends Controller
{
    /**
     * @param PetStoreRequest $request
     * @param PetStoreAction $service
     * @return JsonResponse
     */
    public function __invoke(PetStoreRequest $request, PetStoreAction $service): JsonResponse
    {
        $data = PetStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->store($data);
        });
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
