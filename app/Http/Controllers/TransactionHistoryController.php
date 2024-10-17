<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\TransactionHistory;
use App\Http\Resources\TransactionHistoryResource;

class TransactionHistoryController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $transactionHistories = TransactionHistory::with(['game_user', 'product', 'voucherEarned', 'voucherUsed']);
        $transactionHistories = $transactionHistories->search(request());
        return TransactionHistoryResource::collection($this->paginateOrGet($transactionHistories));
    }
}