import { useState } from 'react';
import { Tabs, TabsContent, TabsList, TabsTrigger } from './ui/tabs';
import { CompaniesSection } from './admin/CompaniesSection';
import { ParticipantsSection } from './admin/ParticipantsSection';
import { ApplicationsSection } from './admin/ApplicationsSection';
import { DashboardOverview } from './admin/DashboardOverview';
import { Building2, Users, FileText, LayoutDashboard, Bell, Settings, LogOut } from 'lucide-react';
import { Button } from './ui/button';
import { Avatar, AvatarFallback } from './ui/avatar';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from './ui/dropdown-menu';

export function AdminDashboard() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
      {/* Modern Header with Gradient */}
      <header className="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
        <div className="max-w-7xl mx-auto px-6 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-4">
              <div className="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <LayoutDashboard className="h-5 w-5 text-white" />
              </div>
              <div>
                <h1 className="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                  JobFair Dashboard
                </h1>
                <p className="text-xs text-slate-600">Admin Panel</p>
              </div>
            </div>

            <div className="flex items-center gap-3">
              <Button variant="ghost" size="icon" className="relative">
                <Bell className="h-4 w-4" />
                <span className="absolute top-1.5 right-1.5 h-2 w-2 bg-red-500 rounded-full border-2 border-white"></span>
              </Button>

              <DropdownMenu>
                <DropdownMenuTrigger asChild>
                  <Button variant="ghost" className="relative h-9 w-9 rounded-full">
                    <Avatar className="h-9 w-9">
                      <AvatarFallback className="bg-gradient-to-br from-blue-600 to-violet-600 text-white text-sm">
                        AD
                      </AvatarFallback>
                    </Avatar>
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" className="w-56">
                  <DropdownMenuLabel>
                    <div className="flex flex-col space-y-1">
                      <p className="text-sm font-medium">Admin</p>
                      <p className="text-xs text-slate-500">admin@jobfair.com</p>
                    </div>
                  </DropdownMenuLabel>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem>
                    <Settings className="mr-2 h-4 w-4" />
                    Settings
                  </DropdownMenuItem>
                  <DropdownMenuItem className="text-red-600">
                    <LogOut className="mr-2 h-4 w-4" />
                    Logout
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-6 py-8">
        <Tabs defaultValue="overview" className="space-y-8">
          <div className="bg-white/60 backdrop-blur-sm rounded-2xl p-2 border border-slate-200/60 shadow-sm w-fit">
            <TabsList className="bg-transparent gap-1">
              <TabsTrigger
                value="overview"
                className="flex items-center gap-2 data-[state=active]:bg-white data-[state=active]:shadow-md rounded-xl"
              >
                <LayoutDashboard className="h-4 w-4" />
                <span>Overview</span>
              </TabsTrigger>
              <TabsTrigger
                value="companies"
                className="flex items-center gap-2 data-[state=active]:bg-white data-[state=active]:shadow-md rounded-xl"
              >
                <Building2 className="h-4 w-4" />
                <span>Perusahaan</span>
              </TabsTrigger>
              <TabsTrigger
                value="participants"
                className="flex items-center gap-2 data-[state=active]:bg-white data-[state=active]:shadow-md rounded-xl"
              >
                <Users className="h-4 w-4" />
                <span>Peserta</span>
              </TabsTrigger>
              <TabsTrigger
                value="applications"
                className="flex items-center gap-2 data-[state=active]:bg-white data-[state=active]:shadow-md rounded-xl"
              >
                <FileText className="h-4 w-4" />
                <span>Lamaran</span>
              </TabsTrigger>
            </TabsList>
          </div>

          <TabsContent value="overview" className="mt-0">
            <DashboardOverview />
          </TabsContent>

          <TabsContent value="companies" className="mt-0">
            <CompaniesSection />
          </TabsContent>

          <TabsContent value="participants" className="mt-0">
            <ParticipantsSection />
          </TabsContent>

          <TabsContent value="applications" className="mt-0">
            <ApplicationsSection />
          </TabsContent>
        </Tabs>
      </main>
    </div>
  );
}
