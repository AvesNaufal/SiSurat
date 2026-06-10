<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input: nim wajib berupa angka maksimal 15, nama wajib karakter string
        $request->validate([
            'nim' => 'required|numeric|digits_between:1,15',
            'nama' => 'required|string|max:100',
        ]);

        // 2. Cari data spesifik mahasiswa di database
        $mahasiswaByNim = Mahasiswa::where('nim', $request->nim)->first();
        
        // Cari apakah nama tersebut sudah terdaftar di sistem (bisa jadi dengan NIM lain)
        $namaExists = Mahasiswa::where('nama', $request->nama)->exists();

        if ($mahasiswaByNim) {
            // Skenario 1: NIM terdaftar di DB, tapi namanya typo / berbeda
            if (strtolower($mahasiswaByNim->nama) !== strtolower($request->nama)) {
                return back()->withInput()->withErrors([
                    'error' => 'NIM atau Nama tidak ditemukan / tidak sesuai.'
                ]);
            }
            
            // Skenario 2: NIM terdaftar dan namanya cocok dengan yang ada di DB
            $mahasiswa = $mahasiswaByNim;
            
        } else {
            // Skenario 3: NIM belum terdaftar (salah/baru), tapi NAMA sudah ada di DB didaftarkan untuk orang lain.
            if ($namaExists) {
                return back()->withInput()->withErrors([
                    'error' => 'NIM atau Nama tidak valid / tidak sesuai.'
                ]);
            }
            
            // Skenario 4: NIM belum terdaftar (baru) DAN Nama belum terdaftar (baru).
            // Buatkan entri Mahasiswa baru.
            $mahasiswa = Mahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->nama
            ]);
        }

        // 3. Simpan identitas mahasiswa ke Session
        session(['mahasiswa' => $mahasiswa]);

        // 4. Redirect ke halaman sistem utama (dashboard/form)
        return redirect()->route('dashboard')->with('success', 'Berhasil login sebagai ' . $mahasiswa->nama);
    }

    public function logout(Request $request)
    {
        // Hapus object mahasiswa dari session Laravel
        $request->session()->forget('mahasiswa');
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
