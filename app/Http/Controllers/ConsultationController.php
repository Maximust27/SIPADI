<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    // ============================================================
    // AREA USER (ORANG TUA)
    // ============================================================

    /**
     * Menampilkan halaman konsultasi milik user yang sedang login.
     */
    public function indexUser()
    {
        // Ambil data konsultasi milik user ini, urutkan dari yang terbaru
        $chats = Consultation::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.consultation_user', compact('chats'));
    }

    /**
     * Menyimpan pertanyaan baru dari user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'question' => 'required|string',
        ]);

        Consultation::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'question' => $request->question,
            'status' => 'pending', // Default status: Belum dijawab
        ]);

        return back()->with('success', 'Pertanyaan berhasil dikirim! Mohon tunggu balasan Kader.');
    }

    // ============================================================
    // AREA KADER (POSYANDU)
    // ============================================================

    /**
     * Menyimpan balasan dari Kader untuk pertanyaan tertentu.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        // Cari konsultasi berdasarkan ID
        $consultation = Consultation::findOrFail($id);

        // Update data dengan jawaban kader
        $consultation->update([
            'answer' => $request->answer,
            'kader_name' => Auth::user()->name, // Simpan nama kader yang menjawab
            'status' => 'answered', // Ubah status jadi 'Sudah Dijawab'
        ]);

        return back()->with('success', 'Jawaban berhasil dikirim kepada warga.');
    }

    /**
     * Menghapus data konsultasi (Opsional, bisa dipakai Admin/Kader).
     */
    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        
        // Pastikan hanya pemilik atau kader/admin yang bisa hapus (Security Check)
        if (Auth::user()->role == 'user' && $consultation->user_id != Auth::id()) {
            return back()->withErrors(['error' => 'Anda tidak berhak menghapus pesan ini.']);
        }

        $consultation->delete();

        return back()->with('success', 'Pesan konsultasi dihapus.');
    }
}