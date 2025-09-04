<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (! in_array($user->role, $roles)) {
            // يمكنك توجيهه إلى لوحته الخاصة تلقائيًا
            return match ($user->role) {
                'admin' => redirect('/dashboard'),
                'manager' => redirect('/manager' ),
                'teacher' => redirect('/teacher'),
                'student' => redirect('/student'),
                'employee' => redirect('/employee'),
                'guardian' => redirect('/guardian'),
                default => redirect('/'),
            };
        }
        return $next($request);
    }
}
