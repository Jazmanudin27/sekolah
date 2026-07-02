<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $school = $request->attributes->get('school');
        $schoolId = $request->input('school_id');

        if (!$school && auth()->user()->role === 'superadmin') {
            $userQuery = User::query();
            $pendingQuery = User::where('role', 'alumni')->where('status_verifikasi', false);
            $eventQuery = Event::query();
            $donationQuery = DonationTransaction::where('status', 'completed');
            $postQuery = Post::query();
            $galleryQuery = Gallery::query();

            if ($schoolId) {
                $userQuery->where('school_id', $schoolId);
                $pendingQuery->where('school_id', $schoolId);
                $eventQuery->where('school_id', $schoolId);
                $donationQuery->whereHas('donation', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
                $postQuery->where('school_id', $schoolId);
                $galleryQuery->where('school_id', $schoolId);
            }

            $stats = [
                'total_users' => $userQuery->count(),
                'pending_verifications' => $pendingQuery->count(),
                'total_events' => $eventQuery->count(),
                'total_donations' => $donationQuery->sum('amount'),
                'total_news' => $postQuery->count(),
                'total_gallery' => $galleryQuery->count(),
            ];

            $recentAlumniQuery = User::where('role', 'alumni');
            $recentTransactionsQuery = DonationTransaction::where('status', 'completed');

            if ($schoolId) {
                $recentAlumniQuery->where('school_id', $schoolId);
                $recentTransactionsQuery->whereHas('donation', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            }

            $recentAlumni = $recentAlumniQuery->latest()->take(5)->get();
            $recentTransactions = $recentTransactionsQuery->with('donation')->latest()->take(5)->get();
        } else {
            $stats = [
                'total_users' => User::where('school_id', $school->id)->count(),
                'pending_verifications' => User::where('school_id', $school->id)->where('role', 'alumni')->where('status_verifikasi', false)->count(),
                'total_events' => Event::where('school_id', $school->id)->count(),
                'total_donations' => DonationTransaction::whereHas('donation', function ($q) use ($school) {
                    $q->where('school_id', $school->id);
                })->where('status', 'completed')->sum('amount'),
                'total_news' => Post::where('school_id', $school->id)->count(),
                'total_gallery' => Gallery::where('school_id', $school->id)->count(),
            ];

            $recentAlumni = User::where('school_id', $school->id)->where('role', 'alumni')->latest()->take(5)->get();
            $recentTransactions = DonationTransaction::whereHas('donation', function ($q) use ($school) {
                $q->where('school_id', $school->id);
            })->with('donation')->latest()->take(5)->get();
        }

        return view('admin.dashboard', compact('stats', 'recentAlumni', 'recentTransactions'));
    }

    public function alumni(Request $request)
    {
        $school = $request->attributes->get('school');
        $schoolId = $request->input('school_id');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = User::where('role', 'alumni');
            if ($schoolId) {
                $query->where('school_id', $schoolId);
            }
        } else {
            $query = User::where('school_id', $school->id)->where('role', 'alumni');
        }

        $alumni = $query->latest()->paginate(20)->withQueryString();
        return view('admin.alumni', compact('alumni'));
    }

    public function verifyAlumni(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $user = User::findOrFail($id);
        } else {
            $user = User::where('school_id', $school->id)->findOrFail($id);
        }
        $user->status_verifikasi = !$user->status_verifikasi;
        $user->save();

        return redirect()->back()->with('success', 'Status verifikasi alumni berhasil diperbarui.');
    }

    public function deleteAlumni(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $user = User::findOrFail($id);
        } else {
            $user = User::where('school_id', $school->id)->findOrFail($id);
        }
        $user->delete();

        return redirect()->back()->with('success', 'Data alumni berhasil dihapus.');
    }

    public function berita(Request $request)
    {
        $school = $request->attributes->get('school');
        $schoolId = $request->input('school_id');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Post::query();
            if ($schoolId) {
                $query->where('school_id', $schoolId);
            }
        } else {
            $query = Post::where('school_id', $school->id);
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        return view('admin.berita', compact('posts'));
    }

    public function submitBerita(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:posts,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:sekolah,alumni,pengumuman,artikel',
            'image' => 'nullable|string',
        ]);

        $schoolId = auth()->user()->role === 'superadmin' ? $request->school_id : $school->id;

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'content' => $request->content,
            'category' => $request->category,
            'image' => $request->image ?? 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800',
            'user_id' => Auth::id(),
            'school_id' => $schoolId,
        ];

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $post = Post::findOrFail($request->id);
            } else {
                $post = Post::where('school_id', $school->id)->findOrFail($request->id);
            }
            $post->update($data);
            $msg = 'Berita berhasil diperbarui.';
        } else {
            Post::create($data);
            $msg = 'Berita berhasil diterbitkan.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteBerita(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $post = Post::findOrFail($id);
        } else {
            $post = Post::where('school_id', $school->id)->findOrFail($id);
        }
        $post->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus.');
    }

    public function event(Request $request)
    {
        $school = $request->attributes->get('school');
        $schoolId = $request->input('school_id');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Event::query();
            if ($schoolId) {
                $query->where('school_id', $schoolId);
            }
        } else {
            $query = Event::where('school_id', $school->id);
        }

        $events = $query->latest()->paginate(15)->withQueryString();
        return view('admin.event', compact('events'));
    }

    public function submitEvent(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:events,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $schoolId = auth()->user()->role === 'superadmin' ? $request->school_id : $school->id;

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'image' => $request->image ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800',
            'school_id' => $schoolId,
        ];

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $event = Event::findOrFail($request->id);
            } else {
                $event = Event::where('school_id', $school->id)->findOrFail($request->id);
            }
            $event->update($data);
            $msg = 'Event agenda berhasil diperbarui.';
        } else {
            Event::create($data);
            $msg = 'Event agenda berhasil dibuat.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteEvent(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $event = Event::findOrFail($id);
        } else {
            $event = Event::where('school_id', $school->id)->findOrFail($id);
        }
        $event->delete();

        return redirect()->back()->with('success', 'Event agenda berhasil dihapus.');
    }

    public function donasi(Request $request)
    {
        $school = $request->attributes->get('school');
        $schoolId = $request->input('school_id');

        if (!$school && auth()->user()->role === 'superadmin') {
            $donationQuery = Donation::query();
            $transactionQuery = DonationTransaction::query();
            
            if ($schoolId) {
                $donationQuery->where('school_id', $schoolId);
                $transactionQuery->whereHas('donation', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            }
        } else {
            $donationQuery = Donation::where('school_id', $school->id);
            $transactionQuery = DonationTransaction::whereHas('donation', function ($q) use ($school) {
                $q->where('school_id', $school->id);
            });
        }

        $donations = $donationQuery->latest()->paginate(10)->withQueryString();
        $transactions = $transactionQuery->with('donation')->latest()->paginate(15)->withQueryString();
        
        return view('admin.donasi', compact('donations', 'transactions'));
    }

    public function submitDonasi(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:donations,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:10000',
            'type' => 'required|in:pembangunan,beasiswa,sosial,bencana',
            'image' => 'nullable|string',
        ]);

        $schoolId = auth()->user()->role === 'superadmin' ? $request->school_id : $school->id;

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'type' => $request->type,
            'image' => $request->image ?? 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800',
            'school_id' => $schoolId,
        ];

        if ($request->id) {
            if (auth()->user()->role === 'superadmin') {
                $donation = Donation::findOrFail($request->id);
            } else {
                $donation = Donation::where('school_id', $school->id)->findOrFail($request->id);
            }
            $donation->update($data);
            $msg = 'Kampanye donasi berhasil diperbarui.';
        } else {
            $data['raised_amount'] = 0;
            Donation::create($data);
            $msg = 'Kampanye donasi berhasil ditambahkan.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteDonasi(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $donation = Donation::findOrFail($id);
        } else {
            $donation = Donation::where('school_id', $school->id)->findOrFail($id);
        }
        $donation->delete();

        return redirect()->back()->with('success', 'Kampanye donasi berhasil dihapus.');
    }

    public function galeri(Request $request)
    {
        $school = $request->attributes->get('school');
        $schoolId = $request->input('school_id');

        if (!$school && auth()->user()->role === 'superadmin') {
            $query = Gallery::query();
            if ($schoolId) {
                $query->where('school_id', $schoolId);
            }
        } else {
            $query = Gallery::where('school_id', $school->id);
        }

        $galleries = $query->latest()->paginate(20)->withQueryString();
        return view('admin.galeri', compact('galleries'));
    }

    public function submitGaleri(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'id' => 'nullable|integer|exists:galleries,id',
            'school_id' => auth()->user()->role === 'superadmin' ? 'required|exists:schools,id' : 'nullable',
            'title' => 'required|string|max:255',
            'type' => 'required|in:foto,video',
            'url' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'category' => 'required|in:reuni,sosial,seminar,sekolah',
        ]);

        $schoolId = auth()->user()->role === 'superadmin' ? $request->school_id : $school->id;

        // Custom validation check
        if ($request->type === 'video') {
            if (!$request->url) {
                return redirect()->back()->withErrors(['url' => 'Link / URL Video wajib diisi jika tipe media adalah Video.'])->withInput();
            }
        } else {
            if (!$request->id && !$request->hasFile('images') && !$request->url) {
                return redirect()->back()->withErrors(['images' => 'Pilih file foto untuk diunggah atau masukkan URL foto.'])->withInput();
            }
        }

        if ($request->id) {
            // Edit Flow (Defensive implementation)
            if (auth()->user()->role === 'superadmin') {
                $gallery = Gallery::findOrFail($request->id);
            } else {
                $gallery = Gallery::where('school_id', $school->id)->findOrFail($request->id);
            }

            $url = $request->url;
            if ($request->type === 'foto' && $request->hasFile('images')) {
                $images = $request->file('images');
                if (count($images) > 0 && $images[0]->isValid()) {
                    // Delete old file if stored locally
                    $storageUrlPrefix = asset('storage');
                    if (str_starts_with($gallery->url, $storageUrlPrefix)) {
                        $relativePath = ltrim(substr($gallery->url, strlen($storageUrlPrefix)), '/');
                        if (Storage::disk('public')->exists($relativePath)) {
                            Storage::disk('public')->delete($relativePath);
                        }
                    }

                    $path = $images[0]->store('galleries', 'public');
                    $url = asset('storage/' . $path);
                }
            }

            $gallery->update([
                'title' => $request->title,
                'type' => $request->type,
                'url' => $url ?? $gallery->url,
                'category' => $request->category,
                'school_id' => $schoolId,
            ]);
            $msg = 'Item galeri berhasil diperbarui.';
        } else {
            // Create Flow
            if ($request->type === 'foto' && $request->hasFile('images')) {
                $uploadedCount = 0;
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('galleries', 'public');
                        $url = asset('storage/' . $path);

                        Gallery::create([
                            'title' => $request->title,
                            'type' => 'foto',
                            'url' => $url,
                            'category' => $request->category,
                            'school_id' => $schoolId,
                        ]);
                        $uploadedCount++;
                    }
                }
                $msg = "$uploadedCount item galeri berhasil ditambahkan.";
            } else {
                Gallery::create([
                    'title' => $request->title,
                    'type' => $request->type,
                    'url' => $request->url,
                    'category' => $request->category,
                    'school_id' => $schoolId,
                ]);
                $msg = 'Item galeri berhasil ditambahkan.';
            }
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteGaleri(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        if (!$school && auth()->user()->role === 'superadmin') {
            $gallery = Gallery::findOrFail($id);
        } else {
            $gallery = Gallery::where('school_id', $school->id)->findOrFail($id);
        }

        // Delete associated local file if it exists
        $storageUrlPrefix = asset('storage');
        if (str_starts_with($gallery->url, $storageUrlPrefix)) {
            $relativePath = ltrim(substr($gallery->url, strlen($storageUrlPrefix)), '/');
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Item galeri berhasil dihapus.');
    }
}
