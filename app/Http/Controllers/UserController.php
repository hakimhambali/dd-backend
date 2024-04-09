<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\PaginateTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $user = User::query()
            ->when(request('name'), function (Builder $query, string $name) {
                $query->where('name', 'like', "%$name%");
            });

        return UserResource::collection($this->paginateOrGet($user));
    }

    public function store(StoreUserRequest $request): Response
    {
        $input = $request->validated();
        $input['password'] = bcrypt('password');

        $user = User::create($input);

        $user->assignRole(RolesEnum::EMPLOYEE);

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        
    }

    public function update(Request $request, User $user)
    {
        
    }

    public function destroy(User $user): Response
    {
        $userCannotBeDeleted = $user->isAdmin() || ($user->id === auth()->id());

        abort_if($userCannotBeDeleted, Response::HTTP_FORBIDDEN, 'User cannot be deleted.');

        $user->delete();

        return response()->noContent();
    }
}
