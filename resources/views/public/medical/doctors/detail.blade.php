<x-layouts.app :title="$doctor['name'] . ' — Dokter Spesialis RSUD R.A.A. Tjokronegoro'" :meta-description="'Profil lengkap, kualifikasi pendidikan, dan jadwal praktik ' . $doctor['name'] . ' di RSUD R.A.A. Tjokronegoro Purworejo.'">
<x-page-header
    title="Dokter & Jadwal"
    description="Profil, kualifikasi pendidikan, dan jadwal praktik dokter spesialis."
/>

{{-- Breadcrumb --}}
<div class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 py-5 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('doctors') }}" class="font-medium text-slate-500 hover:text-[#007b83]">Dokter & Jadwal</a>
            <span class="text-slate-300">&rsaquo;</span>
            <span class="font-semibold text-[#007b83]">{{ $doctor['name'] }}</span>
            <span class="ml-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-0.5 text-xs font-bold uppercase tracking-wider text-[#007b83]">{{ $doctor['poli'] }}</span>
        </nav>
    </div>
</div>

<!-- Doctor Detail Card -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Doctor Photo & Quick Info -->
            <div class="lg:col-span-4">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-100 p-6 bg-slate-50 text-center">
                    <img src="{{ $doctor['photo'] }}" alt="{{ $doctor['name'] }}" referrerpolicy="no-referrer" class="w-48 h-56 rounded-2xl object-cover mx-auto shadow-md">
                    <h2 class="text-lg font-bold text-slate-900 mt-4">{{ $doctor['name'] }}</h2>
                    <p class="text-xs text-teal-700 font-semibold mt-1">{{ $doctor['speciality'] }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $doctor['sub'] }}</p>

                    <div class="mt-6 pt-6 border-t border-slate-200 space-y-3">
                        <a href="{{ route('registration') }}" class="block w-full py-3 rounded-xl font-bold text-sm text-white bg-[#007b83] hover:bg-[#005b64] shadow-md transition">
                            Reservasi Antrean Poli
                        </a>
                        <a href="{{ route('doctors') }}" class="block w-full py-2.5 rounded-xl font-semibold text-xs text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition">
                            &larr; Kembali ke Daftar Dokter
                        </a>
                    </div>
                </div>
            </div>

            <!-- Doctor Detailed Profile & Schedule -->
            <div class="lg:col-span-8 space-y-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#007b83]">Informasi Kredensial</span>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">Latar Belakang & Spesialisasi</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-xl">
                            <span class="font-bold text-slate-800 w-32 shrink-0 text-xs">Pendidikan:</span>
                            <span class="text-xs sm:text-sm">{{ $doctor['education'] }}</span>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-xl">
                            <span class="font-bold text-slate-800 w-32 shrink-0 text-xs">Pengalaman:</span>
                            <span class="text-xs sm:text-sm">{{ $doctor['experience'] }}</span>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-xl">
                            <span class="font-bold text-slate-800 w-32 shrink-0 text-xs">Poliklinik:</span>
                            <span class="text-xs sm:text-sm font-semibold text-teal-700">{{ $doctor['poli'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Schedule Table -->
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#007b83]">Jadwal Pelayanan Poliklinik</span>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">Waktu Praktik Mingguan</h3>
                    
                    <div class="mt-4 overflow-hidden border border-slate-200 rounded-2xl shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3.5 font-bold text-slate-700">Hari</th>
                                    <th class="px-6 py-3.5 font-bold text-slate-700">Waktu Layanan</th>
                                    <th class="px-6 py-3.5 font-bold text-slate-700">Ruangan</th>
                                    <th class="px-6 py-3.5 font-bold text-slate-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach($doctor['days'] as $day)
                                    <tr>
                                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $day }}</td>
                                        <td class="px-6 py-4 text-teal-700 font-medium">08.00 - 13.00 WIB</td>
                                        <td class="px-6 py-4 text-slate-500">{{ $doctor['poli'] }} Lt. 2</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('registration') }}" class="inline-block px-3 py-1.5 text-xs font-bold text-white bg-[#007b83] hover:bg-[#005b64] rounded-lg">
                                                Daftar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-slate-400 mt-3 italic">* Jadwal dapat berubah sewaktu-waktu sesuai dengan penugasan tindakan operasi darurat.</p>
                </div>
            </div>
        </div>
    </div>
</section>
</x-layouts.app>
