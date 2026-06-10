<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Surat - SiSurat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('dashboard') }}" class="flex items-center text-slate-500 hover:text-blue-600 font-bold transition-colors group text-sm">
                    <div class="p-1.5 rounded-xl bg-slate-50 group-hover:bg-blue-50 transition-colors mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                    </div>
                    <span>Kembali</span>
                </a>
                
                <span class="text-lg font-extrabold text-slate-800 tracking-tight hidden sm:block">Arsip Permohonan</span>
                
                <div class="flex items-center">
                    <div class="text-xs font-bold px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl border border-indigo-100 flex items-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        NIM: {{ $mahasiswa->nim }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10" x-data="{ search: '' }">
        
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Surat</h1>
                <p class="text-slate-500 mt-2 text-sm sm:text-base max-w-2xl">Kelola dan unduh kembali dokumen persuratan yang sebelumnya telah Anda ajukan melalui sistem ini.</p>
            </div>
            
            <!-- Search Box -->
            <div class="relative w-full md:w-80 flex-shrink-0">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input x-model="search" type="text" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-400 transition-all" placeholder="Cari berdasarkan No. atau Jenis Surat...">
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                @if($riwayat_surat->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Riwayat Bersih</h3>
                    <p class="text-sm text-slate-500 max-w-sm">Anda belum pernah membuat dokumen persuratan jenis apapun melalui sistem permohonan ini.</p>
                </div>
                @else
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest whitespace-nowrap hidden sm:table-cell">#</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest whitespace-nowrap w-2/5">Informasi Dokumen</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest whitespace-nowrap w-1/5">Tanggal Terbit</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-right whitespace-nowrap w-1/5">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($riwayat_surat as $index => $surat)
                        <?php $label = $jenis_surat_label[$surat->jenis_surat] ?? 'Surat Tidak Dikenal'; ?>
                        <tr class="hover:bg-slate-50 transition-colors group" x-show="'{{ strtolower($surat->nomor_surat . ' ' . $label) }}'.includes(search.toLowerCase())">
                            
                            <!-- Nomor Urut (Mobile hidden) -->
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold text-slate-400 hidden sm:table-cell">
                                {{ $index + 1 }}
                            </td>

                            <!-- Informasi Dokumen -->
                            <td class="px-6 py-5 align-middle">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 mb-1 break-all">{{ $surat->nomor_surat ?? 'Draft/Batal' }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 w-fit tracking-wide">
                                        {{ $label }}
                                    </span>
                                </div>
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-5 whitespace-nowrap align-middle">
                                <div class="flex items-center text-sm font-medium text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $surat->tanggal ? \Carbon\Carbon::parse($surat->tanggal)->format('d M Y') : '-' }}
                                </div>
                            </td>

                            <!-- Tindakan -->
                            <td class="px-6 py-5 whitespace-nowrap align-middle text-right">
                                <a href="{{ route('surat.cetak', $surat->id) }}" target="_blank" class="inline-flex items-center justify-center bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm focus:outline-none focus:ring-4 focus:ring-indigo-500/10 active:scale-95 group-hover:border-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            
            @if(!$riwayat_surat->isEmpty())
            <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs font-semibold text-slate-500">Menampilkan total {{ $riwayat_surat->count() }} dokumen tercatat.</p>
            </div>
            @endif
        </div>
        
    </main>
</body>
</html>
