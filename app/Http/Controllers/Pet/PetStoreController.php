<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Pet\PetStoreRequest;
use App\Services\Application\Pets\DTO\PetStoreData;
use App\Services\Application\Pets\PetStoreService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PetStoreController extends Controller
{
    /**
     * @param PetStoreRequest $request
     * @param PetStoreService $service
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(PetStoreRequest $request, PetStoreService $service): JsonResponse
    {
        $this->authorize('client_create');
        $data = PetStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->store($data);
        });
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
