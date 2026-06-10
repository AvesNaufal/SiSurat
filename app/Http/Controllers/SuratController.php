<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class SuratController extends Controller
{
    public function index()
    {
        if (!session()->has('mahasiswa')) {
            return redirect()->route('login')->withErrors(['nim' => 'Silakan login terlebih dahulu untuk mengakses sistem.']);
        }
        $mahasiswa = session('mahasiswa');
        
        $jenis_surat = [
            'izin-penelitian' => ['label' => 'Izin Penelitian Skripsi/TA', 'color' => 'blue', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>'],
            'pkl' => ['label' => 'Praktik Kerja Lapangan (PKL)', 'color' => 'green', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" /></svg>'],
            'kkl' => ['label' => 'Kuliah Kerja Lapangan (KKL)', 'color' => 'yellow', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" /></svg>'],
            'keterangan-aktif' => ['label' => 'Keterangan Aktif Kuliah', 'color' => 'indigo', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>'],
            'tidak-beasiswa' => ['label' => 'Tidak Menerima Beasiswa', 'color' => 'red', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /></svg>'],
            'tidak-magang' => ['label' => 'Tidak Sedang Magang', 'color' => 'orange', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>'],
            'permohonan-cuti' => ['label' => 'Permohonan Cuti Akademik', 'color' => 'purple', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" /></svg>'],
        ];

        return view('dashboard', compact('mahasiswa', 'jenis_surat'));
    }

    public function create($jenis)
    {
        if (!session()->has('mahasiswa')) {
            return redirect()->route('login')->withErrors(['nim' => 'Silakan login terlebih dahulu untuk mengakses sistem.']);
        }
        $mahasiswa = session('mahasiswa');

        $jenis_surat = [
            'izin-penelitian' => 'Izin Penelitian Skripsi/Tugas Akhir',
            'pkl' => 'Praktik Kerja Lapangan (PKL)',
            'kkl' => 'Kuliah Kerja Lapangan (KKL)',
            'keterangan-aktif' => 'Keterangan Aktif Kuliah',
            'tidak-beasiswa' => 'Tidak Sedang Menerima Beasiswa',
            'tidak-magang' => 'Tidak Sedang Magang',
            'permohonan-cuti' => 'Permohonan Cuti Akademik',
        ];

        if (!array_key_exists($jenis, $jenis_surat)) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Jenis surat tidak valid.']);
        }

        $label_surat = $jenis_surat[$jenis];

        return view('surat.create', compact('mahasiswa', 'jenis', 'label_surat'));
    }

    /**
     * Simpan data surat ke database
     */
    public function store(Request $request)
    {
        if (!session()->has('mahasiswa')) {
            return response()->json(['success' => false, 'message' => 'Sesi habis, silakan login kembali.'], 401);
        }

        $request->validate([
            'nim' => 'required|string|max:15',
            'nama' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'semester' => 'required|integer|min:1|max:14',
            'jenis_surat' => 'required|string|max:50',
            'tujuan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'rentang_waktu' => 'nullable|string|max:100',
        ]);

        // Generate nomor surat otomatis
        $tahun = date('Y');
        $bulan = date('m');
        $urut = Surat::whereYear('tanggal', $tahun)->count() + 1;
        $nomor_surat = sprintf('%03d/FT-TI/UMK/%s/%s', $urut, $bulan, $tahun);

        $surat = Surat::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'semester' => $request->semester,
            'jenis_surat' => $request->jenis_surat,
            'tujuan' => $request->tujuan,
            'alamat' => $request->alamat,
            'rentang_waktu' => $request->rentang_waktu,
            'nomor_surat' => $nomor_surat,
            'file_pdf' => null,
            'tanggal' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil disimpan!',
            'data' => [
                'id' => $surat->id,
                'nomor_surat' => $nomor_surat,
            ]
        ]);
    }

    /**
     * Tampilkan riwayat surat mahasiswa
     */
    public function riwayat()
    {
        if (!session()->has('mahasiswa')) {
            return redirect()->route('login')->withErrors(['nim' => 'Silakan login terlebih dahulu untuk mengakses sistem.']);
        }
        $mahasiswa = session('mahasiswa');

        // Mengambil semua surat berdasarkan nim
        $riwayat_surat = Surat::where('nim', $mahasiswa->nim)
                              ->orderBy('tanggal', 'desc')
                              ->get();

        $jenis_surat_label = [
            'izin-penelitian' => 'Izin Penelitian Skripsi/TA',
            'pkl' => 'Praktik Kerja Lapangan (PKL)',
            'kkl' => 'Kuliah Kerja Lapangan (KKL)',
            'keterangan-aktif' => 'Keterangan Aktif Kuliah',
            'tidak-beasiswa' => 'Tidak Sedang Menerima Beasiswa',
            'tidak-magang' => 'Tidak Sedang Magang',
            'permohonan-cuti' => 'Permohonan Cuti Akademik',
        ];

        return view('surat.riwayat', compact('mahasiswa', 'riwayat_surat', 'jenis_surat_label'));
    }

    /**
     * Tampilkan pratinjau statis untuk cetak ulang surat
     */
    public function cetakUlang($id)
    {
        if (!session()->has('mahasiswa')) {
            return redirect()->route('login')->withErrors(['nim' => 'Silakan login terlebih dahulu untuk mengakses sistem.']);
        }
        $mahasiswa = session('mahasiswa');

        $surat = Surat::where('id', $id)->where('nim', $mahasiswa->nim)->firstOrFail();

        $jenis_surat_label = [
            'izin-penelitian' => 'Izin Penelitian Skripsi/Tugas Akhir',
            'pkl' => 'Praktik Kerja Lapangan (PKL)',
            'kkl' => 'Kuliah Kerja Lapangan (KKL)',
            'keterangan-aktif' => 'Keterangan Aktif Kuliah',
            'tidak-beasiswa' => 'Tidak Sedang Menerima Beasiswa',
            'tidak-magang' => 'Tidak Sedang Magang',
            'permohonan-cuti' => 'Permohonan Cuti Akademik',
        ];

        $label_surat = $jenis_surat_label[$surat->jenis_surat] ?? 'Surat Mahasiswa';

        return view('surat.show', compact('mahasiswa', 'surat', 'label_surat'));
    }
}
