<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PosyanduRecord;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\StandarWho; 

class DashboardController extends Controller
{
    // ============================================================
    // 1. PENGATUR LALU LINTAS (REDIRECT USER)
    // ============================================================
    public function redirectUser() {
        $role = Auth::user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'kader') return redirect()->route('kader.dashboard');
        return redirect()->route('user.dashboard');
    }

    // ============================================================
    // 2. AREA USER (MASYARAKAT)
    // ============================================================
    public function userDashboard() {
        $records = PosyanduRecord::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.user', compact('records'));
    }

    public function userStore(Request $request) {
        $request->validate([
            'child_name' => 'required',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $dob = Carbon::parse($request->birth_date);
        $ageMonths = $dob->diffInMonths(Carbon::now());
        
        // Cek Helper Standar WHO
        if (class_exists(StandarWho::class)) {
            $status = StandarWho::cekStatus($ageMonths, $request->height, $request->gender);
        } else {
            // Fallback jika Helper belum dibuat
            $median = ($ageMonths <= 12) ? 50 + (2.5 * $ageMonths) : 80 + (0.8 * ($ageMonths - 12));
            $status = ($request->height < ($median * 0.92)) ? 'Stunting' : 'Normal';
        }
        
        $h_m = $request->height / 100;
        $bmi = round($request->weight / ($h_m * $h_m), 1);

        PosyanduRecord::create([
            'user_id' => Auth::id(),
            'child_name' => $request->child_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'age_months' => $ageMonths,
            'weight' => $request->weight,
            'height' => $request->height,
            'bmi' => $bmi,
            'status_gizi' => $status
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Data anak berhasil dicek!');
    }

    // ============================================================
    // 3. AREA KADER (POSYANDU)
    // ============================================================
    public function kaderDashboard() {
        // A. Statistik Utama
        $total = PosyanduRecord::count();
        $stunting = PosyanduRecord::where('status_gizi', 'Stunting')->count();
        $normal = PosyanduRecord::where('status_gizi', 'Normal')->count();
        
        // B. Tabel Semua Data (Pagination)
        $records = PosyanduRecord::with('parent')->latest()->paginate(10);

        // C. Daftar Prioritas Penanganan (Red Flag List)
        $stuntingList = PosyanduRecord::with('parent')
            ->where('status_gizi', 'Stunting')
            ->latest()
            ->take(5)
            ->get();

        // D. [GRAFIK PINDAHAN DARI ADMIN] Tren Stunting 6 Bulan Terakhir
        // Kader perlu ini untuk evaluasi kesehatan desa
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('F'); 
            
            $count = PosyanduRecord::where('status_gizi', 'Stunting')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $chartLabels[] = $monthName;
            $chartData[] = $count;
        }

        return view('dashboard.kader', compact('total', 'stunting', 'normal', 'records', 'stuntingList', 'chartLabels', 'chartData'));
    }

    // ============================================================
    // 4. AREA ADMIN (SISTEM)
    // ============================================================
    public function adminDashboard() {
        // Admin fokus manajemen akun saja
        $totalUsers = User::where('role', 'user')->count();
        $totalKader = User::where('role', 'kader')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $users = User::latest()->get();

        // Grafik dihapus dari sini sesuai permintaan
        return view('dashboard.admin', compact('totalUsers', 'totalKader', 'totalAdmin', 'users'));
    }

    public function createUser(Request $request) {
        $request->validate([
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kader'
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'Akun ' . ucfirst($request->role) . ' Berhasil Dibuat');
    }
    
    public function deleteUser($id) {
        if(Auth::id() == $id) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri!']);
        }
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus');
    }
}