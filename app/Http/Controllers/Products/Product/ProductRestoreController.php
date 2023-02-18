<?php

namespace App\Http\Controllers\Products\Product;

use App\Actions\Application\Products\DTO\ProductRestoreData;
use App\Actions\Application\Products\ProductRestoreAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductRestoreController extends Controller
{
    public function __invoke(Request $request, int $id, ProductRestoreAction $service): Response
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
