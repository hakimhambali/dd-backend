<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Middleware\IsUserAllowToBeDeleted;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    use PaginateTrait;

    public static function middleware(): array
    {
        return [
            new Middleware(IsUserAllowToBeDeleted::class, only: ['destroy']),
        ];
    }

    public function index(): AnonymousResourceCollection
    {
        $user = User::notAdmin()->search(request());

        return UserResource::collection($this->paginateOrGet($user));
    }

    public function store(StoreUserRequest $request): Response
    {
        $input = $request->validated();
        $input['password'] = bcrypt(User::DEFAULT_PASSWORD);

        $user = User::create($input);

        $user->profile->update([
            'full_name' => $input['name'],
        ]);

        $user->assignRole(RolesEnum::USER);

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function show(User $user): JsonResource
    {
        return UserResource::make($user);
    }

    public function update(Request $request, User $user): Response
    {
        return response()->noContent();
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
