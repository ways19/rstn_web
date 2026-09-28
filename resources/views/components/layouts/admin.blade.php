@props([
    'title' => 'AdminKit'
])

<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f5f7fb] dark:bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — RSUD R.A.A. Tjokronegoro</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Dark Theme Initialization Script (Anti-FOUC) -->
    <script>
        if (localStorage.getItem('rstn_theme') === 'dark' || (!('rstn_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .adminkit-sidebar-active {
            color: #ffffff !important;
            background: linear-gradient(90deg, rgba(59,125,221,.2), rgba(59,125,221,.1) 50%, transparent);
            border-left: 4px solid #3b7ddd;
            font-weight: 700;
        }
    </style>
    {{ $styles ?? '' }}
    @stack('styles')
</head>
<body class="h-full text-slate-700 dark:text-slate-200 bg-[#f5f7fb] dark:bg-slate-950 text-sm md:text-base antialiased transition-colors duration-200" 
      x-data="{ 
          sidebarCollapsed: false,
          mobileSidebarOpen: false,
          userDropdownOpen: false,
          openMenus: {
              'pelayanan': {{ request()->routeIs('admin.services*', 'admin.beds*') ? 'true' : 'false' }},
              'rawat_jalan': {{ request()->routeIs('admin.services*') ? 'true' : 'false' }},
              'rawat_inap': {{ request()->routeIs('admin.beds*') ? 'true' : 'false' }},
              'darurat_bedah': false,
              'pasien': {{ request()->routeIs('admin.registrations*', 'admin.complaints*') ? 'true' : 'false' }},
              'antrean': {{ request()->routeIs('admin.registrations*') ? 'true' : 'false' }},
              'aduan': {{ request()->routeIs('admin.complaints*') ? 'true' : 'false' }},
              'ppid': {{ request()->routeIs('admin.posts*') ? 'true' : 'false' }},
              'publikasi': {{ request()->routeIs('admin.posts*') ? 'true' : 'false' }},
              'info_publik': false,
              'pengaturan': {{ request()->routeIs('admin.settings*', 'admin.banners*', 'admin.doctors*', 'admin.users*', 'admin.roles*', 'admin.modules*', 'admin.menus*') ? 'true' : 'false' }},
              'modul_nav': {{ request()->routeIs('admin.modules*', 'admin.menus*') ? 'true' : 'false' }},
              'master_medis': {{ request()->routeIs('admin.doctors*', 'admin.banners*') ? 'true' : 'false' }},
              'sistem': {{ request()->routeIs('admin.settings*') ? 'true' : 'false' }},
              'rbac': {{ request()->routeIs('admin.users*', 'admin.roles*') ? 'true' : 'false' }}
          },
          toggleSidebar() {
              if (window.innerWidth >= 1024) {
                  this.sidebarCollapsed = !this.sidebarCollapsed;
              } else {
                  this.mobileSidebarOpen = !this.mobileSidebarOpen;
              }
          },
          toggle(key) {
              this.openMenus[key] = !this.openMenus[key];
          }
      }">

    <!-- Mobile Backdrop Overlay -->
    <div x-show="mobileSidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileSidebarOpen = false" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 lg:hidden"
         style="display: none;"></div>

    <!-- Admin Sidebar Component -->
    <x-admin.sidebar />

    <!-- Main Content Area with Header (Responsive Margin) -->
    <div class="min-h-screen flex flex-col transition-all duration-300 ease-in-out"
         :class="sidebarCollapsed ? 'lg:pl-0' : 'lg:pl-72'">
        
        <!-- Admin Top Header Component -->
        <x-admin.header />

        <!-- Main Content View -->
        <main class="flex-grow p-6 lg:p-8">
            <!-- Global Flash Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold">✓</div>
                        <span class="font-medium text-sm md:text-base">{{ session('success') }}</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm font-bold cursor-pointer">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold">!</div>
                        <span class="font-medium text-sm md:text-base">{{ session('error') }}</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-rose-500 hover:text-rose-800 text-sm font-bold cursor-pointer">✕</button>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- AdminKit Footer Component -->
        <x-admin.footer />
    </div>

    {{ $scripts ?? '' }}
    @stack('scripts')
</body>
</html>
