<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ItemController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $items = Item::with('product');
        $items = $items->search(request());
        return ItemResource::collection($this->paginateOrGet($items));
    }

    // public function show(Item $item): JsonResource
    // {
    //     return new ItemResource($item);
    // }

    public function store(StoreItemRequest $request): JsonResource
    {
        $input = $request->validated();

        $productData = [
            'name' => $input['name'],
            'price' => $input['price'],
            'is_active' => $input['is_active'],
            'product_type' => 'Item',
            'description' => $input['description'] ?? null,
            'created_by' => auth()->id(),
        ];
        $product = Product::create($productData);
        $product->update([
            'code' => 'IT_' . $product->id,
        ]);

        $itemData = [
            'product_id' => $product->id,
            'item_type' => $input['item_type'],
        ];
        $item = Item::create($itemData);

        return new ItemResource($item->load('product'));
    }

    public function update(UpdateItemRequest $request, $id): JsonResource
    {
        $item = Item::findOrFail($id);
        $input = $request->validated();

        $product = $item->product;
        $product->update([
            'name' => $input['name'],
            'price' => $input['price'],
            'is_active' => $input['is_active'],
            'description' => $input['description'],
            'updated_by' => auth()->id(),
        ]);
    
        $item->update([
            'item_type' => $input['item_type'],
        ]);
    
        return new ItemResource($item->load('product'));
    }

    public function destroy(Item $item): Response
    {
        $product = $item->product;
    
        $product->update([
            'deleted_by' => auth()->id(),
        ]);
        $product->delete();
    
        return response()->noContent();
    }
}
