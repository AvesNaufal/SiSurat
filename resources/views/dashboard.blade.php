<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Surat - SiSurat</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 relative overflow-x-hidden min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-800 tracking-tight ml-2">Si<span class="text-blue-600">Surat</span></span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:block text-right">
                        <div class="text-sm font-bold text-slate-800">{{ $mahasiswa->nama }}</div>
                        <div class="text-xs font-medium text-slate-500">{{ $mahasiswa->nim }}</div>
                    </div>
                    
                    <!-- Tombol Riwayat Surat -->
                    <a href="{{ route('surat.riwayat') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm font-bold text-sm" title="Riwayat Surat Anda">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span class="hidden sm:inline">Riwayat</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="p-2.5 bg-slate-100 border border-slate-200 text-slate-500 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Decorative Background Shapes -->
    <div class="absolute top-0 left-0 w-full h-[500px] overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply opacity-50 blur-3xl"></div>
        <div class="absolute top-32 -right-32 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply opacity-50 blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-cyan-200 rounded-full mix-blend-multiply opacity-50 blur-3xl"></div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-12 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl text-balance">Pilih Jenis Layanan Surat</h1>
            <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto text-balance">Pilih jenis surat yang ingin dicetak. Sistem akan secara otomatis mengisikan data diri Anda pada setiap format surat.</p>
        </div>

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl max-w-2xl mx-auto">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-sm font-medium text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($jenis_surat as $slug => $data)
            
            @php
                // Safelist the colors mapping since Tailwind Purge won't pick dynamic bindings
                $colorMap = [
                    'blue' => 'bg-white hover:border-blue-300 text-blue-600 bg-blue-50 group-hover:bg-blue-100 group-hover:text-blue-700',
                    'green' => 'bg-white hover:border-green-300 text-green-600 bg-green-50 group-hover:bg-green-100 group-hover:text-green-700',
                    'yellow' => 'bg-white hover:border-yellow-300 text-yellow-600 bg-yellow-50 group-hover:bg-yellow-100 group-hover:text-yellow-700',
                    'indigo' => 'bg-white hover:border-indigo-300 text-indigo-600 bg-indigo-50 group-hover:bg-indigo-100 group-hover:text-indigo-700',
                    'red' => 'bg-white hover:border-red-300 text-red-600 bg-red-50 group-hover:bg-red-100 group-hover:text-red-700',
                    'orange' => 'bg-white hover:border-orange-300 text-orange-600 bg-orange-50 group-hover:bg-orange-100 group-hover:text-orange-700',
                    'purple' => 'bg-white hover:border-purple-300 text-purple-600 bg-purple-50 group-hover:bg-purple-100 group-hover:text-purple-700',
                ];
                $c = $data['color'];
            @endphp

            <a href="{{ route('surat.create', $slug) }}" class="group block bg-white/90 backdrop-blur-md border border-slate-200/60 rounded-[2rem] p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <!-- Hover Blob background -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-slate-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-2xl z-0"></div>
                
                <div class="relative z-10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-sm
                    @if($c == 'blue') bg-blue-50 text-blue-600 group-hover:bg-blue-100
                    @elseif($c == 'green') bg-green-50 text-green-600 group-hover:bg-green-100
                    @elseif($c == 'yellow') bg-yellow-50 text-yellow-600 group-hover:bg-yellow-100
                    @elseif($c == 'indigo') bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100
                    @elseif($c == 'red') bg-red-50 text-red-600 group-hover:bg-red-100
                    @elseif($c == 'orange') bg-orange-50 text-orange-600 group-hover:bg-orange-100
                    @elseif($c == 'purple') bg-purple-50 text-purple-600 group-hover:bg-purple-100
                    @else bg-slate-50 text-slate-600
                    @endif ">
                    {!! $data['icon'] !!}
                </div>
                
                <h3 class="relative z-10 text-xl font-bold text-slate-800 mb-2 leading-tight
                    @if($c == 'blue') group-hover:text-blue-700
                    @elseif($c == 'green') group-hover:text-green-700
                    @elseif($c == 'yellow') group-hover:text-yellow-700
                    @elseif($c == 'indigo') group-hover:text-indigo-700
                    @elseif($c == 'red') group-hover:text-red-700
                    @elseif($c == 'orange') group-hover:text-orange-700
                    @elseif($c == 'purple') group-hover:text-purple-700
                    @endif transition-colors">
                    {{ $data['label'] }}
                </h3>
                
                <p class="relative z-10 text-sm text-slate-500 font-medium">Buat permohonan surat ini dengan proses yang instan.</p>
                
                <div class="relative z-10 mt-5 flex items-center text-sm font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 transform -translate-x-2 group-hover:translate-x-0
                    @if($c == 'blue') text-blue-600
                    @elseif($c == 'green') text-green-600
                    @elseif($c == 'yellow') text-yellow-600
                    @elseif($c == 'indigo') text-indigo-600
                    @elseif($c == 'red') text-red-600
                    @elseif($c == 'orange') text-orange-600
                    @elseif($c == 'purple') text-purple-600
                    @endif">
                    Buat Surat <span class="ml-1 text-lg leading-none">&rarr;</span>
                </div>
            </a>
            @endforeach
        </div>

    </main>

</body>
</html>
