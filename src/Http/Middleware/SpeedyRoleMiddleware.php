<?php

namespace Hanson\Speedy\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SpeedyRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $permissionName
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionName)
    {
        $user = Auth::user();

        if(!$user->role_id){
            abort(403, trans('view.admin.public.403'));
        }

        return $next($request);
    }
}