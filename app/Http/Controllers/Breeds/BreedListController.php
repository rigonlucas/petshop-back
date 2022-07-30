<?php

namespace App\Http\Controllers\Breeds;

use App\Http\Controllers\Controller;
use App\Http\Resources\Breed\BreedResource;
use App\Services\Application\Breeds\BreedsListService;
use App\Services\Application\Breeds\DTO\BreedListData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BreedListController extends Controller
{
    public function __invoke(Request $request, BreedsListService $service): AnonymousResourceCollection
    {
        $data = BreedListData::fromRequest($request);
        return BreedResource::collection(
            $service->list($data)
        );
    }
}
