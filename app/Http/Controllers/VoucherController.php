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

    public function destroy(Voucher $voucher): Response
    {
        $voucher->delete();
        return response()->noContent();
    }
}
