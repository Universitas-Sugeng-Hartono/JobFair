<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFair 2026 - Portal Peserta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hover-card { transition: all 0.3s ease; box-shadow: 0 4px 18px -2px rgba(0,0,0,0.12), 0 2px 8px -2px rgba(0,0,0,0.08); }
        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 22px 38px -8px rgba(0,0,0,0.18), 0 10px 18px -4px rgba(0,0,0,0.10); }

        /* Modal */
        #applyModal { transition: opacity 0.2s ease; }
        #applyModal.hidden { opacity: 0; pointer-events: none; }

        /* Animated badge */
        @keyframes pulse-green { 0%,100%{opacity:1} 50%{opacity:.6} }
        .badge-applied { animation: pulse-green 2s infinite; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50 text-slate-900">

    <!-- Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                    @if(!empty($settings['logo_image']))
                        <img src="{{ !empty($settings['logo_image']) ? asset('storage/' . $settings['logo_image']) : asset('images/default-logo.png') }}" alt="Logo" class="h-10 object-contain">
                    @else
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-briefcase text-white"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">{{ $settings['logo_text'] ?? 'JobFair 2026' }}</h1>
                        
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    @if($nik)
                        <button onclick="document.getElementById('qrModal').classList.remove('hidden')" class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 hover:bg-indigo-100 transition cursor-pointer shadow-sm">
                            <i class="fa-solid fa-qrcode text-indigo-600 text-sm"></i>
                            <span class="hidden sm:inline text-sm font-medium text-slate-700">QR Code</span>
                        </button>
                        <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-50 to-violet-50 border border-blue-100">
                            <i class="fa-solid fa-id-card text-blue-600 text-sm"></i>
                            <span class="text-sm font-medium text-slate-700">NIK: <span class="text-blue-600 font-bold">{{ $nik }}</span></span>
                        </div>
                        <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-100">
                            <i class="fa-solid fa-file-circle-check text-emerald-600 text-sm"></i>
                            <span class="text-sm font-semibold text-emerald-700">{{ count($appliedPositionIds) }}/12 Lamaran</span>
                        </div>
                        <form action="{{ route('participant.clear-nik') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-lg text-sm text-slate-500 hover:text-red-500 hover:bg-red-50 transition border border-slate-200">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-red-500 text-xl"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- NIK Entry / Welcome Banner --}}
        @if(!$nik)
            {{-- Belum input NIK --}}
            <div class="mb-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                <!-- Dekor kiri atas (kecil) -->
                <div class="absolute top-0 left-0 w-40 h-40 bg-white/8 rounded-full -ml-20 -mt-20"></div>
                <!-- Dekor kanan bawah (besar, di belakang ilustrasi) -->
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full -mr-28 -mb-28"></div>
                <!-- Illustration -->
                <div class="absolute bottom-0 right-0 -mr-4 hidden sm:flex items-end justify-end h-full pointer-events-none select-none" aria-hidden="true">
                    <img src="{{ asset('template/template1.png') }}" alt="" class="h-48 md:h-56 w-auto object-bottom drop-shadow-2xl opacity-95 -mb-3" draggable="false">
                </div>
                <div class="relative sm:max-w-lg">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang di JobFair 2026!</h2>
                    <p class="text-blue-100 mb-6">Masukkan NIK Anda (16 digit) untuk mulai melihat dan melamar ke perusahaan.</p>
                    <form action="{{ route('participant.set-nik') }}" method="POST" class="flex flex-col gap-3 max-w-lg">
                        @csrf
                        <div class="flex-1">
                            <input type="text" name="name" placeholder="Nama Lengkap Anda"
                                   class="w-full px-4 py-3 rounded-xl text-slate-900 text-base font-medium focus:outline-none focus:ring-2 focus:ring-white/50 mb-3" required>
                            @error('name') <p class="text-red-200 text-sm mt-1">{{ $message }}</p> @enderror
                            
                            <input type="text" name="nik" maxlength="16" placeholder="Masukkan 16 digit NIK Anda"
                                   class="w-full px-4 py-3 rounded-xl text-slate-900 text-base font-medium focus:outline-none focus:ring-2 focus:ring-white/50 mb-3"
                                   oninput="this.value=this.value.replace(/\D/g,'')" required>
                            @error('nik') <p class="text-red-200 text-sm mt-1 mb-3">{{ $message }}</p> @enderror
                            
                            <select name="participant_type" class="w-full px-4 py-3 rounded-xl text-slate-900 text-base font-medium focus:outline-none focus:ring-2 focus:ring-white/50" required>
                                <option value="" disabled selected>Pilih Kategori Peserta</option>
                                <option value="Mahasiswa/Alumni USH">Mahasiswa/Alumni USH</option>
                                <option value="Umum">Umum</option>
                            </select>
                            @error('participant_type') <p class="text-red-200 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="px-6 py-3 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition flex items-center gap-2 justify-center mt-2">
                            <i class="fa-solid fa-arrow-right"></i> Mulai
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Sudah input NIK --}}
            <div class="mb-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
                <!-- Dekor kiri atas (kecil) -->
                <div class="absolute top-0 left-0 w-40 h-40 bg-white/8 rounded-full -ml-20 -mt-20"></div>
                <!-- Dekor kanan bawah (besar, di belakang ilustrasi) -->
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full -mr-28 -mb-28"></div>
                <!-- Illustration -->
                <div class="absolute bottom-0 right-0 -mr-4 hidden sm:flex items-end justify-end h-full pointer-events-none select-none" aria-hidden="true">
                    <img src="{{ asset('template/template2.png') }}" alt="" class="h-40 md:h-48 w-auto object-bottom drop-shadow-2xl opacity-95 -mb-3" draggable="false">
                </div>
                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:max-w-lg">
                    <div>
                        <h2 class="text-2xl font-bold mb-1">Halo, {{ $participant->name ?? 'Peserta' }}! <span class="text-blue-200 text-base font-normal">NIK: {{ $nik }}</span></h2>
                        <p class="text-blue-100">Anda telah melamar ke <strong>{{ count($appliedPositionIds) }}</strong> posisi. Sisa kuota: <strong>{{ 12 - count($appliedPositionIds) }}</strong> lamaran.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/10">
                            <i class="fa-solid fa-briefcase"></i>
                            <span class="font-medium">{{ $companies->count() }} Perusahaan</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/10">
                            <i class="fa-solid fa-file-circle-check"></i>
                            <span class="font-medium">{{ count($appliedPositionIds) }}/12 Dilamar</span>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endif

        {{-- Companies Grid --}}
        @if($companies->isEmpty())
            <div class="text-center py-20 text-slate-400">
                <div class="text-6xl mb-4"></div>
                <p class="text-lg font-medium">Belum ada perusahaan yang bergabung.</p>
            </div>
        @else
            <h2 class="text-xl font-bold text-slate-800 mb-5">Daftar Perusahaan</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($companies as $company)
                @php 
                    $isApplied     = $company->positions->whereIn('id', $appliedPositionIds)->isNotEmpty();
                    $posCount      = $company->positions->count();
                    $appliedCount  = $company->positions->whereIn('id', $appliedPositionIds)->count();
                @endphp
                <a href="{{ route('participant.company.show', $company->id) }}"
                   class="flex flex-col bg-white rounded-2xl border {{ $isApplied ? 'border-emerald-300 ring-2 ring-emerald-400/30' : 'border-slate-200/60' }} overflow-hidden hover-card relative group cursor-pointer">

                    {{-- Applied badge --}}
                    @if($isApplied)
                    <div class="absolute top-0 left-0 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold px-3 py-1 rounded-br-lg flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-[10px]"></i> Sudah Dilamar
                    </div>
                    @endif

                    <div class="p-5 flex-1 flex flex-col {{ $isApplied ? 'pt-8' : '' }}">

                        {{-- Logo + Nama --}}
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-12 w-12 rounded-xl bg-white border border-slate-100 flex items-center justify-center shadow-sm flex-shrink-0 overflow-hidden p-1 {{ $isApplied ? 'ring-2 ring-emerald-300' : '' }}" style="min-width:48px;">
                                <img src="{{ $company->logo_path ? asset('storage/' . $company->logo_path) : asset('images/default-company-logo.png') }}" alt="{{ $company->name }}" class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-bold text-slate-800 line-clamp-2 leading-tight {{ $isApplied ? 'text-emerald-700' : 'group-hover:text-blue-600' }} transition-colors">
                                    {{ $company->name }}
                                </h3>
                            </div>
                        </div>

                        {{-- Badge Posisi: max 2 + sisanya --}}
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($company->positions->take(2) as $pos)
                                @php $isPosApplied = in_array($pos->id, $appliedPositionIds); @endphp
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1 whitespace-nowrap border
                                    {{ $isPosApplied ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                                    <i class="fa-solid fa-briefcase text-[9px]"></i>
                                    {{ Str::limit($pos->name, 20) }}
                                    @if($isPosApplied)<i class="fa-solid fa-check text-[9px]"></i>@endif
                                </span>
                            @endforeach
                            @if($posCount > 2)
                                <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                    +{{ $posCount - 2 }} lainnya
                                </span>
                            @endif
                        </div>

                        {{-- Lokasi Perusahaan --}}
                        @php
                            $companyLocation = $company->positions->whereNotNull('location')->first();
                        @endphp
                        @if($companyLocation)
                            <div class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs text-emerald-700 bg-emerald-50 border border-emerald-500 mb-3 font-medium px-2.5 py-1 rounded-md w-fit">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $companyLocation->location }}
                            </div>
                        @endif

                        {{-- Deskripsi --}}
                        <p class="text-xs text-slate-500 line-clamp-2 mb-3 leading-relaxed flex-1">
                            {{ $company->description ?? 'Informasi perusahaan belum tersedia.' }}
                        </p>

                        {{-- Info Chips --}}
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="inline-flex items-center gap-1 text-[10px] bg-slate-50 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-lg">
                                <i class="fa-solid fa-briefcase text-slate-400"></i> {{ $posCount }} Posisi
                            </span>
                            @if($isApplied)
                            <span class="inline-flex items-center gap-1 text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg">
                                <i class="fa-solid fa-check-double"></i> {{ $appliedCount }}/{{ $posCount }} Dilamar
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-[10px] bg-slate-50 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-lg">
                                <i class="fa-solid fa-users text-slate-400"></i> {{ $company->applications()->count() }} Pelamar
                            </span>
                            @endif
                        </div>

                        <hr class="border-slate-100 mb-3">

                        <div class="w-full py-2.5 rounded-xl font-medium text-sm flex items-center justify-center gap-2 transition-all
                            {{ $isApplied
                                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                : 'bg-slate-50 text-slate-700 border border-slate-200 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600' }}">
                            @if($isApplied)
                                <i class="fa-solid fa-circle-check"></i> Sudah Dilamar
                            @else
                                <i class="fa-solid fa-paper-plane text-xs"></i> Lihat &amp; Lamar
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </main>

    <script>
        // Sync applied IDs to localStorage for welcome page indicator
        const appliedIdsFromServer = @json($appliedPositionIds);
        try {
            const stored = JSON.parse(localStorage.getItem('jobfair_applied') || '[]');
            const merged = [...new Set([...stored, ...appliedIdsFromServer])];
            localStorage.setItem('jobfair_applied', JSON.stringify(merged));

            @if(session('applied_position_id'))
            // Mark newly applied position
            if (!merged.includes({{ session('applied_position_id') }})) {
                merged.push({{ session('applied_position_id') }});
                localStorage.setItem('jobfair_applied', JSON.stringify(merged));
            }
            @endif
        } catch(e) {}
    </script>
    <x-bottom-nav active="companies" />
    <x-qr-modal :participant="$participant ?? null" :nik="$nik ?? null" />
</body>
</html>
