<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Item;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $products = Product::with(['items' => function($query) {
            $query->select('id', 'item_type');
        }])
        ->with(['items' => function($query) {
            $query->withPivot('count');
        }, 'skin'])
        ->search(request());
        
        return ProductResource::collection($this->paginateOrGet($products));
    }

    public function store(StoreProductRequest $request): JsonResource
    {
        Log::info("StoreProductRequest");
        $input = $request->validated();

        $productData = [
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'product_type' => 'Item Consumable',
            'description' => $input['description'] ?? null,
            'created_by' => auth()->id(),
        ];
        $product = Product::create($productData);
        $product->update([
            'code' => 'IC_' . $product->id,
        ]);

        if (isset($input['items'])) {
            foreach ($input['items'] as $itemData) {
                $product->items()->attach($itemData['item_id'], ['count' => $itemData['count']]);
            }
        }

        return new ProductResource($product->load('items'));
    }

    public function update(UpdateProductRequest $request, $id): JsonResource
    {
        Log::info("UpdateProductRequest");
        $product = Product::findOrFail($id);
        $input = $request->validated();

        $product->update([
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'description' => $input['description'],
            'updated_by' => auth()->id(),
        ]);
    
        if (isset($input['items'])) {
            $itemsData = [];
            foreach ($input['items'] as $itemData) {
                $itemsData[$itemData['item_id']] = ['count' => $itemData['count']];
            }
            $product->items()->sync($itemsData);
        }
    
        return new ProductResource($product->load('items'));
    }

    public function destroy(Product $product): Response
    {
        Log::info("destroy");
        $product->update([
            'deleted_by' => auth()->id(),
        ]);
        $product->delete();
    
        return response()->noContent();
    }

    public function getItems()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function getProducts()
    {
        $products = Product::where('is_active', true)->get();
        return response()->json($products);
    }
}
