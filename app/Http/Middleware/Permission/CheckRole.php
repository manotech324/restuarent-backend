<?php

namespace App\Http\Middleware\Permission;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
{
    $user = $request->user();

    if (!$user || !in_array($user->role, $roles)) {
        return response()->json([
            'message' => 'Unauthorized. Only '.implode(' or ', $roles).' can perform this action.'
        ], 403);
    }

    return $next($request);
}

}
