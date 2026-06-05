import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import { Input } from '../ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../ui/table';
import { Badge } from '../ui/badge';
import { Search, Download, FileText, Filter } from 'lucide-react';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../ui/select';

interface Application {
  id: string;
  participantNik: string;
  participantName: string;
  companyId: string;
  companyName: string;
  appliedAt: string;
  status: 'submitted' | 'reviewed' | 'shortlisted';
}

export function ApplicationsSection() {
  const [applications] = useState<Application[]>([
    {
      id: '1',
      participantNik: '3201234567890001',
      participantName: 'Rina Wijaya',
      companyId: '1',
      companyName: 'PT Teknologi Maju',
      appliedAt: '2026-06-02T10:45:00',
      status: 'submitted'
    },
    {
      id: '2',
      participantNik: '3201234567890001',
      participantName: 'Rina Wijaya',
      companyId: '2',
      companyName: 'PT Inovasi Digital',
      appliedAt: '2026-06-02T11:00:00',
      status: 'reviewed'
    },
    {
      id: '3',
      participantNik: '3201234567890002',
      participantName: 'Budi Santoso',
      companyId: '1',
      companyName: 'PT Teknologi Maju',
      appliedAt: '2026-06-02T11:20:00',
      status: 'shortlisted'
    },
    {
      id: '4',
      participantNik: '3201234567890002',
      participantName: 'Budi Santoso',
      companyId: '3',
      companyName: 'PT Mandiri Sejahtera',
      appliedAt: '2026-06-02T11:35:00',
      status: 'submitted'
    },
    {
      id: '5',
      participantNik: '3201234567890003',
      participantName: 'Siti Nurhaliza',
      companyId: '2',
      companyName: 'PT Inovasi Digital',
      appliedAt: '2026-06-02T14:30:00',
      status: 'submitted'
    },
    {
      id: '6',
      participantNik: '3201234567890003',
      participantName: 'Siti Nurhaliza',
      companyId: '4',
      companyName: 'PT Global Solutions',
      appliedAt: '2026-06-02T14:45:00',
      status: 'reviewed'
    }
  ]);

  const [searchQuery, setSearchQuery] = useState('');
  const [companyFilter, setCompanyFilter] = useState<string>('all');
  const [statusFilter, setStatusFilter] = useState<string>('all');

  const companies = Array.from(new Set(applications.map(a => a.companyName))).sort();

  const filteredApplications = applications.filter(app => {
    const matchesSearch =
      app.participantName.toLowerCase().includes(searchQuery.toLowerCase()) ||
      app.participantNik.includes(searchQuery) ||
      app.companyName.toLowerCase().includes(searchQuery.toLowerCase());

    const matchesCompany = companyFilter === 'all' || app.companyName === companyFilter;
    const matchesStatus = statusFilter === 'all' || app.status === statusFilter;

    return matchesSearch && matchesCompany && matchesStatus;
  });

  const handleExport = () => {
    const csv = [
      ['NIK', 'Nama Peserta', 'Perusahaan', 'Tanggal Lamar', 'Status'],
      ...applications.map(a => [
        a.participantNik,
        a.participantName,
        a.companyName,
        new Date(a.appliedAt).toLocaleString('id-ID'),
        a.status
      ])
    ].map(row => row.join(',')).join('\n');

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `lamaran_${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
  };

  return (
    <Card className="border-slate-200/60 shadow-lg">
      <CardHeader className="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-transparent">
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <CardTitle className="flex items-center gap-2">
              <div className="h-9 w-9 rounded-xl bg-emerald-100 flex items-center justify-center">
                <FileText className="h-5 w-5 text-emerald-600" />
              </div>
              Manajemen Lamaran
            </CardTitle>
            <CardDescription>Lihat semua lamaran peserta ke perusahaan</CardDescription>
          </div>
          <Button variant="outline" size="sm" onClick={handleExport} className="shadow-sm">
            <Download className="h-4 w-4 mr-2" />
            Export CSV
          </Button>
        </div>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          <div className="flex flex-col lg:flex-row gap-3">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
              <Input
                placeholder="Cari NIK, nama peserta, atau perusahaan..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-9"
              />
            </div>
            <div className="flex gap-3">
              <Select value={companyFilter} onValueChange={setCompanyFilter}>
                <SelectTrigger className="w-[200px]">
                  <SelectValue placeholder="Semua Perusahaan" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">Semua Perusahaan</SelectItem>
                  {companies.map(company => (
                    <SelectItem key={company} value={company}>{company}</SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <Select value={statusFilter} onValueChange={setStatusFilter}>
                <SelectTrigger className="w-[150px]">
                  <SelectValue placeholder="Semua Status" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">Semua Status</SelectItem>
                  <SelectItem value="submitted">Submitted</SelectItem>
                  <SelectItem value="reviewed">Reviewed</SelectItem>
                  <SelectItem value="shortlisted">Shortlisted</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>

          <div className="border rounded-lg">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>NIK</TableHead>
                  <TableHead>Nama Peserta</TableHead>
                  <TableHead>Perusahaan</TableHead>
                  <TableHead className="hidden lg:table-cell">Tanggal Lamar</TableHead>
                  <TableHead className="text-center">Status</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredApplications.map((application) => (
                  <TableRow key={application.id}>
                    <TableCell className="font-mono text-sm">{application.participantNik}</TableCell>
                    <TableCell className="font-medium">{application.participantName}</TableCell>
                    <TableCell>{application.companyName}</TableCell>
                    <TableCell className="hidden lg:table-cell text-sm text-slate-600">
                      {new Date(application.appliedAt).toLocaleString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                      })}
                    </TableCell>
                    <TableCell className="text-center">
                      <Badge
                        variant={
                          application.status === 'shortlisted' ? 'default' :
                          application.status === 'reviewed' ? 'secondary' :
                          'outline'
                        }
                      >
                        {application.status === 'shortlisted' ? 'Shortlisted' :
                         application.status === 'reviewed' ? 'Reviewed' :
                         'Submitted'}
                      </Badge>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>

          {filteredApplications.length === 0 && (
            <div className="text-center py-12 text-slate-500">
              Tidak ada lamaran ditemukan
            </div>
          )}

          <div className="flex items-center justify-between text-sm text-slate-600 pt-4 border-t">
            <span>Total {filteredApplications.length} lamaran</span>
            <span>Menampilkan semua data</span>
          </div>
        </div>
      </CardContent>
    </Card>
  );
}
