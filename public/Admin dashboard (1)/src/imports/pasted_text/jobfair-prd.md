JobFair Website

TL;DR

PRD ini merinci situs JobFair yang menargetkan dua peran pengguna—Admin dan Peserta. Situs memungkinkan pengelolaan perusahaan dan peserta, termasuk branding dan persyaratan perusahaan, sementara peserta (hingga 250 NIK unik) dapat melamar maksimal 12 perusahaan masing-masing.



Goals

Business Goals





Mendigitalisasi dan menyederhanakan proses job fair untuk efisiensi.



Berhasil mengonfigurasi minimal 10 perusahaan dan 250 peserta per event.



Menjamin platform event yang aman, andal, dan dapat diskalakan.



Menyediakan data dan analytics yang komprehensif untuk semua pemangku kepentingan.

User Goals





Memudahkan pendaftaran dan pengajuan untuk pencari kerja (peserta).



Memungkinkan perusahaan menampilkan branding dan persyaratan untuk menarik talenta.



Menyediakan alat bagi admin untuk mengelola data perusahaan dan peserta secara efisien.



Meminimalkan kasus aplikasi duplikat atau tidak valid ke perusahaan.

Non-Goals





Menjalankan proses matchmaking pekerjaan atau wawancara secara penuh dalam platform ini.



Pemrosesan pembayaran untuk peserta atau perusahaan.



Dukungan multi-event (fokus hanya pada konfigurasi single-event).



User Stories

Admin





Sebagai Admin, saya ingin mengelola profil perusahaan—termasuk logo dan persyaratan pekerjaan—agar data perusahaan yang akurat muncul kepada peserta.



Sebagai Admin, saya ingin melihat, menyetujui, atau menolak registrasi peserta, sehingga daftar peserta akurat.



Sebagai Admin, saya ingin memastikan tidak ada NIK yang terdaftar lebih dari sekali dan peserta tidak dapat mendaftar ke lebih dari 12 perusahaan.



Sebagai Admin, saya ingin mengekspor data peserta dan perusahaan untuk keperluan pelaporan.

Peserta





Sebagai Peserta, saya ingin mendaftar ke job fair menggunakan NIK, sehingga saya dapat mengakses event dan melihat perusahaan.



Sebagai Peserta, saya ingin melihat profil perusahaan dan persyaratan pekerjaan untuk membuat keputusan melamar yang tepat.



Sebagai Peserta, saya ingin melamar hingga 12 perusahaan, agar saya memiliki beberapa kesempatan kerja.



Sebagai Peserta, saya ingin mendapatkan konfirmasi atas pengajuan dan status pendaftaran, sehingga saya yakin data saya telah diterima.



Functional Requirements





Company Management (Prioritas: Tinggi) — Admin dapat membuat/mengubah/menghapus profil perusahaan (logo, deskripsi, persyaratan). Daftar perusahaan ditampilkan kepada peserta.



Participant Management (Prioritas: Tinggi) — Admin dapat menyetujui/menolak/menghapus registrasi. Sistem menegakkan registrasi NIK unik (1 orang/1 NIK saja, hingga 250). Peserta dapat mengirimkan registrasi (NIK, data pribadi). Sistem menegakkan peserta dapat melamar maksimal 12 perusahaan.



Application Management (Prioritas: Tinggi) — Peserta dapat melamar ke perusahaan (maks 12, dilacak dengan NIK). Admin dapat melihat aplikasi per perusahaan dan per peserta.



Reporting & Data Export (Prioritas: Menengah) — Admin dapat mengekspor daftar (CSV/XLS) peserta dan aplikasi.



Authentication (Prioritas: Menengah) — Login aman untuk Admin; mekanisme pendaftaran/login untuk Peserta.

User Experience

Entry Point & First-Time User Experience





Peserta menemukan situs dan melihat pengantar event.



Halaman pendaftaran meminta NIK dan detail pribadi.



Setelah pendaftaran berhasil, diarahkan ke dashboard.



Modal onboarding menjelaskan batasan (maks 12 lamaran, satu NIK, dll.).

Core Experience





Langkah 1: Pendaftaran peserta — Validasi field NIK (keunikan, format). Penanganan error untuk NIK yang sudah digunakan atau event penuh (250/250). Konfirmasi melalui email/SMS dinyatakan sebagai opsional dan bukan prioritas.



Langkah 2: Akses dashboard — Menampilkan daftar perusahaan yang tersedia dan persyaratannya. Menampilkan kuota sisa pengajuan (0–12 tersisa).



Langkah 3: Melamar ke perusahaan — Antarmuka sederhana untuk mengajukan minat/aplikasi. Mencegah pengajuan setelah mencapai 12 total, atau pengajuan ke perusahaan yang sama lebih dari sekali.



Langkah 4: Akses admin — Login aman untuk Admin. Melihat/mengelola perusahaan dan data peserta.



Langkah 5: Ekspor data — Tombol ekspor untuk admin, dengan notifikasi status.

Advanced Features & Edge Cases





Menangani upaya untuk mengakali aturan NIK/kuota aplikasi.



Menampilkan pesan yang mudah dipahami bila kuota event penuh.



Opsi override oleh admin untuk kasus khusus (mis. penghapusan registrasi paksa).

UI/UX Highlights





Instruksi yang jelas tentang kuota dan proses.



Desain yang dapat diakses—mendukung browser modern dan mematuhi prinsip aksesibilitas.



Layout responsif untuk pengguna mobile dan desktop.



Narrative

Rina adalah lulusan baru yang mencari pekerjaan pertama. Ia mendengar tentang job fair virtual dan mengunjungi situs. Pendaftaran mudah—ia memasukkan NIK dan informasi dasar, lalu mengetahui bahwa ia dapat melamar hingga 12 perusahaan. Saat menelusuri profil perusahaan, ia memilih yang paling sesuai dengan minatnya. Sistem mencegahnya melamar lebih dari 12 perusahaan, sehingga fokusnya pada pilihan terbaik. Dari sisi admin, Andi mengelola registrasi yang masuk, memvalidasi pelamar dan memastikan tidak ada NIK yang duplikat, sambil menyesuaikan profil setiap perusahaan. Saat event berakhir, ekspor data memungkinkan pelaporan dan tindak lanjut yang lancar. Baik peserta maupun admin mengalami proses yang adil, efisien, dan transparan.



Success Metrics





Waktu untuk mengisi semua slot 250 peserta.



Jumlah perusahaan yang onboarded.



Rata‑rata lamaran per peserta.



Persentase NIK duplikat/tidak valid (target: <1%).



Skor kepuasan pengguna (survei).

User-Centric Metrics





Rasio konversi pendaftaran peserta.



NPS peserta atau skor kepuasan dalam survei.



Persentase peserta yang menggunakan semua 12 kuota lamaran.

Business Metrics





Pengurangan biaya operasional melalui digitalisasi.



Jumlah perusahaan yang onboarded per event.



Kelengkapan dan akurasi data ekspor.

Technical Metrics





Waktu aktif sistem pendaftaran (>99.9%).



Kecepatan pemrosesan pendaftaran/lamaran rata‑rata (<1s).



Integritas data untuk keterkaitan peserta/perusahaan.

Tracking Plan





Registrasi baru (event pengguna).



Lamaran yang dikirim (pengguna, perusahaan, timestamp).



Upaya duplikasi NIK (event validasi/admin).



Inisiasi/keberhasilan/ kegagalan ekspor data.