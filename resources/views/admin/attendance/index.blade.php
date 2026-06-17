@extends('layouts.admin')

@section('title', 'Manajemen Presensi')

@push('styles')
<style>
    .scanner-container {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .scanner-input {
        width: 100%;
        max-width: 400px;
        padding: 1rem 1.5rem;
        font-size: 1.25rem;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    
    .scanner-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: none;
        font-weight: 500;
    }
    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .pulsing {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.6; }
        100% { opacity: 1; }
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title">Manajemen Presensi (Scanner)</h2>
        <p class="content-subtitle">Gunakan alat Barcode/QR Code Scanner untuk memindai NIK peserta.</p>
    </div>
</div>

<div class="scanner-container">
    <div style="font-size: 3rem; color: #3b82f6; margin-bottom: 1rem;">
        <i class="fa-solid fa-barcode"></i>
    </div>
    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Arahkan Kursor ke Kotak Ini</h3>
    <p style="color: #64748b; margin-bottom: 1.5rem;">Pastikan kursor berkedip di kotak bawah sebelum memindai QR code peserta.</p>
    
    <div id="alertMessage" class="alert"></div>

    <form id="scannerForm" onsubmit="handleScan(event)">
        <input type="text" id="nikInput" class="scanner-input" placeholder="Scan NIK di sini..." autofocus autocomplete="off" required>
        <p style="color: #94a3b8; font-size: 0.875rem;">Atau ketik manual NIK (16 digit) dan tekan Enter</p>
    </form>
</div>

<div class="card">
    <div class="card-header" style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title" style="margin: 0;">Daftar Kehadiran </h3>
            <span class="pulsing" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #10b981; font-weight: 600;">
                <i class="fa-solid fa-circle"></i> Live Updates
            </span>
        </div>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peserta</th>
                    <th>NIK</th>
                    <th>Waktu Hadir</th>
                </tr>
            </thead>
            <tbody id="attendanceTableBody">
                <tr>
                    <td colspan="4" style="text-align: center; color: #64748b; padding: 2rem;">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>

    // Keep input focused if clicked anywhere inside the scanner container
    document.querySelector('.scanner-container').addEventListener('click', function() {
        document.getElementById('nikInput').focus();
    });

    const form = document.getElementById('scannerForm');
    const input = document.getElementById('nikInput');
    const alertBox = document.getElementById('alertMessage');
    const tableBody = document.getElementById('attendanceTableBody');

    function showAlert(message, type) {
        alertBox.textContent = message;
        alertBox.className = 'alert ' + (type === 'success' ? 'alert-success' : 'alert-error');
        alertBox.style.display = 'block';
        
        // Hide after 4 seconds
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 4000);
    }

    async function handleScan(e) {
        e.preventDefault();
        const nik = input.value.trim();
        
        if(nik.length !== 16) {
            showAlert('Format NIK tidak valid. Harus 16 digit.', 'error');
            input.value = '';
            input.focus();
            return;
        }

        // Disable input while processing
        input.disabled = true;

        try {
            const response = await fetch("{{ route('attendance.scan') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ nik: nik })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showAlert(data.message, 'success');
                // Play success sound
                playBeep(800, 150);
                // Immediately refresh table
                fetchAttendanceData();
            } else {
                showAlert(data.message || 'Terjadi kesalahan.', 'error');
                // Play error sound
                playBeep(300, 300);
            }
        } catch (error) {
            showAlert('Gagal terhubung ke server.', 'error');
            playBeep(300, 300);
        }

        // Re-enable and focus
        input.value = '';
        input.disabled = false;
        input.focus();
    }

    // Audio Context for beep sounds
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    const audioCtx = new AudioContext();

    function playBeep(frequency, duration) {
        if(audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(frequency, audioCtx.currentTime);
        
        gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + (duration/1000));
        
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        
        oscillator.start();
        oscillator.stop(audioCtx.currentTime + (duration/1000));
    }

    // Fetch live data
    async function fetchAttendanceData() {
        try {
            const response = await fetch("{{ route('attendance.data') }}");
            const data = await response.json();
            
            if(data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: #64748b; padding: 2rem;">Belum ada peserta yang hadir (atau tidak ada yang cocok dengan pencarian).</td></tr>';
                return;
            }

            let html = '';
            data.forEach((participant, index) => {
                const date = new Date(participant.attended_at);
                const timeString = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                const dateString = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td style="font-weight: 500; color: #0f172a;">${participant.name}</td>
                        <td><span style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; font-family: monospace;">${participant.nik}</span></td>
                        <td>
                            <span style="color: #10b981; font-weight: 500;"><i class="fa-regular fa-clock"></i> ${timeString}</span>
                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">${dateString}</div>
                        </td>
                    </tr>
                `;
            });
            
            tableBody.innerHTML = html;
        } catch (error) {
            console.error('Error fetching attendance data:', error);
        }
    }

    // Initial fetch
    fetchAttendanceData();

    // Poll every 5 seconds
    setInterval(fetchAttendanceData, 5000);

    // Keep input focused even if user clicks away to body
    document.addEventListener('click', function(e) {
        if(e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
            input.focus();
        }
    });
</script>
@endpush
