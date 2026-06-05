import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import { Input } from '../ui/input';
import { Label } from '../ui/label';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger, DialogFooter } from '../ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../ui/table';
import { Badge } from '../ui/badge';
import { Plus, Pencil, Trash2, Search, Building2, Download } from 'lucide-react';
import { Textarea } from '../ui/textarea';

interface Company {
  id: string;
  name: string;
  logo: string;
  description: string;
  requirements: string;
  applications: number;
}

export function CompaniesSection() {
  const [companies, setCompanies] = useState<Company[]>([
    {
      id: '1',
      name: 'PT Teknologi Maju',
      logo: '🏢',
      description: 'Perusahaan teknologi terkemuka yang fokus pada pengembangan software enterprise',
      requirements: 'Min. S1 Teknik Informatika, pengalaman 0-2 tahun',
      applications: 142
    },
    {
      id: '2',
      name: 'PT Inovasi Digital',
      logo: '💻',
      description: 'Startup fintech yang berkembang pesat dengan fokus pada digital payment',
      requirements: 'Min. S1 semua jurusan, passion di bidang teknologi',
      applications: 128
    },
    {
      id: '3',
      name: 'PT Mandiri Sejahtera',
      logo: '🏭',
      description: 'Perusahaan manufaktur dengan 20+ tahun pengalaman di industri otomotif',
      requirements: 'Min. D3 Teknik Mesin/Elektro, bersedia kerja shift',
      applications: 115
    },
    {
      id: '4',
      name: 'PT Global Solutions',
      logo: '🌏',
      description: 'Perusahaan konsultan IT yang melayani klien multinasional',
      requirements: 'Min. S1 Sistem Informasi/Manajemen, bahasa Inggris aktif',
      applications: 98
    },
    {
      id: '5',
      name: 'PT Kreatif Indonesia',
      logo: '🎨',
      description: 'Agency kreatif digital yang menangani branding dan marketing untuk berbagai brand',
      requirements: 'Min. S1 DKV/Marketing, portfolio wajib',
      applications: 87
    }
  ]);

  const [searchQuery, setSearchQuery] = useState('');
  const [isAddDialogOpen, setIsAddDialogOpen] = useState(false);
  const [editingCompany, setEditingCompany] = useState<Company | null>(null);
  const [formData, setFormData] = useState({
    name: '',
    logo: '',
    description: '',
    requirements: ''
  });

  const filteredCompanies = companies.filter(company =>
    company.name.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleAdd = () => {
    const newCompany: Company = {
      id: Date.now().toString(),
      name: formData.name,
      logo: formData.logo || '🏢',
      description: formData.description,
      requirements: formData.requirements,
      applications: 0
    };
    setCompanies([...companies, newCompany]);
    setIsAddDialogOpen(false);
    resetForm();
  };

  const handleEdit = (company: Company) => {
    setEditingCompany(company);
    setFormData({
      name: company.name,
      logo: company.logo,
      description: company.description,
      requirements: company.requirements
    });
  };

  const handleUpdate = () => {
    if (editingCompany) {
      setCompanies(companies.map(c =>
        c.id === editingCompany.id
          ? { ...c, ...formData }
          : c
      ));
      setEditingCompany(null);
      resetForm();
    }
  };

  const handleDelete = (id: string) => {
    if (confirm('Yakin ingin menghapus perusahaan ini?')) {
      setCompanies(companies.filter(c => c.id !== id));
    }
  };

  const resetForm = () => {
    setFormData({
      name: '',
      logo: '',
      description: '',
      requirements: ''
    });
  };

  const handleExport = () => {
    const csv = [
      ['ID', 'Nama Perusahaan', 'Deskripsi', 'Persyaratan', 'Jumlah Lamaran'],
      ...companies.map(c => [c.id, c.name, c.description, c.requirements, c.applications.toString()])
    ].map(row => row.join(',')).join('\n');

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `perusahaan_${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
  };

  return (
    <Card className="border-slate-200/60 shadow-lg">
      <CardHeader className="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-transparent">
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <CardTitle className="flex items-center gap-2">
              <div className="h-9 w-9 rounded-xl bg-blue-100 flex items-center justify-center">
                <Building2 className="h-5 w-5 text-blue-600" />
              </div>
              Manajemen Perusahaan
            </CardTitle>
            <CardDescription>Kelola profil perusahaan yang berpartisipasi dalam job fair</CardDescription>
          </div>
          <div className="flex gap-2">
            <Button variant="outline" size="sm" onClick={handleExport} className="shadow-sm">
              <Download className="h-4 w-4 mr-2" />
              Export CSV
            </Button>
            <Dialog open={isAddDialogOpen} onOpenChange={setIsAddDialogOpen}>
              <DialogTrigger asChild>
                <Button size="sm" className="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-md">
                  <Plus className="h-4 w-4 mr-2" />
                  Tambah Perusahaan
                </Button>
              </DialogTrigger>
              <DialogContent>
                <DialogHeader>
                  <DialogTitle>Tambah Perusahaan Baru</DialogTitle>
                  <DialogDescription>Masukkan informasi perusahaan yang akan ditambahkan</DialogDescription>
                </DialogHeader>
                <div className="space-y-4 py-4">
                  <div className="space-y-2">
                    <Label htmlFor="name">Nama Perusahaan</Label>
                    <Input
                      id="name"
                      value={formData.name}
                      onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                      placeholder="PT Nama Perusahaan"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="logo">Logo (emoji atau URL)</Label>
                    <Input
                      id="logo"
                      value={formData.logo}
                      onChange={(e) => setFormData({ ...formData, logo: e.target.value })}
                      placeholder="🏢"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="description">Deskripsi</Label>
                    <Textarea
                      id="description"
                      value={formData.description}
                      onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                      placeholder="Deskripsi singkat tentang perusahaan"
                      rows={3}
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="requirements">Persyaratan</Label>
                    <Textarea
                      id="requirements"
                      value={formData.requirements}
                      onChange={(e) => setFormData({ ...formData, requirements: e.target.value })}
                      placeholder="Persyaratan untuk pelamar"
                      rows={3}
                    />
                  </div>
                </div>
                <DialogFooter>
                  <Button variant="outline" onClick={() => { setIsAddDialogOpen(false); resetForm(); }}>
                    Batal
                  </Button>
                  <Button onClick={handleAdd} disabled={!formData.name || !formData.description}>
                    Tambah
                  </Button>
                </DialogFooter>
              </DialogContent>
            </Dialog>
          </div>
        </div>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          <div className="relative">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
            <Input
              placeholder="Cari perusahaan..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-9"
            />
          </div>

          <div className="border rounded-lg">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead className="w-12">Logo</TableHead>
                  <TableHead>Nama Perusahaan</TableHead>
                  <TableHead className="hidden md:table-cell">Deskripsi</TableHead>
                  <TableHead className="hidden lg:table-cell">Persyaratan</TableHead>
                  <TableHead className="text-center">Lamaran</TableHead>
                  <TableHead className="text-right">Aksi</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredCompanies.map((company) => (
                  <TableRow key={company.id}>
                    <TableCell className="text-2xl">{company.logo}</TableCell>
                    <TableCell className="font-medium">{company.name}</TableCell>
                    <TableCell className="hidden md:table-cell max-w-xs truncate">{company.description}</TableCell>
                    <TableCell className="hidden lg:table-cell max-w-xs truncate text-sm text-slate-600">{company.requirements}</TableCell>
                    <TableCell className="text-center">
                      <Badge variant="secondary">{company.applications}</Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Dialog open={editingCompany?.id === company.id} onOpenChange={(open) => !open && setEditingCompany(null)}>
                          <DialogTrigger asChild>
                            <Button variant="ghost" size="icon" onClick={() => handleEdit(company)}>
                              <Pencil className="h-4 w-4" />
                            </Button>
                          </DialogTrigger>
                          <DialogContent>
                            <DialogHeader>
                              <DialogTitle>Edit Perusahaan</DialogTitle>
                              <DialogDescription>Perbarui informasi perusahaan</DialogDescription>
                            </DialogHeader>
                            <div className="space-y-4 py-4">
                              <div className="space-y-2">
                                <Label htmlFor="edit-name">Nama Perusahaan</Label>
                                <Input
                                  id="edit-name"
                                  value={formData.name}
                                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                />
                              </div>
                              <div className="space-y-2">
                                <Label htmlFor="edit-logo">Logo</Label>
                                <Input
                                  id="edit-logo"
                                  value={formData.logo}
                                  onChange={(e) => setFormData({ ...formData, logo: e.target.value })}
                                />
                              </div>
                              <div className="space-y-2">
                                <Label htmlFor="edit-description">Deskripsi</Label>
                                <Textarea
                                  id="edit-description"
                                  value={formData.description}
                                  onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                                  rows={3}
                                />
                              </div>
                              <div className="space-y-2">
                                <Label htmlFor="edit-requirements">Persyaratan</Label>
                                <Textarea
                                  id="edit-requirements"
                                  value={formData.requirements}
                                  onChange={(e) => setFormData({ ...formData, requirements: e.target.value })}
                                  rows={3}
                                />
                              </div>
                            </div>
                            <DialogFooter>
                              <Button variant="outline" onClick={() => { setEditingCompany(null); resetForm(); }}>
                                Batal
                              </Button>
                              <Button onClick={handleUpdate}>
                                Simpan Perubahan
                              </Button>
                            </DialogFooter>
                          </DialogContent>
                        </Dialog>
                        <Button variant="ghost" size="icon" onClick={() => handleDelete(company.id)}>
                          <Trash2 className="h-4 w-4 text-red-600" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>

          {filteredCompanies.length === 0 && (
            <div className="text-center py-12 text-slate-500">
              Tidak ada perusahaan ditemukan
            </div>
          )}
        </div>
      </CardContent>
    </Card>
  );
}
