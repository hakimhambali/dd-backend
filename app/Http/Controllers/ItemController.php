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
        $items = Item::search(request());
        return ItemResource::collection($this->paginateOrGet($items));
    }

    public function store(StoreItemRequest $request): JsonResource
    {
        Log::info("StoreItemRequest");
        $input = $request->validated();

        $itemData = [
            'item_type' => $input['item_type'],
            'created_by' => auth()->id(),
        ];
        $item = Item::create($itemData);
        $item->update([
            'code' => 'IT_' . $item->id,
        ]);

        return new ItemResource($item);
    }

    public function update(UpdateItemRequest $request, $id): JsonResource
    {
        $item = Item::findOrFail($id);
        $data = array_merge($request->validated(), ['updated_by' => auth()->id()]);
        $item->update($data);
        return ItemResource::make($item);
    }

    public function destroy(Item $item): Response
    {    
        $item->delete();
    
        return response()->noContent();
    }
}
