<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Lamaran - {{ $position->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('participant.company.show', $position->company_id) }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm text-slate-500">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Kembali</h1>
                        <p class="text-xs text-slate-500">ke Detail Perusahaan</p>
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
        
        <div class="bg-white rounded-2xl shadow-sm border-2 border-slate-300 overflow-hidden mb-6">
            <div class="p-6 bg-blue-50/50 border-b border-slate-100 flex items-center gap-4">
                <div class="h-16 w-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm p-1">
                    <img src="{{ asset('storage/' . $position->company->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $position->name }}</h2>
                    <p class="text-sm text-slate-600 mt-1">{{ $position->company->name }}</p>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <div class="mb-6 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm flex items-center gap-3">
                    <div class="h-10 w-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-400">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-medium">Peserta </p>
                        <p class="text-slate-800 font-bold">{{ $participant->name ?? 'Peserta' }} <span class="text-slate-400 font-normal ml-2">({{ $nik }})</span></p>
                    </div>
                </div>

                <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="position_id" value="{{ $position->id }}">

                    <div class="space-y-5">
                        @php $fields = is_string($position->form_config) ? json_decode($position->form_config, true) : ($position->form_config ?? []); @endphp
                        
                        @if(empty($fields))
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                <p class="text-sm text-slate-600 text-center">Tidak ada dokumen atau form tambahan yang diperlukan. Anda bisa langsung mengirimkan lamaran.</p>
                            </div>
                        @else
                            <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Lengkapi Persyaratan Berikut</h3>
                            @foreach($fields as $index => $field)
                                @php $fieldId = $field['id'] ?? $index; @endphp
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-semibold text-slate-700">
                                        {{ $field['label'] }} {!! !empty($field['required']) ? '<span class="text-red-500">*</span>' : '' !!}
                                    </label>
                                    @if($field['type'] === 'file')
                                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:bg-slate-50 hover:border-blue-300 transition relative overflow-hidden group">
                                            <input type="file" name="field_{{ $fieldId }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" {{ !empty($field['required']) ? 'required' : '' }} onchange="updateFileName(this)">
                                            <div class="file-display flex flex-col items-center justify-center pointer-events-none relative z-0">
                                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2 group-hover:text-blue-400 transition-colors file-icon"></i>
                                                <p class="text-sm text-slate-600 file-name line-clamp-1 px-4">Klik atau seret file ke sini</p>
                                            </div>
                                        </div>
                                    @elseif($field['type'] === 'textarea')
                                        <textarea name="field_{{ $fieldId }}" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm" placeholder="Isi {{ $field['label'] }}..." {{ !empty($field['required']) ? 'required' : '' }}></textarea>
                                    @else
                                        <input type="{{ $field['type'] === 'number' ? 'tel' : 'text' }}" name="field_{{ $fieldId }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm" placeholder="Isi {{ $field['label'] }}..." {{ !empty($field['required']) ? 'required' : '' }}>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full h-12 rounded-xl text-white font-bold text-sm bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Lamaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function updateFileName(input) {
            const displayDiv = input.nextElementSibling;
            const fileNameElem = displayDiv.querySelector('.file-name');
            const iconElem = displayDiv.querySelector('.file-icon');
            
            if (input.files && input.files.length > 0) {
                // Saat file dipilih
                fileNameElem.textContent = input.files[0].name;
                fileNameElem.classList.remove('text-slate-600');
                fileNameElem.classList.add('text-blue-600', 'font-semibold');
                
                iconElem.className = 'fa-solid fa-file-circle-check text-3xl text-blue-500 mb-2 file-icon';
                input.parentElement.classList.add('border-blue-300', 'bg-blue-50/30');
            } else {
                // Saat di-reset / cancel
                fileNameElem.textContent = 'Klik atau seret file ke sini';
                fileNameElem.classList.add('text-slate-600');
                fileNameElem.classList.remove('text-blue-600', 'font-semibold');
                
                iconElem.className = 'fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2 group-hover:text-blue-400 transition-colors file-icon';
                input.parentElement.classList.remove('border-blue-300', 'bg-blue-50/30');
            }
        }
    </script>
    <x-bottom-nav active="companies" />
</body>
</html>
