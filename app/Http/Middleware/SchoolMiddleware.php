<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\School;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        
        // Extract subdomain (e.g. "smkn1" from "smkn1.localhost")
        $subdomain = explode('.', $host)[0];
        
        // Exclude central patterns
        $isCentral = in_array($subdomain, ['127', 'localhost', 'www', 'portal']);
        
        $school = null;
        if (!$isCentral) {
            $school = School::where('slug', $subdomain)->first();
        }
        
        // Fallback to default school (ID = 1 or first school)
        if (!$school) {
            $school = School::orderBy('id', 'asc')->first();
        }

        if (!$school) {
            abort(404, 'Sekolah tidak ditemukan.');
        }

        // Share the school globally to all views
        view()->share('currentSchool', $school);

        // Store resolved school in request attributes for easy controller access
        $request->attributes->set('school', $school);

        return $next($request);
    }
}
