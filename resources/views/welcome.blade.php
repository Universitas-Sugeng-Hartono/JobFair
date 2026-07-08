<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobFair 2026 - Wujudkan Karir Impianmu</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'infinite-scroll': 'scroll 22s linear infinite',
                    },
                    keyframes: {
                        scroll: {
                            '0%':   { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Carousel */
        .carousel-track { animation: scroll 22s linear infinite; }
        .carousel-track:hover { animation-play-state: paused; }

        @keyframes scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Mobile menu */
        #mobile-menu { display: none; }
        #mobile-menu.open { display: flex; }

        /* Company card hover effect */
        .hover-card { transition: all 0.3s ease; box-shadow: 0 4px 16px -2px rgba(0,0,0,0.10), 0 2px 6px -1px rgba(0,0,0,0.07); }
        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 24px 40px -8px rgba(0,0,0,0.16), 0 10px 16px -4px rgba(0,0,0,0.10); }

        /* Applied badge pulse */
        @keyframes pulse-green { 0%,100%{opacity:1} 50%{opacity:.7} }
        .badge-applied { animation: pulse-green 2s infinite; }

        /* Megaphone bob animation */
        @keyframes megaphone-bob {
            0%, 100% { transform: translateY(0) rotate(-8deg); }
            50%       { transform: translateY(-8px) rotate(-4deg); }
        }

        /* Rich text styling for CKEditor content */
        .rich-text ul { list-style-type: disc; padding-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .rich-text ol { list-style-type: decimal; padding-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .rich-text li { margin-bottom: 0.25rem; }
        .rich-text p { margin-bottom: 0.5rem; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">

    <!-- ===== NAVIGATION ===== -->
    <nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    @if(!empty($settings['logo_image']))
                        <img src="{{ !empty($settings['logo_image']) ? asset('storage/' . $settings['logo_image']) : asset('images/default-logo.png') }}" alt="Logo" class="h-8 sm:h-10 object-contain">
                    @else
                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <i class="fa-solid fa-briefcase text-white text-xs sm:text-sm"></i>
                        </div>
                    @endif
                    <h1 class="text-base sm:text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                        {{ $settings['logo_text'] ?? 'JobFair 2026' }}
                    </h1>
                </a>

                <!-- Desktop Button -->
                <div class="hidden sm:block">
                    <a href="{{route('participant.index')}}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 rounded-lg shadow-md transition-all">
                        Daftar Sekarang
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Mobile Hamburger -->
                <button id="hamburger-btn" onclick="toggleMenu()" class="sm:hidden h-10 w-10 rounded-lg flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                    <i id="hamburger-icon" class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Mobile Dropdown -->
            <div id="mobile-menu" class="flex-col gap-2 pb-4 pt-3 border-t border-slate-100">
                <a href="{{route('participant.index')}}" class="flex items-center justify-center gap-2 w-full py-3 px-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 rounded-xl shadow-md">
                    <i class="fa-solid fa-arrow-right"></i> Daftar Sekarang
                </a>
                <a href="#features" onclick="toggleMenu()" class="flex items-center gap-2 py-2.5 px-4 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-star text-slate-400"></i> Keunggulan Platform
                </a>
                <a href="#how-it-works" onclick="toggleMenu()" class="flex items-center gap-2 py-2.5 px-4 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-list-check text-slate-400"></i> Cara Kerja
                </a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 via-blue-400/5 to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 lg:py-20">
            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">

                <!-- Left: Text Content -->
                <div class="space-y-4 sm:space-y-6 lg:space-y-8 w-full">
                    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-3 sm:px-4 py-1.5 sm:py-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-blue-600 text-xs sm:text-sm"></i>
                        <span class="text-xs sm:text-sm font-medium text-blue-900">{{ $settings['hero_label'] ?? 'Informasi Event' }}</span>
                    </div>

                    <div class="space-y-3 sm:space-y-4">
                        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-bold leading-tight">
                            <span class="text-slate-900">
                                {{ $settings['hero_title'] ?? 'Event Career Terbesar 2026' }}
                            </span>
                            <br>
                            <span class="inline-flex items-center gap-2 sm:gap-3">
                                <span class="text-blue-700">
                                    {{ $settings['hero_subtitle'] ?? 'Wujudkan Karir Impianmu' }}
                                </span>
                                <img src="{{ asset('template/template4.png') }}"
                                     alt=""
                                     class="inline-block w-10 sm:w-14 lg:w-16 xl:w-20 drop-shadow-xl -mb-1 pointer-events-none select-none"
                                     draggable="false"
                                     style="animation: megaphone-bob 3s ease-in-out infinite;">
                            </span>
                        </h2>
                        <p class="text-sm sm:text-base lg:text-lg xl:text-xl text-slate-600 leading-relaxed">
                            {{ $settings['hero_description'] ?? 'Bergabunglah dengan JobFair 2026 dan temukan peluang karir dari 13+ perusahaan terkemuka di Indonesia. Satu platform, ribuan peluang.' }}
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="{{route('participant.index')}}" class="inline-flex items-center justify-center h-11 sm:h-12 lg:h-14 px-5 sm:px-6 lg:px-8 text-sm sm:text-base lg:text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 rounded-xl shadow-xl shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                            Mulai Sekarang
                            <i class="fa-solid fa-arrow-right ml-2 text-sm sm:text-base"></i>
                        </a>
                       
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center gap-3 sm:gap-4 md:gap-6 lg:gap-8 pt-2 flex-wrap">
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $settings['stat_1_value'] ?? '13+' }}</div>
                            <div class="text-xs sm:text-sm text-slate-500 font-medium">{{ $settings['stat_1_label'] ?? 'Perusahaan' }}</div>
                        </div>
                        <div class="w-px h-8 sm:h-10 bg-slate-200 hidden sm:block"></div>
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $settings['stat_2_value'] ?? '250' }}</div>
                            <div class="text-xs sm:text-sm text-slate-500 font-medium">{{ $settings['stat_2_label'] ?? 'Kuota Peserta' }}</div>
                        </div>
                        <div class="w-px h-8 sm:h-10 bg-slate-200 hidden sm:block"></div>
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-emerald-500 to-teal-500 bg-clip-text text-transparent">{{ $settings['stat_3_value'] ?? '100%' }}</div>
                            <div class="text-xs sm:text-sm text-slate-500 font-medium">{{ $settings['stat_3_label'] ?? 'Gratis' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Illustration -->
                <div class="relative w-full flex items-center justify-center">
                    <!-- Glow background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/15 to-blue-400/15 rounded-3xl blur-3xl"></div>

                    <!-- Floating stats card top-left -->
                    <div class="absolute top-4 left-0 sm:left-4 z-10 bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-100 px-3 sm:px-4 py-2 sm:py-3 flex items-center gap-2 sm:gap-3">
                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-regular fa-building text-white text-xs sm:text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm sm:text-base font-bold text-slate-900 leading-tight">{{ $companies->count() }}+</div>
                            <div class="text-[10px] sm:text-xs text-slate-500">Perusahaan</div>
                        </div>
                    </div>

                    <!-- Floating stats card bottom-right -->
                    <div class="absolute bottom-4 right-0 sm:right-4 z-10 bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-100 px-3 sm:px-4 py-2 sm:py-3 flex items-center gap-2 sm:gap-3">
                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-circle-check text-white text-xs sm:text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm sm:text-base font-bold text-slate-900 leading-tight">100%</div>
                            <div class="text-[10px] sm:text-xs text-slate-500">Gratis</div>
                        </div>
                    </div>

                    <div class="absolute bottom-14 sm:bottom-16 left-0 right-0 z-10 overflow-hidden px-2"
                         style="mask-image: linear-gradient(to right, transparent 0%, black 15%, black 85%, transparent 100%);
                                -webkit-mask-image: linear-gradient(to right, transparent 0%, black 15%, black 85%, transparent 100%);">
                        <div class="carousel-track flex gap-4 w-max py-2">
                            @foreach($companies as $item)
                            <div class="w-16 h-16 sm:w-24 sm:h-24 flex-shrink-0 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-base sm:text-xl shadow-lg overflow-hidden p-1.5">
                                <img src="{{ $item->logo_path ? asset('storage/' . $item->logo_path) : asset('images/default-company-logo.png') }}" alt="{{ $item->name }}" class="w-full h-full object-contain drop-shadow-sm">
                            </div>
                            @endforeach
                            @foreach($companies as $item)
                            <div class="w-16 h-16 sm:w-24 sm:h-24 flex-shrink-0 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-base sm:text-xl shadow-lg overflow-hidden p-1.5">
                                <img src="{{ $item->logo_path ? asset('storage/' . $item->logo_path) : asset('images/default-company-logo.png') }}" alt="{{ $item->name }}" class="w-full h-full object-contain drop-shadow-sm">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Main illustration -->
                    @if(!empty($settings['hero_image']))
                        <img src="{{ !empty($settings['hero_image']) ? asset('storage/' . $settings['hero_image']) : asset('template/template2.png') }}"
                             alt="JobFair Illustration"
                             class="relative z-0 w-full max-w-xs sm:max-w-sm lg:max-w-md xl:max-w-lg drop-shadow-2xl select-none pb-16 sm:pb-20"
                             draggable="false">
                    @else
                        <img src="{{ asset('template/template2.png') }}"
                             alt="JobFair Illustration"
                             class="relative z-0 w-full max-w-xs sm:max-w-sm lg:max-w-md xl:max-w-lg drop-shadow-2xl select-none pb-16 sm:pb-20"
                             draggable="false">
                    @endif
                </div>

            </div>
        </div>
    </section>
    
        <!-- ===== EVENT INFO & LOCATION ===== -->
    <section id="event-info" class="py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10 sm:mb-16">
                <span class="inline-block mb-3 sm:mb-4 bg-violet-100 text-violet-900 text-xs font-semibold px-3 py-1 rounded-full">
                    Informasi Acara
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-3 sm:mb-4 px-4">Detail Pelaksanaan JobFair</h2>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                <!-- Kiri: Informasi Lokasi -->
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Informasi Lokasi</h3>
                    </div>
                    
                    <div class="space-y-4 text-slate-600">
                        <p class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-1 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span><strong>{{ $settings['event_location'] ?? 'Universitas Sugeng Hartono' }}</strong><br>{{ $settings['event_location_desc'] ?? 'Jl. Raya Solo - Baki, Sukoharjo, Jawa Tengah' }}</span>
                        </p>
                        <p class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-1 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span><strong>Tanggal Pelaksanaan:</strong><br>{{ $settings['event_date'] ?? '3 - 10 Juni 2026' }}</span>
                        </p>
                        <p class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-1 text-violet-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span><strong>Waktu:</strong><br>{{ $settings['event_time'] ?? '08.00 WIB - Selesai' }}</span>
                        </p>
                    </div>

                    <div class="mt-8 rounded-xl overflow-hidden shadow-inner border border-slate-100">
                        <div class="bg-slate-100 aspect-video flex items-center justify-center overflow-hidden">
                            <iframe 
                                src="{{ $settings['event_maps_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.9126607212456!2d110.803875!3d-7.5844883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a15ec7abf2ad3%3A0x6b8dd829dd868cd7!2sUniversitas%20Sugeng%20Hartono!5e0!3m2!1sen!2sid!4v1717462000000!5m2!1sen!2sid' }}" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Deskripsi Acara -->
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10 border border-slate-100 h-full">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Deskripsi Acara</h3>
                    </div>

                    <div class="prose prose-slate prose-sm sm:prose-base text-slate-600">
                        {!! $settings['event_description'] ?? '
                        <p class="mb-4">
                            <strong>JobFair Universitas Sugeng Hartono</strong> adalah wadah pertemuan strategis antara para pencari kerja (alumni, mahasiswa tingkat akhir, dan masyarakat umum) dengan perusahaan-perusahaan terkemuka yang sedang mencari talenta terbaik.
                        </p>
                        <p class="mb-4">
                            Acara ini bertujuan untuk memfasilitasi penyerapan tenaga kerja secara efektif dan efisien. Para peserta dapat berinteraksi langsung dengan perwakilan HR dari berbagai perusahaan, mendapatkan wawasan mengenai dunia kerja, serta melamar posisi yang sesuai dengan minat dan kompetensi mereka.
                        </p>
                        <h4 class="text-lg font-semibold text-slate-800 mt-6 mb-3">Langkah-Langkah Mengikuti JobFair</h4>
                        <ol class="space-y-2 list-decimal list-inside">
                            <li>Lakukan pendaftaran dengan memasukkan NIK dan Nama Anda.</li>
                            <li>Eksplorasi berbagai perusahaan dan posisi menarik yang tersedia.</li>
                            <li>Lamar posisi yang sesuai dengan minat dan kualifikasi Anda.</li>
                            <li>Anda diperbolehkan melamar ke <strong>lebih dari 1 perusahaan</strong>!</li>
                            <li>Hadir di lokasi JobFair sesuai jadwal untuk mengikuti proses seleksi selanjutnya.</li>
                        </ol>
                        ' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== FEATURES SECTION (Perusahaan Dinamis) ===== -->
    <section id="features" class="py-12 sm:py-16 lg:py-20 bg-white/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10 sm:mb-16">
                <span class="inline-block mb-3 sm:mb-4 bg-blue-100 text-blue-900 text-xs font-semibold px-3 py-1 rounded-full">
                    Perusahaan Peserta
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-3 sm:mb-4 px-4">Temukan Perusahaan Impianmu</h2>
                <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-2xl mx-auto px-4">
                </p>
            </div>

            @if($companies->isEmpty())
                <div class="text-center py-16 text-slate-500">
                    <div class="text-5xl mb-4">🏢</div>
                    <p class="text-lg font-medium">Belum ada perusahaan yang bergabung.</p>
                    <p class="text-sm mt-1">Periksa kembali beberapa saat lagi.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($companies as $company)
                    @php $positionCount = $company->positions->count(); @endphp
                    <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200 overflow-hidden hover-card cursor-pointer group relative flex flex-col"
                         onclick="window.location.href='/peserta'">

                        <div class="p-4 sm:p-5 flex-1 flex flex-col">
                            <!-- Logo + Nama -->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="h-12 w-12 sm:h-13 sm:w-13 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center shadow-sm flex-shrink-0 overflow-hidden p-1" style="width:52px;height:52px;">
                                    @if($company->logo_path && !Str::startsWith($company->logo_path, ['🏢','💻','🎨','🏦','🏭','🌏']))
                                        <img src="{{ $company->logo_path ? asset('storage/' . $company->logo_path) : asset('images/default-company-logo.png') }}" alt="{{ $company->name }}" class="w-full h-full object-contain">
                                    @else
                                        <span class="text-2xl">{{ $company->logo_path ?? '' }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-800 line-clamp-2 group-hover:text-blue-600 transition-colors leading-tight">
                                        {{ $company->name }}
                                    </h3>
                                </div>
                            </div>

                            <!-- Badge Posisi: max 2, sisanya +N lagi -->
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($company->positions->take(2) as $pos)
                                    <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] sm:text-xs font-semibold px-2 py-0.5 rounded-full flex items-center gap-1 whitespace-nowrap">
                                        <i class="fa-solid fa-briefcase text-[9px]"></i> {{ Str::limit($pos->name, 22) }}
                                    </span>
                                @endforeach
                                @if($positionCount > 2)
                                    <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] sm:text-xs font-semibold px-2 py-0.5 rounded-full flex items-center whitespace-nowrap">
                                        +{{ $positionCount - 2 }} lainnya
                                    </span>
                                @endif
                            </div>

                            <!-- Lokasi Perusahaan -->
                            @php
                                $companyLocation = $company->positions->whereNotNull('location')->first();
                            @endphp
                            @if($companyLocation)
                                <div class="flex items-center gap-1.5 text-[11px] sm:text-xs text-slate-500 mb-3 font-medium">
                                    <i class="fa-solid fa-location-dot text-emerald-500"></i>
                                    {{ $companyLocation->location }}
                                </div>
                            @endif

                            <!-- Deskripsi -->
                            <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                                {{ $company->description ?? 'Informasi perusahaan belum tersedia.' }}
                            </p>

                            <!-- Info chips -->
                            <div class="flex gap-2 mb-3 mt-auto">
                                <span class="inline-flex items-center gap-1 text-[10px] sm:text-xs bg-slate-50 text-slate-600 border border-slate-200 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg">
                                    <i class="fa-solid fa-briefcase text-slate-400"></i>
                                    {{ $positionCount }} Posisi
                                </span>
                                <span class="inline-flex items-center gap-1 text-[10px] sm:text-xs bg-slate-50 text-slate-600 border border-slate-200 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg">
                                    <i class="fa-solid fa-users text-slate-400"></i>
                                    {{ $company->applications()->count() }} Pelamar
                                </span>
                            </div>

                            <hr class="border-slate-100 mb-3">

                            <button class="w-full py-2 sm:py-2.5 rounded-lg sm:rounded-xl bg-slate-50 text-slate-700 text-sm font-medium hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center gap-2 border border-slate-200 hover:border-blue-600">
                                Lihat Detail &amp; Lamar
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- ===== COMPANY MODAL ===== -->
    <div id="companyModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCompanyModal()"></div>
        <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl w-full sm:max-w-2xl border-t sm:border border-slate-100 max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="px-4 sm:px-8 py-5 sm:py-7 border-b border-slate-100 bg-slate-50/50 sticky top-0 z-10">
                    <div class="flex items-start gap-3 sm:gap-5">
                        <div id="modalLogo" class="h-14 w-14 sm:h-20 sm:w-20 rounded-xl sm:rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-3xl sm:text-5xl shadow-sm flex-shrink-0">🏢</div>
                        <div class="flex-1 pt-0 sm:pt-1 min-w-0">
                            <h3 id="modalTitle" class="text-lg sm:text-2xl font-bold text-slate-900 mb-2 sm:mb-3 line-clamp-2">-</h3>
                            <div id="modalBadges" class="flex flex-wrap gap-1.5 sm:gap-2 text-xs"></div>
                        </div>
                        <button onclick="closeCompanyModal()" class="text-slate-400 hover:text-slate-700 bg-white hover:bg-slate-100 h-8 w-8 sm:h-10 sm:w-10 rounded-full flex items-center justify-center transition-colors border border-slate-200 flex-shrink-0">
                            <i class="fa-solid fa-xmark text-sm sm:text-lg"></i>
                        </button>
                    </div>
                </div>
                <!-- Modal Body -->
                <div class="px-4 sm:px-8 py-6 sm:py-8 space-y-5 sm:space-y-6">
                    <div id="modalDescription"></div>
                    <div id="modalResponsibilities"></div>
                    <div id="modalRequirements"></div>
                    <div class="pt-2 border-t border-slate-100">
                        <a href="/peserta" class="w-full h-12 sm:h-14 rounded-xl sm:rounded-2xl text-white font-semibold text-base sm:text-lg bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 shadow-xl shadow-blue-500/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            Daftar &amp; Lamar Sekarang
                            <i class="fa-solid fa-arrow-right text-sm sm:text-base"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- ===== EVENT INFO ===== -->
    <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-slate-900 to-slate-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">

                <div class="space-y-5 sm:space-y-6">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold">{{ $settings['event_info_title'] ?? 'Informasi Event' }}</h2>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-violet-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base sm:text-lg">{{ $settings['event_location'] ?? 'Universitas Sugeng Hartono' }}</div>
                                <div class="text-slate-300 text-sm">{{ $settings['event_location_desc'] ?? 'Jl. Raya Solo - Baki, Sukoharjo, Jawa Tengah' }}</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fa-regular fa-calendar text-blue-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base sm:text-lg">{{ $settings['event_date'] ?? '3 - 10 Juni 2026' }}</div>
                                <div class="text-slate-300 text-sm">{{ $settings['event_date_desc'] ?? 'Pendaftaran dibuka selama 1 minggu' }}</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fa-regular fa-clock text-emerald-400 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base sm:text-lg">{{ $settings['event_time'] ?? '08.00 WIB - Selesai' }}</div>
                                <div class="text-slate-300 text-sm">Waktu Pelaksanaan Acara</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Illustration + CTA -->
                <div class="flex flex-col gap-5">
                    <!-- Stats CTA card -->
                    <div class="bg-gradient-to-br from-blue-500/20 to-violet-500/20 rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-white/10">
                        <div class="space-y-4">
                            <div class="text-center">
                                <div class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/30 rounded-full px-3 sm:px-4 py-1.5 sm:py-2 mb-3">
                                    <div class="h-2 w-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-xs sm:text-sm font-medium text-green-300">Pendaftaran Dibuka</span>
                                </div>
                                <div class="text-4xl sm:text-5xl font-bold mb-1">
                                    {{ $participantCount }}<span class="text-2xl sm:text-3xl text-slate-400">/{{ $settings['stat_2_value'] ?? '250' }}</span>
                                </div>
                                <div class="text-sm text-slate-300">Peserta terdaftar</div>
                            </div>
                            @php
                                $maxQuota = is_numeric($settings['stat_2_value'] ?? '250') ? (int)($settings['stat_2_value'] ?? '250') : 250;
                                $percentage = $maxQuota > 0 ? min(($participantCount / $maxQuota) * 100, 100) : 0;
                            @endphp
                            <div class="bg-white/10 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-violet-500 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <a href="{{route('participant.index')}}" class="flex items-center justify-center gap-2 w-full h-12 font-semibold bg-white text-slate-900 hover:bg-slate-100 rounded-xl transition-colors text-sm sm:text-base">
                                Daftar Sebelum Terlambat
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-900 text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-6">
                <div class="flex items-center gap-3">
                    @if(!empty($settings['logo_image']))
                        <img src="{{ !empty($settings['logo_image']) ? asset('storage/' . $settings['logo_image']) : asset('images/default-logo.png') }}" alt="Logo" class="h-10 object-contain">
                    @else
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center">
                            <i class="fa-solid fa-briefcase text-white"></i>
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-sm sm:text-base">{{ $settings['logo_text'] ?? 'JobFair 2026' }}</div>
                
                    </div>
                </div>
                <div class="text-xs sm:text-sm text-slate-400">&copy; {{ date('Y') }} {{ $settings['logo_text'] ?? 'JobFair 2026' }}. All rights reserved.</div>
            </div>
        </div>
    </footer>

    <script>
        // ── Mobile nav ──────────────────────────────────────────────────
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('hamburger-icon');
            menu.classList.toggle('open');
            icon.className = menu.classList.contains('open')
                ? 'fa-solid fa-xmark text-lg'
                : 'fa-solid fa-bars text-lg';
        }

        window.addEventListener('scroll', () => {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('open')) {
                menu.classList.remove('open');
                document.getElementById('hamburger-icon').className = 'fa-solid fa-bars text-lg';
            }
        }, { passive: true });



        // ── Company data from DB (passed via PHP) ────────────────────────
        const companies = @json($companies->keyBy('id'));

        // ── Company Modal ────────────────────────────────────────────────
        function openCompanyModal(id) {
            const c = companies[id];
            if (!c) return;

            // Logo
            const logoEl = document.getElementById('modalLogo');
            if (c.logo_path && !['🏢','💻','🎨','🏦','🏭','🌏'].includes(c.logo_path)) {
                logoEl.innerHTML = `<img src="/storage/${c.logo_path}" class="w-full h-full object-cover rounded-2xl" alt="${c.name}">`;
            } else {
                logoEl.textContent = c.logo_path ?? '🏢';
            }

            // Title
            document.getElementById('modalTitle').textContent = c.name;

            // Badges
            const badges = document.getElementById('modalBadges');
            let badgeHtml = '';
            if (c.position_name) badgeHtml += `<span class="bg-gradient-to-r from-blue-600 to-violet-600 text-white px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg font-semibold flex items-center gap-1 sm:gap-1.5"><i class="fa-solid fa-briefcase text-xs"></i> ${c.position_name}</span>`;
            if (c.selection) badgeHtml += `<span class="bg-white border border-slate-200 text-slate-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg font-medium shadow-sm">${c.selection}</span>`;
            if (c.time_to_answer) badgeHtml += `<span class="bg-white border border-slate-200 text-slate-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg flex items-center gap-1 sm:gap-1.5 font-medium shadow-sm"><i class="fa-regular fa-clock text-slate-400"></i> ${c.time_to_answer}</span>`;
            badges.innerHTML = badgeHtml;

            // Description
            const descEl = document.getElementById('modalDescription');
            descEl.innerHTML = c.description ? `
                <div>
                    <h4 class="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                        <div class="h-7 w-7 sm:h-8 sm:w-8 rounded-lg sm:rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-briefcase text-blue-600 text-xs sm:text-sm"></i>
                        </div>
                        Tentang Perusahaan
                    </h4>
                    <p class="text-slate-600 text-sm sm:text-[15px] leading-relaxed pl-0 sm:pl-10">${c.description}</p>
                </div>` : '';

            // Responsibilities
            const respEl = document.getElementById('modalResponsibilities');
            respEl.innerHTML = c.job_responsibilities ? `
                <hr class="border-slate-100">
                <div>
                    <h4 class="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                        <div class="h-7 w-7 sm:h-8 sm:w-8 rounded-lg sm:rounded-xl bg-violet-100 flex items-center justify-center">
                            <i class="fa-solid fa-list-check text-violet-600 text-xs sm:text-sm"></i>
                        </div>
                        Job Responsibilities
                    </h4>
                    <div class="text-slate-600 text-sm sm:text-[15px] leading-relaxed pl-0 sm:pl-10 rich-text">${c.job_responsibilities}</div>
                </div>` : '';

            // Requirements
            const reqEl = document.getElementById('modalRequirements');
            reqEl.innerHTML = c.requirements ? `
                <hr class="border-slate-100">
                <div>
                    <h4 class="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                        <div class="h-7 w-7 sm:h-8 sm:w-8 rounded-lg sm:rounded-xl bg-emerald-100 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs sm:text-sm"></i>
                        </div>
                        Requirements
                    </h4>
                    <div class="text-slate-600 text-sm sm:text-[15px] leading-relaxed pl-0 sm:pl-10 rich-text">${c.requirements}</div>
                </div>` : '';

            document.getElementById('companyModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCompanyModal() {
            document.getElementById('companyModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeCompanyModal();
        });
    </script>
    <x-bottom-nav active="home" />

</body>
</html>
