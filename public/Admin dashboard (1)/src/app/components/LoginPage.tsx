import { useState } from 'react';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Label } from './ui/label';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from './ui/tabs';
import { Briefcase, ArrowLeft, CheckCircle } from 'lucide-react';
import { Alert, AlertDescription } from './ui/alert';

interface LoginPageProps {
  onLogin: (name: string) => void;
  onBack: () => void;
}

export function LoginPage({ onLogin, onBack }: LoginPageProps) {
  const [registerData, setRegisterData] = useState({
    nik: '',
    name: '',
    email: '',
    phone: ''
  });

  const [loginNik, setLoginNik] = useState('');
  const [showSuccess, setShowSuccess] = useState(false);

  const handleRegister = (e: React.FormEvent) => {
    e.preventDefault();
    setShowSuccess(true);
    setTimeout(() => {
      onLogin(registerData.name);
    }, 2000);
  };

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault();
    if (loginNik === '3201234567890001') {
      onLogin('Rina Wijaya');
    } else {
      alert('NIK tidak ditemukan atau belum disetujui');
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50 flex flex-col">
      {/* Header */}
      <nav className="backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div className="max-w-7xl mx-auto px-6 py-4">
          <div className="flex items-center gap-3">
            <Button variant="ghost" size="icon" onClick={onBack}>
              <ArrowLeft className="h-5 w-5" />
            </Button>
            <div className="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
              <Briefcase className="h-5 w-5 text-white" />
            </div>
            <div>
              <h1 className="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                JobFair 2026
              </h1>
            </div>
          </div>
        </div>
      </nav>

      {/* Main Content */}
      <div className="flex-1 flex items-center justify-center px-6 py-12">
        <div className="w-full max-w-md">
          <div className="text-center mb-8">
            <h2 className="text-3xl font-bold text-slate-900 mb-2">
              Selamat Datang!
            </h2>
            <p className="text-slate-600">
              Masuk atau daftar untuk mulai melamar pekerjaan
            </p>
          </div>

          <Card className="border-slate-200/60 shadow-2xl">
            <CardContent className="pt-6">
              <Tabs defaultValue="login">
                <TabsList className="grid w-full grid-cols-2 mb-6">
                  <TabsTrigger value="login">Masuk</TabsTrigger>
                  <TabsTrigger value="register">Daftar</TabsTrigger>
                </TabsList>

                <TabsContent value="login">
                  <form onSubmit={handleLogin} className="space-y-4">
                    <div className="space-y-2">
                      <Label htmlFor="login-nik">NIK</Label>
                      <Input
                        id="login-nik"
                        placeholder="Masukkan NIK Anda"
                        value={loginNik}
                        onChange={(e) => setLoginNik(e.target.value)}
                        required
                        maxLength={16}
                      />
                      <p className="text-xs text-slate-500">
                        Gunakan NIK yang sudah terdaftar dan disetujui
                      </p>
                    </div>

                    <Alert className="bg-blue-50 border-blue-200">
                      <AlertDescription className="text-sm text-blue-900">
                        💡 Demo: Gunakan NIK <strong>3201234567890001</strong> untuk login
                      </AlertDescription>
                    </Alert>

                    <Button
                      type="submit"
                      className="w-full h-11 bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700"
                    >
                      Masuk
                    </Button>
                  </form>
                </TabsContent>

                <TabsContent value="register">
                  {showSuccess ? (
                    <div className="text-center py-12">
                      <div className="h-16 w-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <CheckCircle className="h-8 w-8 text-green-600" />
                      </div>
                      <h3 className="text-xl font-semibold text-slate-900 mb-2">
                        Pendaftaran Berhasil!
                      </h3>
                      <p className="text-slate-600 mb-4">
                        Akun Anda telah dibuat dan menunggu persetujuan admin
                      </p>
                      <div className="text-sm text-slate-500">
                        Mengalihkan ke dashboard...
                      </div>
                    </div>
                  ) : (
                    <form onSubmit={handleRegister} className="space-y-4">
                      <div className="space-y-2">
                        <Label htmlFor="register-nik">NIK</Label>
                        <Input
                          id="register-nik"
                          placeholder="16 digit NIK"
                          value={registerData.nik}
                          onChange={(e) => setRegisterData({ ...registerData, nik: e.target.value })}
                          required
                          maxLength={16}
                        />
                      </div>

                      <div className="space-y-2">
                        <Label htmlFor="register-name">Nama Lengkap</Label>
                        <Input
                          id="register-name"
                          placeholder="Sesuai KTP"
                          value={registerData.name}
                          onChange={(e) => setRegisterData({ ...registerData, name: e.target.value })}
                          required
                        />
                      </div>

                      <div className="space-y-2">
                        <Label htmlFor="register-email">Email</Label>
                        <Input
                          id="register-email"
                          type="email"
                          placeholder="email@example.com"
                          value={registerData.email}
                          onChange={(e) => setRegisterData({ ...registerData, email: e.target.value })}
                          required
                        />
                      </div>

                      <div className="space-y-2">
                        <Label htmlFor="register-phone">Nomor Telepon</Label>
                        <Input
                          id="register-phone"
                          type="tel"
                          placeholder="08xxxxxxxxxx"
                          value={registerData.phone}
                          onChange={(e) => setRegisterData({ ...registerData, phone: e.target.value })}
                          required
                        />
                      </div>

                      <Alert className="bg-amber-50 border-amber-200">
                        <AlertDescription className="text-xs text-amber-900">
                          Pastikan data yang Anda masukkan sesuai dengan KTP. Admin akan memverifikasi dalam 1x24 jam.
                        </AlertDescription>
                      </Alert>

                      <Button
                        type="submit"
                        className="w-full h-11 bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700"
                      >
                        Daftar Sekarang
                      </Button>
                    </form>
                  )}
                </TabsContent>
              </Tabs>
            </CardContent>
          </Card>

          <div className="mt-6 text-center">
            <p className="text-sm text-slate-600">
              Dengan mendaftar, Anda menyetujui{' '}
              <button className="text-blue-600 hover:underline">
                Syarat & Ketentuan
              </button>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
