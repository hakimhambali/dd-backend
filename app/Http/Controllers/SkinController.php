<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Skin;
use App\Http\Requests\StoreSkinRequest;
use App\Http\Requests\UpdateSkinRequest;
use App\Http\Resources\SkinResource;
use App\Models\Product;

class SkinController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        Log::info('indexSkin');
        $skins = Skin::with('product');
        $skins = $skins->search(request());
        return SkinResource::collection($this->paginateOrGet($skins));
    }

    // public function show(Skin $skin): JsonResource
    // {
    //     return new SkinResource($skin);
    // }

    public function store(StoreSkinRequest $request): JsonResource
    {
        $input = $request->validated();

        $productData = [
            'name' => $input['name'],
            'price' => $input['price'],
            'product_type' => 'Skin',
            'description' => $input['description'] ?? null,
            'created_by' => auth()->id(),
        ];
        $product = Product::create($productData);
        $product->update([
            'code' => 'SK_' . $product->id,
        ]);

        $skinData = [
            'product_id' => $product->id,
            'skin_type' => $input['skin_type'],
        ];
        $skin = Skin::create($skinData);

        return new SkinResource($skin->load('product'));
    }

    // public function update(UpdateSkinRequest $request, Product $product): JsonResource
    // {
    //     // $skin = Skin::findOrFail($id);

    //     // if ($request->has(['name', 'price', 'description'])) {
    //     //     $skin->product->update($request->only(['name', 'price', 'description']));
    //     // }

    //     // if ($request->has(['skin_type'])) {
    //     //     $skin->product->update($request->only(['skin_type']));
    //     // }

    //     // return new SkinResource($skin->load('product'));

    //     $product->update($request->all());
    //     return ProductResource::make($product);
    // }

    public function destroy(Skin $skin): Response
    {
        $product = $skin->product;
        $product->delete();
        return response()->noContent();
    }
}
