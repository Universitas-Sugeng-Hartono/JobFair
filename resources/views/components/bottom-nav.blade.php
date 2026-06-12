@props(['active' => 'home'])

<!-- Spacer to prevent content from hiding behind fixed nav -->
<div class="sm:hidden h-[68px] w-full shrink-0"></div>

<!-- Mobile Bottom Navigation -->
<nav class="sm:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 flex justify-around items-center h-[68px] z-[99] shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.08)]" style="padding-bottom: env(safe-area-inset-bottom);">
    <!-- Home -->
    <a href="{{ url('/') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 transition-all {{ $active === 'home' ? 'text-[#f97316]' : 'text-slate-400 hover:text-slate-500' }}">
        <i class="fa-solid fa-house text-2xl {{ $active === 'home' ? 'drop-shadow-sm' : '' }}"></i>
        <span class="text-[11px] font-bold">Home</span>
    </a>
    
    <!-- Perusahaan -->
    <a href="{{ route('participant.index') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 transition-all {{ $active === 'companies' ? 'text-[#f97316]' : 'text-slate-400 hover:text-slate-500' }}">
        <i class="fa-regular fa-building text-2xl {{ $active === 'companies' ? 'drop-shadow-sm' : '' }}"></i>
        <span class="text-[11px] font-bold">Perusahaan</span>
    </a>
    
    <!-- Riwayat -->
    <a href="{{ route('participant.history') }}" class="flex flex-col items-center justify-center w-full h-full gap-1 transition-all {{ $active === 'history' ? 'text-[#f97316]' : 'text-slate-400 hover:text-slate-500' }}">
        <i class="fa-solid fa-clock-rotate-left text-2xl {{ $active === 'history' ? 'drop-shadow-sm' : '' }}"></i>
        <span class="text-[11px] font-bold">Riwayat</span>
    </a>
    
    @if(session('participant_nik'))
    <!-- QR Code -->
    <button onclick="document.getElementById('qrModal').classList.remove('hidden')" class="flex flex-col items-center justify-center w-full h-full gap-1 transition-all text-slate-400 hover:text-indigo-500 cursor-pointer">
        <div class="relative flex items-center justify-center">
            <i class="fa-solid fa-qrcode text-2xl"></i>
        </div>
        <span class="text-[11px] font-bold">QR Code</span>
    </button>
    @endif
</nav>
