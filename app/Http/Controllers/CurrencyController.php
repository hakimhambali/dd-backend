<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Currency;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Product;

class CurrencyController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        Log::info('indexCurrencySell');
        $currencies = Currency::with('product');
        $currencies = $currencies->search(request());
        return CurrencyResource::collection($this->paginateOrGet($currencies));
    }

    public function store(StoreCurrencyRequest $request): JsonResource
    {
        $input = $request->validated();

        $productData = [
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'product_type' => 'Currency',
            'description' => $input['description'] ?? null,
            'created_by' => auth()->id(),
        ];
        $product = Product::create($productData);

        $product->update([
            'code' => 'CU_' . $product->id,
        ]);

        $currencyData = [
            'product_id' => $product->id,
            'currency_type' => $input['currency_type'],
            'currency_value' => $input['currency_value'],
            // 'parent_id' => $input['parent_id'] ?? null,
        ];
        $currency = Currency::create($currencyData);

        return new CurrencyResource($currency->load('product'));
    }

    public function update(UpdateCurrencyRequest $request, $id): JsonResource
    {
        $currency = Currency::findOrFail($id);
        $input = $request->validated();

        $product = $currency->product;
        $product->update([
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'description' => $input['description'],
            'updated_by' => auth()->id(),
        ]);
    
        $currency->update([
            'currency_type' => $input['currency_type'],
            'currency_value' => $input['currency_value'],
            // 'parent_id' => $input['parent_id'] ?? null,
        ]);
    
        return new CurrencyResource($currency->load('product'));
    }

    public function destroy(Currency $currency): Response
    {
        $product = $currency->product;
        $product->delete();

        return response()->noContent();
    }
}
