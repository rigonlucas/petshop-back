<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Services\Application\Products\DTO\ProductRestoreData;
use App\Services\Application\Products\ProductRestoreService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductRestoreController extends Controller
{
    public function __invoke(Request $request, int $id, ProductRestoreService $service): Response
    {
        $data = new ProductRestoreData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        DB::transaction(function () use ($service, $data) {
            $service->restore($data);
        });
        return response()->noContent();
    }
}
