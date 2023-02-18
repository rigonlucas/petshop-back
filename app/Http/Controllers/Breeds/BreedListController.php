<?php

namespace App\Http\Controllers\Breeds;

use App\Actions\Application\Breeds\BreedsListAction;
use App\Actions\Application\Breeds\DTO\BreedListData;
use App\Http\Controllers\Controller;
use App\Http\Resources\Breed\BreedResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BreedListController extends Controller
{
    public function __invoke(Request $request, BreedsListAction $service): AnonymousResourceCollection
    {
        $data = BreedListData::fromRequest($request);
        return BreedResource::collection(
            $service->list($data)
        );
    }
}
