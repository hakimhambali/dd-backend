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

    public function store(StoreSkinRequest $request): JsonResource
    {
        $input = $request->validated();

        $productData = [
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'product_type' => 'Skin',
            'description' => $input['description'] ?? null,
            'created_by' => auth()->id(),
        ];
        $product = Product::create($productData);

        if ($input['skin_type'] == "Bicycle") {
            $product->update([
                'code' => 'SB_' . $product->id,
            ]);
        }

        if ($input['skin_type'] == "Skateboard") {
            $product->update([
                'code' => 'SS_' . $product->id,
            ]);
        }

        if ($input['skin_type'] == "Outfit") {
            $product->update([
                'code' => 'SO_' . $product->id,
            ]);
        }

        $skinData = [
            'product_id' => $product->id,
            'skin_type' => $input['skin_type'],
            'skin_tier' => $input['skin_tier'],
            // 'parent_id' => $input['parent_id'] ?? null,
        ];
        $skin = Skin::create($skinData);

        return new SkinResource($skin->load('product'));
    }

    public function update(UpdateSkinRequest $request, $id): JsonResource
    {
        $skin = Skin::findOrFail($id);
        $input = $request->validated();

        $product = $skin->product;
        $product->update([
            'name' => $input['name'],
            'price_real' => $input['price_real'],
            'price_game' => $input['price_game'],
            'price_game_type' => $input['price_game_type'],
            'is_active' => $input['is_active'],
            'description' => $input['description'],
            'updated_by' => auth()->id(),
        ]);
    
        $skin->update([
            'skin_type' => $input['skin_type'],
            'skin_tier' => $input['skin_tier'],
            // 'parent_id' => $input['parent_id'] ?? null,
        ]);
    
        return new SkinResource($skin->load('product'));
    }

    public function destroy(Skin $skin): Response
    {
        $product = $skin->product;
        $product->delete();

        return response()->noContent();
    }
}
