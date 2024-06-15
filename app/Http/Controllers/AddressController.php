<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\User;
use App\Traits\PaginateTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    use PaginateTrait;

    /**
     * Get a listing of the addresses.
     */
    public function index(): AnonymousResourceCollection
    {
        $query = Address::whereHasMorph(
            'addressable',
            [User::class],
            fn (Builder $query) => $query->where('addressable_id', auth()->id())
        );

        $query
            ->when(request('unit_no'), function (Builder $query, string $unitNo) {
                $query->where('unit_no', 'like', "%$unitNo%");
            });

        return AddressResource::collection($this->paginateOrGet($query));
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(StoreAddressRequest $request): Response
    {
        auth()->user()->addresses()->create($request->validated());

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified address.
     */
    public function show(Address $address): JsonResource
    {
        return AddressResource::make($address);
    }

    /**
     * Update the specified address in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified adress from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
