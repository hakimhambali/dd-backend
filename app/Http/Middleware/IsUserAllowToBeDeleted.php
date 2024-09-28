<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAllowToBeDeleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->route('user');

        $userCannotBeDeleted = $user->isSuperadmin() || ($user->id === $request->user()->id);

        abort_if($userCannotBeDeleted, Response::HTTP_FORBIDDEN, 'User cannot be deleted.');

        return $next($request);
    }
}
