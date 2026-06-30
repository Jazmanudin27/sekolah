<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admission;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminSchoolController extends Controller
{
    // ==========================================
    // 1. SISWA MANAGEMENT (KELOLA SISWA)
    // ==========================================

    public function siswa(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Student::query();
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query = Student::where('school_id', $school->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('nis', 'LIKE', '%' . $search . '%')
                  ->orWhere('class', 'LIKE', '%' . $search . '%');
            });
        }

        $students = $query->orderBy('class')->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.siswa', compact('students'));
    }

    public function submitSiswa(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:students,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'nis' => 'required|string|max:50|unique:students,nis,' . $request->id,
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
            'status' => 'required|string|in:aktif,lulus',
        ]);

        $data = $request->only(['nis', 'name', 'class', 'major', 'status']);
        
        if (auth()->user()->role === 'superadmin') {
            $data['school_id'] = $request->school_id;
        } else {
            $data['school_id'] = $school->id;
        }

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $student = Student::findOrFail($request->id);
            } else {
                $student = Student::where('school_id', $school->id)->findOrFail($request->id);
            }
            $student->update($data);
            $msg = 'Data siswa berhasil diperbarui!';
        } else {
            Student::create($data);
            $msg = 'Siswa baru berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteSiswa(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $student = Student::findOrFail($id);
        } else {
            $student = Student::where('school_id', $school->id)->findOrFail($id);
        }
        $student->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }

    // ==========================================
    // 2. GURU MANAGEMENT (KELOLA GURU)
    // ==========================================

    public function guru(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Teacher::query();
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query = Teacher::where('school_id', $school->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('nip', 'LIKE', '%' . $search . '%')
                  ->orWhere('subject', 'LIKE', '%' . $search . '%');
            });
        }

        $teachers = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.guru', compact('teachers'));
    }

    public function submitGuru(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:teachers,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'nip' => 'nullable|string|max:50|unique:teachers,nip,' . $request->id,
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'foto_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nip', 'name', 'subject', 'role']);
        
        if (auth()->user()->role === 'superadmin') {
            $data['school_id'] = $request->school_id;
        } else {
            $data['school_id'] = $school->id;
        }

        if ($request->hasFile('foto_file')) {
            $file = $request->file('foto_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/guru'), $filename);
            $data['foto'] = asset('uploads/guru/' . $filename);
        }

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $teacher = Teacher::findOrFail($request->id);
            } else {
                $teacher = Teacher::where('school_id', $school->id)->findOrFail($request->id);
            }
            $teacher->update($data);
            $msg = 'Data guru berhasil diperbarui!';
        } else {
            Teacher::create($data);
            $msg = 'Guru baru berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteGuru(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $teacher = Teacher::findOrFail($id);
        } else {
            $teacher = Teacher::where('school_id', $school->id)->findOrFail($id);
        }
        $teacher->delete();
        return redirect()->back()->with('success', 'Data guru berhasil dihapus!');
    }

    // ==========================================
    // 3. PPDB MANAGEMENT (VERIFIKASI PPDB)
    // ==========================================

    public function ppdb(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Admission::query();
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query = Admission::where('school_id', $school->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('registration_number', 'LIKE', '%' . $search . '%')
                  ->orWhere('previous_school', 'LIKE', '%' . $search . '%');
            });
        }

        $admissions = $query->latest()->paginate(15)->withQueryString();
        return view('admin.ppdb', compact('admissions'));
    }

    public function verifyPPDB(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $admission = Admission::findOrFail($id);
        } else {
            $admission = Admission::where('school_id', $school->id)->findOrFail($id);
        }
        
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $admission->status = $request->status;
        $admission->save();

        return redirect()->back()->with('success', 'Status pendaftaran PPDB berhasil diperbarui!');
    }

    public function deletePPDB(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $admission = Admission::findOrFail($id);
        } else {
            $admission = Admission::where('school_id', $school->id)->findOrFail($id);
        }
        $admission->delete();
        return redirect()->back()->with('success', 'Data pendaftaran PPDB berhasil dihapus!');
    }

    // ==========================================
    // 4. FASILITAS MANAGEMENT (KELOLA FASILITAS)
    // ==========================================

    public function fasilitas(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Facility::query();
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query = Facility::where('school_id', $school->id);
        }

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $facilities = $query->latest()->paginate(10)->withQueryString();
        return view('admin.fasilitas', compact('facilities'));
    }

    public function submitFasilitas(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:facilities,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description']);
        
        if (auth()->user()->role === 'superadmin') {
            $data['school_id'] = $request->school_id;
        } else {
            $data['school_id'] = $school->id;
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/fasilitas'), $filename);
            $data['image'] = asset('uploads/fasilitas/' . $filename);
        }

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $facility = Facility::findOrFail($request->id);
            } else {
                $facility = Facility::where('school_id', $school->id)->findOrFail($request->id);
            }
            $facility->update($data);
            $msg = 'Fasilitas sekolah berhasil diperbarui!';
        } else {
            Facility::create($data);
            $msg = 'Fasilitas sekolah baru berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteFasilitas(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $facility = Facility::findOrFail($id);
        } else {
            $facility = Facility::where('school_id', $school->id)->findOrFail($id);
        }
        $facility->delete();
        return redirect()->back()->with('success', 'Fasilitas sekolah berhasil dihapus!');
    }

    // ==========================================
    // 5. EKSTRAKURIKULER (KELOLA EKSTRA)
    // ==========================================

    public function ekstrakurikuler(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Extracurricular::query();
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query = Extracurricular::where('school_id', $school->id);
        }

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('mentor', 'LIKE', '%' . $search . '%');
        }

        $ekstras = $query->latest()->paginate(10)->withQueryString();
        return view('admin.ekstrakurikuler', compact('ekstras'));
    }

    public function submitEkstrakurikuler(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:extracurriculars,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'mentor' => 'required|string|max:255',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'mentor']);
        
        if (auth()->user()->role === 'superadmin') {
            $data['school_id'] = $request->school_id;
        } else {
            $data['school_id'] = $school->id;
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ekstrakurikuler'), $filename);
            $data['image'] = asset('uploads/ekstrakurikuler/' . $filename);
        }

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $ekstra = Extracurricular::findOrFail($request->id);
            } else {
                $ekstra = Extracurricular::where('school_id', $school->id)->findOrFail($request->id);
            }
            $ekstra->update($data);
            $msg = 'Kegiatan ekstra berhasil diperbarui!';
        } else {
            Extracurricular::create($data);
            $msg = 'Kegiatan ekstra baru berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteEkstrakurikuler(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $ekstra = Extracurricular::findOrFail($id);
        } else {
            $ekstra = Extracurricular::where('school_id', $school->id)->findOrFail($id);
        }
        $ekstra->delete();
        return redirect()->back()->with('success', 'Kegiatan ekstra berhasil dihapus!');
    }

    // ==========================================
    // 6. PRESTASI MANAGEMENT (KELOLA PRESTASI)
    // ==========================================

    public function prestasi(Request $request)
    {
        $school = $request->attributes->get('school');
        $search = $request->input('search');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Achievement::query();
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
        } else {
            $query = Achievement::where('school_id', $school->id);
        }

        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
        }

        $achievements = $query->orderBy('year', 'desc')->paginate(10)->withQueryString();
        return view('admin.prestasi', compact('achievements'));
    }

    public function submitPrestasi(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:achievements,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'category' => 'required|string|in:akademik,non-akademik',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title', 'year', 'category', 'description']);
        
        if (auth()->user()->role === 'superadmin') {
            $data['school_id'] = $request->school_id;
        } else {
            $data['school_id'] = $school->id;
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/prestasi'), $filename);
            $data['image'] = asset('uploads/prestasi/' . $filename);
        }

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $achievement = Achievement::findOrFail($request->id);
            } else {
                $achievement = Achievement::where('school_id', $school->id)->findOrFail($request->id);
            }
            $achievement->update($data);
            $msg = 'Prestasi sekolah berhasil diperbarui!';
        } else {
            Achievement::create($data);
            $msg = 'Prestasi sekolah baru berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deletePrestasi(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $achievement = Achievement::findOrFail($id);
        } else {
            $achievement = Achievement::where('school_id', $school->id)->findOrFail($id);
        }
        $achievement->delete();
        return redirect()->back()->with('success', 'Prestasi sekolah berhasil dihapus!');
    }
}
