import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import { Input } from '../ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../ui/table';
import { Badge } from '../ui/badge';
import { Search, CheckCircle, XCircle, Download, Users, AlertCircle } from 'lucide-react';
import { Alert, AlertDescription } from '../ui/alert';

interface Participant {
  id: string;
  nik: string;
  name: string;
  email: string;
  phone: string;
  status: 'pending' | 'approved' | 'rejected';
  applications: number;
  registeredAt: string;
}

export function ParticipantsSection() {
  const [participants, setParticipants] = useState<Participant[]>([
    {
      id: '1',
      nik: '3201234567890001',
      name: 'Rina Wijaya',
      email: 'rina.wijaya@email.com',
      phone: '081234567890',
      status: 'approved',
      applications: 12,
      registeredAt: '2026-06-02T10:30:00'
    },
    {
      id: '2',
      nik: '3201234567890002',
      name: 'Budi Santoso',
      email: 'budi.santoso@email.com',
      phone: '081234567891',
      status: 'approved',
      applications: 8,
      registeredAt: '2026-06-02T11:15:00'
    },
    {
      id: '3',
      nik: '3201234567890003',
      name: 'Siti Nurhaliza',
      email: 'siti.nurhaliza@email.com',
      phone: '081234567892',
      status: 'approved',
      applications: 5,
      registeredAt: '2026-06-02T14:20:00'
    },
    {
      id: '4',
      nik: '3201234567890004',
      name: 'Ahmad Fauzi',
      email: 'ahmad.fauzi@email.com',
      phone: '081234567893',
      status: 'pending',
      applications: 0,
      registeredAt: '2026-06-03T08:45:00'
    },
    {
      id: '5',
      nik: '3201234567890005',
      name: 'Dewi Lestari',
      email: 'dewi.lestari@email.com',
      phone: '081234567894',
      status: 'pending',
      applications: 0,
      registeredAt: '2026-06-03T09:30:00'
    }
  ]);

  const [searchQuery, setSearchQuery] = useState('');
  const [statusFilter, setStatusFilter] = useState<'all' | 'pending' | 'approved' | 'rejected'>('all');

  const filteredParticipants = participants.filter(participant => {
    const matchesSearch =
      participant.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      participant.nik.includes(searchQuery) ||
      participant.email.toLowerCase().includes(searchQuery.toLowerCase());

    const matchesStatus = statusFilter === 'all' || participant.status === statusFilter;

    return matchesSearch && matchesStatus;
  });

  const handleApprove = (id: string) => {
    setParticipants(participants.map(p =>
      p.id === id ? { ...p, status: 'approved' as const } : p
    ));
  };

  const handleReject = (id: string) => {
    if (confirm('Yakin ingin menolak peserta ini?')) {
      setParticipants(participants.map(p =>
        p.id === id ? { ...p, status: 'rejected' as const } : p
      ));
    }
  };

  const handleDelete = (id: string) => {
    if (confirm('Yakin ingin menghapus peserta ini? Data lamaran juga akan dihapus.')) {
      setParticipants(participants.filter(p => p.id !== id));
    }
  };

  const handleExport = () => {
    const csv = [
      ['NIK', 'Nama', 'Email', 'Telepon', 'Status', 'Jumlah Lamaran', 'Tanggal Daftar'],
      ...participants.map(p => [
        p.nik,
        p.name,
        p.email,
        p.phone,
        p.status,
        p.applications.toString(),
        new Date(p.registeredAt).toLocaleString('id-ID')
      ])
    ].map(row => row.join(',')).join('\n');

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `peserta_${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
  };

  const pendingCount = participants.filter(p => p.status === 'pending').length;
  const approvedCount = participants.filter(p => p.status === 'approved').length;
  const capacityUsed = participants.filter(p => p.status !== 'rejected').length;
  const maxCapacity = 250;

  return (
    <div className="space-y-6">
      <div className="grid gap-4 md:grid-cols-3">
        <Card className="border-none shadow-lg bg-gradient-to-br from-slate-700 to-slate-800 text-white">
          <CardContent className="pt-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-white/70 mb-1">Kapasitas</p>
                <p className="text-3xl font-bold">{capacityUsed}<span className="text-lg text-white/60">/{maxCapacity}</span></p>
              </div>
              <div className="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                <Users className="h-6 w-6" />
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="border-none shadow-lg bg-gradient-to-br from-amber-500 to-orange-600 text-white">
          <CardContent className="pt-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-white/70 mb-1">Pending</p>
                <p className="text-3xl font-bold">{pendingCount}</p>
              </div>
              <div className="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                <AlertCircle className="h-6 w-6" />
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="border-none shadow-lg bg-gradient-to-br from-green-500 to-emerald-600 text-white">
          <CardContent className="pt-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-white/70 mb-1">Disetujui</p>
                <p className="text-3xl font-bold">{approvedCount}</p>
              </div>
              <div className="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                <CheckCircle className="h-6 w-6" />
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <Card className="border-slate-200/60 shadow-lg">
        <CardHeader className="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-transparent">
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <CardTitle className="flex items-center gap-2">
                <div className="h-9 w-9 rounded-xl bg-violet-100 flex items-center justify-center">
                  <Users className="h-5 w-5 text-violet-600" />
                </div>
                Manajemen Peserta
              </CardTitle>
              <CardDescription>Kelola registrasi dan data peserta job fair</CardDescription>
            </div>
            <Button variant="outline" size="sm" onClick={handleExport} className="shadow-sm">
              <Download className="h-4 w-4 mr-2" />
              Export CSV
            </Button>
          </div>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            <div className="flex flex-col sm:flex-row gap-3">
              <div className="relative flex-1">
                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
                <Input
                  placeholder="Cari NIK, nama, atau email..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="pl-9"
                />
              </div>
              <div className="flex gap-2 bg-slate-100 p-1 rounded-lg">
                <Button
                  variant={statusFilter === 'all' ? 'default' : 'ghost'}
                  size="sm"
                  onClick={() => setStatusFilter('all')}
                  className={statusFilter === 'all' ? 'shadow-sm' : ''}
                >
                  Semua
                </Button>
                <Button
                  variant={statusFilter === 'pending' ? 'default' : 'ghost'}
                  size="sm"
                  onClick={() => setStatusFilter('pending')}
                  className={statusFilter === 'pending' ? 'shadow-sm' : ''}
                >
                  Pending
                </Button>
                <Button
                  variant={statusFilter === 'approved' ? 'default' : 'ghost'}
                  size="sm"
                  onClick={() => setStatusFilter('approved')}
                  className={statusFilter === 'approved' ? 'shadow-sm' : ''}
                >
                  Disetujui
                </Button>
                <Button
                  variant={statusFilter === 'rejected' ? 'default' : 'ghost'}
                  size="sm"
                  onClick={() => setStatusFilter('rejected')}
                  className={statusFilter === 'rejected' ? 'shadow-sm' : ''}
                >
                  Ditolak
                </Button>
              </div>
            </div>

            <div className="border rounded-lg">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>NIK</TableHead>
                    <TableHead>Nama</TableHead>
                    <TableHead className="hidden md:table-cell">Email</TableHead>
                    <TableHead className="hidden lg:table-cell">Telepon</TableHead>
                    <TableHead className="text-center">Lamaran</TableHead>
                    <TableHead className="text-center">Status</TableHead>
                    <TableHead className="text-right">Aksi</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {filteredParticipants.map((participant) => (
                    <TableRow key={participant.id}>
                      <TableCell className="font-mono text-sm">{participant.nik}</TableCell>
                      <TableCell className="font-medium">{participant.name}</TableCell>
                      <TableCell className="hidden md:table-cell text-sm text-slate-600">{participant.email}</TableCell>
                      <TableCell className="hidden lg:table-cell text-sm text-slate-600">{participant.phone}</TableCell>
                      <TableCell className="text-center">
                        <Badge variant={participant.applications >= 12 ? 'default' : 'secondary'}>
                          {participant.applications}/12
                        </Badge>
                      </TableCell>
                      <TableCell className="text-center">
                        <Badge
                          variant={
                            participant.status === 'approved' ? 'default' :
                            participant.status === 'pending' ? 'secondary' :
                            'destructive'
                          }
                        >
                          {participant.status === 'approved' ? 'Disetujui' :
                           participant.status === 'pending' ? 'Pending' :
                           'Ditolak'}
                        </Badge>
                      </TableCell>
                      <TableCell className="text-right">
                        <div className="flex justify-end gap-2">
                          {participant.status === 'pending' && (
                            <>
                              <Button
                                variant="ghost"
                                size="icon"
                                onClick={() => handleApprove(participant.id)}
                                title="Setujui"
                              >
                                <CheckCircle className="h-4 w-4 text-green-600" />
                              </Button>
                              <Button
                                variant="ghost"
                                size="icon"
                                onClick={() => handleReject(participant.id)}
                                title="Tolak"
                              >
                                <XCircle className="h-4 w-4 text-red-600" />
                              </Button>
                            </>
                          )}
                          <Button
                            variant="ghost"
                            size="icon"
                            onClick={() => handleDelete(participant.id)}
                            title="Hapus"
                          >
                            <XCircle className="h-4 w-4 text-slate-600" />
                          </Button>
                        </div>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>

            {filteredParticipants.length === 0 && (
              <div className="text-center py-12 text-slate-500">
                Tidak ada peserta ditemukan
              </div>
            )}
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
