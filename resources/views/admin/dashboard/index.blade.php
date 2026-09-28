<x-layouts.admin title="Dashboard">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ringkasan Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1">Statistik operasional pendaftaran antrean, aduan masyarakat, dan ketersediaan fasilitas rumah sakit.</p>
        </div>
        <div>
            <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-bold text-sm text-white bg-[#3b7ddd] hover:bg-[#2b65b6] shadow-sm transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
    <span>Cek Antrean Hari Ini</span>
</a>
        </div>
    </div><div class="space-y-6">

    <!-- Stat Cards Row (AdminKit Style with Larger Fonts) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Stat 1: Pendaftar Online -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-wider">Pendaftar Online</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $stats['total_registrations'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#3b7ddd] flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-2 text-sm">
                <span class="px-2 py-0.5 rounded-full font-bold text-xs bg-emerald-50 text-emerald-700 border border-emerald-100">+12.5%</span>
                <span class="text-slate-500 font-medium">{{ $stats['pending_registrations'] }} antrean aktif</span>
            </div>
        </div>

        <!-- Stat 2: Aduan Pasien -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-wider">Aduan & Masukan</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $stats['total_complaints'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-2 text-sm">
                <span class="px-2 py-0.5 rounded-full font-bold text-xs bg-amber-50 text-amber-700 border border-amber-100">{{ $stats['new_complaints'] }} baru</span>
                <span class="text-slate-500 font-medium">Perlu ditindaklanjuti</span>
            </div>
        </div>

        <!-- Stat 3: Bed Kosong -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-wider">Bed Tersedia (Kosong)</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-emerald-600 mt-2 tracking-tight">{{ $stats['available_beds'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-2 text-sm">
                <span class="px-2 py-0.5 rounded-full font-bold text-xs bg-emerald-50 text-emerald-700 border border-emerald-100">Siap Pakai</span>
                <span class="text-slate-500 font-medium">dari {{ $stats['total_beds'] }} total kapasitas</span>
            </div>
        </div>

        <!-- Stat 4: Dokter & Poli -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm hover:border-slate-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-wider">Dokter Spesialis</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $stats['total_doctors'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center space-x-2 text-sm">
                <span class="px-2 py-0.5 rounded-full font-bold text-xs bg-blue-50 text-[#3b7ddd] border border-blue-100">18 Poliklinik</span>
                <span class="text-slate-500 font-medium">Jadwal aktif</span>
            </div>
        </div>
    </div>

    <!-- Main Content Tables Row (AdminKit Latest Projects & Feeds) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Pendaftaran Antrean Online Terbaru (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between overflow-hidden">
            <div>
                <!-- Card Header -->
                <div class="p-6 pb-4 flex items-center justify-between border-b border-slate-100">
                    <div>
                        <h3 class="font-extrabold text-base md:text-lg text-slate-900">Antrean Pendaftaran Online Terbaru</h3>
                        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Pasien yang terdaftar melalui portal pendaftaran web.</p>
                    </div>
                    <a href="{{ route('admin.registrations.index') }}" class="text-sm font-bold text-[#3b7ddd] hover:text-[#2b65b6] hover:underline flex items-center space-x-1">
                        <span>Lihat Semua</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- Table with Comfortable Sizing -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                        <thead class="text-slate-600 bg-slate-50 font-bold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-4">No. Antrean</th>
                                <th class="px-6 py-4">Nama Pasien</th>
                                <th class="px-6 py-4">Poli / Klinik</th>
                                <th class="px-6 py-4">Tgl Kunjungan</th>
                                <th class="px-6 py-4">Penjamin</th>
                                <th class="px-6 py-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latestRegistrations as $reg)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 font-black text-base text-[#3b7ddd]">{{ $reg->queue_number }}</td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block text-sm md:text-base leading-tight">{{ $reg->patient_name }}</span>
                                        <span class="text-xs md:text-sm text-slate-500 font-mono mt-0.5 block">{{ $reg->phone }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 font-medium text-sm">{{ $reg->clinic }}</td>
                                    <td class="px-6 py-4 text-slate-600 text-sm">{{ $reg->visit_date ? $reg->visit_date->format('d/m/Y') : '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="uppercase font-bold text-xs px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200/60">
                                            {{ $reg->insurance }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                            {{ $reg->status === 'terdaftar' ? 'bg-amber-100 text-amber-800' : '' }}
                                            {{ $reg->status === 'dipanggil' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $reg->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                                            {{ $reg->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada pendaftaran online baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="p-4 px-6 bg-slate-50/80 border-t border-slate-100 text-sm text-slate-600 flex items-center justify-between font-medium">
                <span>Terintegrasi langsung dengan database registrasi pasien.</span>
                <a href="{{ route('admin.registrations.index') }}" class="font-bold text-[#3b7ddd] hover:underline">Kelola Seluruh Antrean &rarr;</a>
            </div>
        </div>

        <!-- Right: Aduan & Aspirasi Masyarakat Masuk (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between overflow-hidden">
            <div>
                <!-- Card Header -->
                <div class="p-6 pb-4 flex items-center justify-between border-b border-slate-100">
                    <div>
                        <h3 class="font-extrabold text-base md:text-lg text-slate-900">Aduan & Saran</h3>
                        <p class="text-xs md:text-sm text-slate-500 mt-0.5">Umpan balik dari pasien.</p>
                    </div>
                    <a href="{{ route('admin.complaints.index') }}" class="text-sm font-bold text-[#3b7ddd] hover:text-[#2b65b6] hover:underline flex items-center space-x-1">
                        <span>Semua</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- Feed Items -->
                <div class="p-6 space-y-4">
                    @forelse($latestComplaints as $comp)
                        <div class="flex items-start space-x-3.5 pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 font-bold text-sm mt-0.5">
                                {{ strtoupper(substr($comp->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <strong class="text-slate-900 font-bold text-sm md:text-base">{{ $comp->name }}</strong>
                                    <span class="text-xs text-slate-400 font-medium">{{ $comp->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="text-xs font-bold text-[#3b7ddd] block mt-0.5">{{ $comp->category }}</span>
                                <p class="text-slate-600 line-clamp-2 mt-1.5 leading-relaxed text-sm">
                                    "{{ $comp->message }}"
                                </p>
                                <div class="mt-2.5 flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase
                                        {{ $comp->status === 'baru' ? 'bg-rose-100 text-rose-800' : ($comp->status === 'diproses' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                        {{ $comp->status }}
                                    </span>
                                    <a href="{{ route('admin.complaints.show', $comp) }}" class="text-[#3b7ddd] font-bold text-sm hover:underline">
                                        Tanggapi &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Tidak ada aduan yang belum ditanggapi.</p>
                    @endforelse
                </div>
            </div>

            <div class="p-4 px-6 bg-slate-50/80 border-t border-slate-100 text-sm text-slate-600 flex items-center justify-between font-medium">
                <span>Total aduan: <strong class="text-slate-900">{{ $stats['total_complaints'] }}</strong></span>
                <a href="{{ route('admin.complaints.index') }}" class="font-bold text-[#3b7ddd] hover:underline">Kotak Masuk &rarr;</a>
            </div>
        </div>

    </div>

</div>
</x-layouts.admin>
