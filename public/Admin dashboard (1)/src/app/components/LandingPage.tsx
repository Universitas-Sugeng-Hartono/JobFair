import { Button } from './ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Badge } from './ui/badge';
import {
  Briefcase,
  Users,
  Building2,
  CheckCircle,
  TrendingUp,
  Target,
  ArrowRight,
  Calendar,
  MapPin,
  Award,
  Sparkles
} from 'lucide-react';

interface LandingPageProps {
  onGetStarted: () => void;
}

export function LandingPage({ onGetStarted }: LandingPageProps) {
  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
      {/* Navigation */}
      <nav className="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div className="max-w-7xl mx-auto px-6 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <div className="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <Briefcase className="h-5 w-5 text-white" />
              </div>
              <div>
                <h1 className="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                  JobFair 2026
                </h1>
              </div>
            </div>
            <Button
              onClick={onGetStarted}
              className="bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 shadow-md"
            >
              Daftar Sekarang
              <ArrowRight className="ml-2 h-4 w-4" />
            </Button>
          </div>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-blue-600/5 via-violet-600/5 to-transparent"></div>
        <div className="max-w-7xl mx-auto px-6 py-20 lg:py-32">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="space-y-8">
              <div className="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-4 py-2">
                <Sparkles className="h-4 w-4 text-blue-600" />
                <span className="text-sm font-medium text-blue-900">Event Career Terbesar 2026</span>
              </div>

              <div className="space-y-4">
                <h1 className="text-5xl lg:text-6xl font-bold leading-tight">
                  <span className="bg-gradient-to-r from-slate-900 via-blue-900 to-violet-900 bg-clip-text text-transparent">
                    Wujudkan Karir
                  </span>
                  <br />
                  <span className="bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                    Impianmu
                  </span>
                </h1>
                <p className="text-xl text-slate-600 leading-relaxed">
                  Bergabunglah dengan JobFair 2026 dan temukan peluang karir dari 12+ perusahaan terkemuka di Indonesia. Satu platform, ribuan peluang.
                </p>
              </div>

              <div className="flex flex-wrap gap-4">
                <Button
                  size="lg"
                  onClick={onGetStarted}
                  className="h-14 px-8 text-lg bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 shadow-xl shadow-blue-500/20"
                >
                  Mulai Sekarang
                  <ArrowRight className="ml-2 h-5 w-5" />
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  className="h-14 px-8 text-lg border-2"
                >
                  Pelajari Lebih Lanjut
                </Button>
              </div>

              <div className="flex items-center gap-8 pt-4">
                <div>
                  <div className="text-3xl font-bold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                    12+
                  </div>
                  <div className="text-sm text-slate-600">Perusahaan</div>
                </div>
                <div className="h-12 w-px bg-slate-200"></div>
                <div>
                  <div className="text-3xl font-bold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                    250
                  </div>
                  <div className="text-sm text-slate-600">Kuota Peserta</div>
                </div>
                <div className="h-12 w-px bg-slate-200"></div>
                <div>
                  <div className="text-3xl font-bold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                    100%
                  </div>
                  <div className="text-sm text-slate-600">Gratis</div>
                </div>
              </div>
            </div>

            <div className="relative">
              <div className="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-violet-500/20 rounded-3xl blur-3xl"></div>
              <div className="relative bg-white/80 backdrop-blur-xl rounded-3xl border border-slate-200/60 shadow-2xl p-8">
                <div className="space-y-6">
                  <div className="flex items-center gap-4">
                    <div className="h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                      <Building2 className="h-8 w-8 text-white" />
                    </div>
                    <div>
                      <div className="text-2xl font-bold text-slate-900">12 Perusahaan</div>
                      <div className="text-slate-600">Terkemuka & Terpercaya</div>
                    </div>
                  </div>

                  <div className="grid grid-cols-3 gap-4">
                    {['🏢', '💻', '🏭', '🌏', '🎨', '🏦'].map((emoji, i) => (
                      <div key={i} className="aspect-square rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center text-4xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                        {emoji}
                      </div>
                    ))}
                  </div>

                  <div className="bg-gradient-to-r from-blue-50 to-violet-50 rounded-2xl p-4 border border-blue-100">
                    <div className="flex items-center gap-3">
                      <div className="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center">
                        <Target className="h-5 w-5 text-white" />
                      </div>
                      <div>
                        <div className="font-semibold text-slate-900">Lamar hingga 12 posisi</div>
                        <div className="text-sm text-slate-600">Maksimalkan peluang karirmu</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-white/50">
        <div className="max-w-7xl mx-auto px-6">
          <div className="text-center mb-16">
            <Badge className="mb-4 bg-blue-100 text-blue-900 hover:bg-blue-100">
              Kenapa JobFair 2026?
            </Badge>
            <h2 className="text-4xl font-bold text-slate-900 mb-4">
              Keunggulan Platform Kami
            </h2>
            <p className="text-xl text-slate-600 max-w-2xl mx-auto">
              Proses melamar pekerjaan yang mudah, cepat, dan efisien untuk semua peserta
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            <Card className="border-slate-200/60 shadow-lg hover:shadow-xl transition-shadow">
              <CardHeader>
                <div className="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 shadow-lg shadow-blue-500/20">
                  <CheckCircle className="h-7 w-7 text-white" />
                </div>
                <CardTitle>Proses Mudah & Cepat</CardTitle>
                <CardDescription>
                  Daftar sekali, lamar ke 12 perusahaan. Tidak perlu isi formulir berulang kali.
                </CardDescription>
              </CardHeader>
            </Card>

            <Card className="border-slate-200/60 shadow-lg hover:shadow-xl transition-shadow">
              <CardHeader>
                <div className="h-14 w-14 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center mb-4 shadow-lg shadow-violet-500/20">
                  <Building2 className="h-7 w-7 text-white" />
                </div>
                <CardTitle>Perusahaan Terpercaya</CardTitle>
                <CardDescription>
                  Semua perusahaan telah diverifikasi dan merupakan perusahaan terkemuka di Indonesia.
                </CardDescription>
              </CardHeader>
            </Card>

            <Card className="border-slate-200/60 shadow-lg hover:shadow-xl transition-shadow">
              <CardHeader>
                <div className="h-14 w-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-4 shadow-lg shadow-emerald-500/20">
                  <Award className="h-7 w-7 text-white" />
                </div>
                <CardTitle>100% Gratis</CardTitle>
                <CardDescription>
                  Tidak ada biaya pendaftaran atau biaya tersembunyi. Sepenuhnya gratis untuk peserta.
                </CardDescription>
              </CardHeader>
            </Card>
          </div>
        </div>
      </section>

      {/* How It Works */}
      <section className="py-20">
        <div className="max-w-7xl mx-auto px-6">
          <div className="text-center mb-16">
            <Badge className="mb-4 bg-violet-100 text-violet-900 hover:bg-violet-100">
              Cara Kerja
            </Badge>
            <h2 className="text-4xl font-bold text-slate-900 mb-4">
              3 Langkah Menuju Karir Impian
            </h2>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            <div className="relative">
              <div className="absolute top-8 left-1/2 -translate-x-1/2 w-full h-0.5 bg-gradient-to-r from-blue-200 to-violet-200 hidden md:block"></div>
              <Card className="relative border-none shadow-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                <CardHeader>
                  <div className="h-16 w-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 mx-auto">
                    <div className="text-3xl font-bold">1</div>
                  </div>
                  <CardTitle className="text-center text-white">Daftar & Verifikasi</CardTitle>
                  <CardDescription className="text-center text-blue-100">
                    Buat akun menggunakan NIK dan data pribadi. Admin akan memverifikasi dalam 24 jam.
                  </CardDescription>
                </CardHeader>
              </Card>
            </div>

            <div className="relative">
              <Card className="relative border-none shadow-xl bg-gradient-to-br from-violet-500 to-violet-600 text-white">
                <CardHeader>
                  <div className="h-16 w-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 mx-auto">
                    <div className="text-3xl font-bold">2</div>
                  </div>
                  <CardTitle className="text-center text-white">Jelajahi Perusahaan</CardTitle>
                  <CardDescription className="text-center text-violet-100">
                    Lihat profil 12 perusahaan, persyaratan, dan posisi yang tersedia.
                  </CardDescription>
                </CardHeader>
              </Card>
            </div>

            <div className="relative">
              <Card className="relative border-none shadow-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white">
                <CardHeader>
                  <div className="h-16 w-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 mx-auto">
                    <div className="text-3xl font-bold">3</div>
                  </div>
                  <CardTitle className="text-center text-white">Lamar & Tunggu</CardTitle>
                  <CardDescription className="text-center text-emerald-100">
                    Lamar hingga 12 perusahaan dan tunggu panggilan interview dari HR.
                  </CardDescription>
                </CardHeader>
              </Card>
            </div>
          </div>
        </div>
      </section>

      {/* Event Info */}
      <section className="py-20 bg-gradient-to-br from-slate-900 to-slate-800 text-white">
        <div className="max-w-7xl mx-auto px-6">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div className="space-y-6">
              <h2 className="text-4xl font-bold">
                Informasi Event
              </h2>
              <div className="space-y-4">
                <div className="flex items-start gap-4">
                  <div className="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <Calendar className="h-6 w-6 text-blue-400" />
                  </div>
                  <div>
                    <div className="font-semibold text-lg">3 - 10 Juni 2026</div>
                    <div className="text-slate-300">Pendaftaran dibuka selama 1 minggu</div>
                  </div>
                </div>
                <div className="flex items-start gap-4">
                  <div className="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <MapPin className="h-6 w-6 text-violet-400" />
                  </div>
                  <div>
                    <div className="font-semibold text-lg">Online Platform</div>
                    <div className="text-slate-300">Akses dari mana saja, kapan saja</div>
                  </div>
                </div>
                <div className="flex items-start gap-4">
                  <div className="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <Users className="h-6 w-6 text-emerald-400" />
                  </div>
                  <div>
                    <div className="font-semibold text-lg">Kuota Terbatas</div>
                    <div className="text-slate-300">Hanya 250 peserta yang akan diterima</div>
                  </div>
                </div>
              </div>
            </div>

            <div className="relative">
              <div className="bg-gradient-to-br from-blue-500/20 to-violet-500/20 rounded-3xl p-8 backdrop-blur-sm border border-white/10">
                <div className="space-y-6">
                  <div className="text-center">
                    <div className="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/30 rounded-full px-4 py-2 mb-4">
                      <div className="h-2 w-2 bg-green-400 rounded-full animate-pulse"></div>
                      <span className="text-sm font-medium text-green-300">Pendaftaran Dibuka</span>
                    </div>
                    <div className="text-6xl font-bold mb-2">186/250</div>
                    <div className="text-slate-300">Peserta terdaftar</div>
                  </div>
                  <div className="bg-white/10 rounded-full h-4 overflow-hidden">
                    <div className="bg-gradient-to-r from-blue-500 to-violet-500 h-full" style={{ width: '74.4%' }}></div>
                  </div>
                  <Button
                    size="lg"
                    onClick={onGetStarted}
                    className="w-full h-14 text-lg bg-white text-slate-900 hover:bg-slate-100"
                  >
                    Daftar Sebelum Terlambat
                    <ArrowRight className="ml-2 h-5 w-5" />
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-slate-900 text-white py-12">
        <div className="max-w-7xl mx-auto px-6">
          <div className="flex flex-col md:flex-row justify-between items-center gap-6">
            <div className="flex items-center gap-3">
              <div className="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center">
                <Briefcase className="h-5 w-5 text-white" />
              </div>
              <div>
                <div className="font-bold">JobFair 2026</div>
                <div className="text-sm text-slate-400">Powered by Technology</div>
              </div>
            </div>
            <div className="text-sm text-slate-400">
              © 2026 JobFair. All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
