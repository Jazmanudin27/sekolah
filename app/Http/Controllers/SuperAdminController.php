<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        $schools = School::withCount(['users'])->get();
        return view('superadmin.dashboard', compact('schools'));
    }

    public function submitSchool(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:schools,slug',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'welcome_headmaster' => 'nullable|string',
            'welcome_alumni' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        School::create($request->all());

        return redirect()->route('superadmin.schools')->with('success', 'Sekolah baru berhasil ditambahkan ke ERP!');
    }

    public function deleteSchool($id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        return redirect()->route('superadmin.schools')->with('success', 'Sekolah berhasil dihapus dari ERP.');
    }
}
