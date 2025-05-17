<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use PaginateTrait;

    public function getMyProfile(Request $request): JsonResource
    {
        $adminUser = $request->user();
    
        if (!$adminUser) {
            return new JsonResource([
                'message' => 'Admin User not found',
            ]);
        }
    
        return new UserResource($adminUser->load('profile'));
    }
}
