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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Dark Theme Initialization Script (Anti-FOUC) -->
    <script>
        if (localStorage.getItem('rstn_theme') === 'dark' || (!('rstn_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

    <style>
        body { font-family: var(--font-sans); }
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
                'pelayanan': {{ request()->routeIs('admin.services.*', 'admin.beds.*') ? 'true' : 'false' }},
                'rawat_jalan': {{ request()->routeIs('admin.services.*') ? 'true' : 'false' }},
                'rawat_inap': {{ request()->routeIs('admin.beds.*') ? 'true' : 'false' }},
                'darurat_bedah': false,

                'pasien': {{ request()->routeIs('admin.registrations.*', 'admin.complaints.*') ? 'true' : 'false' }},
                'antrean': {{ request()->routeIs('admin.registrations.*') ? 'true' : 'false' }},
                'aduan': {{ request()->routeIs('admin.complaints.*') ? 'true' : 'false' }},

                'ppid': {{ request()->routeIs(
                    'admin.posts.*',
                    'admin.banners.*'
                ) ? 'true' : 'false' }},
                'publikasi': {{ request()->routeIs('admin.posts.*') ? 'true' : 'false' }},
                'info_publik': {{ request()->routeIs('admin.banners.*') ? 'true' : 'false' }},

                'cms_menu': {{ ((request()->routeIs('admin.pages.*') && !in_array(request('tab'), ['sections', 'documents'])) || request()->routeIs('admin.tab-references.*')) ? 'true' : 'false' }},
                'cms_pages': {{ (request()->routeIs('admin.pages.*') && !in_array(request('tab'), ['sections', 'documents'])) ? 'true' : 'false' }},
                'cms_tabs': {{ request()->routeIs('admin.tab-references.*') ? 'true' : 'false' }},

                'menu_ppid': {{ (request()->routeIs('admin.ppid.information.*', 'admin.ppid.objections.*', 'admin.ppid-documents.*', 'admin.page-sections.*') || (request()->routeIs('admin.pages.index') && in_array(request('tab'), ['sections', 'documents']))) ? 'true' : 'false' }},
                'ppid_info_publik': {{ (request()->routeIs('admin.ppid-documents.*', 'admin.page-sections.*') || (request()->routeIs('admin.pages.index') && in_array(request('tab'), ['sections', 'documents']))) ? 'true' : 'false' }},
                'ppid_permohonan_menu': {{ request()->routeIs('admin.ppid.information.*', 'admin.ppid.objections.*') ? 'true' : 'false' }},

                'menu_diklat': {{ request()->routeIs(
                    'admin.diklat.registrations.*',
                    'admin.diklat.attendances.*'
                ) ? 'true' : 'false' }},
                'diklat_pendaftaran': {{ request()->routeIs(
                    'admin.diklat.registrations.education.*',
                    'admin.diklat.registrations.training.*'
                ) ? 'true' : 'false' }},
                'diklat_absensi': {{ request()->routeIs('admin.diklat.attendances.*') ? 'true' : 'false' }},

                'halaman_ppid': false,
                'ppid_profil': false,
                'ppid_informasi': false,
                'ppid_permohonan': false,

                'pengaturan': {{ request()->routeIs(
                    'admin.settings.*',
                    'admin.banners.*',
                    'admin.doctors.*',
                    'admin.users.*',
                    'admin.roles.*',
                    'admin.modules.*',
                    'admin.menus.*'
                ) ? 'true' : 'false' }},
                'modul_nav': {{ request()->routeIs('admin.modules.*', 'admin.menus.*') ? 'true' : 'false' }},
                'master_medis': {{ request()->routeIs('admin.doctors.*', 'admin.banners.*') ? 'true' : 'false' }},
                'sistem': {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }},
                'rbac': {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'true' : 'false' }}
            },
            
            toggleSidebar() {
                if (window.innerWidth >= 1024) {
                    this.sidebarCollapsed = !this.sidebarCollapsed;
                } else {
                    this.mobileSidebarOpen = !this.mobileSidebarOpen;
                }
            },
        
            toggle(key) {
                const groups = {
                    utama: ['pelayanan', 'pasien', 'ppid', 'cms_menu', 'menu_ppid', 'menu_diklat', 'pengaturan'],
                    pelayanan: ['rawat_jalan', 'rawat_inap', 'darurat_bedah'],
                    pasien: ['antrean', 'aduan'],
                    ppid: ['publikasi', 'info_publik'],
                    cms_menu: ['cms_pages', 'cms_tabs'],
                    menu_ppid: ['ppid_info_publik', 'ppid_permohonan_menu'],
                    menu_diklat: ['diklat_pendaftaran', 'diklat_absensi'],
                    pengaturan: ['modul_nav', 'master_medis', 'sistem', 'rbac'],
                };

                const parentMap = {
                    rawat_jalan: 'pelayanan',
                    rawat_inap: 'pelayanan',
                    darurat_bedah: 'pelayanan',
                    antrean: 'pasien',
                    aduan: 'pasien',
                    publikasi: 'ppid',
                    info_publik: 'ppid',
                    cms_pages: 'cms_menu',
                    cms_tabs: 'cms_menu',
                    ppid_info_publik: 'menu_ppid',
                    ppid_permohonan_menu: 'menu_ppid',
                    diklat_pendaftaran: 'menu_diklat',
                    diklat_absensi: 'menu_diklat',
                    modul_nav: 'pengaturan',
                    master_medis: 'pengaturan',
                    sistem: 'pengaturan',
                    rbac: 'pengaturan',
                };

                const parent = parentMap[key];

                if (parent) {
                    // Tutup submenu lain dalam kelompok yang sama.
                    (groups[parent] || []).forEach(menu => {
                        if (menu !== key) {
                            this.openMenus[menu] = false;
                        }
                    });

                    // Pastikan induk terbuka ketika submenu dibuka.
                    this.openMenus[parent] = true;
                    this.openMenus[key] = !this.openMenus[key];
                    return;
                }

                // Menu utama: tutup kelompok utama lainnya.
                if (groups.utama.includes(key)) {
                    groups.utama.forEach(menu => {
                        if (menu !== key) {
                            this.openMenus[menu] = false;
                        }
                    });

                    this.openMenus[key] = !this.openMenus[key];
                }
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/id.js"></script>

    <script>
        window.syncDiklatDuration = function (startEl, endEl, durationEl, mode) {
            if (!startEl) return;
            if (!durationEl) {
                const container = startEl.closest('form') || startEl.closest('[role="dialog"]') || startEl.closest('[x-data]') || document;
                const visibleDur = Array.from(container.querySelectorAll('input[name="duration"]')).find(function (el) {
                    return el.offsetParent !== null;
                });
                durationEl = visibleDur
                    || container.querySelector('input[x-ref="createDurationInput"]')
                    || container.querySelector('input[x-ref="modalDurationInput"]')
                    || container.querySelector('input[name="duration"]');
            }
            if (!durationEl) return;

            const startRaw = (startEl.value || '').trim();
            if (!startRaw) return;

            if (mode === 'single') {
                durationEl.value = '1 Hari Pelaksanaan';
                durationEl.dispatchEvent(new Event('input', { bubbles: true }));
                durationEl.dispatchEvent(new Event('change', { bubbles: true }));
                return;
            }

            const endRaw = (endEl ? endEl.value : '').trim();
            if (!endRaw || endRaw === startRaw) {
                durationEl.value = '1 Hari Pelaksanaan';
                durationEl.dispatchEvent(new Event('input', { bubbles: true }));
                durationEl.dispatchEvent(new Event('change', { bubbles: true }));
                return;
            }

            const parseDateUtc = function (str) {
                if (!str) return null;
                const dateOnly = str.split(' ')[0].trim();
                if (dateOnly.includes('-')) {
                    const parts = dateOnly.split('-').map(Number);
                    if (parts.length === 3 && !isNaN(parts[0]) && !isNaN(parts[1]) && !isNaN(parts[2])) {
                        return Date.UTC(parts[0], parts[1] - 1, parts[2]);
                    }
                } else if (dateOnly.includes('/')) {
                    const parts = dateOnly.split('/').map(Number);
                    if (parts.length === 3 && !isNaN(parts[0]) && !isNaN(parts[1]) && !isNaN(parts[2])) {
                        return Date.UTC(parts[2], parts[1] - 1, parts[0]);
                    }
                }
                const d = new Date(dateOnly);
                return isNaN(d.getTime()) ? null : Date.UTC(d.getFullYear(), d.getMonth(), d.getDate());
            };

            const startUtc = parseDateUtc(startRaw);
            const endUtc = parseDateUtc(endRaw);

            if (startUtc !== null && endUtc !== null) {
                if (endUtc >= startUtc) {
                    const days = Math.round((endUtc - startUtc) / 86400000) + 1;
                    durationEl.value = days + ' Hari Pelaksanaan';
                } else {
                    durationEl.value = '1 Hari Pelaksanaan';
                }
            } else {
                durationEl.value = '1 Hari Pelaksanaan';
            }

            durationEl.dispatchEvent(new Event('input', { bubbles: true }));
            durationEl.dispatchEvent(new Event('change', { bubbles: true }));
        };

        window.setDiklatDateMode = function (triggerEl, mode) {
            if (!triggerEl) return;
            const container = triggerEl.closest('form') || triggerEl.closest('[role="dialog"]') || triggerEl.closest('[x-data]') || document;
            const startEl = container.querySelector('input[name="start_at"]');
            const endEl = container.querySelector('input[name="end_at"]');
            const visibleDur = Array.from(container.querySelectorAll('input[name="duration"]')).find(function (el) {
                return el.offsetParent !== null;
            });
            const durationEl = visibleDur
                || container.querySelector('input[x-ref="createDurationInput"]')
                || container.querySelector('input[x-ref="modalDurationInput"]')
                || container.querySelector('input[name="duration"]');

            const modeInput = container.querySelector('input[name="date_mode"]');
            if (modeInput) {
                modeInput.value = mode;
            }

            if (mode === 'single') {
                if (startEl && endEl && startEl.value) {
                    endEl.value = startEl.value;
                    if (endEl._flatpickr) {
                        endEl._flatpickr.setDate(startEl.value, false);
                    }
                }
                if (durationEl) {
                    durationEl.value = '1 Hari Pelaksanaan';
                    durationEl.dispatchEvent(new Event('input', { bubbles: true }));
                    durationEl.dispatchEvent(new Event('change', { bubbles: true }));
                }
            } else {
                window.syncDiklatDuration(startEl, endEl, durationEl, 'range');
            }
        };

        window.handleDiklatDateChange = function (changedInput) {
            if (!changedInput) return;
            const container = changedInput.closest('form') || changedInput.closest('[role="dialog"]') || changedInput.closest('[x-data]') || document;

            const startEl = container.querySelector('input[name="start_at"]');
            const endEl = container.querySelector('input[name="end_at"]');
            const visibleDur = Array.from(container.querySelectorAll('input[name="duration"]')).find(function (el) {
                return el.offsetParent !== null;
            });
            const durationEl = visibleDur
                || container.querySelector('input[x-ref="createDurationInput"]')
                || container.querySelector('input[x-ref="modalDurationInput"]')
                || container.querySelector('input[name="duration"]');

            let mode = 'range';
            const modeEl = container.querySelector('input[name="date_mode"]');
            if (modeEl && modeEl.value === 'single') {
                mode = 'single';
            } else {
                const singleBtn = container.querySelector('button[class*="bg-[#007b83]"]');
                if (singleBtn && singleBtn.textContent.includes('1 Hari')) {
                    mode = 'single';
                }
            }

            if (mode === 'single' && startEl && endEl && changedInput === startEl && startEl.value) {
                endEl.value = startEl.value;
                if (endEl._flatpickr) {
                    endEl._flatpickr.setDate(startEl.value, false);
                }
            }

            window.syncDiklatDuration(startEl, endEl, durationEl, mode);
        };

        // Global delegate listener untuk mendeteksi perubahan tanggal input native
        document.addEventListener('input', function (e) {
            if (e.target && (e.target.name === 'start_at' || e.target.name === 'end_at')) {
                window.handleDiklatDateChange(e.target);
            }
        });
        document.addEventListener('change', function (e) {
            if (e.target && (e.target.name === 'start_at' || e.target.name === 'end_at')) {
                window.handleDiklatDateChange(e.target);
            }
        });

        window.initIndonesianDatePickers = function (container) {
            if (typeof flatpickr === 'undefined' || !container) {
                return;
            }

            const targets = [];
            if (container.nodeType === 1) {
                if (container.matches && container.matches('input.datetime-picker-id')) {
                    targets.push(container);
                }
                if (container.querySelectorAll) {
                    targets.push(...container.querySelectorAll('input.datetime-picker-id'));
                }
            } else if (container === document || container === document.body) {
                targets.push(...document.querySelectorAll('input.datetime-picker-id'));
            }

            targets.forEach(function (input) {
                if (
                    input.dataset.fpInitialized === '1' ||
                    input._flatpickr ||
                    input.classList.contains('flatpickr-input')
                ) {
                    return;
                }

                input.dataset.fpInitialized = '1';

                const fp = flatpickr(input, {
                    locale: (typeof flatpickr.l10ns !== 'undefined' && flatpickr.l10ns.id) ? flatpickr.l10ns.id : 'default',
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd F Y',
                    allowInput: false,
                    disableMobile: true,
                    onOpen: function (selectedDates, dateStr, instance) {
                        if (instance.calendarContainer) {
                            instance.calendarContainer.style.zIndex = '99999';
                        }
                    },
                    onChange: function (selectedDates, dateStr, instance) {
                        if (instance.input) {
                            instance.input.value = dateStr;
                            instance.input.dispatchEvent(new Event('input', { bubbles: true }));
                            instance.input.dispatchEvent(new Event('change', { bubbles: true }));
                            window.handleDiklatDateChange(instance.input);
                        }
                    },
                    onClose: function (selectedDates, dateStr, instance) {
                        if (instance.input) {
                            instance.input.value = dateStr;
                            instance.input.dispatchEvent(new Event('input', { bubbles: true }));
                            instance.input.dispatchEvent(new Event('change', { bubbles: true }));
                            window.handleDiklatDateChange(instance.input);
                        }
                    }
                });

                if (fp && fp.altInput) {
                    fp.altInput.dataset.fpInitialized = '1';
                    fp.altInput.classList.remove('datetime-picker-id');
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function () {
            window.initIndonesianDatePickers(document.body);

            let isInitializingPickers = false;
            const observer = new MutationObserver(function (mutations) {
                if (isInitializingPickers) return;
                isInitializingPickers = true;
                try {
                    mutations.forEach(function (mutation) {
                        mutation.addedNodes.forEach(function (node) {
                            if (node.nodeType === 1 && !node.classList.contains('flatpickr-calendar')) {
                                window.initIndonesianDatePickers(node);
                            }
                        });
                    });
                } finally {
                    isInitializingPickers = false;
                }
            });

            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
</body>
</html>
