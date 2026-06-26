@extends('layouts.admin')

@section('title', 'Edit Lowongan')

@push('styles')
<style>
    .builder-container { display: flex; gap: 2rem; flex-wrap: wrap; }
    .main-form { flex: 2; min-width: 300px; }
    .form-builder { flex: 1; min-width: 300px; background: #f8fafc; border-radius: 12px; padding: 1.5rem; border: 1px solid #e2e8f0; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem; transition: border-color 0.2s; }
    .form-control:focus { outline: none; border-color: #3b82f6; ring: 2px; }
    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; font-size: 0.875rem; cursor: pointer; border: none; transition: all 0.2s; }
    .btn-primary { background: #3b82f6; color: white; }
    .btn-primary:hover { background: #2563eb; }
    .btn-outline { background: white; border: 1px solid #cbd5e1; color: #475569; }
    .btn-outline:hover { background: #f1f5f9; }
    .btn-danger { background: #ef4444; color: white; padding: 0.5rem; }
    .builder-item { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1rem; }
    .builder-item-drag { cursor: grab; color: #94a3b8; }
    .builder-item-content { flex: 1; }
</style>
@endpush

@section('content')
<div class="content-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1e293b;">Edit Lowongan</h1>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Mengedit posisi <strong>{{ $position->name }}</strong> untuk perusahaan <strong>{{ $company->name }}</strong>.</p>
    </div>
    <a href="{{ route('positions.index') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<form action="{{ route('positions.update', $position->id) }}" method="POST" id="positionForm">
    @csrf
    @method('PUT')
    <input type="hidden" name="form_config" id="form_config_input">

    <div class="builder-container">
        
        <div class="main-form bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">Informasi Posisi</h2>

            <div class="form-group">
                <label for="name">Nama Posisi <span style="color:#ef4444">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $position->name) }}" required>
            </div>

            <div class="form-group">
                <label for="time_to_answer">Waktu Proses</label>
                <input type="text" name="time_to_answer" id="time_to_answer" class="form-control" value="{{ old('time_to_answer', $position->time_to_answer) }}">
            </div>

            <div class="form-group">
                <label for="selection">Tahapan Seleksi</label>
                <input type="text" name="selection" id="selection" class="form-control" value="{{ old('selection', $position->selection) }}">
            </div>
            <div class="form-group">
                <label for="location">Lokasi</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $position->location) }}">
            </div>

            <div class="form-group">
                <label for="job_responsibilities">Tanggung Jawab Pekerjaan</label>
                <textarea name="job_responsibilities" id="job_responsibilities" rows="4" class="form-control">{{ old('job_responsibilities', $position->job_responsibilities) }}</textarea>
            </div>

            <div class="form-group">
                <label for="requirements">Persyaratan</label>
                <textarea name="requirements" id="requirements" rows="4" class="form-control">{{ old('requirements', $position->requirements) }}</textarea>
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
        </div>

        <div class="form-builder">
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">Form Builder</h2>
            <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem;">Tentukan data apa saja yang wajib diisi oleh pelamar untuk posisi ini.</p>
            
            <div id="builder-items-container"></div>

            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #cbd5e1;">
                <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Tambah Input Baru</h4>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-outline" onclick="addFormField('text')"><i class="fa-solid fa-font"></i> Teks Pendek</button>
                    <button type="button" class="btn btn-outline" onclick="addFormField('number')"><i class="fa-solid fa-hashtag"></i> Angka (NIK)</button>
                    <button type="button" class="btn btn-outline" onclick="addFormField('file')"><i class="fa-solid fa-file-arrow-up"></i> Upload File</button>
                </div>
            </div>
        </div>

    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
        <a href="{{ route('companies.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary" onclick="prepareFormSubmit()">Simpan Perubahan</button>
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
    ClassicEditor.create(document.querySelector('#job_responsibilities')).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#requirements')).catch(error => console.error(error));

    let formFields = @json($position->form_config ?? []);
    if (!formFields || formFields.length === 0) {
        formFields = [
            { id: generateId(), type: 'text', label: 'Nama Lengkap', required: true },
            { id: generateId(), type: 'number', label: 'NIK', required: true },
            { id: generateId(), type: 'file', label: 'Upload Dokumen (CV/KTP)', required: true }
        ];
    }

    function generateId() { return Math.random().toString(36).substr(2, 9); }

    function renderFields() {
        const container = document.getElementById('builder-items-container');
        container.innerHTML = '';
        if(formFields.length === 0) {
            container.innerHTML = '<div style="text-align:center; color:#94a3b8; padding: 2rem 0;">Belum ada form input.</div>';
            return;
        }

        formFields.forEach((field, index) => {
            const item = document.createElement('div');
            item.className = 'builder-item';
            let icon = 'fa-font';
            let typeLabel = 'Teks Pendek';
            if(field.type === 'number') { icon = 'fa-hashtag'; typeLabel = 'Angka'; }
            if(field.type === 'file') { icon = 'fa-file-arrow-up'; typeLabel = 'Upload File'; }

            item.innerHTML = `
                <div class="builder-item-drag"><i class="fa-solid fa-grip-vertical"></i></div>
                <div class="builder-item-content">
                    <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">
                        <i class="fa-solid ${icon}"></i> ${typeLabel}
                    </div>
                    <input type="text" class="form-control" value="${field.label}" onchange="updateFieldLabel('${field.id}', this.value)" placeholder="Label inputan..." style="padding: 0.5rem; font-size: 0.875rem;">
                    
                    <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem;">
                        <input type="checkbox" id="req_${field.id}" ${field.required ? 'checked' : ''} onchange="updateFieldRequired('${field.id}', this.checked)">
                        <label for="req_${field.id}">Wajib Diisi</label>
                    </div>
                </div>
                <button type="button" class="btn btn-danger" onclick="removeFormField('${field.id}')" title="Hapus Input">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            container.appendChild(item);
        });
        initSortable();
    }

    let sortableInstance = null;
    function initSortable() {
        const container = document.getElementById('builder-items-container');
        if (sortableInstance) sortableInstance.destroy();
        sortableInstance = new Sortable(container, {
            handle: '.builder-item-drag',
            animation: 150,
            onEnd: function (evt) {
                const movedItem = formFields.splice(evt.oldIndex, 1)[0];
                formFields.splice(evt.newIndex, 0, movedItem);
            }
        });
    }

    function addFormField(type) {
        formFields.push({
            id: generateId(),
            type: type,
            label: type === 'file' ? 'Upload Dokumen' : (type === 'number' ? 'NIK / Nomor' : 'Pertanyaan / Input'),
            required: true
        });
        renderFields();
    }

    function removeFormField(id) {
        if(confirm('Hapus input ini?')) {
            formFields = formFields.filter(f => f.id !== id);
            renderFields();
        }
    }

    function updateFieldLabel(id, newLabel) {
        const field = formFields.find(f => f.id === id);
        if(field) field.label = newLabel;
    }

    function updateFieldRequired(id, isRequired) {
        const field = formFields.find(f => f.id === id);
        if(field) field.required = isRequired;
    }

    function prepareFormSubmit() {
        document.getElementById('form_config_input').value = JSON.stringify(formFields);
    }

    function addInfoRow(label = '', value = '') {
        const container = document.getElementById('additional-info-container');
        const rowId = 'info_' + Math.random().toString(36).substr(2, 9);
        const row = document.createElement('div');
        row.id = rowId;
        row.style = "display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-start;";
        row.innerHTML = `
            <div style="flex: 1;">
                <input type="text" name="add_info_label[]" class="form-control" placeholder="Label (Misal: Kompetensi)" value="${label}" required>
            </div>
            <div style="flex: 2;">
                <textarea name="add_info_value[]" class="form-control" rows="2" placeholder="Isi informasi..." required>${value}</textarea>
            </div>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('${rowId}').remove()" style="padding: 0.75rem;"><i class="fa-solid fa-trash"></i></button>
        `;
        container.appendChild(row);
    }

    let existingAdditionalInfo = @json($position->additional_info ?? []);
    if (existingAdditionalInfo && existingAdditionalInfo.length > 0) {
        existingAdditionalInfo.forEach(info => {
            addInfoRow(info.label, info.value);
        });
    }

    renderFields();
</script>
@endpush
