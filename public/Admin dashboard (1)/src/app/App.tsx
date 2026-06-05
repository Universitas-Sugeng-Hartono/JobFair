import { useState } from 'react';
import { AdminDashboard } from './components/AdminDashboard';
import { ParticipantHome } from './components/participant/ParticipantHome';
import { LandingPage } from './components/LandingPage';
import { LoginPage } from './components/LoginPage';
import { Button } from './components/ui/button';
import { LayoutDashboard, Users } from 'lucide-react';

type Page = 'landing' | 'login' | 'participant' | 'admin';

export default function App() {
  const [currentPage, setCurrentPage] = useState<Page>('landing');
  const [userName, setUserName] = useState<string>('');

  const handleLogin = (name: string) => {
    setUserName(name);
    setCurrentPage('participant');
  };

  const handleGetStarted = () => {
    setCurrentPage('login');
  };

  const handleBackToLanding = () => {
    setCurrentPage('landing');
  };

  const showViewSwitcher = currentPage === 'participant' || currentPage === 'admin';

  return (
    <div className="relative">
      {/* View Switcher - Floating Button (only show when logged in) */}
      {showViewSwitcher && (
        <div className="fixed bottom-6 right-6 z-50">
          <div className="bg-white rounded-2xl shadow-2xl border border-slate-200/60 p-2 backdrop-blur-xl">
            <div className="flex gap-2">
              <Button
                variant={currentPage === 'participant' ? 'default' : 'ghost'}
                size="sm"
                onClick={() => setCurrentPage('participant')}
                className={currentPage === 'participant' ? 'bg-gradient-to-r from-blue-600 to-violet-600' : ''}
              >
                <Users className="h-4 w-4 mr-2" />
                Peserta
              </Button>
              <Button
                variant={currentPage === 'admin' ? 'default' : 'ghost'}
                size="sm"
                onClick={() => setCurrentPage('admin')}
                className={currentPage === 'admin' ? 'bg-gradient-to-r from-blue-600 to-violet-600' : ''}
              >
                <LayoutDashboard className="h-4 w-4 mr-2" />
                Admin
              </Button>
            </div>
          </div>
        </div>
      )}

      {/* Render Current Page */}
      {currentPage === 'landing' && <LandingPage onGetStarted={handleGetStarted} />}
      {currentPage === 'login' && <LoginPage onLogin={handleLogin} onBack={handleBackToLanding} />}
      {currentPage === 'participant' && <ParticipantHome />}
      {currentPage === 'admin' && <AdminDashboard />}
    </div>
  );
}