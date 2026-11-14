<x-layouts.app :title="$documentation->title . ' — Dokumentasi RSUD R.A.A. Tjokronegoro'">

    <x-page-header
        title="Dokumentasi"
        description="Dokumentasi kegiatan pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <a
            href="{{ route('information.documentation') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900"
        >
            <span aria-hidden="true">←</span>
            Kembali ke Dokumentasi
        </a>

        <section class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                {{ $documentation->title }}
            </h1>

            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-600">
                @if ($documentation->event_date)
                    <span>
                        📅 {{ $documentation->event_date->translatedFormat('d F Y') }}
                    </span>
                @endif

                @if ($documentation->location)
                    <span>📍 {{ $documentation->location }}</span>
                @endif

                <span>
                    🖼️ {{ $photoUrls->count() }} foto
                </span>

            </div>

            @if ($documentation->description)
                <p class=" whitespace-pre-line leading-7 text-slate-600">
                    {{ $documentation->description }}
                </p>
            @endif
        </section>

        @if ($photoUrls->isNotEmpty())
        <section>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">
                    Galeri Foto Kegiatan
                </h2>

                <span
                    id="photo-count"
                    class="text-sm text-slate-500"
                ></span>
            </div>

            <div
                id="documentation-gallery"
                class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4"
            >
                @foreach ($photoUrls as $index => $url)
                    <button
                        type="button"
                        class="gallery-photo group relative overflow-hidden rounded-xl bg-slate-100 text-left focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 {{ $index >= 12 ? 'hidden' : '' }}"
                        data-index="{{ $index }}"
                        aria-label="Lihat foto {{ $index + 1 }}"
                    >
                        <img
                            src="{{ $url }}"
                            alt="Foto {{ $index + 1 }} — {{ $documentation->title }}"
                            loading="{{ $index < 12 ? 'eager' : 'lazy' }}"
                            class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-105"
                        >

                        <span class="absolute inset-0 bg-black/0 transition group-hover:bg-black/10"></span>
                    </button>
                @endforeach
            </div>

            {{-- INDIKATOR PEMUATAN --}}
            <div
                id="gallery-loading"
                class="mt-8 hidden items-center justify-center gap-3 text-sm text-slate-500"
            >
                <svg
                    class="h-5 w-5 animate-spin text-blue-700"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                    ></path>
                </svg>

                Memuat foto lainnya...
            </div>

            {{-- PEMICU INFINITE SCROLL --}}
            <div
                id="gallery-sentinel"
                class="h-10"
                aria-hidden="true"
            ></div>

            <p
                id="gallery-finished"
                class="hidden py-5 text-center text-sm text-slate-400"
            >
                Semua foto kegiatan telah ditampilkan.
            </p>
        </section>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
                <p class="font-semibold text-slate-700">Belum ada foto dokumentasi.</p>
                <p class="mt-2 text-sm text-slate-500">
                    Foto kegiatan belum tersedia untuk ditampilkan.
                </p>
            </div>
        @endif

    </main>

    {{-- Lightbox foto --}}
    <div
        id="photo-lightbox"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/95 p-4"
        role="dialog"
        aria-modal="true"
        aria-label="Pratinjau foto dokumentasi"
    >
        <button
            id="lightbox-close"
            type="button"
            class="absolute right-4 top-4 z-10 rounded-full bg-white/15 px-4 py-2 text-2xl text-white hover:bg-white/25"
            aria-label="Tutup foto"
        >
            &times;
        </button>

        <button
            id="lightbox-prev"
            type="button"
            class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/15 px-4 py-3 text-2xl text-white hover:bg-white/25 sm:left-6"
            aria-label="Foto sebelumnya"
        >
            ‹
        </button>

        <div class="flex max-h-full w-full max-w-6xl flex-col items-center justify-center">
            <img
                id="lightbox-image"
                src=""
                alt=""
                class="max-h-[78vh] max-w-full rounded-lg object-contain"
            >

            <p id="lightbox-counter" class="mt-4 text-sm text-white/80"></p>
        </div>

        <button
            id="lightbox-next"
            type="button"
            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/15 px-4 py-3 text-2xl text-white hover:bg-white/25 sm:right-6"
            aria-label="Foto berikutnya"
        >
            ›
        </button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const gallery = document.getElementById('documentation-gallery');

        if (!gallery) return;

        const photoCount = document.getElementById('photo-count');
        const loadingIndicator = document.getElementById('gallery-loading');
        const sentinel = document.getElementById('gallery-sentinel');
        const finishedMessage = document.getElementById('gallery-finished');

        const lightbox = document.getElementById('photo-lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCounter = document.getElementById('lightbox-counter');

        const closeButton = document.getElementById('lightbox-close');
        const prevButton = document.getElementById('lightbox-prev');
        const nextButton = document.getElementById('lightbox-next');

        const batchSize = 12;

        const photoButtons = Array.from(
            gallery.querySelectorAll('.gallery-photo')
        );

        let visibleCount = Math.min(batchSize, photoButtons.length);
        let currentIndex = 0;
        let isLoading = false;

        // =====================================================
        // UPDATE JUMLAH FOTO
        // =====================================================

        function updatePhotoCount() {
            photoCount.textContent =
                `Menampilkan ${visibleCount} dari ${photoButtons.length} foto`;
        }

        // =====================================================
        // INFINITE SCROLL
        // =====================================================

        function loadMorePhotos() {
            if (isLoading || visibleCount >= photoButtons.length) {
                return;
            }

            isLoading = true;

            loadingIndicator.classList.remove('hidden');
            loadingIndicator.classList.add('flex');

            // Beri jeda singkat agar indikator loading terlihat.
            setTimeout(function () {
                const nextLimit = Math.min(
                    visibleCount + batchSize,
                    photoButtons.length
                );

                for (let i = visibleCount; i < nextLimit; i++) {
                    const button = photoButtons[i];

                    button.classList.remove('hidden');

                    const img = button.querySelector('img');

                    if (img) {
                        img.loading = 'lazy';
                    }
                }

                visibleCount = nextLimit;

                updatePhotoCount();

                loadingIndicator.classList.add('hidden');
                loadingIndicator.classList.remove('flex');

                isLoading = false;

                if (visibleCount >= photoButtons.length) {
                    observer.disconnect();

                    sentinel.classList.add('hidden');
                    finishedMessage.classList.remove('hidden');
                }
            }, 300);
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    loadMorePhotos();
                }
            });
        }, {
            root: null,
            rootMargin: '500px 0px',
            threshold: 0
        });

        if (visibleCount < photoButtons.length) {
            observer.observe(sentinel);
        } else {
            sentinel.classList.add('hidden');
            finishedMessage.classList.remove('hidden');
        }

        updatePhotoCount();

        // =====================================================
        // LIGHTBOX
        // =====================================================

        function showPhoto(index) {
            currentIndex = (
                index + photoButtons.length
            ) % photoButtons.length;

            const img = photoButtons[currentIndex].querySelector('img');

            lightboxImage.src = img.src;
            lightboxImage.alt = img.alt;

            lightboxCounter.textContent =
                `Foto ${currentIndex + 1} dari ${photoButtons.length}`;
        }

        function openLightbox(index) {
            showPhoto(index);

            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');

            document.body.style.overflow = 'hidden';

            closeButton.focus();
        }

        function closeLightbox() {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');

            document.body.style.overflow = '';
        }

        gallery.addEventListener('click', function (event) {
            const button = event.target.closest('.gallery-photo');

            if (!button) return;

            const index = Number(button.dataset.index);

            openLightbox(index);
        });

        closeButton.addEventListener('click', closeLightbox);

        prevButton.addEventListener('click', function () {
            showPhoto(currentIndex - 1);
        });

        nextButton.addEventListener('click', function () {
            showPhoto(currentIndex + 1);
        });

        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (lightbox.classList.contains('hidden')) return;

            if (event.key === 'Escape') closeLightbox();

            if (event.key === 'ArrowLeft') {
                showPhoto(currentIndex - 1);
            }

            if (event.key === 'ArrowRight') {
                showPhoto(currentIndex + 1);
            }
        });
    });
</script>

</x-layouts.app>