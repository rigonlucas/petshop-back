<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Pet\PetUpdateRequest;
use App\Services\Application\Pets\DTO\PetUpdateData;
use App\Services\Application\Pets\PetUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PetUpdateController extends Controller
{
    /**
     * @param PetUpdateRequest $request
     * @param int $id
     * @param PetUpdateService $service
     * @return JsonResponse
     */
    public function __invoke(PetUpdateRequest $request, int $id, PetUpdateService $service): JsonResponse
    {
        $data = PetUpdateData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;
        $result = DB::transaction(function () use ($service, $data) {
            return $service->update($data);
        });
        return response()->json(['row_updated' => $result], ResponseAlias::HTTP_OK);
    }
}
