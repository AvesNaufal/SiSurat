<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form {{ $label_surat }} - SiSurat</title>
    <!-- Google Fonts: Inter and Serif for paper -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Memuat Alpine.js untuk live preview -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-surat { font-family: 'Times New Roman', Times, serif; }
        
        .surat-kertas { 
            aspect-ratio: 1 / 1.4142; /* A4 aspect ratio */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        
        /* ===== PRINT STYLES - Perbaikan Total ===== */
        @media print {
            /* Reset semua elemen halaman */
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                width: 210mm !important;
                height: 297mm !important;
                overflow: visible !important;
            }
            
            /* Sembunyikan SEMUA elemen kecuali area cetak */
            nav, 
            .lg\:col-span-4,
            .xl\:col-span-3,
            .absolute.top-4.right-4,
            main > div > div:first-child {
                display: none !important;
            }
            
            /* Reset container-container pembungkus */
            main,
            main > div,
            main > div > div:last-child,
            main > div > div:last-child > div {
                display: block !important;
                position: static !important;
                width: 100% !important;
                max-width: none !important;
                height: auto !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            
            /* Styling kertas surat saat print */
            #printable-area {
                display: flex !important;
                flex-direction: column !important;
                position: relative !important;
                width: 210mm !important;
                min-height: 297mm !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 15mm 20mm 15mm 20mm !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                overflow: visible !important;
                aspect-ratio: auto !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Kop Surat tetap muncul dengan background warna */
            #printable-area .absolute {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Pastikan gambar logo tercetak */
            #printable-area img {
                display: inline-block !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Warna background untuk kop dan footer */
            [style*="print-color-adjust"] {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Hilangkan scrollbar area */
            .custom-scrollbar {
                overflow: visible !important;
            }

            /* Class khusus untuk elemen yang TIDAK boleh dicetak */
            .no-print {
                display: none !important;
            }

            /* Page settings */
            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
        
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk mencetak surat (langsung konek ke printer)
        function cetakSurat() {
            window.print();
        }

        // Fungsi utama: Simpan data ke database dulu, lalu cetak
        function simpanDanCetak() {
            // Ambil nilai langsung dari elemen input
            const prodi = document.querySelector('select[x-model="prodi"]')?.value;
            const semester = document.querySelector('input[x-model="semester"]')?.value;
            const nim = document.querySelector('input[x-model="nim"]')?.value;
            const nama = document.querySelector('input[x-model="nama"]')?.value;
            const tujuanEl = document.querySelector('input[x-model="tujuan"]') || document.querySelector('textarea[x-model="tujuan"]');
            const alamatEl = document.querySelector('textarea[x-model="alamat"]');
            const rentangEl = document.querySelector('input[x-model="rentang_waktu"]');
            
            const tujuan = tujuanEl ? tujuanEl.value : '';
            const alamat = alamatEl ? alamatEl.value : '';
            const rentang_waktu = rentangEl ? rentangEl.value : '';

            // Validasi sederhana
            if (!prodi) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Harap pilih Program Studi terlebih dahulu!', confirmButtonColor: '#3b82f6' });
                return;
            }
            if (!semester) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Harap isi Semester terlebih dahulu!', confirmButtonColor: '#3b82f6' });
                return;
            }

            // Disable tombol saat proses
            const button = event.currentTarget || document.querySelector('button[onclick="simpanDanCetak()"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
            button.disabled = true;

            // Ambil CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const jenisSurat = document.getElementById('jenis_surat_hidden').value;

            // Kirim data ke server via AJAX (fetch)
            fetch('{{ route("surat.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    nim: nim,
                    nama: nama,
                    prodi: prodi,
                    semester: semester,
                    jenis_surat: jenisSurat,
                    tujuan: tujuan,
                    alamat: alamat,
                    rentang_waktu: rentang_waktu,
                })
            })
            .then(response => response.json())
            .then(data => {
                button.innerHTML = originalText;
                button.disabled = false;

                if (data.success) {
                    // Update nomor surat di preview jika berhasil
                    const nomorEl = document.getElementById('nomor-surat-preview');
                    if (nomorEl && data.data.nomor_surat) {
                        nomorEl.textContent = 'Nomor: ' + data.data.nomor_surat;
                    }

                    // Tampilkan SweetAlert modern
                    Swal.fire({
                        title: 'Berhasil Dibuat!',
                        html: `Dokumen permohonan Anda berhasil tersimpan dengan rincian:<br><br><b>Nomor Surat:</b><br><span style="color:#2563eb;font-weight:bold;">${data.data.nomor_surat}</span>`,
                        icon: 'success',
                        confirmButtonText: 'Oke, Cetak Surat',
                        confirmButtonColor: '#2563eb', // blue-600
                        allowOutsideClick: false,
                        backdrop: `rgba(15, 23, 42, 0.8)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Alihkan (Redirect) ke halaman cetak khusus
                            window.location.href = `/surat/${data.data.id}/cetak`;
                        }
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan saat menyimpan.', confirmButtonColor: '#ef4444' });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalText;
                button.disabled = false;
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan koneksi. Silakan periksa jaringan Anda.', confirmButtonColor: '#ef4444' });
            });
        }
    </script>
</head>
<body class="bg-slate-50 min-h-screen">
    
    <!-- Navbar -->
    <nav class="no-print bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Back Link -->
                <a href="{{ route('dashboard') }}" class="flex items-center text-slate-500 hover:text-blue-600 font-medium transition-colors group">
                    <div class="p-1 rounded-full group-hover:bg-blue-50 transition-colors mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                    </div>
                    <span>Kembali</span>
                </a>
                
                <!-- Center Title -->
                <span class="hidden sm:block text-xl font-extrabold text-slate-800 tracking-tight">{{ $label_surat }}</span>
                
                <!-- Right Profile Profile Indicator -->
                <div class="flex items-center">
                    <div class="text-xs font-semibold px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-full border border-indigo-200 flex items-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        {{ $mahasiswa->nim }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Grid dengan Alpine Data -->
    <main class="max-w-screen-2xl mx-auto px-4 py-6"
          x-data="{ 
              nama: '{{ addslashes($mahasiswa->nama) }}',
              nim: '{{ addslashes($mahasiswa->nim) }}',
              prodi: '',
              semester: '',
              tujuan: '',
              alamat: '',
              rentang_waktu: ''
          }">
          
        <!-- 2 Column Wrapper -->
        <div class="lg:grid lg:grid-cols-12 lg:gap-6 min-h-[calc(100vh-8rem)]">
            
            <!-- Kolom Kiri: Form -->
            <div class="no-print lg:col-span-4 xl:col-span-3 flex flex-col h-full bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-6 lg:mb-0">
                <div class="p-6 bg-slate-100/50 border-b border-slate-100 flex-shrink-0">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Data Isian Surat</h2>
                    </div>
                    <p class="text-xs text-slate-500">Lengkapi formulir di bawah ini. Hasil dapat dilihat pada live-preview sebelah kanan.</p>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto">
                    <form id="form-surat" class="space-y-6">
                        <input type="hidden" id="jenis_surat_hidden" value="{{ $jenis }}">
                        <!-- Profil Readonly -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">NIM Mahasiswa</label>
                                <input type="text" x-model="nim" readonly class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 px-4 py-2.5 outline-none cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Nama Lengkap</label>
                                <input type="text" x-model="nama" readonly class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 px-4 py-2.5 outline-none cursor-not-allowed">
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        <!-- Data Dinamis Form -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Program Studi <span class="text-red-500">*</span></label>
                                <select x-model="prodi" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-shadow bg-white text-slate-800">
                                    <option value="" disabled selected>-- Pilih Program Studi --</option>
                                    <option value="S1 Teknik Informatika">S1 Teknik Informatika</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Semester <span class="text-red-500">*</span></label>
                                <input type="number" x-model="semester" min="1" max="14" placeholder="Misal: 5" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-shadow">
                            </div>

                            <!-- Custom Fields Based on Letter Type -->
                            @if(in_array($jenis, ['izin-penelitian', 'pkl', 'kkl']))
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Instansi Tujuan <span class="text-red-500">*</span></label>
                                <input type="text" x-model="tujuan" placeholder="Cth: PT. Teknologi Nusantara" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-shadow">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Instansi <span class="text-red-500">*</span></label>
                                <textarea x-model="alamat" rows="2" placeholder="Alamat lengkap instansi..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-shadow resize-none"></textarea>
                            </div>
                            @endif

                            @if(in_array($jenis, ['pkl', 'kkl']))
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Rentang Tanggal <span class="text-red-500">*</span></label>
                                <input type="text" x-model="rentang_waktu" placeholder="Cth: Agustus s.d September 2026" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-shadow">
                            </div>
                            @endif

                            @if($jenis == 'permohonan-cuti')
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Alasan Cuti Akademik <span class="text-red-500">*</span></label>
                                <textarea x-model="tujuan" rows="3" placeholder="Sebutkan secara rinci mengapa Anda mengajukan cuti..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-shadow resize-none"></textarea>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="p-6 border-t border-slate-100 bg-white space-y-3">
                    <button type="button" onclick="simpanDanCetak()" class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl shadow-md shadow-blue-500/30 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Simpan & Cetak
                    </button>
                    <p class="text-center text-xs text-slate-400 font-medium">Pilih printer untuk cetak langsung, atau "Simpan sebagai PDF" untuk download</p>
                </div>
            </div>

            <!-- Kolom Kanan: Preview (Live Preview) -->
            <div class="lg:col-span-8 xl:col-span-9 flex flex-col h-full bg-slate-200/50 lg:bg-slate-800 rounded-3xl overflow-hidden relative border border-slate-300 lg:border-slate-800 lg:shadow-xl group">
                
                <!-- Action Bar Float on Preview Window -->
                <div class="no-print absolute top-4 right-4 z-40 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="cetakSurat()" class="bg-white/90 backdrop-blur border border-slate-200 text-slate-700 hover:text-blue-600 px-4 py-2 rounded-xl shadow-lg font-bold text-xs flex items-center gap-2 transition-all hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak / Print
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar flex items-start justify-center p-4 sm:p-8 lg:p-12">
                    
                    <!-- Kertas A4 (Container Preview) -->
                    <div id="printable-area" class="bg-white w-full max-w-[794px] min-h-[1123px] surat-kertas lg:rounded-sm p-10 sm:p-12 md:p-[70px] text-black relative flex flex-col font-surat border-2 border-transparent focus-within:border-blue-500 transition-colors">
                        
                        <!-- KOP SURAT UMK STYLE -->
                        <!-- Bagian Header Utama (Didesain memanjang penuh ke ujung kertas) -->
                        <div class="absolute top-0 left-0 w-full h-[150px] sm:h-[170px] bg-white z-0" style="-webkit-print-color-adjust: exact; print-color-adjust: exact;">
                            <!-- Sky blue left bar -->
                            <div class="absolute top-0 left-0 w-5 sm:w-8 h-full bg-[#73c0e1]"></div>
                            
                            <!-- Light grey curved logo container -->
                            <div class="absolute top-0 left-5 sm:left-8 w-28 sm:w-[130px] h-full bg-[#f0f4f8]" style="border-bottom-right-radius: 3rem;"></div>
                            
                            <!-- Header Content Grid -->
                            <div class="w-full h-full flex items-center">
                                <!-- Logo Box -->
                                <div class="relative z-10 w-28 sm:w-[130px] ml-5 sm:ml-8 flex flex-col items-center h-full pt-4">
                                    <!-- File logo harus Anda taruh di dalam folder: public/images/logo_umk.png -->
                                    <img src="{{ asset('images/logo_umk.png') }}" alt="Logo UMK" class="w-16 sm:w-[86px] h-auto drop-shadow-sm" onerror="this.onerror=null; this.src='https://umk.ac.id/images/Logo_UMK.png';">
                                    <!-- Warna tulisan diubah menjadi biru pekat persis seperti di gambar -->
                                    <div class="text-[9px] sm:text-[11px] font-bold text-center text-[#25549b] mt-1.5 leading-[1.1] tracking-normal font-sans">
                                        UNIVERSITAS<br>MURIA KUDUS
                                    </div>
                                </div>

                                <!-- Text Section -->
                                <div class="flex-1 ml-5 sm:ml-8 pt-1 sm:pt-2 pr-10 sm:pr-12 md:pr-[70px] font-sans text-left z-10">
                                    <h2 class="text-[13px] sm:text-[16px] text-[#86a2c9] tracking-widest mb-0 leading-tight font-medium">UNIVERSITAS MURIA KUDUS</h2>
                                    <h1 class="text-[26px] sm:text-[38px] font-bold uppercase text-[#86a2c9] mt-0.5 mb-1 leading-none tracking-tight scale-y-110 origin-left">FAKULTAS TEKNIK</h1>
                                    <h2 class="text-[15px] sm:text-[19px] text-[#86a2c9] mt-1.5 sm:mt-2 mb-2 leading-none tracking-tight">Program Studi Teknik Informatika</h2>
                                    <p class="text-[9px] sm:text-[11px] text-[#a0aabf] mt-1 leading-snug font-medium">
                                        Jl. Lingkar Utara, Gondangmanis Bae Kudus 59327 Jawa Tengah, Telepon : (0291) 438229 ext. 119<br>
                                        Fax: (0291) 437198, e-Mail: ti@umk.ac.id, Website: https://ti.umk.ac.id
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Spacer untuk menggantikan ruang absolute header -->
                        <div class="h-[100px] sm:h-[110px] w-full relative z-10"></div>

                        <!-- KONTEN SURAT DINAMIS -->
                        <div class="flex-1 text-[13px] md:text-[15px] leading-relaxed">
                            
                            <!-- Nomor dan Judul -->
                            <div class="text-center mb-8">
                                <h3 class="font-bold underline uppercase text-base md:text-lg">{{ $label_surat }}</h3>
                                <p id="nomor-surat-preview" class="mt-1">Nomor: ... / FT-TI / UMK / <?php echo date('Y'); ?></p>
                            </div>

                            <p class="text-justify indent-10 mb-5">
                                Dekan Fakultas Teknik Universitas Muria Kudus menerangkan dengan sesungguhnya bahwa mahasiswa di bawah ini:
                            </p>

                            <!-- Biodata -->
                            <div class="ml-10 md:ml-12 mb-6 space-y-1">
                                <table class="w-full text-left">
                                    <tr>
                                        <td class="w-[180px] py-1">Nama Lengkap</td>
                                        <td class="w-[10px] py-1">:</td>
                                        <td class="py-1"><span x-text="nama || '...'" class="font-bold uppercase tracking-wide"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">Nomor Induk Mahasiswa</td>
                                        <td class="py-1">:</td>
                                        <td class="py-1"><span x-text="nim || '...'"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">Program Studi</td>
                                        <td class="py-1">:</td>
                                        <td class="py-1"><span x-text="prodi || '...'"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">Semester</td>
                                        <td class="py-1">:</td>
                                        <td class="py-1"><span x-text="semester || '...'"></span></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Body Sesuai Jenis Surat -->
                            @if(in_array($jenis, ['izin-penelitian', 'pkl', 'kkl']))
                            <p class="text-justify indent-10 mb-4">
                                Bermaksud memohon izin untuk melaksanakan kegiatan pada instansi / perusahaan yang Bapak/Ibu pimpin:
                            </p>
                            <div class="ml-10 md:ml-12 mb-6 font-bold space-y-1">
                                <table class="w-full text-left">
                                    <tr>
                                        <td class="w-[180px] py-1 font-normal">Nama Instansi</td>
                                        <td class="w-[10px] py-1 font-normal">:</td>
                                        <td class="py-1 uppercase"><span x-text="tujuan || '...'"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="py-1 font-normal align-top">Alamat Instansi</td>
                                        <td class="py-1 font-normal align-top">:</td>
                                        <td class="py-1 capitalize whitespace-pre-line"><span x-text="alamat || '...'"></span></td>
                                    </tr>
                                    @if(in_array($jenis, ['pkl', 'kkl']))
                                    <tr>
                                        <td class="py-1 font-normal">Rentang Waktu</td>
                                        <td class="py-1 font-normal">:</td>
                                        <td class="py-1"><span x-text="rentang_waktu || '...'"></span></td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <p class="text-justify indent-10 mb-4">
                                Kegiatan tersebut merupakan salah satu syarat akademik yang wajib ditempuh oleh mahasiswa bersangkutan. Demikian permohonan ini disampaikan, atas bantuan dan kerja sama yang baik kami ucapkan terima kasih.
                            </p>

                            @elseif($jenis == 'keterangan-aktif')
                            <p class="text-justify indent-10 mb-4">
                                Adalah benar-benar mahasiswa terdaftar dan berstatus <strong>aktif</strong> mengikuti perkuliahan pada semester berjalan pada Fakultas Teknik Universitas Muria Kudus.
                            </p>
                            <p class="text-justify indent-10 mb-4">
                                Surat keterangan aktif kuliah ini diberikan kepadanya sebagai persyaratan kelengkapan administrasi. Demikian agar dapat dipergunakan sebagaimana mestinya.
                            </p>
                            
                            @elseif($jenis == 'tidak-beasiswa')
                            <p class="text-justify indent-10 mb-4">
                                Menyatakan dengan sebenar-benarnya bahwa mahasiswa tersebut di atas pada saat surat keterangan ini diterbitkan <strong>tidak sedang menerima beasiswa dari pihak manapun</strong> yang tercatat di lingkungan universitas.
                            </p>
                            <p class="text-justify indent-10 mb-4">
                                Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
                            </p>

                            @elseif($jenis == 'tidak-magang')
                            <p class="text-justify indent-10 mb-4">
                                Menyatakan dengan sebenar-benarnya bahwa mahasiswa tersebut di atas pada saat surat keterangan ini diterbitkan <strong>tidak sedang terikat program magang atau kerja praktik pada instansi manapun</strong> yang tercatat di lingkungan universitas.
                            </p>
                            <p class="text-justify indent-10 mb-4">
                                Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
                            </p>

                            @elseif($jenis == 'permohonan-cuti')
                            <p class="text-justify indent-10 mb-4">
                                Bermaksud untuk mengajukan permohonan izin Cuti Berhenti Kuliah Sementara dengan alasan utama: "<strong x-text="tujuan || '...'"></strong>".
                            </p>
                            <p class="text-justify indent-10 mb-4">
                                Mengingat alasan tersebut di atas, permohonan cuti bersangkutan kami setujui sesuai dengan batasan kalender akademik. Surat ini diterbitkan sebagai pengesahan status kemahasiswaan sementara hingga mahasiswa tersebut melapor aktif kembali.
                            </p>
                            @endif

                        </div>

                        <!-- TANDA TANGAN -->
                        <div class="mt-16 flex justify-end text-[13px] md:text-[15px] relative z-10">
                            <div class="text-left w-[280px]">
                                <p>Kudus, <?php echo date('d F Y'); ?></p>
                                <p class="mb-24">Dekan Fakultas Teknik,</p>
                                <p class="font-bold underline uppercase">Dr. Ir. Taufiq Hidayat, ST, MT, IPM.</p>
                                <p>NIP. 197901232005011002</p>
                            </div>
                        </div>

                        <!-- FOOTER UMK -->
                        <div class="absolute bottom-0 left-0 w-full flex h-6 sm:h-8 z-50 overflow-hidden" style="-webkit-print-color-adjust: exact; print-color-adjust: exact;">
                            <div class="w-16 sm:w-20 bg-[#e2e8f0]"></div>
                            <div class="flex-1 bg-[#00a8e8] flex items-center justify-end px-6">
                                <span class="text-white text-[10px] sm:text-xs font-sans italic tracking-wide">Dignity, Quality, Integrity</span>
                                <span class="text-white text-[10px] sm:text-xs font-sans font-bold ml-1 tracking-wide"> | umk.ac.id</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
