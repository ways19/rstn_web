<x-layouts.app title="Dokter &amp; Jadwal — RSUD R.A.A. Tjokronegoro" meta-description="Direktori dokter spesialis dan jadwal praktik lengkap di RSUD R.A.A. Tjokronegoro Purworejo. Penyakit Dalam, Anak, Obgyn, Bedah, Jantung, Mata, dan lainnya.">
<x-page-header
    title="Dokter & Jadwal"
    description="Temukan dokter spesialis, periksa jadwal hari praktik, dan lakukan reservasi antrean poliklinik dengan mudah."
/>

<!-- Interactive Doctor Directory via Alpine.js -->
<section class="py-16 bg-slate-50" x-data="{
    searchQuery: '',
    selectedSpeciality: 'semua',
    selectedDay: 'semua',
    doctors: {{ Js::from($doctors) }},
    get filteredDoctors() {
        return this.doctors.filter(doc => {
            const matchSpec = this.selectedSpeciality === 'semua' || doc.speciality === this.selectedSpeciality;
            const matchDay = this.selectedDay === 'semua' || (doc.days && doc.days.includes(this.selectedDay));
            const matchSearch = doc.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                doc.speciality.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                doc.poli.toLowerCase().includes(this.searchQuery.toLowerCase());
            return matchSpec && matchDay && matchSearch;
        });
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search & Filter Controls Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 mb-12 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <!-- Search Box -->
                <div class="md:col-span-6 relative">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Cari nama dokter, poli, atau spesialisasi..." 
                           class="w-full px-5 py-3.5 pl-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600 text-sm">
                    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Day Filter -->
                <div class="md:col-span-3">
                    <select x-model="selectedDay" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                        <option value="semua">Semua Hari Praktik</option>
                        <option value="Senin">Hari Senin</option>
                        <option value="Selasa">Hari Selasa</option>
                        <option value="Rabu">Hari Rabu</option>
                        <option value="Kamis">Hari Kamis</option>
                        <option value="Jumat">Hari Jumat</option>
                        <option value="Sabtu">Hari Sabtu</option>
                    </select>
                </div>

                <!-- Reset Filter -->
                <div class="md:col-span-3">
                    <button @click="searchQuery = ''; selectedSpeciality = 'semua'; selectedDay = 'semua'" 
                            class="w-full py-3.5 px-4 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Speciality Filter Pills -->
            <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-2">
                <button @click="selectedSpeciality = 'semua'" 
                        :class="selectedSpeciality === 'semua' ? 'bg-[#007b83] text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-full text-sm font-medium transition">
                    Semua Spesialis
                </button>
                <template x-for="spec in [...new Set(doctors.map(d => d.speciality))]" :key="spec">
                    <button @click="selectedSpeciality = spec" 
                            :class="selectedSpeciality === spec ? 'bg-[#007b83] text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-4 py-2 rounded-full text-sm font-medium transition"
                            x-text="spec">
                    </button>
                </template>
            </div>
        </div>

        <!-- Doctors Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="doctor in filteredDoctors" :key="doctor.id">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col justify-between">
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <img :src="doctor.photo" :alt="doctor.name" referrerpolicy="no-referrer" class="w-24 h-28 rounded-2xl object-cover shrink-0 bg-slate-100 shadow-sm">
                            <div>
                                <span class="text-xs font-semibold text-teal-700 bg-teal-50 px-2.5 py-0.5 rounded-full inline-block mb-1" x-text="doctor.poli"></span>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug" x-text="doctor.name"></h3>
                                <p class="text-sm text-slate-500 mt-1" x-text="doctor.sub"></p>
                                <span class="text-xs text-slate-400 mt-1 block">Pengalaman: <strong class="text-slate-600" x-text="doctor.experience"></strong></span>
                            </div>
                        </div>

                        <!-- Schedule Box -->
                        <div class="mt-5 p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider block mb-1">Jadwal Praktik:</span>
                            <p class="text-sm font-semibold text-[#007b83]" x-text="doctor.schedule"></p>
                        </div>
                    </div>

                    <div class="p-6 pt-0 flex items-center justify-between">
                        <a :href="`{{ url('/dokter') }}/${doctor.id}`" class="text-sm font-semibold text-[#007b83] hover:underline">
                            Lihat Profil &rarr;
                        </a>
                        <a href="{{ route('registration') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-[#007b83] hover:bg-[#005b64] rounded-xl shadow-md transition">
                            Daftar Poli
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="filteredDoctors.length === 0" class="text-center py-20 bg-white rounded-3xl border border-slate-200">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-slate-600 font-bold text-base">Tidak ada dokter yang cocok</p>
            <p class="text-slate-400 text-xs mt-1">Coba sesuaikan kata kunci pencarian atau ubah filter hari praktik.</p>
        </div>
    </div>
</section>
</x-layouts.app>
