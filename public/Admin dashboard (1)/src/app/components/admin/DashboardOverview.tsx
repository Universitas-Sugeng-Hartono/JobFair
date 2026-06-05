import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../ui/card';
import { Building2, Users, FileText, CheckCircle, TrendingUp, ArrowUpRight, ArrowDownRight } from 'lucide-react';
import { Progress } from '../ui/progress';

export function DashboardOverview() {
  const stats = {
    companies: 12,
    totalParticipants: 186,
    maxParticipants: 250,
    pendingParticipants: 24,
    approvedParticipants: 162,
    totalApplications: 1248,
    averageApplicationsPerParticipant: 7.7
  };

  const participantProgress = (stats.totalParticipants / stats.maxParticipants) * 100;

  return (
    <div className="space-y-6">
      {/* Modern Stats Cards with Gradients */}
      <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <Card className="border-none shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white overflow-hidden relative">
          <div className="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium text-white/90">Total Perusahaan</CardTitle>
            <div className="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
              <Building2 className="h-5 w-5 text-white" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold">{stats.companies}</div>
            <div className="flex items-center gap-1 mt-2">
              <ArrowUpRight className="h-3 w-3" />
              <p className="text-xs text-white/80">
                +2 bulan ini
              </p>
            </div>
          </CardContent>
        </Card>

        <Card className="border-none shadow-lg bg-gradient-to-br from-violet-500 to-purple-600 text-white overflow-hidden relative">
          <div className="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium text-white/90">Total Peserta</CardTitle>
            <div className="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
              <Users className="h-5 w-5 text-white" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold">{stats.totalParticipants}<span className="text-xl text-white/70">/{stats.maxParticipants}</span></div>
            <div className="mt-3">
              <Progress value={participantProgress} className="h-2 bg-white/20" />
            </div>
            <p className="text-xs text-white/80 mt-2">
              {Math.round(participantProgress)}% kapasitas terisi
            </p>
          </CardContent>
        </Card>

        <Card className="border-none shadow-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white overflow-hidden relative">
          <div className="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium text-white/90">Total Lamaran</CardTitle>
            <div className="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
              <FileText className="h-5 w-5 text-white" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold">{stats.totalApplications.toLocaleString()}</div>
            <p className="text-xs text-white/80 mt-2">
              Rata-rata {stats.averageApplicationsPerParticipant}/peserta
            </p>
          </CardContent>
        </Card>

        <Card className="border-none shadow-lg bg-gradient-to-br from-amber-500 to-orange-600 text-white overflow-hidden relative">
          <div className="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium text-white/90">Pending Approval</CardTitle>
            <div className="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
              <TrendingUp className="h-5 w-5 text-white" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold">{stats.pendingParticipants}</div>
            <div className="flex items-center justify-between mt-2">
              <p className="text-xs text-white/80">Perlu ditinjau</p>
              <div className="flex items-center gap-1">
                <CheckCircle className="h-3 w-3" />
                <span className="text-xs">{stats.approvedParticipants} approved</span>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <div className="grid gap-6 md:grid-cols-2">
        <Card className="border-slate-200/60 shadow-lg">
          <CardHeader className="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-transparent">
            <CardTitle className="flex items-center gap-2">
              <div className="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center">
                <TrendingUp className="h-4 w-4 text-blue-600" />
              </div>
              Perusahaan Populer
            </CardTitle>
            <CardDescription>Top 5 perusahaan berdasarkan jumlah lamaran</CardDescription>
          </CardHeader>
          <CardContent className="pt-6">
            <div className="space-y-5">
              {[
                { name: 'PT Teknologi Maju', applications: 142, color: 'from-blue-500 to-blue-600' },
                { name: 'PT Inovasi Digital', applications: 128, color: 'from-violet-500 to-purple-600' },
                { name: 'PT Mandiri Sejahtera', applications: 115, color: 'from-emerald-500 to-teal-600' },
                { name: 'PT Global Solutions', applications: 98, color: 'from-amber-500 to-orange-600' },
                { name: 'PT Kreatif Indonesia', applications: 87, color: 'from-pink-500 to-rose-600' }
              ].map((company, index) => (
                <div key={index} className="space-y-2.5">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                      <div className="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-xs font-semibold text-slate-600">
                        {index + 1}
                      </div>
                      <span className="font-medium text-sm">{company.name}</span>
                    </div>
                    <span className="text-sm font-semibold text-slate-900">{company.applications}</span>
                  </div>
                  <div className="relative h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div
                      className={`absolute inset-y-0 left-0 bg-gradient-to-r ${company.color} rounded-full transition-all duration-500`}
                      style={{ width: `${(company.applications / 142) * 100}%` }}
                    ></div>
                  </div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        <Card className="border-slate-200/60 shadow-lg">
          <CardHeader className="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-transparent">
            <CardTitle className="flex items-center gap-2">
              <div className="h-8 w-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                <FileText className="h-4 w-4 text-emerald-600" />
              </div>
              Aktivitas Terbaru
            </CardTitle>
            <CardDescription>Real-time activity feed</CardDescription>
          </CardHeader>
          <CardContent className="pt-6">
            <div className="space-y-4">
              {[
                { action: 'Peserta baru terdaftar', name: 'Rina Wijaya', time: '5 menit lalu', type: 'user' },
                { action: 'Lamaran baru', name: 'Budi Santoso ke PT Teknologi Maju', time: '12 menit lalu', type: 'application' },
                { action: 'Peserta disetujui', name: 'Siti Nurhaliza', time: '23 menit lalu', type: 'approve' },
                { action: 'Perusahaan baru', name: 'PT Kreatif Indonesia', time: '1 jam lalu', type: 'company' },
                { action: 'Lamaran baru', name: 'Ahmad Fauzi ke PT Inovasi Digital', time: '1 jam lalu', type: 'application' },
                { action: 'Peserta baru terdaftar', name: 'Dewi Lestari', time: '2 jam lalu', type: 'user' }
              ].map((activity, index) => (
                <div key={index} className="flex items-start gap-3 group">
                  <div className={`h-8 w-8 rounded-lg flex items-center justify-center flex-shrink-0 ${
                    activity.type === 'user' ? 'bg-blue-100' :
                    activity.type === 'application' ? 'bg-emerald-100' :
                    activity.type === 'approve' ? 'bg-green-100' :
                    'bg-violet-100'
                  }`}>
                    {activity.type === 'user' && <Users className="h-4 w-4 text-blue-600" />}
                    {activity.type === 'application' && <FileText className="h-4 w-4 text-emerald-600" />}
                    {activity.type === 'approve' && <CheckCircle className="h-4 w-4 text-green-600" />}
                    {activity.type === 'company' && <Building2 className="h-4 w-4 text-violet-600" />}
                  </div>
                  <div className="min-w-0 flex-1">
                    <p className="text-sm font-medium text-slate-900">{activity.action}</p>
                    <p className="text-sm text-slate-600 truncate">{activity.name}</p>
                  </div>
                  <span className="text-xs text-slate-400 whitespace-nowrap">{activity.time}</span>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
