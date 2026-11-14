<x-layouts.admin title="Edit Dokter">
@php
    $rawPhoto = $doctor->getRawOriginal('photo');
    $isExternalUrl = $rawPhoto && (str_starts_with($rawPhoto, 'http://') || str_starts_with($rawPhoto, 'https://'));
    $hasPhoto = !empty($rawPhoto);
    $initialSource = old('photo_source', $isExternalUrl ? 'url' : 'upload');
@endphp

<div class="max-w-2xl bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
        <div>
            <h2 class="text-base font-bold text-slate-900">Perbarui Profil Dokter</h2>
            <p class="text-xs text-slate-500 mt-0.5">Ubah informasi dokter, jadwal praktik, poliklinik, atau perbarui foto profil dokter.</p>
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

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
            <input type="text" name="name" required value="{{ old('name', $doctor->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
            @error('name') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Spesialisasi *</label>
                <input type="text" name="speciality" required value="{{ old('speciality', $doctor->speciality) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('speciality') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Sub-Spesialisasi / Keahlian</label>
                <input type="text" name="sub_speciality" value="{{ old('sub_speciality', $doctor->sub_speciality) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('sub_speciality') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Poliklinik Tujuan *</label>
                <input type="text" name="poli" required value="{{ old('poli', $doctor->poli) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('poli') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Jadwal Praktik (Teks Ringkas) *</label>
                <input type="text" name="schedule" required value="{{ old('schedule', $doctor->schedule) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('schedule') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pendidikan</label>
                <input type="text" name="education" value="{{ old('education', $doctor->education) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('education') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Pengalaman</label>
                <input type="text" name="experience" value="{{ old('experience', $doctor->experience) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600">
                @error('experience') <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Bagian Foto Profil Dokter Saat Ini & Opsi Penggantian -->
        <div class="rounded-2xl border border-slate-200 p-4 bg-slate-50/70 space-y-3.5"
             x-data="{
                photoSource: '{{ $initialSource }}',
                previewUrl: null,
                inputUrl: '{{ old('photo_url', $isExternalUrl ? $rawPhoto : '') }}',
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
                <p class="text-[11px] text-slate-500 mt-0.5">Kelola foto profil dokter dengan memilih berkas dari folder komputer atau memasukkan URL gambar.</p>
            </div>

            <!-- Tampilan Foto Saat Ini -->
            @if ($hasPhoto)
                <div class="flex items-center gap-3.5 p-3.5 bg-white rounded-2xl border border-slate-200 shadow-xs">
                    <img src="{{ $doctor->photo }}" alt="{{ $doctor->name }}" referrerpolicy="no-referrer" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs shrink-0">
                    <div class="min-w-0 flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-800">Foto Saat Ini Tersimpan</span>
                            @if ($isExternalUrl)
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-md bg-sky-100 text-sky-800">Tautan Eksternal (URL)</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-md bg-emerald-100 text-emerald-800">File Tersimpan di Server</span>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-500 truncate">
                            {{ $rawPhoto }}
                        </p>
                        @if ($doctor->photo)
                            <a href="{{ $doctor->photo }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] text-teal-700 hover:text-teal-900 font-semibold hover:underline">
                                Cek Foto Saat Ini ↗
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Pilihan Metode Ganti Foto -->
            <div class="pt-1">
                <span class="block text-[11px] font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Opsi Perubahan Foto:</span>
                <div class="flex flex-wrap items-center gap-3">
                    <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition select-none"
                           :class="photoSource === 'upload' ? 'bg-teal-50 border-teal-500 text-teal-800 shadow-sm ring-1 ring-teal-500/20' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                        <input type="radio" name="photo_source" value="upload" x-model="photoSource" class="text-teal-600 focus:ring-teal-500">
                        <span>📁 Upload File dari Folder Komputer</span>
                    </label>

                    <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition select-none"
                           :class="photoSource === 'url' ? 'bg-teal-50 border-teal-500 text-teal-800 shadow-sm ring-1 ring-teal-500/20' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                        <input type="radio" name="photo_source" value="url" x-model="photoSource" class="text-teal-600 focus:ring-teal-500">
                        <span>🔗 Gunakan URL Foto Gambar</span>
                    </label>
                </div>
            </div>

            <!-- Panel 1: Unggah Berkas Baru -->
            <div x-show="photoSource === 'upload'" x-transition class="space-y-2 pt-1">
                <label class="block text-[11px] font-semibold text-slate-700">Pilih Berkas Foto Baru</label>
                <input type="file" name="photo_file" accept="image/png,image/jpeg,image/jpg,image/webp"
                       @change="handleFile($event)"
                       :disabled="photoSource !== 'upload'"
                       class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 border border-slate-200 rounded-xl bg-white p-1 cursor-pointer">
                <p class="text-[11px] text-slate-400">Kosongkan jika tetap ingin menggunakan foto yang tersimpan saat ini. Format: JPG, JPEG, PNG, WEBP (maks. 5 MB).</p>

                <!-- Pratinjau File Baru yang Dipilih -->
                <div x-show="previewUrl" class="mt-2.5 flex items-center gap-3 p-3 bg-white rounded-xl border border-teal-200 shadow-xs">
                    <img :src="previewUrl" alt="Pratinjau Foto Baru" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs shrink-0">
                    <div>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-teal-100 text-teal-800">Pratinjau Foto Baru</span>
                        <p class="text-[11px] text-slate-500 mt-0.5">Foto baru ini akan menggantikan foto lama saat formulir disimpan.</p>
                    </div>
                </div>
                @error('photo_file')
                    <p class="text-[11px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Panel 2: Input URL Gambar -->
            <div x-show="photoSource === 'url'" x-transition class="space-y-2 pt-1" style="display: none;">
                <label class="block text-[11px] font-semibold text-slate-700">Masukkan URL Gambar Baru</label>
                <input type="url" name="photo_url" x-model="inputUrl" placeholder="https://drive.google.com/... atau tautan gambar langsung"
                       :disabled="photoSource !== 'url'"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-600 bg-white">
                <p class="text-[11px] text-slate-400">Mendukung link langsung gambar (HTTPS) serta link berbagi dari <strong>Google Drive</strong> (pastikan izin akses: <em>Siapa saja yang memiliki link</em>).</p>

                <!-- Pratinjau URL Gambar -->
                <div x-show="inputUrl && inputUrl.length > 8" class="mt-2.5 flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-200 shadow-xs">
                    <img :src="formatUrl(inputUrl)" referrerpolicy="no-referrer" x-on:error="$el.src = 'https://placehold.co/100x100?text=Invalid+Image'" alt="Pratinjau URL" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs shrink-0">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-slate-100 text-slate-700">Pratinjau URL Baru</span>
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
            <input type="checkbox" name="is_active" value="1" {{ $doctor->is_active ? 'checked' : '' }} id="active" class="rounded text-teal-600 focus:ring-teal-500">
            <label for="active" class="font-bold text-slate-700 cursor-pointer">Dokter Aktif Melayani</label>
        </div>

        <div class="pt-4 flex justify-between items-center">
            <a href="{{ route('admin.doctors.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#007b83] hover:bg-[#005b64] text-white font-bold rounded-xl shadow transition">Perbarui Data Dokter</button>
        </div>
    </form>
</div>
</x-layouts.admin>
