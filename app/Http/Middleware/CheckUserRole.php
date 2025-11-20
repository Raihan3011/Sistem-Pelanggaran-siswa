<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Cek apakah user level sesuai dengan role yang diizinkan
        if (!in_array($user->level, $roles)) {
            // Redirect ke dashboard sesuai role mereka
            return redirect()->route('dashboard')
                           ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        
        return $next($request);
    }
}
