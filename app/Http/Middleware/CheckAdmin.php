<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_alumni'])) {
            $school = $request->attributes->get('school');

            // If not superadmin, restrict them to their assigned school id
            if ($school && auth()->user()->role !== 'superadmin' && auth()->user()->school_id != $school->id) {
                abort(403, 'Akses ditolak. Anda bukan Administrator untuk sekolah ini.');
            }

            return $next($request);
        }

        abort(403, 'Akses ditolak. Halaman ini hanya untuk Administrator.');
    }
}
