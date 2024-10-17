<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Voucher;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Http\Resources\VoucherResource;

class VoucherController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $vouchers = Voucher::search(request());
        return VoucherResource::collection($this->paginateOrGet($vouchers));
    }

    public function store(StoreVoucherRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $voucher = Voucher::create($data);
        return new VoucherResource($voucher);
    }

    public function update(UpdateVoucherRequest $request, $id): JsonResource
    {
        // $voucher = Voucher::findOrFail($id);
        // $input = $request->validated();
        // $voucher->update($input);
        // if (isset($input['products'])) {
        //     $productIds = $input['products'];
        //     $voucher->products()->sync($productIds);
        // }
        // return new VoucherResource($voucher->load('products'));

        $voucher = Voucher::findOrFail($id);
        $data = array_merge($request->validated(), ['updated_by' => auth()->id()]);
        $voucher->update($data);
        return VoucherResource::make($voucher);
    }
    
    public function destroy(Voucher $voucher): Response
    {
        $voucher->update([
            'deleted_by' => auth()->id(),
        ]);
    
        $voucher->delete();
    
        return response()->noContent();
    }
}
