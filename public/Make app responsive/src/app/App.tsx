import { useState, useEffect } from 'react';
import { Menu, X, Briefcase, Building2, Star, Clock, Users, ArrowRight, Calendar, MapPin, CheckCircle, ListChecks, Circle } from 'lucide-react';

// Mock company data
const mockCompanies = [
  {
    id: 1,
    name: 'Tech Innovations Inc',
    logo_path: '💻',
    position_name: 'Software Engineer',
    description: 'Perusahaan teknologi terkemuka yang fokus pada pengembangan solusi digital inovatif untuk transformasi bisnis.',
    time_to_answer: '10-15 menit',
    applications_count: 45,
    selection: 'Interview + Test',
    job_responsibilities: '• Mengembangkan dan memelihara aplikasi web\n• Berkolaborasi dengan tim product dan design\n• Review code dan mentoring junior developer',
    requirements: '• Minimal S1 Teknik Informatika/sejenis\n• Pengalaman 2+ tahun dengan React/Node.js\n• Paham konsep database dan API design'
  },
  {
    id: 2,
    name: 'Digital Marketing Co',
    logo_path: '🎨',
    position_name: 'Marketing Specialist',
    description: 'Agensi digital marketing yang membantu brand berkembang melalui strategi pemasaran digital yang efektif.',
    time_to_answer: '5-10 menit',
    applications_count: 38,
    selection: 'Portfolio Review',
    job_responsibilities: '• Merancang dan menjalankan kampanye digital\n• Analisis performa marketing metrics\n• Koordinasi dengan creative team',
    requirements: '• Minimal S1 Marketing/Komunikasi\n• Pengalaman dengan Google Ads & Meta Ads\n• Kemampuan analisis data yang baik'
  },
  {
    id: 3,
    name: 'FinTech Solutions',
    logo_path: '🏦',
    position_name: 'Product Manager',
    description: 'Platform fintech yang menyediakan solusi pembayaran digital untuk UMKM dan enterprise.',
    time_to_answer: '15-20 menit',
    applications_count: 52,
    selection: 'Case Study + Interview',
    job_responsibilities: '• Mendefinisikan product roadmap\n• Bekerja sama dengan engineering dan design\n• Analisis user feedback dan market research',
    requirements: '• Minimal S1 semua jurusan\n• Pengalaman 3+ tahun sebagai Product Manager\n• Paham agile methodology'
  },
  {
    id: 4,
    name: 'Manufacturing Hub',
    logo_path: '🏭',
    position_name: 'Operations Manager',
    description: 'Perusahaan manufaktur dengan standar internasional yang memproduksi komponen elektronik berkualitas tinggi.',
    time_to_answer: '10 menit',
    applications_count: 31,
    selection: 'Interview',
    job_responsibilities: '• Mengelola operasional produksi harian\n• Optimasi proses dan efisiensi\n• Koordinasi dengan supply chain team',
    requirements: '• Minimal S1 Teknik Industri/sejenis\n• Pengalaman di bidang manufacturing\n• Leadership dan problem solving yang kuat'
  },
  {
    id: 5,
    name: 'Global Consulting',
    logo_path: '🌏',
    position_name: 'Business Analyst',
    description: 'Konsultan bisnis yang membantu perusahaan mencapai target melalui analisis mendalam dan strategi yang tepat.',
    time_to_answer: '12-15 menit',
    applications_count: 29,
    selection: 'Assessment + Interview',
    job_responsibilities: '• Analisis proses bisnis klien\n• Membuat rekomendasi improvement\n• Presentasi hasil analisis kepada stakeholder',
    requirements: '• Minimal S1 Ekonomi/Manajemen\n• Kemampuan analisis dan komunikasi yang baik\n• Familiar dengan data analysis tools'
  },
  {
    id: 6,
    name: 'Creative Studio',
    logo_path: '🎨',
    position_name: 'UI/UX Designer',
    description: 'Studio kreatif yang menghasilkan desain digital berkualitas tinggi untuk berbagai brand ternama.',
    time_to_answer: '8-10 menit',
    applications_count: 41,
    selection: 'Portfolio Review',
    job_responsibilities: '• Mendesain user interface untuk web dan mobile\n• Melakukan user research dan testing\n• Kolaborasi dengan developer',
    requirements: '• Minimal D3 DKV/sejenis\n• Portfolio yang kuat\n• Mahir menggunakan Figma/Adobe XD'
  }
];

export default function App() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [selectedCompany, setSelectedCompany] = useState<typeof mockCompanies[0] | null>(null);
  const [appliedIds, setAppliedIds] = useState<number[]>([]);

  useEffect(() => {
    // Load applied companies from localStorage
    try {
      const stored = localStorage.getItem('jobfair_applied');
      if (stored) {
        setAppliedIds(JSON.parse(stored));
      }
    } catch (e) {
      console.error('Error loading applied companies:', e);
    }
  }, []);

  useEffect(() => {
    // Close mobile menu on scroll
    const handleScroll = () => {
      if (mobileMenuOpen) {
        setMobileMenuOpen(false);
      }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, [mobileMenuOpen]);

  const openCompanyModal = (company: typeof mockCompanies[0]) => {
    setSelectedCompany(company);
    document.body.style.overflow = 'hidden';
  };

  const closeCompanyModal = () => {
    setSelectedCompany(null);
    document.body.style.overflow = '';
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
      {/* Navigation */}
      <nav className="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="flex items-center justify-between h-16">
            {/* Logo */}
            <a href="/" className="flex items-center gap-2 sm:gap-3 flex-shrink-0">
              <div className="h-8 w-8 sm:h-10 sm:w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <Briefcase className="text-white w-4 h-4 sm:w-5 sm:h-5" />
              </div>
              <h1 className="text-base sm:text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                JobFair 2026
              </h1>
            </a>

            {/* Desktop Button */}
            <div className="hidden sm:block">
              <a href="/peserta" className="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 rounded-lg shadow-md transition-all">
                Daftar Sekarang
                <ArrowRight className="w-3 h-3" />
              </a>
            </div>

            {/* Mobile Hamburger */}
            <button
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              className="sm:hidden h-10 w-10 rounded-lg flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors"
            >
              {mobileMenuOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
            </button>
          </div>

          {/* Mobile Dropdown */}
          {mobileMenuOpen && (
            <div className="flex flex-col gap-2 pb-4 pt-3 border-t border-slate-100">
              <a href="/peserta" className="flex items-center justify-center gap-2 w-full py-3 px-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 rounded-xl shadow-md">
                <ArrowRight className="w-4 h-4" /> Daftar Sekarang
              </a>
              <a href="#features" onClick={() => setMobileMenuOpen(false)} className="flex items-center gap-2 py-2.5 px-4 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                <Star className="w-4 h-4 text-slate-400" /> Keunggulan Platform
              </a>
              <a href="#how-it-works" onClick={() => setMobileMenuOpen(false)} className="flex items-center gap-2 py-2.5 px-4 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                <ListChecks className="w-4 h-4 text-slate-400" /> Cara Kerja
              </a>
            </div>
          )}
        </div>
      </nav>

      {/* Hero Section */}
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-blue-600/5 via-violet-600/5 to-transparent pointer-events-none"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 lg:py-20">
          <div className="flex flex-col lg:grid lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">
            {/* Left: Text Content */}
            <div className="space-y-4 sm:space-y-6 lg:space-y-8 w-full">
              <div className="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-3 sm:px-4 py-1.5 sm:py-2">
                <Star className="text-blue-600 w-3 h-3 sm:w-4 sm:h-4" />
                <span className="text-xs sm:text-sm font-medium text-blue-900">Event Career Terbesar 2026</span>
              </div>

              <div className="space-y-3 sm:space-y-4">
                <h2 className="text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-bold leading-tight">
                  <span className="bg-gradient-to-r from-slate-900 via-blue-900 to-violet-900 bg-clip-text text-transparent">
                    Wujudkan Karir
                  </span>
                  <br />
                  <span className="bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                    Impianmu
                  </span>
                </h2>
                <p className="text-sm sm:text-base lg:text-lg xl:text-xl text-slate-600 leading-relaxed">
                  Bergabunglah dengan JobFair 2026 dan temukan peluang karir dari {mockCompanies.length}+ perusahaan terkemuka di Indonesia. Satu platform, ribuan peluang.
                </p>
              </div>

              {/* CTA Buttons */}
              <div className="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <a href="/peserta" className="inline-flex items-center justify-center h-11 sm:h-12 lg:h-14 px-5 sm:px-6 lg:px-8 text-sm sm:text-base lg:text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 rounded-xl shadow-xl shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                  Mulai Sekarang
                  <ArrowRight className="ml-2 w-4 h-4 sm:w-5 sm:h-5" />
                </a>
                <a href="#features" className="inline-flex items-center justify-center h-11 sm:h-12 lg:h-14 px-5 sm:px-6 lg:px-8 text-sm sm:text-base lg:text-lg font-medium text-slate-700 border-2 border-slate-200 bg-white hover:bg-slate-50 rounded-xl transition-all">
                  Pelajari Lebih Lanjut
                </a>
              </div>

              {/* Stats */}
              <div className="flex items-center gap-3 sm:gap-4 md:gap-6 lg:gap-8 pt-2 flex-wrap">
                <div>
                  <div className="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">{mockCompanies.length}+</div>
                  <div className="text-xs sm:text-sm text-slate-600">Perusahaan</div>
                </div>
                <div className="h-8 sm:h-10 w-px bg-slate-200"></div>
                <div>
                  <div className="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">250</div>
                  <div className="text-xs sm:text-sm text-slate-600">Kuota Peserta</div>
                </div>
                <div className="h-8 sm:h-10 w-px bg-slate-200"></div>
                <div>
                  <div className="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">100%</div>
                  <div className="text-xs sm:text-sm text-slate-600">Gratis</div>
                </div>
              </div>
            </div>

            {/* Right: Card with Carousel */}
            <div className="relative w-full">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-violet-500/20 rounded-2xl sm:rounded-3xl blur-3xl"></div>
              <div className="relative bg-white/80 backdrop-blur-xl rounded-2xl sm:rounded-3xl border border-slate-200/60 shadow-2xl p-4 sm:p-5 lg:p-8">
                <div className="space-y-4 sm:space-y-5 lg:space-y-6">
                  {/* Card Header */}
                  <div className="flex items-center gap-3 sm:gap-4">
                    <div className="h-12 w-12 sm:h-14 sm:w-14 lg:h-16 lg:w-16 rounded-xl sm:rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg flex-shrink-0">
                      <Building2 className="text-white w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8" />
                    </div>
                    <div>
                      <div className="text-lg sm:text-xl lg:text-2xl font-bold text-slate-900">{mockCompanies.length} Perusahaan</div>
                      <div className="text-xs sm:text-sm lg:text-base text-slate-600">Terkemuka & Terpercaya</div>
                    </div>
                  </div>

                  {/* Logo Carousel */}
                  <div className="relative overflow-hidden -mx-4 sm:-mx-5 lg:-mx-8">
                    <div className="flex gap-2 sm:gap-3 animate-[scroll_22s_linear_infinite] hover:[animation-play-state:paused] py-2 px-4 sm:px-5 lg:px-8">
                      {/* First set */}
                      {mockCompanies.map((company) => (
                        <div key={`carousel-1-${company.id}`} className="w-12 h-12 sm:w-14 sm:h-14 lg:w-20 lg:h-20 flex-shrink-0 rounded-xl sm:rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center text-xl sm:text-2xl lg:text-4xl border border-slate-200 shadow-sm">
                          {company.logo_path}
                        </div>
                      ))}
                      {/* Second set for seamless loop */}
                      {mockCompanies.map((company) => (
                        <div key={`carousel-2-${company.id}`} className="w-12 h-12 sm:w-14 sm:h-14 lg:w-20 lg:h-20 flex-shrink-0 rounded-xl sm:rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center text-xl sm:text-2xl lg:text-4xl border border-slate-200 shadow-sm">
                          {company.logo_path}
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* CTA Banner */}
                  <div className="bg-gradient-to-r from-blue-50 to-violet-50 rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-blue-100">
                    <div className="flex items-center gap-2 sm:gap-3">
                      <div className="h-8 w-8 sm:h-9 sm:w-9 lg:h-10 lg:w-10 rounded-lg sm:rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0">
                        <CheckCircle className="text-white w-4 h-4 sm:w-5 sm:h-5" />
                      </div>
                      <div>
                        <div className="text-sm sm:text-base font-semibold text-slate-900">Lamar hingga 12 posisi</div>
                        <div className="text-xs sm:text-sm text-slate-600">Maksimalkan peluang karirmu</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section - Companies */}
      <section id="features" className="py-12 sm:py-16 lg:py-20 bg-white/50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-10 sm:mb-16">
            <span className="inline-block mb-3 sm:mb-4 bg-blue-100 text-blue-900 text-xs font-semibold px-3 py-1 rounded-full">
              Perusahaan Peserta
            </span>
            <h2 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-3 sm:mb-4 px-4">Temukan Perusahaan Impianmu</h2>
            <p className="text-base sm:text-lg lg:text-xl text-slate-600 max-w-2xl mx-auto px-4">
              Bergabunglah dan lamar ke perusahaan-perusahaan terkemuka yang berpartisipasi di JobFair 2026
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            {mockCompanies.map((company, index) => {
              const isApplied = appliedIds.includes(company.id);
              const isFeatured = index === 0;

              return (
                <div
                  key={company.id}
                  onClick={() => openCompanyModal(company)}
                  className={`bg-white rounded-xl sm:rounded-2xl border overflow-hidden transition-all cursor-pointer group relative hover:shadow-lg hover:-translate-y-1 ${
                    isApplied
                      ? 'ring-2 ring-emerald-400/40 border-emerald-200'
                      : isFeatured
                        ? 'ring-2 ring-blue-500/20 border-slate-200/60'
                        : 'border-slate-200/60'
                  }`}
                >
                  {/* Badges */}
                  {isApplied ? (
                    <div className="bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold px-2.5 sm:px-3 py-1 flex items-center gap-1 w-max rounded-br-lg absolute top-0 left-0 animate-pulse">
                      <CheckCircle className="w-3 h-3" /> Sudah Dilamar
                    </div>
                  ) : isFeatured ? (
                    <div className="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-semibold px-2.5 sm:px-3 py-1 flex items-center gap-1 w-max rounded-br-lg absolute top-0 left-0">
                      <Star className="w-3 h-3" /> Featured
                    </div>
                  ) : null}

                  <div className={`p-4 sm:p-6 ${isFeatured || isApplied ? 'pt-8 sm:pt-10' : ''}`}>
                    {/* Logo + Company Name */}
                    <div className="flex items-start gap-3 sm:gap-4 mb-3 sm:mb-4">
                      <div className="h-12 w-12 sm:h-14 sm:w-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-2xl sm:text-3xl shadow-sm flex-shrink-0">
                        {company.logo_path}
                      </div>
                      <div className="flex-1 min-w-0">
                        <h3 className="text-sm sm:text-base font-bold text-slate-800 line-clamp-1 group-hover:text-blue-600 transition-colors">
                          {company.name}
                        </h3>
                        {company.position_name && (
                          <div className="mt-1 sm:mt-1.5 flex items-center gap-1 sm:gap-1.5">
                            <Briefcase className="text-blue-500 w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" />
                            <span className="text-xs sm:text-sm font-semibold text-blue-600 line-clamp-1">{company.position_name}</span>
                          </div>
                        )}
                      </div>
                    </div>

                    {/* Description */}
                    <p className="text-xs sm:text-sm text-slate-600 line-clamp-2 mb-3 sm:mb-4 leading-relaxed">
                      {company.description}
                    </p>

                    {/* Info tags */}
                    <div className="flex flex-wrap gap-1.5 sm:gap-2 mb-3 sm:mb-4">
                      {company.time_to_answer && (
                        <span className="inline-flex items-center gap-1 text-[10px] sm:text-xs bg-slate-50 text-slate-600 border border-slate-200 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg">
                          <Clock className="w-3 h-3 text-slate-400 flex-shrink-0" />
                          <span className="truncate">{company.time_to_answer}</span>
                        </span>
                      )}
                      <span className="inline-flex items-center gap-1 text-[10px] sm:text-xs bg-slate-50 text-slate-600 border border-slate-200 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg">
                        <Users className="w-3 h-3 text-slate-400 flex-shrink-0" />
                        {company.applications_count} pelamar
                      </span>
                    </div>

                    <hr className="border-slate-100 mb-3 sm:mb-4" />

                    <button className="w-full py-2 sm:py-2.5 rounded-lg sm:rounded-xl bg-slate-50 text-slate-700 text-sm sm:text-base font-medium hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center gap-2 border border-slate-200 hover:border-blue-600">
                      Lihat Detail & Lamar
                      <ArrowRight className="w-3 h-3 sm:w-4 sm:h-4" />
                    </button>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* Company Modal */}
      {selectedCompany && (
        <div className="fixed inset-0 z-[100]">
          <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={closeCompanyModal}></div>
          <div className="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4">
            <div className="relative bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl w-full sm:max-w-2xl border-t sm:border border-slate-100 max-h-[90vh] overflow-y-auto">
              {/* Modal Header */}
              <div className="px-4 sm:px-8 py-5 sm:py-7 border-b border-slate-100 bg-slate-50/50 sticky top-0 z-10">
                <div className="flex items-start gap-3 sm:gap-5">
                  <div className="h-14 w-14 sm:h-20 sm:w-20 rounded-xl sm:rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-3xl sm:text-5xl shadow-sm flex-shrink-0">
                    {selectedCompany.logo_path}
                  </div>
                  <div className="flex-1 pt-0 sm:pt-1 min-w-0">
                    <h3 className="text-lg sm:text-2xl font-bold text-slate-900 mb-2 sm:mb-3 line-clamp-2">{selectedCompany.name}</h3>
                    <div className="flex flex-wrap gap-1.5 sm:gap-2 text-xs">
                      {selectedCompany.position_name && (
                        <span className="bg-gradient-to-r from-blue-600 to-violet-600 text-white px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg font-semibold flex items-center gap-1 sm:gap-1.5">
                          <Briefcase className="w-3 h-3" /> {selectedCompany.position_name}
                        </span>
                      )}
                      {selectedCompany.selection && (
                        <span className="bg-white border border-slate-200 text-slate-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg font-medium shadow-sm">
                          {selectedCompany.selection}
                        </span>
                      )}
                      {selectedCompany.time_to_answer && (
                        <span className="bg-white border border-slate-200 text-slate-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg flex items-center gap-1 sm:gap-1.5 font-medium shadow-sm">
                          <Clock className="w-3 h-3 text-slate-400" /> {selectedCompany.time_to_answer}
                        </span>
                      )}
                    </div>
                  </div>
                  <button
                    onClick={closeCompanyModal}
                    className="text-slate-400 hover:text-slate-700 bg-white hover:bg-slate-100 h-8 w-8 sm:h-10 sm:w-10 rounded-full flex items-center justify-center transition-colors border border-slate-200 flex-shrink-0"
                  >
                    <X className="w-4 h-4 sm:w-5 sm:h-5" />
                  </button>
                </div>
              </div>

              {/* Modal Body */}
              <div className="px-4 sm:px-8 py-6 sm:py-8 space-y-5 sm:space-y-6">
                {/* Description */}
                {selectedCompany.description && (
                  <div>
                    <h4 className="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                      <div className="h-7 w-7 sm:h-8 sm:w-8 rounded-lg sm:rounded-xl bg-blue-100 flex items-center justify-center">
                        <Briefcase className="text-blue-600 w-3.5 h-3.5 sm:w-4 sm:h-4" />
                      </div>
                      Tentang Perusahaan
                    </h4>
                    <p className="text-sm sm:text-[15px] text-slate-600 leading-relaxed pl-0 sm:pl-10">{selectedCompany.description}</p>
                  </div>
                )}

                {/* Responsibilities */}
                {selectedCompany.job_responsibilities && (
                  <>
                    <hr className="border-slate-100" />
                    <div>
                      <h4 className="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                        <div className="h-7 w-7 sm:h-8 sm:w-8 rounded-lg sm:rounded-xl bg-violet-100 flex items-center justify-center">
                          <ListChecks className="text-violet-600 w-3.5 h-3.5 sm:w-4 sm:h-4" />
                        </div>
                        Job Responsibilities
                      </h4>
                      <p className="text-sm sm:text-[15px] text-slate-600 leading-relaxed pl-0 sm:pl-10 whitespace-pre-line">{selectedCompany.job_responsibilities}</p>
                    </div>
                  </>
                )}

                {/* Requirements */}
                {selectedCompany.requirements && (
                  <>
                    <hr className="border-slate-100" />
                    <div>
                      <h4 className="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                        <div className="h-7 w-7 sm:h-8 sm:w-8 rounded-lg sm:rounded-xl bg-emerald-100 flex items-center justify-center">
                          <CheckCircle className="text-emerald-600 w-3.5 h-3.5 sm:w-4 sm:h-4" />
                        </div>
                        Requirements
                      </h4>
                      <p className="text-sm sm:text-[15px] text-slate-600 leading-relaxed pl-0 sm:pl-10 whitespace-pre-line">{selectedCompany.requirements}</p>
                    </div>
                  </>
                )}

                <div className="pt-2 border-t border-slate-100">
                  <a
                    href="/peserta"
                    className="w-full h-12 sm:h-14 rounded-xl sm:rounded-2xl text-white font-semibold text-base sm:text-lg bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 shadow-xl shadow-blue-500/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                  >
                    Daftar & Lamar Sekarang
                    <ArrowRight className="w-4 h-4 sm:w-5 sm:h-5" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* How It Works */}
      <section id="how-it-works" className="py-12 sm:py-16 lg:py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-10 sm:mb-16">
            <span className="inline-block mb-3 sm:mb-4 bg-violet-100 text-violet-900 text-xs font-semibold px-3 py-1 rounded-full">
              Cara Kerja
            </span>
            <h2 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-3 sm:mb-4 px-4">3 Langkah Menuju Karir Impian</h2>
          </div>

          <div className="grid sm:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            <div className="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl sm:rounded-2xl shadow-xl p-5 sm:p-6 lg:p-8">
              <div className="h-12 w-12 sm:h-16 sm:w-16 rounded-xl sm:rounded-2xl bg-white/20 flex items-center justify-center mb-3 sm:mb-4 mx-auto">
                <span className="text-2xl sm:text-3xl font-bold">1</span>
              </div>
              <h3 className="text-center text-base sm:text-lg font-semibold mb-2">Daftar & Verifikasi</h3>
              <p className="text-center text-blue-100 text-sm sm:text-base">Buat akun menggunakan NIK dan data pribadi. Admin akan memverifikasi dalam 24 jam.</p>
            </div>

            <div className="bg-gradient-to-br from-violet-500 to-violet-600 text-white rounded-xl sm:rounded-2xl shadow-xl p-5 sm:p-6 lg:p-8">
              <div className="h-12 w-12 sm:h-16 sm:w-16 rounded-xl sm:rounded-2xl bg-white/20 flex items-center justify-center mb-3 sm:mb-4 mx-auto">
                <span className="text-2xl sm:text-3xl font-bold">2</span>
              </div>
              <h3 className="text-center text-base sm:text-lg font-semibold mb-2">Jelajahi Perusahaan</h3>
              <p className="text-center text-violet-100 text-sm sm:text-base">Lihat profil 12 perusahaan, persyaratan, dan posisi yang tersedia.</p>
            </div>

            <div className="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-xl sm:rounded-2xl shadow-xl p-5 sm:p-6 lg:p-8">
              <div className="h-12 w-12 sm:h-16 sm:w-16 rounded-xl sm:rounded-2xl bg-white/20 flex items-center justify-center mb-3 sm:mb-4 mx-auto">
                <span className="text-2xl sm:text-3xl font-bold">3</span>
              </div>
              <h3 className="text-center text-base sm:text-lg font-semibold mb-2">Lamar & Tunggu</h3>
              <p className="text-center text-emerald-100 text-sm sm:text-base">Lamar hingga 12 perusahaan dan tunggu panggilan interview dari HR.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Event Info */}
      <section className="py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-slate-900 to-slate-800 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div className="space-y-5 sm:space-y-6">
              <h2 className="text-2xl sm:text-3xl lg:text-4xl font-bold">Informasi Event</h2>
              <div className="space-y-3 sm:space-y-4">
                <div className="flex items-start gap-3 sm:gap-4">
                  <div className="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <Calendar className="text-blue-400 w-5 h-5 sm:w-6 sm:h-6" />
                  </div>
                  <div>
                    <div className="font-semibold text-base sm:text-lg">3 - 10 Juni 2026</div>
                    <div className="text-slate-300 text-sm">Pendaftaran dibuka selama 1 minggu</div>
                  </div>
                </div>
                <div className="flex items-start gap-3 sm:gap-4">
                  <div className="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <MapPin className="text-violet-400 w-5 h-5 sm:w-6 sm:h-6" />
                  </div>
                  <div>
                    <div className="font-semibold text-base sm:text-lg">Online Platform</div>
                    <div className="text-slate-300 text-sm">Akses dari mana saja, kapan saja</div>
                  </div>
                </div>
                <div className="flex items-start gap-3 sm:gap-4">
                  <div className="h-10 w-10 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <Users className="text-emerald-400 w-5 h-5 sm:w-6 sm:h-6" />
                  </div>
                  <div>
                    <div className="font-semibold text-base sm:text-lg">Kuota Terbatas</div>
                    <div className="text-slate-300 text-sm">Hanya 250 peserta yang akan diterima</div>
                  </div>
                </div>
              </div>
            </div>

            <div className="bg-gradient-to-br from-blue-500/20 to-violet-500/20 rounded-2xl sm:rounded-3xl p-5 sm:p-6 lg:p-8 border border-white/10">
              <div className="space-y-5 sm:space-y-6">
                <div className="text-center">
                  <div className="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/30 rounded-full px-3 sm:px-4 py-1.5 sm:py-2 mb-3 sm:mb-4">
                    <Circle className="h-2 w-2 bg-green-400 rounded-full animate-pulse fill-current" />
                    <span className="text-xs sm:text-sm font-medium text-green-300">Pendaftaran Dibuka</span>
                  </div>
                  <div className="text-4xl sm:text-5xl lg:text-6xl font-bold mb-2">
                    186<span className="text-2xl sm:text-3xl lg:text-4xl text-slate-400">/250</span>
                  </div>
                  <div className="text-sm sm:text-base text-slate-300">Peserta terdaftar</div>
                </div>
                <div className="bg-white/10 rounded-full h-3 sm:h-4 overflow-hidden">
                  <div className="bg-gradient-to-r from-blue-500 to-violet-500 h-full rounded-full" style={{ width: '74.4%' }}></div>
                </div>
                <a href="/peserta" className="flex items-center justify-center gap-2 w-full h-12 sm:h-14 text-base sm:text-lg font-semibold bg-white text-slate-900 hover:bg-slate-100 rounded-xl sm:rounded-2xl transition-colors">
                  Daftar Sebelum Terlambat
                  <ArrowRight className="w-4 h-4 sm:w-5 sm:h-5" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-slate-900 text-white py-8 sm:py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-6">
            <div className="flex items-center gap-3">
              <div className="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center">
                <Briefcase className="text-white w-5 h-5" />
              </div>
              <div>
                <div className="font-bold text-sm sm:text-base">JobFair 2026</div>
                <div className="text-xs sm:text-sm text-slate-400">Powered by Technology</div>
              </div>
            </div>
            <div className="text-xs sm:text-sm text-slate-400">&copy; 2026 JobFair. All rights reserved.</div>
          </div>
        </div>
      </footer>

      <style>{`
        @keyframes scroll {
          0% { transform: translateX(0); }
          100% { transform: translateX(-50%); }
        }
      `}</style>
    </div>
  );
}
