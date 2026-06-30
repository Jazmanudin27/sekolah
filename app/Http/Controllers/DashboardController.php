<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventRsvp;
use App\Models\DonationTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Stats
        $rsvpsCount = EventRsvp::where('user_id', $user->id)->count();
        $donationsTotal = DonationTransaction::where('user_id', $user->id)->where('status', 'completed')->sum('amount');
        
        // Upcoming RSVP'd events
        $myEvents = EventRsvp::where('user_id', $user->id)
            ->whereHas('event', function($q) {
                $q->where('date', '>=', now());
            })
            ->with('event')
            ->take(3)
            ->get();

        return view('dashboard.index', compact('user', 'rsvpsCount', 'donationsTotal', 'myEvents'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('dashboard.profil', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'domisili' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'kontak_whatsapp' => 'required|string|max:20',
            'bio' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'github' => 'nullable|string',
            'instagram' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'domisili' => $request->domisili,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'kontak_whatsapp' => $request->kontak_whatsapp,
            'bio' => $request->bio,
            'media_sosial' => [
                'linkedin' => $request->linkedin,
                'github' => $request->github,
                'instagram' => $request->instagram,
            ]
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Mock profile picture upload
        if ($request->has('foto_url') && $request->foto_url != '') {
            $data['foto'] = $request->foto_url;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function digitalCard()
    {
        $user = Auth::user();
        return view('dashboard.kartu', compact('user'));
    }

    public function events()
    {
        $rsvps = EventRsvp::where('user_id', Auth::id())->with('event')->latest()->get();
        return view('dashboard.event', compact('rsvps'));
    }

    public function donations()
    {
        $donations = DonationTransaction::where('user_id', Auth::id())->with('donation')->latest()->get();
        return view('dashboard.donasi', compact('donations'));
    }
}
