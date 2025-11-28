<?php

namespace App\Http\Middleware\Permission;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BranchSupervisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = Auth::user(); 

        if (!$user || $user->role !== 'branch_supervisor') {
            return response()->json([
                'message' => 'Unauthorized. Only Branch Supervisor can perform this action.'
            ], 403);
        }
        return $next($request);
    }
}
