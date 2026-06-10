<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat {{ $surat->nomor_surat }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Tinos:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        /* CSS KHUSUS CETAK & SURAT */
        body { background-color: #1e293b; color: #f8fafc; font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        .font-surat { font-family: 'Tinos', 'Times New Roman', serif; color: black; }
        
        .surat-wrapper {
            display: flex;
            justify-content: center;
            padding: 80px 20px 40px 20px; /* Spacer dari header */
        }

        .surat-kertas { 
            background-color: white; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.2); 
            width: 100%;
            max-width: 794px; /* A4 width */
            min-height: 1123px; /* A4 height */
            padding: 70px;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Nav-Bar Khusus UI */
        .action-bar {
            position: fixed;
            top: 0; left: 0; width: 100%;
            background-color: #0f172a; /* slate-900 */
            border-bottom: 1px solid #334155;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
        }
        
        @media print {
            body { background: white !important; padding: 0 !important; margin: 0 !important; width: 100% !important; height: 100% !important;}
            .no-print { display: none !important; }
            .surat-wrapper { padding: 0 !important; display: block !important; }
            .surat-kertas { 
                box-shadow: none !important; 
                margin: 0 !important; 
                padding: 70px !important; 
                max-width: 100% !important; 
                width: 794px !important; 
                border: none !important; 
                min-height: 1123px !important; 
                height: 1123px !important; 
                overflow: hidden !important; 
                position: relative !important;
            }
        }
        
        @page { size: A4; margin: 0; }
    </style>
</head>
<body>

    <!-- Action Bar (Floating Print Button) -->
    <div class="no-print action-bar flex items-center justify-between">
        <div class="text-white text-sm font-semibold tracking-wide hidden sm:block">Pratinjau Cetak SiSurat</div>
        <div class="flex gap-4 ml-auto w-full sm:w-auto justify-end">
            <a href="{{ route('surat.riwayat') }}" class="flex items-center gap-2 bg-slate-700 hover:bg-slate-600 border border-slate-500 text-white px-4 py-2 rounded-lg font-bold text-sm transition-colors cursor-pointer" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Kembali
            </a>
            <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition-colors border-none cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- Kertas A4 -->
    <div class="surat-wrapper">
        <div class="surat-kertas font-surat">
            
            <!-- KOP SURAT UMK STYLE -->
            <!-- Menggunakan inline styles height statis untuk menghindari issue tailwind compilation -->
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 160px; background: white; z-index: 1; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                <div style="position: absolute; top: 0; left: 0; width: 30px; height: 100%; background: #73c0e1;"></div>
                <div style="position: absolute; top: 0; left: 30px; width: 120px; height: 100%; background: #f0f4f8; border-bottom-right-radius: 3rem;"></div>
                
                <div style="width: 100%; height: 100%; display: flex; align-items: center;">
                    <!-- Logo -->
                    <div style="position: relative; z-index: 10; width: 120px; margin-left: 30px; display: flex; flex-direction: column; align-items: center; padding-top: 15px;">
                        <img src="{{ asset('images/logo_umk.png') }}" alt="Logo UMK" style="width: 80px; height: auto;" onerror="this.onerror=null; this.src='https://umk.ac.id/images/Logo_UMK.png';">
                        <div style="font-size: 10px; font-weight: bold; text-align: center; color: #25549b; margin-top: 5px; line-height: 1.1; font-family: 'Inter', sans-serif;">
                            UNIVERSITAS<br>MURIA KUDUS
                        </div>
                    </div>

                    <!-- Text -->
                    <div style="flex: 1; margin-left: 30px; padding-top: 10px; font-family: 'Inter', sans-serif; position: relative; z-index: 10;">
                        <h2 style="font-size: 16px; color: #86a2c9; letter-spacing: 0.1em; line-height: 1.2; font-weight: 500; margin: 0;">UNIVERSITAS MURIA KUDUS</h2>
                        <h1 style="font-size: 34px; font-weight: bold; text-transform: uppercase; color: #86a2c9; margin: 2px 0; line-height: 1; transform: scaleY(1.1); transform-origin: left;">FAKULTAS TEKNIK</h1>
                        <h2 style="font-size: 18px; color: #86a2c9; margin: 5px 0; line-height: 1;">Program Studi Teknik Informatika</h2>
                        <p style="font-size: 11px; color: #a0aabf; margin-top: 5px; line-height: 1.3; font-weight: 500;">
                            Jl. Lingkar Utara, Gondangmanis Bae Kudus 59327 Jawa Tengah, Telepon : (0291) 438229 ext. 119<br>
                            Fax: (0291) 437198, e-Mail: ti@umk.ac.id, Website: https://ti.umk.ac.id
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Spacer absolut yang dijamin besarnya sama dengan tinggi header (160px) 
                 mengembalikan flow dokumen ke bawah agar tidak tertutup. -->
            <div style="height: 120px; width: 100%; position: relative; z-index: 0;"></div>

            <!-- KONTEN SURAT DINAMIS -->
            <div style="flex: 1; font-size: 15px; line-height: 1.6; position: relative; z-index: 10;">
                
                <div style="text-align: center; margin-bottom: 30px; margin-top: 20px;">
                    <h3 style="font-weight: bold; text-decoration: underline; text-transform: uppercase; font-size: 18px; margin: 0;">{{ $label_surat }}</h3>
                    <p style="margin: 5px 0 0 0;">Nomor: {{ $surat->nomor_surat }}</p>
                </div>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 20px;">
                    Dekan Fakultas Teknik Universitas Muria Kudus menerangkan dengan sesungguhnya bahwa mahasiswa di bawah ini:
                </p>

                <div style="margin-left: 40px; margin-bottom: 25px;">
                    <table style="width: 100%; text-align: left; border-collapse: collapse;">
                        <tr>
                            <td style="width: 180px; padding: 4px 0;">Nama Lengkap</td>
                            <td style="width: 10px; padding: 4px 0;">:</td>
                            <td style="padding: 4px 0;"><span style="font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">{{ $surat->nama }}</span></td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0;">Nomor Induk Mahasiswa</td>
                            <td style="padding: 4px 0;">:</td>
                            <td style="padding: 4px 0;"><span>{{ $surat->nim }}</span></td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0;">Program Studi</td>
                            <td style="padding: 4px 0;">:</td>
                            <td style="padding: 4px 0;"><span>{{ $surat->prodi }}</span></td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0;">Semester</td>
                            <td style="padding: 4px 0;">:</td>
                            <td style="padding: 4px 0;"><span>{{ $surat->semester }}</span></td>
                        </tr>
                    </table>
                </div>

                <!-- Body Sesuai Jenis Surat -->
                @if(in_array($surat->jenis_surat, ['izin-penelitian', 'pkl', 'kkl']))
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Bermaksud memohon izin untuk melaksanakan kegiatan pada instansi / perusahaan yang Bapak/Ibu pimpin:
                </p>
                <div style="margin-left: 40px; margin-bottom: 25px;">
                    <table style="width: 100%; text-align: left; font-weight: bold;">
                        <tr>
                            <td style="width: 180px; padding: 4px 0; font-weight: normal;">Nama Instansi</td>
                            <td style="width: 10px; padding: 4px 0; font-weight: normal;">:</td>
                            <td style="padding: 4px 0; text-transform: uppercase;"><span>{{ $surat->tujuan ?? '...' }}</span></td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; font-weight: normal; vertical-align: top;">Alamat Instansi</td>
                            <td style="padding: 4px 0; font-weight: normal; vertical-align: top;">:</td>
                            <td style="padding: 4px 0; text-transform: capitalize; white-space: pre-line;"><span>{{ $surat->alamat ?? '...' }}</span></td>
                        </tr>
                        @if(in_array($surat->jenis_surat, ['pkl', 'kkl']))
                        <tr>
                            <td style="padding: 4px 0; font-weight: normal;">Rentang Waktu</td>
                            <td style="padding: 4px 0; font-weight: normal;">:</td>
                            <td style="padding: 4px 0;"><span>{{ $surat->rentang_waktu ?? '...' }}</span></td>
                        </tr>
                        @endif
                    </table>
                </div>
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Kegiatan tersebut merupakan salah satu syarat akademik yang wajib ditempuh oleh mahasiswa bersangkutan. Demikian permohonan ini disampaikan, atas bantuan dan kerja sama yang baik kami ucapkan terima kasih.
                </p>

                @elseif($surat->jenis_surat == 'keterangan-aktif')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Adalah benar-benar mahasiswa terdaftar dan berstatus <strong>aktif</strong> mengikuti perkuliahan pada semester berjalan pada Fakultas Teknik Universitas Muria Kudus.
                </p>
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Surat keterangan aktif kuliah ini diberikan kepadanya sebagai persyaratan kelengkapan administrasi. Demikian agar dapat dipergunakan sebagaimana mestinya.
                </p>
                
                @elseif($surat->jenis_surat == 'tidak-beasiswa')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Menyatakan dengan sebenar-benarnya bahwa mahasiswa tersebut di atas pada saat surat keterangan ini diterbitkan <strong>tidak sedang menerima beasiswa dari pihak manapun</strong> yang tercatat di lingkungan universitas.
                </p>
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
                </p>

                @elseif($surat->jenis_surat == 'tidak-magang')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Menyatakan dengan sebenar-benarnya bahwa mahasiswa tersebut di atas pada saat surat keterangan ini diterbitkan <strong>tidak sedang terikat program magang atau kerja praktik pada instansi manapun</strong> yang tercatat di lingkungan universitas.
                </p>
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
                </p>

                @elseif($surat->jenis_surat == 'permohonan-cuti')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Bermaksud untuk mengajukan permohonan izin Cuti Berhenti Kuliah Sementara dengan alasan utama: "<strong>{{ $surat->tujuan ?? '...' }}</strong>".
                </p>
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
                    Mengingat alasan tersebut di atas, permohonan cuti bersangkutan kami setujui sesuai dengan batasan kalender akademik. Surat ini diterbitkan sebagai pengesahan status kemahasiswaan sementara hingga mahasiswa tersebut melapor aktif kembali.
                </p>
                @endif

            </div>

            <!-- TANDA TANGAN -->
            <div style="margin-top: 60px; display: flex; justify-content: flex-end; font-size: 15px; position: relative; z-index: 10;">
                <div style="text-align: left; width: 280px;">
                    <p style="margin: 0 0 5px 0;">Kudus, {{ \Carbon\Carbon::parse($surat->tanggal)->format('d F Y') }}</p>
                    <p style="margin: 0 0 90px 0;">Dekan Fakultas Teknik,</p>
                    <p style="margin: 0; font-weight: bold; text-decoration: underline; text-transform: uppercase;">Dr. Ir. Taufiq Hidayat, ST, MT, IPM.</p>
                    <p style="margin: 0;">NIP. 197901232005011002</p>
                </div>
            </div>

            <!-- FOOTER UMK -->
            <div style="position: absolute; bottom: 0; left: 0; width: 100%; display: flex; height: 35px; z-index: 50; overflow: hidden; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                <div style="width: 80px; background: #e2e8f0;"></div>
                <div style="flex: 1; background: #00a8e8; display: flex; align-items: center; justify-content: flex-end; padding: 0 25px;">
                    <span style="color: white; font-size: 12px; font-family: 'Inter', sans-serif; font-style: italic; letter-spacing: 0.05em;">Dignity, Quality, Integrity</span>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
