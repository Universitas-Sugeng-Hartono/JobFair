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

                <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data" id="applicationForm">
                    @csrf
                    <input type="hidden" name="position_id" value="{{ $position->id }}">

                    <div class="space-y-5 relative">
                        @php 
                            $fields = is_string($position->form_config) ? json_decode($position->form_config, true) : ($position->form_config ?? []); 
                            
                            $sections = [];
                            $currentSection = ['id' => 'section_default', 'label' => 'Informasi Umum', 'fields' => []];
                            $hasSteps = false;

                            foreach ($fields as $field) {
                                if (isset($field['type']) && $field['type'] === 'step') {
                                    if (!empty($currentSection['fields']) || $hasSteps) {
                                        $sections[] = $currentSection;
                                    }
                                    $currentSection = ['id' => $field['id'], 'label' => $field['label'], 'fields' => []];
                                    $hasSteps = true;
                                } else {
                                    $currentSection['fields'][] = $field;
                                }
                            }
                            if (!empty($currentSection['fields']) || count($sections) === 0) {
                                $sections[] = $currentSection;
                            }
                        @endphp
                        
                        @if(empty($fields))
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                <p class="text-sm text-slate-600 text-center">Tidak ada dokumen atau form tambahan yang diperlukan. Anda bisa langsung mengirimkan lamaran.</p>
                            </div>
                            <div class="mt-8 pt-6 border-t border-slate-100">
                                <button type="submit" class="w-full h-12 rounded-xl text-white font-bold text-sm bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Lamaran
                                </button>
                            </div>
                        @else
                            
                            <!-- Progress Bar -->
                            @if(count($sections) > 1)
                            <div class="mb-8">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider" id="stepIndicatorText">Langkah 1 dari {{ count($sections) }}</span>
                                    <span class="text-xs font-bold text-blue-600" id="stepIndicatorLabel">{{ $sections[0]['label'] }}</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" id="progressBar" style="width: {{ 100 / count($sections) }}%"></div>
                                </div>
                            </div>
                            @endif

                            @foreach($sections as $sIndex => $section)
                            <div class="wizard-step" id="step-{{ $section['id'] }}" data-index="{{ $sIndex }}" style="{{ $sIndex > 0 ? 'display: none;' : '' }}">
                                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">{{ $section['label'] }}</h3>
                                
                                <div class="space-y-4">
                                @foreach($section['fields'] as $index => $field)
                                    @php 
                                        $fieldId = $field['id'] ?? $index; 
                                        $isRequired = !empty($field['required']);
                                    @endphp
                                    <div class="space-y-1.5 field-container" data-field-id="{{ $fieldId }}">
                                        <label class="block text-sm font-semibold text-slate-700">
                                            {{ $field['label'] }} {!! $isRequired ? '<span class="text-red-500">*</span>' : '' !!}
                                        </label>
                                        
                                        @if($field['type'] === 'file')
                                            @php $maxFiles = $field['max_files'] ?? 1; @endphp
                                            <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:bg-slate-50 hover:border-blue-300 transition relative overflow-hidden group">
                                                <input type="file" name="field_{{ $fieldId }}{{ $maxFiles > 1 ? '[]' : '' }}" {{ $maxFiles > 1 ? 'multiple' : '' }} data-max="{{ $maxFiles }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" {!! $isRequired ? 'required data-required="true"' : '' !!} onchange="updateFileName(this)">
                                                <div class="file-display flex flex-col items-center justify-center pointer-events-none relative z-0">
                                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2 group-hover:text-blue-400 transition-colors file-icon"></i>
                                                    <p class="text-sm text-slate-600 file-name line-clamp-1 px-4">
                                                        Klik atau seret {{ $maxFiles > 1 ? 'maksimal ' . $maxFiles . ' ' : '' }}file ke sini
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($field['type'] === 'textarea')
                                            <textarea name="field_{{ $fieldId }}" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm" placeholder="Isi {{ $field['label'] }}..." {!! $isRequired ? 'required data-required="true"' : '' !!}></textarea>
                                        @elseif($field['type'] === 'radio')
                                            @php 
                                                $options = array_map('trim', explode(',', $field['options'] ?? '')); 
                                                $jumpCond = $field['jump_condition'] ?? '';
                                                $jumpTarget = $field['jump_target'] ?? '';
                                            @endphp
                                            <div class="space-y-2 mt-2">
                                                @foreach($options as $opt)
                                                    <label class="flex items-center gap-3 cursor-pointer group">
                                                        <input type="radio" name="field_{{ $fieldId }}" value="{{ $opt }}" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" {!! $isRequired ? 'required data-required="true"' : '' !!}
                                                            @if($jumpCond === $opt && $jumpTarget) data-jump-target="{{ $jumpTarget }}" @endif
                                                            onchange="evaluateJumpLogic()">
                                                        <span class="text-sm text-slate-700 group-hover:text-slate-900">{{ $opt }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($field['type'] === 'checkbox')
                                            @php $options = array_map('trim', explode(',', $field['options'] ?? '')); @endphp
                                            <div class="space-y-2 mt-2">
                                                @foreach($options as $opt)
                                                    <label class="flex items-center gap-3 cursor-pointer group">
                                                        <input type="checkbox" name="field_{{ $fieldId }}[]" value="{{ $opt }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                                        <span class="text-sm text-slate-700 group-hover:text-slate-900">{{ $opt }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($field['type'] === 'date')
                                            <input type="date" name="field_{{ $fieldId }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm" {!! $isRequired ? 'required data-required="true"' : '' !!}>
                                        @else
                                            <input type="{{ $field['type'] === 'number' ? 'number' : 'text' }}" name="field_{{ $fieldId }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm" placeholder="Isi {{ $field['label'] }}..." {!! $isRequired ? 'required data-required="true"' : '' !!}>
                                        @endif
                                    </div>
                                @endforeach
                                </div>

                                <div class="mt-8 pt-6 border-t border-slate-100 flex gap-3">
                                    @if($sIndex > 0)
                                        <button type="button" class="w-1/3 h-12 rounded-xl text-slate-700 font-bold text-sm bg-slate-100 hover:bg-slate-200 transition-all flex items-center justify-center gap-2" onclick="prevStep()">
                                            <i class="fa-solid fa-arrow-left"></i> Kembali
                                        </button>
                                    @endif
                                    
                                    @if($sIndex < count($sections) - 1)
                                        <button type="button" class="flex-1 h-12 rounded-xl text-white font-bold text-sm bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2" onclick="nextStep()">
                                            Selanjutnya <i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="flex-1 h-12 rounded-xl text-white font-bold text-sm bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-paper-plane"></i> Kirim Lamaran
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const steps = Array.from(document.querySelectorAll('.wizard-step'));
        let currentStepIndex = 0;
        let activeSteps = steps.map(s => s.id); // array of step IDs that are NOT skipped
        let skipTargets = {}; // mapping of current step -> step to skip to

        function evaluateJumpLogic() {
            skipTargets = {};
            // Temukan semua radio button yang dicentang dan memiliki data-jump-target
            const checkedJumps = document.querySelectorAll('input[type="radio"]:checked[data-jump-target]');
            checkedJumps.forEach(radio => {
                const targetId = radio.getAttribute('data-jump-target');
                const parentStep = radio.closest('.wizard-step');
                if(parentStep && targetId) {
                    skipTargets[parentStep.id] = 'step-' + targetId;
                }
            });
            recalculateActiveSteps();
        }

        function recalculateActiveSteps() {
            activeSteps = [];
            let i = 0;
            while (i < steps.length) {
                const stepId = steps[i].id;
                activeSteps.push(stepId);
                
                if (skipTargets[stepId]) {
                    // Temukan index target
                    const targetIndex = steps.findIndex(s => s.id === skipTargets[stepId]);
                    if (targetIndex > i) {
                        // Hilangkan required di step yang di-skip
                        for(let j = i + 1; j < targetIndex; j++) {
                            disableRequired(steps[j]);
                        }
                        i = targetIndex;
                        continue;
                    }
                }
                
                // Kembalikan required jika tidak di-skip
                enableRequired(steps[i]);
                i++;
            }
            updateProgress();
        }

        function disableRequired(stepElem) {
            const inputs = stepElem.querySelectorAll('input, textarea, select');
            inputs.forEach(el => {
                if(el.hasAttribute('required')) {
                    el.setAttribute('data-was-required', 'true');
                    el.removeAttribute('required');
                }
            });
        }

        function enableRequired(stepElem) {
            const inputs = stepElem.querySelectorAll('input, textarea, select');
            inputs.forEach(el => {
                if(el.hasAttribute('data-was-required')) {
                    el.setAttribute('required', 'required');
                    el.removeAttribute('data-was-required');
                }
            });
        }

        function validateCurrentStep() {
            const currentStepElem = steps[currentStepIndex];
            const inputs = currentStepElem.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;
            
            // Clear old errors
            currentStepElem.querySelectorAll('.text-red-500.text-xs.error-msg').forEach(e => e.remove());
            currentStepElem.querySelectorAll('.border-red-500').forEach(e => e.classList.remove('border-red-500'));

            inputs.forEach(input => {
                if (!input.value && input.type !== 'radio' && input.type !== 'checkbox' && input.type !== 'file') {
                    isValid = false;
                    showError(input);
                } else if (input.type === 'radio' || input.type === 'checkbox') {
                    const name = input.getAttribute('name');
                    const checked = currentStepElem.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        isValid = false;
                        showError(input.closest('.space-y-2') || input.parentElement);
                    }
                } else if (input.type === 'file') {
                    if (input.files.length === 0) {
                        isValid = false;
                        showError(input.parentElement);
                    }
                }
            });
            return isValid;
        }

        function showError(element) {
            element.classList.add('border-red-500');
            const msg = document.createElement('p');
            msg.className = 'text-red-500 text-xs mt-1 error-msg';
            msg.textContent = 'Bidang ini wajib diisi.';
            element.parentElement.appendChild(msg);
        }

        function nextStep() {
            if (!validateCurrentStep()) return;

            steps[currentStepIndex].style.display = 'none';
            
            // Cari step berikutnya yang aktif
            const currentStepId = steps[currentStepIndex].id;
            const activeIndex = activeSteps.indexOf(currentStepId);
            
            if (activeIndex < activeSteps.length - 1) {
                const nextStepId = activeSteps[activeIndex + 1];
                currentStepIndex = steps.findIndex(s => s.id === nextStepId);
                steps[currentStepIndex].style.display = 'block';
                updateProgress();
            }
        }

        function prevStep() {
            steps[currentStepIndex].style.display = 'none';
            
            // Cari step sebelumnya yang aktif
            const currentStepId = steps[currentStepIndex].id;
            const activeIndex = activeSteps.indexOf(currentStepId);
            
            if (activeIndex > 0) {
                const prevStepId = activeSteps[activeIndex - 1];
                currentStepIndex = steps.findIndex(s => s.id === prevStepId);
                steps[currentStepIndex].style.display = 'block';
                updateProgress();
            }
        }

        function updateProgress() {
            const currentStepId = steps[currentStepIndex].id;
            const activeIndex = activeSteps.indexOf(currentStepId);
            const totalActive = activeSteps.length;
            
            const pBar = document.getElementById('progressBar');
            const pText = document.getElementById('stepIndicatorText');
            const pLabel = document.getElementById('stepIndicatorLabel');
            
            if(pBar && pText && pLabel) {
                pBar.style.width = ((activeIndex + 1) / totalActive * 100) + '%';
                pText.textContent = 'Langkah ' + (activeIndex + 1) + ' dari ' + totalActive;
                
                const stepLabel = steps[currentStepIndex].querySelector('h3').textContent;
                pLabel.textContent = stepLabel;
            }
        }

        // Initialize
        evaluateJumpLogic();

        function updateFileName(input) {
            const displayDiv = input.nextElementSibling;
            const fileNameElem = displayDiv.querySelector('.file-name');
            const iconElem = displayDiv.querySelector('.file-icon');
            const maxFiles = parseInt(input.getAttribute('data-max')) || 1;
            
            // Clear old errors if any
            input.parentElement.classList.remove('border-red-500');
            const errMsg = input.parentElement.parentElement.querySelector('.error-msg');
            if(errMsg) errMsg.remove();
            
            if (input.files && input.files.length > 0) {
                if (input.files.length > maxFiles) {
                    alert('Maksimal ' + maxFiles + ' file yang dapat diupload.');
                    input.value = ''; // reset
                    return updateFileName(input);
                }

                if (input.files.length === 1) {
                    fileNameElem.textContent = input.files[0].name;
                } else {
                    fileNameElem.textContent = input.files.length + ' file terpilih';
                }
                fileNameElem.classList.remove('text-slate-600');
                fileNameElem.classList.add('text-blue-600', 'font-semibold');
                
                iconElem.className = 'fa-solid fa-file-circle-check text-3xl text-blue-500 mb-2 file-icon';
                input.parentElement.classList.add('border-blue-300', 'bg-blue-50/30');
            } else {
                fileNameElem.textContent = 'Klik atau seret ' + (maxFiles > 1 ? 'maksimal ' + maxFiles + ' ' : '') + 'file ke sini';
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
