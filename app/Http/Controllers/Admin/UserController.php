<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Middleware\IsUserAllowToBeDeleted;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateuserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\WelcomeUser;
use App\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

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
        $users = User::with(['profile', 'roles'])->search(request()); 
        return UserResource::collection($this->paginateOrGet($users));
    }

    public function store(StoreUserRequest $request): JsonResource
    {
        $input = $request->validated();

        if ($request->input('role') === RolesEnum::SUPERADMIN->value && !request()->user()->isSuperadmin()) {
            return response()->json([
                'error' => 'Unauthorized action. You do not have permission to assign the Superadmin role.'
            ], 403);
        }
        
        if ($request->input('role') === RolesEnum::SUPERADMIN->value && request()->user()->isSuperadmin()) {
            $input['password'] = bcrypt(User::DEFAULT_PASSWORD_SUPERADMIN);
        } else {
            $input['password'] = bcrypt(User::DEFAULT_PASSWORD_ADMIN);
        }
    
        $user = User::create($input);
    
        $user->profile->update([
            'full_name' => $input['full_name'],
            'staff_no' => $input['staff_no'],
            'nric_passport' => $input['nric_passport'],
            'phone_number' => $input['phone_number'],
        ]);
    
        if ($request->input('role') === RolesEnum::SUPERADMIN->value && request()->user()->isSuperadmin()) {
            $user->assignRole(RolesEnum::SUPERADMIN);
        } else {
            $user->assignRole(RolesEnum::from($request->input('role')));
        }
    
        $user->notify(new WelcomeUser());
    
        return UserResource::make($user);
    }

    public function update(UpdateuserRequest $request, $id): JsonResource
    {
        $user = user::findOrFail($id);
        $input = $request->validated();

        $profile = $user->profile;
        $profile->update([
            'full_name' => $input['full_name'],
            'staff_no' => $input['staff_no'],
            'nric_passport' => $input['nric_passport'],
            'phone_number' => $input['phone_number'],
        ]);
    
        $user->update([
            'email' => $input['email'],
        ]);
    
        if ($user->role !== $input['role']) {
            $user->syncRoles([$input['role']]);
        }
    
        return new userResource($user->load('profile'));
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }

    public function me(Request $request): JsonResource
    {
        return UserResource::make($request->user()->load('profile'));
    }
}
