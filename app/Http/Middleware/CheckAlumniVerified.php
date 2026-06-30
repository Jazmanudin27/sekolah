<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAlumniVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $school = $request->attributes->get('school');
            if ($school && $user->role !== 'superadmin' && $user->school_id != $school->id) {
                abort(403, 'Akses ditolak. Anda bukan alumni terdaftar di sekolah ini.');
            }

            if ($user->status_verifikasi || in_array($user->role, ['superadmin', 'admin_alumni'])) {
                return $next($request);
            }
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'Akun Anda belum diverifikasi oleh Admin.');
        }

        return redirect()->route('login');
    }
}
