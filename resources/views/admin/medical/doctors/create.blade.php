<x-layouts.admin title="Tambah Dokter">
<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
        <div>
            <h2 class="text-base font-bold text-slate-900">Tambah Profil Dokter</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi formulir di bawah ini untuk menambahkan data dokter baru.</p>
        </div>
        <a href="{{ route('admin.doctors.index') }}" 
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 text-xs font-bold border border-slate-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <p class="font-bold mb-1">Terdapat beberapa kesalahan pengisian formulir:</p>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
        @csrf

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
            <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: dr. Tolkha Amaruddin, Sp.THT-KL., M.Kes" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            @error('name') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Spesialisasi *</label>
                <input type="text" name="speciality" required value="{{ old('speciality') }}" placeholder="Contoh: Spesialis Penyakit Dalam" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('speciality') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Sub-Spesialisasi / Keahlian</label>
                <input type="text" name="sub_speciality" value="{{ old('sub_speciality') }}" placeholder="Contoh: Gastroenterologi & Hepatologi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('sub_speciality') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Poliklinik Tujuan *</label>
                <input type="text" name="poli" required value="{{ old('poli') }}" placeholder="Contoh: Poli Penyakit Dalam" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('poli') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jadwal Praktik (Teks Ringkas) *</label>
                <input type="text" name="schedule" required value="{{ old('schedule') }}" placeholder="Contoh: Senin - Kamis: 08.00 - 13.00 WIB" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('schedule') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pendidikan</label>
                <input type="text" name="education" value="{{ old('education') }}" placeholder="Contoh: FK UGM" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('education') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pengalaman</label>
                <input type="text" name="experience" value="{{ old('experience') }}" placeholder="Contoh: 10 Tahun" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('experience') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Bagian Foto Profil Dokter (Upload Komputer vs URL) -->
        <div class="rounded-2xl border border-slate-200 p-4 bg-slate-50/70 space-y-3"
             x-data="{
                photoSource: '{{ old('photo_source', 'upload') }}',
                previewUrl: null,
                inputUrl: '{{ old('photo_url', old('photo', '')) }}',
                formatUrl(url) {
                    if (!url) return '';
                    const match = url.match(/(?:drive\.google\.com\/(?:file\/d\/|open\?id=|uc\?(?:.*&)?id=)|docs\.google\.com\/(?:file\/d\/))([a-zA-Z0-9_-]+)/i);
                    if (match && match[1]) {
                        return 'https://drive.google.com/thumbnail?id=' + match[1] + '&sz=w1000';
                    }
                    return url;
                },
                isGoogleDrive(url) {
                    return /(?:drive\.google\.com|docs\.google\.com)/i.test(url);
                },
                handleFile(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.previewUrl = URL.createObjectURL(file);
                    } else {
                        this.previewUrl = null;
                    }
                }
             }">
            <div>
                <label class="block font-bold text-slate-800 uppercase tracking-wider text-xs">Foto Profil Dokter</label>
                <p class="text-[11px] text-slate-500 mt-0.5">Pilih metode penyediaan foto dokter: unggah dari folder komputer Anda atau gunakan tautan URL gambar eksternal.</p>
            </div>

            <!-- Radio Pilihan Metode -->
            <div class="flex flex-wrap items-center gap-3 pt-1">
                <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition select-none"
                       :class="photoSource === 'upload' ? 'bg-teal-50 border-teal-500 text-teal-800 shadow-sm ring-1 ring-teal-500/20' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                    <input type="radio" name="photo_source" value="upload" x-model="photoSource" class="text-teal-600 focus:ring-teal-500">
                    <span>📁 Pilih File dari Folder Komputer</span>
                </label>

                <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition select-none"
                       :class="photoSource === 'url' ? 'bg-teal-50 border-teal-500 text-teal-800 shadow-sm ring-1 ring-teal-500/20' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                    <input type="radio" name="photo_source" value="url" x-model="photoSource" class="text-teal-600 focus:ring-teal-500">
                    <span>🔗 Gunakan URL Foto Gambar</span>
                </label>
            </div>

            <!-- Opsi 1: Upload File Komputer -->
            <div x-show="photoSource === 'upload'" x-transition class="space-y-2 pt-2">
                <input type="file" name="photo_file" accept="image/png,image/jpeg,image/jpg,image/webp"
                       @change="handleFile($event)"
                       :disabled="photoSource !== 'upload'"
                       class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border border-slate-200 rounded-xl bg-white p-1 cursor-pointer">
                <p class="text-[11px] text-slate-400">Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal ukuran 5 MB.</p>

                <!-- Pratinjau File yang Dipilih -->
                <div x-show="previewUrl" class="mt-3 flex items-center gap-3 p-3 bg-white rounded-xl border border-teal-200 shadow-xs">
                    <img :src="previewUrl" alt="Pratinjau Foto" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs">
                    <div>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-teal-100 text-teal-800">Pratinjau Foto Pilihan</span>
                        <p class="text-[11px] text-slate-500 mt-0.5">Foto ini siap diunggah dan disimpan ke server.</p>
                    </div>
                </div>
                @error('photo_file')
                    <p class="text-[11px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Opsi 2: Input URL Gambar -->
            <div x-show="photoSource === 'url'" x-transition class="space-y-2 pt-2" style="display: none;">
                <input type="url" name="photo_url" x-model="inputUrl" placeholder="https://drive.google.com/... atau tautan gambar langsung"
                       :disabled="photoSource !== 'url'"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600 bg-white">
                <p class="text-[11px] text-slate-400">Mendukung link langsung gambar (HTTPS) serta link berbagi dari <strong>Google Drive</strong> (pastikan izin akses: <em>Siapa saja yang memiliki link</em>).</p>

                <!-- Pratinjau URL -->
                <div x-show="inputUrl && inputUrl.length > 8" class="mt-3 flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-200 shadow-xs">
                    <img :src="formatUrl(inputUrl)" referrerpolicy="no-referrer" x-on:error="$el.src = 'https://placehold.co/100x100?text=Invalid+Image'" alt="Pratinjau URL" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs shrink-0">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-slate-100 text-slate-700">Pratinjau URL Gambar</span>
                            <template x-if="isGoogleDrive(inputUrl)">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-emerald-100 text-emerald-800">
                                    ✓ Google Drive Terdeteksi (Otomatis Dikonversi)
                                </span>
                            </template>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 truncate" x-text="formatUrl(inputUrl)"></p>
                    </div>
                </div>
                @error('photo_url')
                    <p class="text-[11px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-2 pt-2">
            <input type="checkbox" name="is_active" value="1" checked id="active" class="rounded text-teal-600 focus:ring-teal-500">
            <label for="active" class="font-bold text-slate-700 cursor-pointer">Dokter Aktif Melayani</label>
        </div>

        <div class="pt-4 flex justify-between items-center">
            <a href="{{ route('admin.doctors.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Simpan Data Dokter</button>
        </div>
    </form>
</div>
</x-layouts.admin>
