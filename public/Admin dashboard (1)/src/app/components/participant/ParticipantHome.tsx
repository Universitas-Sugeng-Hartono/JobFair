import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import { Input } from '../ui/input';
import { Badge } from '../ui/badge';
import { Search, Briefcase, MapPin, Clock, Users, Filter, ChevronRight, Star } from 'lucide-react';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '../ui/dialog';
import { Separator } from '../ui/separator';
import { Avatar, AvatarFallback } from '../ui/avatar';

interface Company {
  id: string;
  name: string;
  logo: string;
  description: string;
  requirements: string;
  industry: string;
  location: string;
  applications: number;
  featured?: boolean;
}

export function ParticipantHome() {
  const [companies] = useState<Company[]>([
    {
      id: '1',
      name: 'PT Teknologi Maju',
      logo: '🏢',
      description: 'Perusahaan teknologi terkemuka yang fokus pada pengembangan software enterprise dan solusi digital untuk transformasi bisnis.',
      requirements: 'Min. S1 Teknik Informatika/Sistem Informasi, pengalaman 0-2 tahun, menguasai React/Node.js',
      industry: 'Technology',
      location: 'Jakarta Selatan',
      applications: 142,
      featured: true
    },
    {
      id: '2',
      name: 'PT Inovasi Digital',
      logo: '💻',
      description: 'Startup fintech yang berkembang pesat dengan fokus pada digital payment dan financial inclusion.',
      requirements: 'Min. S1 semua jurusan, passion di bidang teknologi dan finance',
      industry: 'Fintech',
      location: 'Jakarta Pusat',
      applications: 128,
      featured: true
    },
    {
      id: '3',
      name: 'PT Mandiri Sejahtera',
      logo: '🏭',
      description: 'Perusahaan manufaktur dengan 20+ tahun pengalaman di industri otomotif dan komponen kendaraan.',
      requirements: 'Min. D3 Teknik Mesin/Elektro, bersedia kerja shift',
      industry: 'Manufacturing',
      location: 'Bekasi',
      applications: 115
    },
    {
      id: '4',
      name: 'PT Global Solutions',
      logo: '🌏',
      description: 'Perusahaan konsultan IT yang melayani klien multinasional dengan berbagai solusi teknologi.',
      requirements: 'Min. S1 Sistem Informasi/Manajemen, bahasa Inggris aktif',
      industry: 'Consulting',
      location: 'Jakarta Selatan',
      applications: 98
    },
    {
      id: '5',
      name: 'PT Kreatif Indonesia',
      logo: '🎨',
      description: 'Agency kreatif digital yang menangani branding, marketing, dan creative campaigns untuk berbagai brand ternama.',
      requirements: 'Min. S1 DKV/Marketing/Komunikasi, portfolio wajib',
      industry: 'Creative Agency',
      location: 'Bandung',
      applications: 87,
      featured: true
    },
    {
      id: '6',
      name: 'PT Sejahtera Abadi',
      logo: '🏦',
      description: 'Perusahaan financial services yang menyediakan solusi perbankan dan investasi terpercaya.',
      requirements: 'Min. S1 Ekonomi/Akuntansi/Manajemen, IPK min 3.0',
      industry: 'Financial Services',
      location: 'Jakarta Pusat',
      applications: 76
    },
    {
      id: '7',
      name: 'PT Edukasi Nusantara',
      logo: '📚',
      description: 'Platform edtech yang menyediakan solusi pembelajaran online untuk berbagai tingkat pendidikan.',
      requirements: 'Min. S1 Pendidikan/Psikologi, passion dalam pendidikan',
      industry: 'Education',
      location: 'Yogyakarta',
      applications: 65
    },
    {
      id: '8',
      name: 'PT Sehat Bersama',
      logo: '🏥',
      description: 'Jaringan rumah sakit dan klinik modern dengan teknologi kesehatan terkini.',
      requirements: 'Min. D3/S1 Kesehatan/Keperawatan/Farmasi, STR aktif',
      industry: 'Healthcare',
      location: 'Surabaya',
      applications: 54
    },
    {
      id: '9',
      name: 'PT Logistik Express',
      logo: '🚚',
      description: 'Perusahaan logistik dan supply chain management dengan jangkauan nasional.',
      requirements: 'Min. S1 Teknik Industri/Logistik/Manajemen Operasional',
      industry: 'Logistics',
      location: 'Tangerang',
      applications: 48
    },
    {
      id: '10',
      name: 'PT Retail Modern',
      logo: '🛒',
      description: 'Jaringan retail modern dengan 100+ toko di seluruh Indonesia dan platform e-commerce.',
      requirements: 'Min. S1 semua jurusan, pengalaman retail diutamakan',
      industry: 'Retail',
      location: 'Jakarta Barat',
      applications: 43
    },
    {
      id: '11',
      name: 'PT Energi Berkelanjutan',
      logo: '⚡',
      description: 'Perusahaan renewable energy yang fokus pada solusi energi terbarukan dan berkelanjutan.',
      requirements: 'Min. S1 Teknik Elektro/Lingkungan/Fisika',
      industry: 'Energy',
      location: 'Serpong',
      applications: 38
    },
    {
      id: '12',
      name: 'PT Media Kreatif',
      logo: '📱',
      description: 'Perusahaan media digital yang mengembangkan konten kreatif untuk berbagai platform.',
      requirements: 'Min. S1 Komunikasi/Broadcasting/Film, portfolio required',
      industry: 'Media',
      location: 'Jakarta Selatan',
      applications: 32
    }
  ]);

  const [searchQuery, setSearchQuery] = useState('');
  const [selectedCompany, setSelectedCompany] = useState<Company | null>(null);
  const [appliedCompanies, setAppliedCompanies] = useState<string[]>([]);

  const filteredCompanies = companies.filter(company =>
    company.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
    company.industry.toLowerCase().includes(searchQuery.toLowerCase()) ||
    company.location.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleApply = (companyId: string) => {
    if (appliedCompanies.length >= 12) {
      alert('Anda sudah mencapai batas maksimal 12 lamaran!');
      return;
    }
    if (appliedCompanies.includes(companyId)) {
      alert('Anda sudah melamar ke perusahaan ini!');
      return;
    }
    setAppliedCompanies([...appliedCompanies, companyId]);
    setSelectedCompany(null);
  };

  const remainingApplications = 12 - appliedCompanies.length;

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
      {/* Hero Header */}
      <header className="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div className="max-w-7xl mx-auto px-6 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-4">
              <div className="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <Briefcase className="h-6 w-6 text-white" />
              </div>
              <div>
                <h1 className="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                  JobFair 2026
                </h1>
                <p className="text-sm text-slate-600">Temukan karir impianmu</p>
              </div>
            </div>

            <div className="flex items-center gap-4">
              <div className="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-50 to-violet-50 border border-blue-100">
                <Users className="h-4 w-4 text-blue-600" />
                <span className="text-sm font-medium text-slate-700">
                  <span className="text-blue-600 font-bold">{appliedCompanies.length}</span>/12 Lamaran
                </span>
              </div>
              <Avatar className="h-10 w-10">
                <AvatarFallback className="bg-gradient-to-br from-violet-600 to-purple-600 text-white">
                  RW
                </AvatarFallback>
              </Avatar>
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-6 py-8">
        {/* Welcome Section */}
        <div className="mb-8">
          <div className="bg-gradient-to-r from-blue-600 to-violet-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
            <div className="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div className="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <div className="relative">
              <h2 className="text-3xl font-bold mb-2">Selamat Datang, Rina Wijaya!</h2>
              <p className="text-blue-100 mb-6">Jelajahi 12 perusahaan terbaik dan lamar hingga 12 posisi yang sesuai dengan keahlianmu</p>
              <div className="flex flex-wrap gap-4">
                <div className="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                  <Briefcase className="h-5 w-5" />
                  <span className="font-medium">{companies.length} Perusahaan</span>
                </div>
                <div className="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                  <Clock className="h-5 w-5" />
                  <span className="font-medium">{remainingApplications} Kuota Tersisa</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Search and Filter */}
        <div className="mb-6">
          <div className="bg-white rounded-2xl shadow-lg border border-slate-200/60 p-4">
            <div className="flex gap-3">
              <div className="relative flex-1">
                <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" />
                <Input
                  placeholder="Cari perusahaan, industri, atau lokasi..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="pl-12 h-12 text-base border-slate-200"
                />
              </div>
              <Button variant="outline" size="lg" className="px-6">
                <Filter className="h-5 w-5 mr-2" />
                Filter
              </Button>
            </div>
          </div>
        </div>

        {/* Companies Grid */}
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {filteredCompanies.map((company) => (
            <Card
              key={company.id}
              className={`group hover:shadow-2xl transition-all duration-300 cursor-pointer border-slate-200/60 overflow-hidden ${
                company.featured ? 'ring-2 ring-blue-500/20' : ''
              } ${appliedCompanies.includes(company.id) ? 'bg-green-50/50 border-green-200' : ''}`}
              onClick={() => setSelectedCompany(company)}
            >
              {company.featured && (
                <div className="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-semibold px-3 py-1 flex items-center gap-1">
                  <Star className="h-3 w-3 fill-white" />
                  Featured Company
                </div>
              )}
              <CardHeader className="pb-3">
                <div className="flex items-start justify-between gap-3">
                  <div className="flex items-center gap-3">
                    <div className="text-4xl">{company.logo}</div>
                    <div className="flex-1 min-w-0">
                      <CardTitle className="text-lg line-clamp-1 group-hover:text-blue-600 transition-colors">
                        {company.name}
                      </CardTitle>
                      <div className="flex items-center gap-1 mt-1">
                        <Badge variant="secondary" className="text-xs">
                          {company.industry}
                        </Badge>
                      </div>
                    </div>
                  </div>
                  {appliedCompanies.includes(company.id) && (
                    <Badge className="bg-green-500 hover:bg-green-600">
                      Applied
                    </Badge>
                  )}
                </div>
              </CardHeader>
              <CardContent className="space-y-3">
                <p className="text-sm text-slate-600 line-clamp-2">
                  {company.description}
                </p>
                <div className="flex flex-col gap-2 text-xs text-slate-500">
                  <div className="flex items-center gap-2">
                    <MapPin className="h-3.5 w-3.5 flex-shrink-0" />
                    <span className="truncate">{company.location}</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <Users className="h-3.5 w-3.5 flex-shrink-0" />
                    <span>{company.applications} pelamar</span>
                  </div>
                </div>
                <Separator />
                <Button
                  className="w-full group/btn"
                  variant={appliedCompanies.includes(company.id) ? 'outline' : 'default'}
                  disabled={appliedCompanies.includes(company.id)}
                >
                  {appliedCompanies.includes(company.id) ? 'Sudah Melamar' : 'Lihat Detail'}
                  <ChevronRight className="h-4 w-4 ml-2 group-hover/btn:translate-x-1 transition-transform" />
                </Button>
              </CardContent>
            </Card>
          ))}
        </div>

        {filteredCompanies.length === 0 && (
          <div className="text-center py-16">
            <div className="text-6xl mb-4">🔍</div>
            <h3 className="text-xl font-semibold text-slate-900 mb-2">Tidak ada perusahaan ditemukan</h3>
            <p className="text-slate-600">Coba kata kunci lain atau ubah filter pencarian</p>
          </div>
        )}
      </main>

      {/* Company Detail Modal */}
      <Dialog open={!!selectedCompany} onOpenChange={() => setSelectedCompany(null)}>
        <DialogContent className="max-w-2xl max-h-[90vh] overflow-y-auto">
          {selectedCompany && (
            <>
              <DialogHeader>
                <div className="flex items-start gap-4">
                  <div className="text-5xl">{selectedCompany.logo}</div>
                  <div className="flex-1">
                    <DialogTitle className="text-2xl mb-2">{selectedCompany.name}</DialogTitle>
                    <div className="flex flex-wrap gap-2">
                      <Badge variant="secondary">{selectedCompany.industry}</Badge>
                      <Badge variant="outline" className="flex items-center gap-1">
                        <MapPin className="h-3 w-3" />
                        {selectedCompany.location}
                      </Badge>
                      <Badge variant="outline" className="flex items-center gap-1">
                        <Users className="h-3 w-3" />
                        {selectedCompany.applications} pelamar
                      </Badge>
                    </div>
                  </div>
                </div>
              </DialogHeader>

              <div className="space-y-6 mt-4">
                <div>
                  <h3 className="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                    <div className="h-6 w-6 rounded-lg bg-blue-100 flex items-center justify-center">
                      <Briefcase className="h-3.5 w-3.5 text-blue-600" />
                    </div>
                    Tentang Perusahaan
                  </h3>
                  <p className="text-slate-700 leading-relaxed">
                    {selectedCompany.description}
                  </p>
                </div>

                <Separator />

                <div>
                  <h3 className="font-semibold text-slate-900 mb-2 flex items-center gap-2">
                    <div className="h-6 w-6 rounded-lg bg-violet-100 flex items-center justify-center">
                      <Users className="h-3.5 w-3.5 text-violet-600" />
                    </div>
                    Persyaratan
                  </h3>
                  <p className="text-slate-700 leading-relaxed">
                    {selectedCompany.requirements}
                  </p>
                </div>

                {appliedCompanies.includes(selectedCompany.id) ? (
                  <div className="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
                    <div className="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0">
                      <ChevronRight className="h-5 w-5 text-white" />
                    </div>
                    <div>
                      <p className="font-semibold text-green-900">Lamaran Terkirim</p>
                      <p className="text-sm text-green-700">Anda sudah melamar ke perusahaan ini</p>
                    </div>
                  </div>
                ) : (
                  <div className="space-y-3">
                    <div className="bg-blue-50 border border-blue-200 rounded-xl p-4">
                      <p className="text-sm text-blue-900">
                        <span className="font-semibold">Kuota tersisa: {remainingApplications}/12</span>
                        <br />
                        <span className="text-blue-700">Anda dapat melamar maksimal 12 perusahaan</span>
                      </p>
                    </div>
                    <Button
                      className="w-full h-12 text-base bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700"
                      onClick={() => handleApply(selectedCompany.id)}
                      disabled={remainingApplications === 0}
                    >
                      {remainingApplications === 0 ? 'Kuota Habis' : 'Lamar Sekarang'}
                    </Button>
                  </div>
                )}
              </div>
            </>
          )}
        </DialogContent>
      </Dialog>
    </div>
  );
}
