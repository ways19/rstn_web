
<x-layouts.app :title="'Absensi Pelatihan — RSUD R.A.A. Tjokronegoro'">

    @push('styles')
        @vite(['resources/css/pages/diklat-registration.css'])
    @endpush

    <x-page-header
        title="Absensi Peserta Pelatihan"
        description="Formulir pencatatan kehadiran peserta program pelatihan RSUD R.A.A. Tjokronegoro."
    />

    <main
        id="attendance-content"
        class="diklat-registration mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8"
    >
        <a
            href="{{ route('information.diklat.detail', $program->id) }}"
            class="diklat-registration__back"
        >
            ← Kembali ke Pendidikan &amp; Pelatihan
        </a>

        @if ($errors->any())
            <div class="diklat-registration__alert" role="alert">
                <strong>Absensi belum berhasil dicatat.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="diklat-registration__card">

            {{-- INFORMASI PROGRAM --}}
            <div class="diklat-registration__program">
                <span class="diklat-registration__program-label">
                    PROGRAM PELATIHAN
                </span>

                <h2>{{ $program->name }}</h2>

                <div class="diklat-registration__program-details">
                    <p>
                        <span>Kategori</span>
                        <strong>{{ $program->category }}</strong>
                    </p>

                    <p>
                        <span>Penyelenggara</span>
                        <strong>
                            {{ $program->organizer ?: 'Instalasi Diklat RSUD' }}
                        </strong>
                    </p>

                    <p>
                        <span>Lokasi</span>
                        <strong>
                            {{ $program->location ?: 'Belum ditentukan' }}
                        </strong>
                    </p>

                    <p>
                        <span>Jadwal</span>
                        <strong>
                            {{ $program->schedule ?: 'Sesuai konfirmasi' }}
                        </strong>
                    </p>

                    @if ($program->duration)
                        <p>
                            <span>Durasi</span>
                            <strong>{{ $program->duration }}</strong>
                        </p>
                    @endif

                    @if ($program->start_at)
                        <p>
                            <span>Mulai Absensi</span>
                            <strong>
                                {{ $program->start_at->translatedFormat('d F Y, H:i') }}
                            </strong>
                        </p>
                    @endif

                    @if ($program->end_at)
                        <p>
                            <span>Batas Absensi</span>
                            <strong>
                                {{ $program->end_at->translatedFormat('d F Y, H:i') }}
                            </strong>
                        </p>
                    @endif
                </div>

                <p>
                    <span>Sasaran Peserta</span>
                    <strong>
                        @switch($program->participant_target)
                            @case('internal')
                                Internal RSUD
                                @break
                            @case('keduanya')
                                Publik dan Internal RSUD
                                @break
                            @default
                                Publik
                        @endswitch
                    </strong>
                </p>

                <p>
                    <span>Biaya</span>
                    <strong>
                        @if ($program->is_paid)
                            Rp{{ number_format($program->fee ?? 0, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </strong>
                </p>

                @if ($program->description)
                    <div class="diklat-wizard-information">
                        <h3>Informasi Pelatihan</h3>
                        <p>{{ $program->description }}</p>
                    </div>
                @endif
            </div>

            {{-- STATUS ABSENSI --}}
            @if (!$isOpen)
                <div class="diklat-registration__notice">
                    <span class="diklat-registration__notice-icon">i</span>

                    <p>
                        @if (
                            !$program->start_at ||
                            !$program->end_at
                        )
                            Jadwal pembukaan absensi belum tersedia.
                        @elseif (now()->lessThan($program->start_at))
                            Absensi belum dibuka. Silakan kembali pada
                            {{ $program->start_at->translatedFormat('d F Y, H:i') }}.
                        @else
                            Waktu pengisian absensi telah berakhir.
                        @endif
                    </p>
                </div>
            @else

                {{-- FORMULIR ABSENSI --}}
                <div class="diklat-registration__form-heading">
                    <h2>Formulir Kehadiran</h2>
                    <p>Lengkapi data berikut untuk mencatat kehadiran.</p>
                </div>

                <form
                    action="{{ route('information.diklat.attendance.store', $program->id) }}"
                    method="POST"
                >
                    @csrf

                    <div class="diklat-registration__grid">

                        <div class="diklat-registration__field diklat-registration__field--full">
                            <label for="full_name">
                                Nama lengkap <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                maxlength="255"
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                                required
                            >

                            @error('full_name')
                                <small class="diklat-registration__error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="diklat-registration__field diklat-registration__field--full">
                            <label for="institution">
                                Instansi asal <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="institution"
                                name="institution"
                                value="{{ old('institution') }}"
                                maxlength="255"
                                placeholder="Masukkan nama rumah sakit atau institusi"
                                required
                            >

                            @error('institution')
                                <small class="diklat-registration__error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>

                    <div class="diklat-registration__notice">
                        <span class="diklat-registration__notice-icon">i</span>

                        <p>
                            Pastikan nama lengkap dan instansi sudah benar.
                            Setiap peserta hanya dapat mengisi absensi satu
                            kali untuk program pelatihan ini.
                        </p>
                    </div>

                    <div class="diklat-wizard-actions">
                        <a
                            href="{{ route('information.diklat.detail', $program->id) }}"
                            class="diklat-registration__button diklat-registration__button--secondary"
                        >
                            ← Kembali
                        </a>

                        <button
                            type="submit"
                            onclick="return confirm('Pastikan nama dan instansi sudah benar. Kirim absensi sekarang?')"
                            class="diklat-registration__button diklat-registration__button--primary"
                        >
                            Kirim Absensi ✓
                        </button>
                        
                    </div>
                </form>
            @endif

        </section>
    </main>

</x-layouts.app>
