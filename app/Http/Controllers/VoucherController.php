<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $voucher = Voucher::findOrFail($id);
        $data = array_merge($request->validated(), ['updated_by' => auth()->id()]);
        $voucher->update($data);
        
        return VoucherResource::make($voucher);
    }
    
    public function destroy(Voucher $voucher): Response
    {
        Log::info('Deleting Voucher: ', ['voucher' => $voucher]);
        $voucher->update([
            'deleted_by' => auth()->id(),
        ]);
    
        $voucher->delete();
    
        return response()->noContent();
    }

    public function permanentDestroy($id): Response
    {
        try {
            $voucher = Voucher::withTrashed()->findOrFail($id);
            Log::info('Delete Voucher Permanently: ', ['Voucher' => $voucher]);
        
            $voucher->forceDelete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            Log::error('Voucher not found for permanent deletion', ['id' => $id]);
            return response()->json(['error' => 'GameUser not found'], 404);
        }
        
    }

    public function restore($id): Response
    {
        $voucher = Voucher::withTrashed()->findOrFail($id);
        Log::info('Restore Voucher: ', ['Voucher' => $voucher]);
    
        if ($voucher->deleted_at) {
            $voucher->restore();
            Log::info('Restored Voucher successfully: ', ['id' => $id]);

            return response()->noContent();
        }

        return response()->json(['message' => 'Voucher is already active.'], 400);        
    }
}
