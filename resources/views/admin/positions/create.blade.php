@extends('layouts.admin')

@section('title', 'Tambah Lowongan')

@push('styles')
<style>
    .builder-container {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .main-form {
        flex: 2;
        min-width: 300px;
    }
    .form-builder {
        flex: 1;
        min-width: 300px;
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        margin-bottom: 0.5rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        ring: 2px;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    .btn-primary {
        background: #3b82f6;
        color: white;
    }
    .btn-primary:hover {
        background: #2563eb;
    }
    .btn-outline {
        background: white;
        border: 1px solid #cbd5e1;
        color: #475569;
    }
    .btn-outline:hover {
        background: #f1f5f9;
    }
    .btn-danger {
        background: #ef4444;
        color: white;
        padding: 0.5rem;
    }
    
    /* Builder Items */
    .builder-item {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .builder-item-drag {
        cursor: grab;
        color: #94a3b8;
    }
    .builder-item-content {
        flex: 1;
    }
</style>
@endpush

@section('content')
<div class="content-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1e293b;">Tambah Lowongan</h1>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">
            @if($company)
                Membuat lowongan baru untuk perusahaan <strong>{{ $company->name }}</strong>.
            @else
                Pilih perusahaan dan buat lowongan baru.
            @endif
        </p>
    </div>
    <a href="{{ route('positions.index') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('positions.store') }}" method="POST" id="positionForm">
    @csrf
    @if($company)
        <input type="hidden" name="company_id" value="{{ $company->id }}">
    @else
        <div class="form-group" style="margin-bottom: 1.5rem; background: white; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0;">
            <label for="company_id" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Pilih Perusahaan <span style="color:#ef4444">*</span></label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">— Pilih Perusahaan —</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ old('company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <input type="hidden" name="form_config" id="form_config_input">

    <!-- Tab Indicators -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem;">
        <div id="tab-1" style="flex: 1; text-align: center; padding: 0.5rem; font-weight: 600; color: #3b82f6; border-bottom: 3px solid #3b82f6; margin-bottom: -1rem; cursor: pointer;" onclick="showTab(1)">
            1. Informasi Posisi
        </div>
        <div id="tab-2" style="flex: 1; text-align: center; padding: 0.5rem; font-weight: 600; color: #64748b; border-bottom: 3px solid transparent; margin-bottom: -1rem; cursor: pointer;" onclick="showTab(2)">
            2. Form Builder
        </div>
    </div>

    <!-- Step 1: Profil Lowongan -->
    <div id="step-1-content" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
        <div class="form-group">
            <label for="name">Nama Posisi <span style="color:#ef4444">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Staff IT, Marketing Executive, Akuntan" required>
        </div>

        <div class="form-group">
            <label for="time_to_answer">Waktu Proses (Time to Answer)</label>
            <input type="text" name="time_to_answer" id="time_to_answer" class="form-control" placeholder="Contoh: 1-3 Hari Kerja">
        </div>

        <div class="form-group">
            <label for="selection">Tahapan Seleksi</label>
            <input type="text" name="selection" id="selection" class="form-control" placeholder="Contoh: Interview & Psikotes">
        </div>
        
        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control" placeholder="Contoh: Sukoharjo">
        </div>

        <div class="form-group">
            <label for="job_responsibilities">Tanggung Jawab Pekerjaan</label>
            <textarea name="job_responsibilities" id="job_responsibilities" rows="4" class="form-control" placeholder="Tuliskan tanggung jawab pekerjaan..."></textarea>
        </div>

        <div class="form-group">
            <label for="requirements">Persyaratan</label>
            <textarea name="requirements" id="requirements" rows="4" class="form-control" placeholder="Tuliskan syarat minimal..."></textarea>
        </div>
        
        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a;">Informasi Tambahan (Opsional)</h3>
            <button type="button" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.75rem;" onclick="addInfoRow()">
                <i class="fa-solid fa-plus"></i> Tambah Info
            </button>
        </div>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">Tambahkan informasi spesifik lain seperti Kompetensi Teknis, Benefit, dll.</p>
        
        <div id="additional-info-container">
            <!-- Rows here -->
        </div>
        
        <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('positions.index') }}" class="btn btn-outline">Batal</a>
            <button type="button" class="btn btn-primary" onclick="showTab(2)">Selanjutnya: Form Builder <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- Step 2: Form Builder -->
    <div id="step-2-content" style="display: none;" class="bg-slate-50 p-6 rounded-2xl shadow-sm border border-slate-200 mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">Form Builder</h2>
        <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">Tentukan data apa saja yang wajib diisi oleh pelamar untuk posisi ini.</p>
        
        <div id="builder-items-container">
            <!-- Javascript will render items here -->
        </div>

        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #cbd5e1;">
            <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Tambah Input Baru</h4>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button type="button" class="btn btn-outline" onclick="addFormField('step')"><i class="fa-solid fa-layer-group"></i> Section Baru</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('text')"><i class="fa-solid fa-font"></i> Teks</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('textarea')"><i class="fa-solid fa-paragraph"></i> Paragraf</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('number')"><i class="fa-solid fa-hashtag"></i> Angka</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('radio')"><i class="fa-regular fa-circle-dot"></i> Pil. Ganda</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('checkbox')"><i class="fa-regular fa-square-check"></i> Checkbox</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('date')"><i class="fa-regular fa-calendar"></i> Tanggal</button>
                <button type="button" class="btn btn-outline" onclick="addFormField('file')"><i class="fa-solid fa-file-arrow-up"></i> File</button>
            </div>
        </div>
        
        <div style="margin-top: 2rem; display: flex; justify-content: space-between; gap: 1rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
            <button type="button" class="btn btn-outline" onclick="showTab(1)"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
            <button type="submit" class="btn btn-primary" onclick="prepareFormSubmit()"><i class="fa-solid fa-save"></i> Simpan Lowongan</button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable {
        min-height: 150px;
    }
</style>
<script>
    function showTab(tabNumber) {
        if (tabNumber === 1) {
            document.getElementById('step-1-content').style.display = 'block';
            document.getElementById('step-2-content').style.display = 'none';
            document.getElementById('tab-1').style.color = '#3b82f6';
            document.getElementById('tab-1').style.borderBottomColor = '#3b82f6';
            document.getElementById('tab-2').style.color = '#64748b';
            document.getElementById('tab-2').style.borderBottomColor = 'transparent';
        } else {
            document.getElementById('step-1-content').style.display = 'none';
            document.getElementById('step-2-content').style.display = 'block';
            document.getElementById('tab-2').style.color = '#3b82f6';
            document.getElementById('tab-2').style.borderBottomColor = '#3b82f6';
            document.getElementById('tab-1').style.color = '#64748b';
            document.getElementById('tab-1').style.borderBottomColor = 'transparent';
        }
    }

    ClassicEditor.create(document.querySelector('#job_responsibilities')).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#requirements')).catch(error => console.error(error));

    let formFields = [
        { id: generateId(), type: 'text', label: 'Nama Lengkap', required: true },
        { id: generateId(), type: 'number', label: 'NIK', required: true },
        { id: generateId(), type: 'file', label: 'Upload Dokumen (CV/KTP)', required: true }
    ];

    function generateId() { return Math.random().toString(36).substr(2, 9); }

    let activeBuilderSection = 0;
    let currentSectionStartIndex = 0;

    function renderFields() {
        const container = document.getElementById('builder-items-container');
        container.innerHTML = '';
        if(formFields.length === 0) {
            container.innerHTML = '<div style="text-align:center; color:#94a3b8; padding: 2rem 0;">Belum ada form input.</div>';
            return;
        }

        let totalSections = 1;
        formFields.forEach((f, i) => { if (f.type === 'step' && i !== 0) totalSections++; });
        
        if (activeBuilderSection >= totalSections) activeBuilderSection = totalSections - 1;
        if (activeBuilderSection < 0) activeBuilderSection = 0;

        let currentSectionIndex = 0;
        let sectionWrapper = document.createElement('div');
        sectionWrapper.className = 'builder-section-page';
        let visibleWrapper = null;
        let startIndex = 0;

        formFields.forEach((field, index) => {
            if (field.type === 'step' && index !== 0) {
                if (currentSectionIndex === activeBuilderSection) visibleWrapper = sectionWrapper;
                currentSectionIndex++;
                sectionWrapper = document.createElement('div');
                sectionWrapper.className = 'builder-section-page';
                if (currentSectionIndex === activeBuilderSection) startIndex = index;
            }

            const item = document.createElement('div');
            item.className = 'builder-item';
            if (field.type === 'step') {
                item.style.backgroundColor = '#f1f5f9';
                item.style.borderLeft = '4px solid #3b82f6';
            }

            let icon = 'fa-font';
            let typeLabel = 'Teks Pendek';
            if(field.type === 'number') { icon = 'fa-hashtag'; typeLabel = 'Angka'; }
            if(field.type === 'file') { icon = 'fa-file-arrow-up'; typeLabel = 'Upload File'; }
            if(field.type === 'textarea') { icon = 'fa-paragraph'; typeLabel = 'Paragraf'; }
            if(field.type === 'radio') { icon = 'fa-circle-dot'; typeLabel = 'Pilihan Ganda'; }
            if(field.type === 'checkbox') { icon = 'fa-square-check'; typeLabel = 'Checkbox'; }
            if(field.type === 'date') { icon = 'fa-calendar'; typeLabel = 'Tanggal'; }
            if(field.type === 'step') { icon = 'fa-layer-group'; typeLabel = 'Section / Langkah Baru'; }

            let extraOptions = '';
            if (field.type === 'radio' || field.type === 'checkbox') {
                extraOptions = `
                    <div style="margin-top: 0.5rem; font-size: 0.75rem;">
                        <label style="color:#64748b; font-weight:600; display:block; margin-bottom:0.25rem;">Opsi Jawaban (pisahkan dengan koma):</label>
                        <input type="text" class="form-control" value="${field.options || ''}" onchange="updateFieldOptions('${field.id}', this.value)" placeholder="Misal: Laki-laki, Perempuan" style="padding: 0.4rem; font-size: 0.8rem;">
                    </div>
                `;
            }

            let jumpLogic = '';
            if (field.type === 'radio') {
                jumpLogic = `
                    <div style="margin-top: 0.5rem; font-size: 0.75rem; background: #fffbeb; padding: 0.5rem; border-radius: 6px; border: 1px solid #fef3c7;">
                        <label style="color:#b45309; font-weight:600; display:block; margin-bottom:0.25rem;"><i class="fa-solid fa-code-branch"></i> Jump Logic (Lompat Section)</label>
                        <div style="display:flex; gap:0.5rem; align-items:center;">
                            <span>Jika pilih</span>
                            <input type="text" class="form-control" value="${field.jump_condition || ''}" onchange="updateFieldJumpCondition('${field.id}', this.value)" placeholder="Opsi (misal: Tidak)" style="padding: 0.3rem; font-size: 0.75rem; width:100px;">
                            <span>lompat ke</span>
                            <select class="form-control" onchange="updateFieldJumpTarget('${field.id}', this.value)" style="padding: 0.3rem; font-size: 0.75rem; width:120px;">
                                <option value="">- Pilih Section -</option>
                                ${formFields.filter(f => f.type === 'step').map((s, i) => `<option value="${s.id}" ${field.jump_target === s.id ? 'selected' : ''}>${s.label || 'Section '+(i+1)}</option>`).join('')}
                            </select>
                        </div>
                    </div>
                `;
            }

            let requiredAndMax = '';
            if (field.type !== 'step') {
                requiredAndMax = `
                    <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 1rem; font-size: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="req_${field.id}" ${field.required ? 'checked' : ''} onchange="updateFieldRequired('${field.id}', this.checked)">
                            <label for="req_${field.id}">Wajib Diisi</label>
                        </div>
                        ${field.type === 'file' ? `
                        <div style="display: flex; align-items: center; gap: 0.5rem; border-left: 1px solid #cbd5e1; padding-left: 1rem;">
                            <label for="max_${field.id}">Maksimal File:</label>
                            <input type="number" id="max_${field.id}" min="1" max="10" value="${field.max_files || 1}" onchange="updateFieldMaxFiles('${field.id}', this.value)" style="padding: 0.25rem 0.5rem; width: 60px; border: 1px solid #cbd5e1; border-radius: 4px;">
                        </div>
                        ` : ''}
                    </div>
                `;
            }

            item.innerHTML = `
                <div class="builder-item-drag"><i class="fa-solid fa-grip-vertical"></i></div>
                <div class="builder-item-content">
                    <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">
                        <i class="fa-solid ${icon}"></i> ${typeLabel}
                    </div>
                    <input type="text" class="form-control" value="${field.label}" onchange="updateFieldLabel('${field.id}', this.value)" placeholder="${field.type === 'step' ? 'Nama Section (misal: Data Diri)' : 'Label pertanyaan...'}" style="padding: 0.5rem; font-size: 0.875rem; font-weight: ${field.type === 'step' ? 'bold' : 'normal'};">
                    ${extraOptions}
                    ${jumpLogic}
                    ${requiredAndMax}
                </div>
                <button type="button" class="btn btn-danger" onclick="removeFormField('${field.id}')" title="Hapus Input">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            sectionWrapper.appendChild(item);
        });

        if (currentSectionIndex === activeBuilderSection) visibleWrapper = sectionWrapper;

        currentSectionStartIndex = startIndex;
        if (visibleWrapper) container.appendChild(visibleWrapper);

        // Render pagination controls
        if (totalSections > 1) {
            const navDiv = document.createElement('div');
            navDiv.style.marginTop = '1rem';
            navDiv.style.display = 'flex';
            navDiv.style.justifyContent = 'space-between';
            navDiv.style.background = '#f8fafc';
            navDiv.style.padding = '0.75rem 1rem';
            navDiv.style.borderRadius = '8px';
            navDiv.style.border = '1px solid #e2e8f0';

            let prevBtn = `<button type="button" class="btn btn-outline" ${activeBuilderSection === 0 ? 'disabled style="opacity:0.5;"' : ''} onclick="changeBuilderSection(-1)"><i class="fa-solid fa-arrow-left"></i> Section Sebelumnya</button>`;
            let nextBtn = `<button type="button" class="btn btn-outline" ${activeBuilderSection === totalSections - 1 ? 'disabled style="opacity:0.5;"' : ''} onclick="changeBuilderSection(1)">Section Selanjutnya <i class="fa-solid fa-arrow-right"></i></button>`;
            
            navDiv.innerHTML = `${prevBtn} <div style="font-weight: 600; color: #64748b; align-self: center; font-size: 0.875rem;">Halaman ${activeBuilderSection + 1} dari ${totalSections}</div> ${nextBtn}`;
            container.appendChild(navDiv);
        }

        initSortable();
    }

    function changeBuilderSection(delta) {
        activeBuilderSection += delta;
        renderFields();
    }

    let sortableInstance = null;
    function initSortable() {
        const visibleWrapper = document.querySelector('.builder-section-page');
        if (!visibleWrapper) return;

        if (sortableInstance) sortableInstance.destroy();
        sortableInstance = new Sortable(visibleWrapper, {
            handle: '.builder-item-drag',
            animation: 150,
            onEnd: function (evt) {
                const oldRealIndex = currentSectionStartIndex + evt.oldIndex;
                const newRealIndex = currentSectionStartIndex + evt.newIndex;
                const movedItem = formFields.splice(oldRealIndex, 1)[0];
                formFields.splice(newRealIndex, 0, movedItem);
                renderFields(); // re-render to update jump target dropdowns if sections moved
            }
        });
    }

    function addFormField(type) {
        let label = 'Pertanyaan / Input';
        if (type === 'file') label = 'Upload Dokumen';
        if (type === 'number') label = 'Angka / NIK';
        if (type === 'step') label = 'Bagian Baru';

        let newField = {
            id: 'f_' + generateId(),
            type: type,
            label: label,
            required: type !== 'step'
        };
        if (type === 'file') newField.max_files = 1;
        if (type === 'radio' || type === 'checkbox') newField.options = 'Opsi 1, Opsi 2';
        
        let insertIndex = formFields.length;
        for (let i = currentSectionStartIndex + 1; i < formFields.length; i++) {
            if (formFields[i].type === 'step') {
                insertIndex = i;
                break;
            }
        }
        
        formFields.splice(insertIndex, 0, newField);
        
        if (type === 'step') {
            activeBuilderSection++;
        }
        
        renderFields();
    }

    function removeFormField(id) {
        if(confirm('Hapus item ini?')) {
            formFields = formFields.filter(f => f.id !== id);
            // remove jump targets pointing to this section if it's a step
            formFields.forEach(f => {
                if (f.jump_target === id) f.jump_target = '';
            });
            renderFields();
        }
    }

    function updateFieldLabel(id, newLabel) {
        const field = formFields.find(f => f.id === id);
        if(field) { field.label = newLabel; renderFields(); }
    }

    function updateFieldOptions(id, opts) {
        const field = formFields.find(f => f.id === id);
        if(field) field.options = opts;
    }

    function updateFieldJumpCondition(id, cond) {
        const field = formFields.find(f => f.id === id);
        if(field) field.jump_condition = cond;
    }

    function updateFieldJumpTarget(id, target) {
        const field = formFields.find(f => f.id === id);
        if(field) field.jump_target = target;
    }

    function updateFieldRequired(id, isRequired) {
        const field = formFields.find(f => f.id === id);
        if(field) field.required = isRequired;
    }

    function updateFieldMaxFiles(id, maxFiles) {
        const field = formFields.find(f => f.id === id);
        if(field) field.max_files = parseInt(maxFiles) || 1;
    }

    function prepareFormSubmit() {
        document.getElementById('form_config_input').value = JSON.stringify(formFields);
    }

    function addInfoRow(label = '', value = '') {
        const container = document.getElementById('additional-info-container');
        const rowId = 'info_' + Math.random().toString(36).substr(2, 9);
        const row = document.createElement('div');
        row.id = rowId;
        row.style = "position: relative; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 1.5rem; background: #f8fafc;";
        row.innerHTML = `
            <button type="button" class="btn btn-danger" onclick="document.getElementById('${rowId}').remove()" style="position: absolute; top: 1rem; right: 1rem; padding: 0.5rem; border-radius: 6px;"><i class="fa-solid fa-trash"></i></button>
            <div class="form-group" style="margin-right: 3rem; margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Label Info (Misal: Kompetensi)</label>
                <input type="text" name="add_info_label[]" class="form-control" placeholder="Ketik label di sini..." required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Isi Informasi</label>
                <textarea id="add_info_value_${rowId}" name="add_info_value[]" class="form-control" rows="2" placeholder="Isi informasi..."></textarea>
            </div>
        `;
        
        row.querySelector('input').value = label;
        row.querySelector('textarea').value = value;
        
        container.appendChild(row);
        
        ClassicEditor.create(document.querySelector(`#add_info_value_${rowId}`)).catch(error => console.error(error));
    }

    renderFields();
</script>
@endpush
