<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role_Id)
    {
        $current_user_logged = $request->user();
        //$role = Role::firstWhere('id',$role_Id);

        if (!$current_user_logged->hasRole($role_Id)) {
            return response([
                'errors' => [
                    'status' => 401,
                    'message' => 'you do not have enough privileges to access this route',
                ]
            ], 401);
        }
        return $next($request);
    }
}
