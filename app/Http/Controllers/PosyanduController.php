<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosyanduRecord;
use Carbon\Carbon;

class PosyanduController extends Controller
{
    // Halaman 1: Dashboard
    public function index()
    {
        $total = PosyanduRecord::count();
        $stunted = PosyanduRecord::where('status_gizi', 'Stunting')->count();
        $normal = PosyanduRecord::where('status_gizi', 'Normal')->count();

        return view('dashboard', compact('total', 'stunted', 'normal'));
    }

    // Halaman 2: Form Input
    public function create()
    {
        return view('input');
    }

    // Proses Simpan Data (Logic Javascript dipindah ke sini)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'birth_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        // 1. Hitung Umur
        $dob = Carbon::parse($request->birth_date);
        $now = Carbon::now();
        $ageMonths = $dob->diffInMonths($now); // Hitung bulan secara akurat

        // 2. Logika Stunting (Replikasi logic JS di atas)
        $medianHeight = 0;
        if ($ageMonths <= 12) {
            $medianHeight = 50 + (2.5 * $ageMonths);
        } else {
            $medianHeight = 80 + (0.8 * ($ageMonths - 12));
        }
        
        $threshold = $medianHeight * 0.92;
        $status = ($request->height < $threshold) ? 'Stunting' : 'Normal';

        // 3. Hitung BMI
        $h_meter = $request->height / 100;
        $bmi = round($request->weight / ($h_meter * $h_meter), 1);

        // 4. Simpan ke Database
        $record = PosyanduRecord::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'age_months' => $ageMonths,
            'weight' => $request->weight,
            'height' => $request->height,
            'bmi' => $bmi,
            'status_gizi' => $status
        ]);

        // 5. Redirect kembali dengan membawa data hasil untuk ditampilkan
        return redirect()->route('input')->with([
            'success' => true,
            'result' => $record
        ]);
    }

    // Halaman 3: Register Table
    public function list()
    {
        $records = PosyanduRecord::latest()->get();
        return view('register', compact('records'));
    }
}