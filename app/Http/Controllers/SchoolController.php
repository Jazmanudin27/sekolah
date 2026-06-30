<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admission;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Achievement;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $achievements = Achievement::where('school_id', $school->id)->latest()->take(3)->get();
        $news = \App\Models\Post::where('school_id', $school->id)->latest()->take(3)->get();
        
        $stats = [
            'total_siswa' => Student::where('school_id', $school->id)->where('status', 'aktif')->count(),
            'total_guru' => Teacher::where('school_id', $school->id)->count(),
            'total_fasilitas' => Facility::where('school_id', $school->id)->count(),
            'total_prestasi' => Achievement::where('school_id', $school->id)->count(),
        ];

        return view('public.school_home', compact('achievements', 'news', 'stats'));
    }

    /**
     * Display public Student directory.
     */
    public function siswa(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');
        $major = $request->input('major');

        $query = Student::where('school_id', $school->id)->where('status', 'aktif');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('nis', 'LIKE', '%' . $search . '%');
            });
        }

        if ($major) {
            $query->where('major', $major);
        }

        $students = $query->orderBy('name')->paginate(12)->withQueryString();

        // Statistics
        $totalStudents = Student::where('school_id', $school->id)->where('status', 'aktif')->count();
        $totalRPL = Student::where('school_id', $school->id)->where('status', 'aktif')->where('major', 'RPL')->count();
        $totalTKJ = Student::where('school_id', $school->id)->where('status', 'aktif')->where('major', 'TKJ')->count();
        $totalMM = Student::where('school_id', $school->id)->where('status', 'aktif')->where('major', 'Multimedia')->count();

        return view('public.siswa', compact('students', 'totalStudents', 'totalRPL', 'totalTKJ', 'totalMM'));
    }

    /**
     * Display public Teacher & Staff directory.
     */
    public function guru(Request $request)
    {
        $school = $request->attributes->get('school');
        $teachers = Teacher::where('school_id', $school->id)->orderBy('name')->get();
        return view('public.guru', compact('teachers'));
    }

    /**
     * Display PPDB landing & registration page.
     */
    public function ppdb()
    {
        return view('public.ppdb');
    }

    /**
     * Handle PPDB registration form submission.
     */
    public function daftar(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'previous_school' => 'required|string|max:255',
            'major_choice' => 'required|string|max:255',
        ]);

        $validated['school_id'] = $school->id;

        $admission = Admission::create($validated);

        return redirect()->route('ppdb.status', ['q' => $admission->registration_number])
            ->with('success', 'Pendaftaran PPDB berhasil dikirim! Silakan simpan Nomor Pendaftaran Anda.');
    }

    /**
     * Display PPDB lookup status page.
     */
    public function status(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('q');
        $admission = null;

        if ($search) {
            $admission = Admission::where('school_id', $school->id)
                                  ->where('registration_number', trim($search))
                                  ->first();
        }

        return view('public.ppdb-status', compact('admission', 'search'));
    }

    /**
     * Display School Facilities portfolio.
     */
    public function fasilitas(Request $request)
    {
        $school = $request->attributes->get('school');
        $facilities = Facility::where('school_id', $school->id)->get();
        return view('public.fasilitas', compact('facilities'));
    }

    /**
     * Display Extracurricular activities directory.
     */
    public function ekstrakurikuler(Request $request)
    {
        $school = $request->attributes->get('school');
        $ekstras = Extracurricular::where('school_id', $school->id)->get();
        return view('public.ekstrakurikuler', compact('ekstras'));
    }

    /**
     * Display School Achievements.
     */
    public function prestasi(Request $request)
    {
        $school = $request->attributes->get('school');
        $category = $request->input('category');
        $query = Achievement::where('school_id', $school->id);

        if ($category) {
            $query->where('category', $category);
        }

        $achievements = $query->orderBy('year', 'desc')->get();
        return view('public.prestasi', compact('achievements'));
    }
}
