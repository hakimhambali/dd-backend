<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReligionResource;
use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReligionController extends Controller
{
    /**
     * Retrieves all religions.
     */
    public function index(): JsonResource
    {
        $religions = Religion::all();

        return ReligionResource::collection($religions);
    }

    /**
     * Store a new religion in the database.
     */
    public function store(Request $request): JsonResource
    {
        $input = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $religion = Religion::create($input);

        return ReligionResource::make($religion);
    }

    /**
     * Retrieve a single religion.
     */
    public function show(Religion $religion): JsonResource
    {
        return ReligionResource::make($religion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Religion $religion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Religion $religion)
    {
        //
    }
}
