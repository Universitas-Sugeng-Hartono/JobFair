<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company->name }} - JobFair 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .rich-text ul { list-style-type: disc; padding-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .rich-text ol { list-style-type: decimal; padding-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .rich-text li { margin-bottom: 0.25rem; }
        .rich-text p { margin-bottom: 0.5rem; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 pb-20">

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('participant.index') }}" class="flex items-center gap-3 hover:opacity-80 transition group">
                    <div class="h-10 w-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center shadow-sm text-slate-600 group-hover:bg-slate-100 group-hover:text-slate-900 transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 leading-tight">Kembali</h1>
                        <p class="text-xs text-slate-500 font-medium">ke Daftar Perusahaan</p>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    @if($nik)
                        <button onclick="document.getElementById('qrModal').classList.remove('hidden')" class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 hover:shadow-md transition cursor-pointer shadow-sm text-indigo-700">
                            <i class="fa-solid fa-qrcode text-sm"></i>
                            <span class="hidden sm:inline text-sm font-semibold">QR Code</span>
                        </button>
                        <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-white shadow-sm border border-slate-200">
                            <i class="fa-solid fa-id-card text-blue-600 text-sm"></i>
                            <span class="text-sm font-medium text-slate-600">NIK: <span class="text-slate-900 font-bold">{{ $nik }}</span></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-300 text-red-800 px-5 py-4 rounded-2xl shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-xl"></i>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Header Perusahaan --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden mb-8 transform transition hover:shadow-2xl">
            <div class="px-6 sm:px-10 py-8">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
                    <div class="h-28 w-28 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-5xl shadow-md flex-shrink-0 p-3">
                        <img src="{{ $company->logo_path ? asset('storage/' . $company->logo_path) : asset('images/default-company-logo.png') }}" alt="{{ $company->name }}" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">{{ $company->name }}</h2>
                        @php
                            $companyLocation = $companyPositions->whereNotNull('location')->first();
                        @endphp
                        @if($companyLocation)
                            <div class="inline-flex items-center justify-center sm:justify-start gap-2 text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 mb-4 font-bold px-3 py-1.5 rounded-lg w-fit shadow-sm">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $companyLocation->location }}
                            </div>
                        @endif
                        @if($company->description)
                            <p class="text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto sm:mx-0 text-justify sm:text-left">{{ $company->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-briefcase text-slate-400"></i> Posisi yang Tersedia
        </h3>

        @php
            $hasAppliedToCompany = count(array_intersect($companyPositions->pluck('id')->toArray(), $appliedPositionIds)) > 0;
        @endphp

        @if($hasAppliedToCompany || (isset($alreadyAppliedToThisCompany) && $alreadyAppliedToThisCompany))
            <div class="mb-8 flex items-start gap-3 bg-amber-50 border border-amber-300 text-amber-900 px-5 py-4 rounded-2xl shadow-md">
                <i class="fa-solid fa-circle-info text-amber-500 text-xl mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-base mb-1">Anda sudah melamar di perusahaan ini</h4>
                    <p class="text-sm font-medium opacity-90">Sesuai ketentuan, setiap peserta hanya diperbolehkan melamar maksimal 1 (satu) posisi untuk setiap perusahaan.</p>
                </div>
            </div>
        @endif

        <div class="space-y-5">
            @foreach($companyPositions as $pos)
            @php
                $isPosApplied = in_array($pos->id, $appliedPositionIds);
            @endphp
            <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 border {{ $isPosApplied ? 'border-emerald-400 ring-2 ring-emerald-100' : 'border-slate-200' }} overflow-hidden">
                {{-- Header Posisi (Clickable) --}}
                <div @click="open = !open" class="px-6 py-5 cursor-pointer flex flex-col sm:flex-row sm:items-center justify-between gap-4 select-none hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div>
                            <h4 class="text-lg font-bold text-slate-800">{{ $pos->name ?? 'Posisi Umum' }}</h4>
                            <div class="flex flex-wrap gap-2 text-xs mt-2 font-semibold">
                                @if($pos->selection)
                                    <span class="text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-md shadow-sm"><i class="fa-solid fa-clipboard-check mr-1 text-slate-400"></i>{{ $pos->selection }}</span>
                                @endif
                                @if($pos->time_to_answer)
                                    <span class="text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-md shadow-sm"><i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ $pos->time_to_answer }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 sm:justify-end">
                        @if($isPosApplied)
                            <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 px-3 py-1.5 rounded-full text-sm font-bold flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                <i class="fa-solid fa-check"></i> Sudah Dilamar
                            </span>
                        @endif
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-transform duration-300 border border-slate-200 shadow-sm" :class="open ? 'rotate-180 bg-indigo-100 text-indigo-600 border-indigo-200' : ''">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                {{-- Body (Expandable) --}}
                <div x-show="open" x-collapse x-cloak>
                    <div class="px-6 sm:px-8 py-6 bg-slate-50 border-t border-slate-200">
                        {{-- Info Posisi --}}
                        <div class="space-y-6">
                            @if($pos->job_responsibilities)
                                <div>
                                    <h5 class="font-bold text-slate-800 mb-3 flex items-center gap-2 text-sm uppercase tracking-wider">
                                        Job Responsibilities
                                    </h5>
                                    <div class="text-sm text-slate-600 pl-6 border-l-2 border-indigo-200 rich-text">{!! $pos->job_responsibilities !!}</div>
                                </div>
                            @endif

                            @if($pos->requirements)
                                <div>
                                    <h5 class="font-bold text-slate-800 mb-3 flex items-center gap-2 text-sm uppercase tracking-wider">
                                        Requirements
                                    </h5>
                                    <div class="text-sm text-slate-600 pl-6 border-l-2 border-amber-200 rich-text">{!! $pos->requirements !!}</div>
                                </div>
                            @endif
                            
                            @if(!$pos->job_responsibilities && !$pos->requirements)
                                <p class="text-sm text-slate-500 italic">Tidak ada deskripsi spesifik untuk posisi ini.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Footer Aksi --}}
                    <div class="px-6 sm:px-8 py-5 bg-white border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-slate-500 font-medium">Tertarik dengan posisi ini? Pastikan Anda telah membaca persyaratan.</p>                        @if(!$nik)
                            <button type="button" disabled class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-slate-500 font-bold text-sm bg-slate-100 border border-slate-200 cursor-not-allowed shadow-sm" title="Silakan login dengan NIK di halaman utama">
                                <i class="fa-solid fa-lock mr-2"></i> Login untuk Melamar
                            </button>
                        @else
                            @if($isPosApplied)
                                <button type="button" disabled class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-emerald-800 font-bold text-sm bg-emerald-100 border border-emerald-300 cursor-not-allowed shadow-sm">
                                    <i class="fa-solid fa-check mr-2"></i> Sudah Dilamar
                                </button>
                            @elseif($hasAppliedToCompany)
                                <button type="button" disabled class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-slate-500 font-bold text-sm bg-slate-100 border border-slate-300 cursor-not-allowed shadow-sm" title="Anda hanya bisa melamar 1 posisi per perusahaan.">
                                    <i class="fa-solid fa-ban mr-2"></i> Batas 1 Posisi Penuh
                                </button>
                            @else
                                <a href="{{ route('participant.apply', $pos->id) }}" class="w-full sm:w-auto px-8 py-3 rounded-xl text-white font-bold text-sm bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                                    Lamar Posisi Ini <i class="fa-solid fa-paper-plane ml-1"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
    <x-bottom-nav active="companies" />
    <x-qr-modal :participant="$participant ?? null" :nik="$nik ?? null" />
</body>
</html>
