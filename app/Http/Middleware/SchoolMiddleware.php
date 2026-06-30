<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('school_slug');

        if (!$slug) {
            return $next($request);
        }

        $school = School::where('slug', $slug)->first();

        if (!$school) {
            abort(404, 'Sekolah tidak ditemukan.');
        }

        // Share the school globally to all views
        view()->share('currentSchool', $school);

        // Store resolved school in request attributes for easy controller access
        $request->attributes->set('school', $school);

        // Set route defaults so helper functions like route() automatically use the current school_slug
        URL::defaults(['school_slug' => $school->slug]);

        return $next($request);
    }
}
