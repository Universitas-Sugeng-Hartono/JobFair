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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50 text-slate-900">

    <!-- Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('participant.index') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm text-slate-500">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Kembali</h1>
                        <p class="text-xs text-slate-500">ke Daftar Perusahaan</p>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    @if($nik)
                        <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-50 to-violet-50 border border-blue-100">
                            <i class="fa-solid fa-id-card text-blue-600 text-sm"></i>
                            <span class="text-sm font-medium text-slate-700">NIK: <span class="text-blue-600 font-bold">{{ $nik }}</span></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        
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

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-8">
            {{-- Header Perusahaan --}}
            <div class="px-6 sm:px-10 py-8">
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="h-24 w-24 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-5xl shadow-sm flex-shrink-0 p-2">
                        <img src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }}" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">{{ $company->name }}</h2>
                        @if($company->description)
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $company->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-bold text-slate-800 mb-5">Daftar Posisi Tersedia</h3>

        @php
            $hasAppliedToCompany = count(array_intersect($companyPositions->pluck('id')->toArray(), $appliedPositionIds)) > 0;
        @endphp

        @foreach($companyPositions as $pos)
        @php
            $isPosApplied = in_array($pos->id, $appliedPositionIds);
        @endphp
        <div class="bg-white rounded-3xl shadow-lg border {{ $isPosApplied ? 'border-emerald-300 ring-2 ring-emerald-100' : 'border-slate-100' }} overflow-hidden mb-8">
            {{-- Header Posisi --}}
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded-xl">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-800">{{ $pos->name ?? 'Posisi Umum' }}</h4>
                        <div class="flex gap-2 text-xs mt-1">
                            @if($pos->selection)
                                <span class="text-slate-500"><i class="fa-solid fa-clipboard-check mr-1"></i>{{ $pos->selection }}</span>
                            @endif
                            @if($pos->time_to_answer)
                                <span class="text-slate-500 ml-2"><i class="fa-regular fa-clock mr-1"></i>{{ $pos->time_to_answer }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($isPosApplied)
                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-full text-sm font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-check"></i> Sudah Dilamar
                    </span>
                @endif
            </div>

            {{-- Body --}}
            <div class="px-6 sm:px-8 py-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Info Posisi --}}
                <div class="space-y-6">
                    @if($pos->job_responsibilities)
                        <div>
                            <h5 class="font-bold text-slate-900 mb-2 flex items-center gap-2">
                                Job Responsibilities
                            </h5>
                            <p class="text-sm text-slate-600 whitespace-pre-line pl-5 leading-relaxed border-l-2 border-slate-200">{{ $pos->job_responsibilities }}</p>
                        </div>
                    @endif

                    @if($pos->requirements)
                        <div>
                            <h5 class="font-bold text-slate-900 mb-2 flex items-center gap-2">
                                Requirements
                            </h5>
                            <p class="text-sm text-slate-600 whitespace-pre-line pl-5 leading-relaxed border-l-2 border-slate-200">{{ $pos->requirements }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer Aksi --}}
            <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end">
                @if(!$nik)
                    <button type="button" disabled class="px-6 py-2.5 rounded-xl text-slate-500 font-semibold text-sm bg-slate-200 cursor-not-allowed" title="Silakan login dengan NIK di halaman utama">
                        <i class="fa-solid fa-lock mr-2"></i> Login untuk Melamar
                    </button>
                @else
                    @if($isPosApplied)
                        <button type="button" disabled class="px-6 py-2.5 rounded-xl text-emerald-700 font-semibold text-sm bg-emerald-100 border border-emerald-200 cursor-not-allowed">
                            <i class="fa-solid fa-check mr-2"></i> Sudah Dilamar
                        </button>
                    @elseif($hasAppliedToCompany)
                        <button type="button" disabled class="px-6 py-2.5 rounded-xl text-slate-500 font-semibold text-sm bg-slate-100 border border-slate-200 cursor-not-allowed" title="Anda hanya bisa melamar 1 posisi per perusahaan.">
                            <i class="fa-solid fa-ban mr-2"></i> Batas 1 Posisi
                        </button>
                    @else
                        <a href="{{ route('participant.apply', $pos->id) }}" class="px-6 py-2.5 rounded-xl text-white font-semibold text-sm bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-500/25 transition-all flex items-center gap-2">
                            Lamar Posisi Ini <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endif
                @endif
            </div>
        </div>
        </div>
        @endforeach
    </main>
    <x-bottom-nav active="companies" />
</body>
</html>
