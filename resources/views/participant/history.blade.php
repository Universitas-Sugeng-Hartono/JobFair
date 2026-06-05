<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lamaran - JobFair 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 flex flex-col pb-10">

    <!-- Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('participant.index') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm text-slate-500">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Riwayat</h1>
                        <p class="text-xs text-slate-500">Lamaran Saya</p>
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

    <main class="max-w-4xl w-full mx-auto px-4 sm:px-6 py-8">
        @if(!$nik)
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 text-center">
                <div class="w-20 h-20 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fa-solid fa-user-lock"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">Anda Belum Masuk</h2>
                <p class="text-slate-500 mb-6">Silakan mendaftar atau masukkan NIK Anda di halaman utama untuk melihat riwayat lamaran.</p>
                <a href="{{ url('/peserta') }}" class="inline-flex items-center justify-center h-12 px-8 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-lg shadow-blue-500/30">
                    Ke Halaman Utama
                </a>
            </div>
        @else
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Lamaran Terkirim</h2>
                    <p class="text-slate-500 text-sm mt-1">Anda telah mengirimkan lamaran untuk <span class="font-bold text-blue-600">{{ count($applications) }}</span> posisi</p>
                </div>
            </div>

            @if(count($applications) == 0)
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
                    <div class="w-20 h-20 bg-slate-50 border border-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-slate-500 mb-6">Anda belum melamar ke perusahaan manapun. Mulai cari perusahaan impian Anda sekarang!</p>
                    <a href="{{ route('participant.index') }}" class="inline-flex items-center justify-center h-11 px-6 font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all border border-blue-200">
                        Cari Lowongan
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($applications as $application)
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center gap-5">
                            <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-xl bg-white border border-slate-100 flex items-center justify-center shadow-sm p-2 flex-shrink-0">
                                @if($application->position && $application->position->company->logo_path)
                                    <img src="{{ asset('storage/' . $application->position->company->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
                                @else
                                    <i class="fa-regular fa-building text-2xl text-slate-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $application->position->name ?? 'Posisi Tidak Diketahui' }}</h3>
                                <p class="text-slate-500 text-sm mb-3 font-medium">{{ $application->position->company->name ?? '-' }}</p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg">
                                        <i class="fa-regular fa-clock"></i> {{ $application->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 mt-3 sm:mt-0">
                                <div class="px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-sm flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-circle-check"></i> Lamaran Terkirim
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </main>

    <x-bottom-nav active="history" />
</body>
</html>
