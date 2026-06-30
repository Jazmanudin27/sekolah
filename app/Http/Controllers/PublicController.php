<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\EventRsvp;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\Career;
use App\Models\Business;
use App\Models\ForumTopic;
use App\Models\ForumReply;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function portalHome()
    {
        $schools = \App\Models\School::withCount(['users'])->get();
        return view('public.portal_directory', compact('schools'));
    }

    public function index(Request $request)
    {
        $school = $request->attributes->get('school');

        // Stats
        $stats = [
            'total_alumni' => User::where('school_id', $school->id)->where('role', 'alumni')->count(),
            'total_angkatan' => User::where('school_id', $school->id)->where('role', 'alumni')->distinct('angkatan')->count('angkatan'),
            'total_donatur' => DonationTransaction::whereHas('donation', function ($q) use ($school) {
                $q->where('school_id', $school->id);
            })->where('status', 'completed')->distinct('donor_name')->count('donor_name'),
            'total_kegiatan' => Event::where('school_id', $school->id)->count(),
        ];

        // Latest News (3)
        $news = Post::where('school_id', $school->id)->latest()->take(3)->get();

        // Upcoming Events (2)
        $events = Event::where('school_id', $school->id)->where('date', '>=', now())->orderBy('date')->take(2)->get();

        // Testimonial mock
        $testimonials = [
            [
                'name' => 'Rian Kurniawan (Alumni 2018)',
                'content' => 'Sekolah ini memberikan fondasi keahlian yang sangat kuat. Hubungan alumni yang erat sangat membantu saya mendapat pekerjaan pertama saya.',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100'
            ],
            [
                'name' => 'Siti Aminah (Alumni 2021)',
                'content' => 'Fasilitas pembelajaran sekolah sangat lengkap. Berkat bimbingan guru-guru, saya bisa berkarir di bidang desain grafis dengan percaya diri.',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100'
            ],
        ];

        return view('public.alumni_home', compact('stats', 'news', 'events', 'testimonials'));
    }

    public function profil()
    {
        return view('public.profil');
    }

    public function ikatanAlumni()
    {
        return view('public.ikatan-alumni');
    }

    public function alumni(Request $request)
    {
        $school = $request->attributes->get('school');
        $query = User::where('school_id', $school->id)->where('role', 'alumni')->where('status_verifikasi', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }
        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }
        if ($request->filled('domisili')) {
            $query->where('domisili', 'like', '%' . $request->domisili . '%');
        }
        if ($request->filled('pekerjaan')) {
            $query->where('pekerjaan', 'like', '%' . $request->pekerjaan . '%');
        }

        $alumni = $query->latest()->paginate(12);

        // Fetch distinct filter options
        $angkatans = User::where('school_id', $school->id)->where('role', 'alumni')->whereNotNull('angkatan')->distinct()->pluck('angkatan')->sortDesc();
        $jurusans = User::where('school_id', $school->id)->where('role', 'alumni')->whereNotNull('jurusan')->distinct()->pluck('jurusan')->sort();

        return view('public.alumni.index', compact('alumni', 'angkatans', 'jurusans'));
    }

    public function alumniDetail(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        $alumnus = User::where('school_id', $school->id)->where('role', 'alumni')->where('status_verifikasi', true)->findOrFail($id);
        return view('public.alumni.detail', compact('alumnus'));
    }

    public function berita(Request $request)
    {
        $school = $request->attributes->get('school');
        $query = Post::where('school_id', $school->id);
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $posts = $query->latest()->paginate(9);
        return view('public.berita.index', compact('posts'));
    }

    public function beritaDetail(Request $request, $slug)
    {
        $school = $request->attributes->get('school');
        $post = Post::where('school_id', $school->id)->where('slug', $slug)->firstOrFail();
        $related = Post::where('school_id', $school->id)->where('id', '!=', $post->id)->latest()->take(3)->get();
        return view('public.berita.show', compact('post', 'related'));
    }

    public function agenda(Request $request)
    {
        $school = $request->attributes->get('school');
        $upcomingEvents = Event::where('school_id', $school->id)->where('date', '>=', now())->orderBy('date')->get();
        $pastEvents = Event::where('school_id', $school->id)->where('date', '<', now())->orderByDesc('date')->get();
        return view('public.agenda.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function agendaDetail(Request $request, $slug)
    {
        $school = $request->attributes->get('school');
        $event = Event::where('school_id', $school->id)->where('slug', $slug)->firstOrFail();
        $rsvps = EventRsvp::where('event_id', $event->id)->with('user')->get();
        
        $myRsvp = null;
        if (Auth::check()) {
            $myRsvp = EventRsvp::where('event_id', $event->id)->where('user_id', Auth::id())->first();
        }

        return view('public.agenda.show', compact('event', 'rsvps', 'myRsvp'));
    }

    public function rsvpEvent(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'status' => 'required|in:hadir,tidak_hadir,ragu_ragu',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melakukan RSVP.');
        }

        // Verify event belongs to this school
        $event = Event::where('school_id', $school->id)->findOrFail($id);

        EventRsvp::updateOrCreate(
            ['user_id' => Auth::id(), 'event_id' => $event->id],
            ['status' => $request->status]
        );

        return redirect()->back()->with('success', 'Status kehadiran berhasil dikonfirmasi.');
    }

    public function donasi(Request $request)
    {
        $school = $request->attributes->get('school');
        $donations = Donation::where('school_id', $school->id)->latest()->get();
        $topDonors = DonationTransaction::whereHas('donation', function ($q) use ($school) {
            $q->where('school_id', $school->id);
        })->where('status', 'completed')
            ->select('donor_name', \DB::raw('SUM(amount) as total'))
            ->groupBy('donor_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();
            
        return view('public.donasi.index', compact('donations', 'topDonors'));
    }

    public function donasiDetail(Request $request, $slug)
    {
        $school = $request->attributes->get('school');
        $donation = Donation::where('school_id', $school->id)->where('slug', $slug)->firstOrFail();
        $transactions = DonationTransaction::where('donation_id', $donation->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('public.donasi.show', compact('donation', 'transactions'));
    }

    public function submitDonasi(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $donation = Donation::where('school_id', $school->id)->findOrFail($id);

        $transaction = DonationTransaction::create([
            'donation_id' => $donation->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'donor_name' => $request->donor_name,
            'status' => 'completed', // Immediately completed for simulation
            'payment_method' => $request->payment_method,
            'message' => $request->message,
        ]);

        // Update raised amount
        $donation->increment('raised_amount', $request->amount);

        return redirect()->back()->with('success', 'Terima kasih atas donasi Anda! Pembayaran disimulasikan berhasil.');
    }

    public function karirBisnis(Request $request)
    {
        $school = $request->attributes->get('school');
        $careers = Career::where('school_id', $school->id)->latest()->get();
        $businesses = Business::where('school_id', $school->id)->latest()->get();
        return view('public.karir-bisnis.index', compact('careers', 'businesses'));
    }

    public function submissionKarir(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:fulltime,parttime,internship,freelance',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        Career::create([
            'title' => $request->title,
            'company' => $request->company,
            'description' => $request->description,
            'type' => $request->type,
            'location' => $request->location,
            'contact' => $request->contact,
            'user_id' => Auth::id(),
            'school_id' => $school->id,
        ]);

        return redirect()->back()->with('success', 'Lowongan pekerjaan berhasil ditambahkan.');
    }

    public function submissionBisnis(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'contact' => 'required|string|max:255',
        ]);

        Business::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'contact' => $request->contact,
            'user_id' => Auth::id(),
            'school_id' => $school->id,
        ]);

        return redirect()->back()->with('success', 'Usaha alumni berhasil ditambahkan.');
    }

    public function galeri(Request $request)
    {
        $school = $request->attributes->get('school');
        $photos = Gallery::where('school_id', $school->id)->where('type', 'foto')->latest()->get();
        $videos = Gallery::where('school_id', $school->id)->where('type', 'video')->latest()->get();
        return view('public.galeri', compact('photos', 'videos'));
    }

    public function forum(Request $request)
    {
        $school = $request->attributes->get('school');
        $topics = ForumTopic::where('school_id', $school->id)->with(['user', 'replies'])->latest()->paginate(15);
        return view('public.forum.index', compact('topics'));
    }

    public function forumDetail(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        $topic = ForumTopic::where('school_id', $school->id)->with(['user', 'replies.user'])->findOrFail($id);
        return view('public.forum.topic', compact('topic'));
    }

    public function submitForumTopic(Request $request)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat diskusi.');
        }

        $topic = ForumTopic::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'school_id' => $school->id,
        ]);

        return redirect()->route('forum.show', ['school_slug' => $school->slug, 'id' => $topic->id])->with('success', 'Topik diskusi berhasil dibuat.');
    }

    public function submitForumReply(Request $request, $id)
    {
        $school = $request->attributes->get('school');
        
        $request->validate([
            'content' => 'required|string',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membalas diskusi.');
        }

        // Verify topic belongs to school
        $topic = ForumTopic::where('school_id', $school->id)->findOrFail($id);

        ForumReply::create([
            'content' => $request->content,
            'forum_topic_id' => $topic->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function kontak()
    {
        return view('public.kontak');
    }

    public function submitKontak(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Simulating email sent
        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
