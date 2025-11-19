<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Bundle;
use App\Models\Product;
use App\Http\Requests\StoreBundleRequest;
use App\Http\Requests\UpdateBundleRequest;
use App\Http\Resources\BundleResource;

class BundleController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $bundles = Bundle::with(['products' => function($query) {
            $query->select('id', 'product_type');
        }])
        ->search(request());
        
        return BundleResource::collection($this->paginateOrGet($bundles));
    }

    public function store(StoreBundleRequest $request): JsonResource
    {
        Log::info("store BundleController");
        $input = $request->validated();

        $bundleData = [
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'description' => $input['description'] ?? null,
            'created_by' => auth()->id(),
        ];
        $bundle = Bundle::create($bundleData);
        $bundle->update([
            'code' => 'BD_' . $bundle->id,
        ]);

        if (isset($input['products'])) {
            foreach ($input['products'] as $productData) {
                $bundle->products()->attach($productData['product_id']);
            }
        }

        return new BundleResource($bundle->load('products'));
    }

    public function update(UpdateBundleRequest $request, $id): JsonResource
    {
        Log::info("update BundleController");
        $bundle = Bundle::findOrFail($id);
        $input = $request->validated();

        $bundle->update([
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'description' => $input['description'],
            'updated_by' => auth()->id(),
        ]);
    
        if (isset($input['products'])) {
            $productIds = collect($input['products'])->pluck('product_id')->toArray();
            $bundle->products()->sync($productIds);
        }
    
        return new BundleResource($bundle->load('products'));
    }

    public function destroy(Bundle $bundle): Response
    {
        Log::info("destroy");
        $bundle->delete();
        return response()->noContent();
    }

    public function getProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function getBundles()
    {
        $bundles = Bundle::where('is_active', true)->get();
        return response()->json($bundles);
    }
}
