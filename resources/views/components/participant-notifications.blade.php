<!-- @php
    $unreadNotifications = collect();
    $nik = session('participant_nik');

    if ($nik) {
        $participant = \App\Models\Participant::where('nik', $nik)->first();
        if ($participant) {
            $unreadNotifications = $participant->notifications()
                ->where('is_read', false)
                ->latest()
                ->get();
        }
    }
@endphp -->
@php
    $mappedNotifications = $unreadNotifications->map(fn ($n) => [
        'id' => $n->id,
        'title' => $n->title,
        'message' => $n->message,
    ])->values();
@endphp

@if($unreadNotifications->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notifications = @json($mappedNotifications);
            const csrfToken = @json(csrf_token());

            // 1. Buat konfigurasi Toast bergaya WhatsApp
            const WhatsAppToast = Swal.mixin({
                toast: true,
                position: 'top-end', // Posisi di pojok kanan atas
                showConfirmButton: false,
                timer: 5000, // Hilang otomatis dalam 5 detik
                timerProgressBar: true,
                background: '#ffffff',
                iconColor: '#25D366', // Warna hijau khas WhatsApp
                didOpen: (toast) => {
                    // Jika mouse diarahkan ke notifikasi, waktu hitung mundur berhenti sementara
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // 2. Tampilkan notifikasi
            notifications.forEach((n, index) => {
                // Beri jeda (setTimeout) agar jika ada lebih dari 1 notifikasi, 
                // munculnya bergantian secara rapi (tidak saling tumpuk)
                setTimeout(() => {
                    WhatsAppToast.fire({
                        icon: 'success', // Ganti 'info' jika tidak ingin ikon centang hijau
                        title: n.title,
                        text: n.message,
                        customClass: {
                            title: 'font-bold text-gray-800',
                            popup: 'shadow-lg border-l-4 border-green-500' // Tambahan aksen hijau jika pakai Tailwind CSS
                        }
                    });
                }, index * 5500); // Muncul bergantian setiap 5,5 detik
            });
        });
    </script>
@endif
