@props(['participant', 'nik'])

@if($participant)
<div id="qrModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="document.getElementById('qrModal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-[pulse-green_0.5s_ease-out]">
        <div class="px-6 py-6 text-center">
            <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-qrcode text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-1">QR Code Presensi</h3>
            <p class="text-sm text-slate-500 mb-6">Tunjukkan QR code ini kepada panitia untuk mencocokkan presensi dan data lamaran Anda.</p>
            
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex justify-center mb-6">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($nik) }}" alt="QR Code {{ $nik }}" class="rounded-xl">
            </div>

            <div class="flex items-center justify-center gap-2 text-sm font-medium text-slate-700 bg-slate-100 py-2 rounded-lg">
                <i class="fa-solid fa-id-card text-slate-400"></i> NIK: {{ $nik }}
            </div>
        </div>
        <div class="border-t border-slate-100 p-4 bg-slate-50">
            <button onclick="document.getElementById('qrModal').classList.add('hidden')" class="w-full py-3 rounded-xl font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                Tutup
            </button>
        </div>
    </div>
</div>
@endif
