<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SchoolIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->school) {
            return redirect('/login')->withErrors('لا يمكن الوصول: لا توجد مدرسة مرتبطة بك.');
        }

        if (! $user->school->is_active) {
            return to_route('manager.actvation');
        }

        return $next($request);  
    }
}
