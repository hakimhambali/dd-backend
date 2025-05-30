<?php

namespace App\Http\Controllers;

use App\Traits\PaginateTrait;

use App\Models\Offer;
use App\Http\Resources\OfferResource;

class OfferController extends Controller
{
    use PaginateTrait;

    public function getOffers()
    {
        $offers = Offer::with('productOffered')->get();
        return OfferResource::collection($offers);
    }
}
