<x-layouts.app title="Fasilitas — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Fasilitas"
        description="Informasi mengenai fasilitas pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Submenu Pendidikan & Pelatihan --}}
    <x-submenus.diklat active="facilities" />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 py-5 text-sm" aria-label="Breadcrumb">
                <a href="{{ url('/informasi/diklat') }}" class="font-medium text-slate-500 hover:text-[#007b83]">Informasi</a>
                <span class="text-slate-300">›</span>
                <span class="font-semibold text-[#007b83]">Fasilitas</span>
            </nav>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {!! $page->content !!}
        
        <section class="facility-page">

            {{-- Daftar fasilitas --}}
            <div class="facility-list">
                @forelse ($facilities as $facility)
                    <article class="facility-card">

                        <div class="facility-card-header">
                            <div class="facility-heading">
                                <span class="facility-icon facility-icon-teal">
                                    <svg viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true">
                                        <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                        <path d="M8 9h8M8 13h5"></path>
                                    </svg>
                                </span>
                                <h3>{{ $facility->title }}</h3>
                            </div>

                            @if ($facility->category)
                                <span class="facility-category">
                                    {{ mb_strtoupper($facility->category) }}
                                </span>
                            @endif
                        </div>

                        {{-- Foto utama yang membuka lightbox --}}
                        @php
                            $facilityGallery = collect();

                            if ($facility->image_path) {
                                $facilityGallery->push(asset('storage/' . $facility->image_path));
                            }

                            foreach ($facility->photos as $photo) {
                                if ($photo->image_path) {
                                    $facilityGallery->push(asset('storage/' . $photo->image_path));
                                }
                            }
                        @endphp

                        @if ($facilityGallery->isNotEmpty())
                            <div
                                class="facility-photo facility-gallery-trigger cursor-pointer"
                                role="button"
                                tabindex="0"
                                aria-label="Buka galeri foto {{ $facility->title }}"
                                data-facility-gallery="{{ $facilityGallery->toJson() }}"
                                data-facility-title="{{ $facility->title }}"
                            >
                                <img
                                    src="{{ $facilityGallery->first() }}"
                                    alt="{{ $facility->title }}"
                                    loading="lazy"
                                >

                                <div class="facility-photo-overlay">
                                    @if ($facility->label)
                                        <span class="facility-photo-label">
                                            {{ mb_strtoupper($facility->label) }}
                                        </span>
                                    @endif

                                    @if ($facility->caption)
                                        <p>{{ $facility->caption }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($facility->description)
                            <p class="facility-description">
                                {{ $facility->description }}
                            </p>
                        @endif

                        @if ($facility->link_url)
                            <div class="mt-5">
                                <a
                                    href="{{ $facility->link_url }}"
                                    class="facility-library-link"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    {{ $facility->link_label ?: 'Selengkapnya' }}
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        @endif

                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center">
                        <h3 class="font-semibold text-slate-800">Belum Ada Fasilitas</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Informasi fasilitas pendidikan dan pelatihan belum tersedia.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    {{-- Lightbox galeri fasilitas --}}
    <div
        id="facility-lightbox"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/90 p-4"
        role="dialog"
        aria-modal="true"
        aria-label="Galeri foto fasilitas"
    >
        <button
            type="button"
            id="facility-lightbox-close"
            class="absolute right-5 top-5 z-10 flex h-11 w-11 items-center justify-center rounded-full bg-white/15 text-3xl text-white hover:bg-white/30"
            aria-label="Tutup galeri"
        >&times;</button>

        <button
            type="button"
            id="facility-lightbox-prev"
            class="absolute left-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-3xl text-white hover:bg-white/30 sm:left-6"
            aria-label="Foto sebelumnya"
        >&#8249;</button>

        <div class="flex max-h-[90vh] w-full max-w-5xl flex-col items-center gap-4">
            <p id="facility-lightbox-title" class="text-center text-lg font-semibold text-white"></p>

            <img
                id="facility-lightbox-image"
                src=""
                alt=""
                class="max-h-[65vh] max-w-full rounded-lg object-contain"
            >

            <p id="facility-lightbox-counter" class="text-sm text-white/80"></p>

            <div
                id="facility-lightbox-thumbnails"
                class="flex max-w-full gap-2 overflow-x-auto py-2"
            ></div>
        </div>

        <button
            type="button"
            id="facility-lightbox-next"
            class="absolute right-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-3xl text-white hover:bg-white/30 sm:right-6"
            aria-label="Foto berikutnya"
        >&#8250;</button>
    </div>

    {{-- JavaScript lightbox --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lightbox = document.getElementById('facility-lightbox');
            const image = document.getElementById('facility-lightbox-image');
            const title = document.getElementById('facility-lightbox-title');
            const counter = document.getElementById('facility-lightbox-counter');
            const thumbnails = document.getElementById('facility-lightbox-thumbnails');
            const closeButton = document.getElementById('facility-lightbox-close');
            const prevButton = document.getElementById('facility-lightbox-prev');
            const nextButton = document.getElementById('facility-lightbox-next');

            if (!lightbox || !image || !thumbnails) return;

            let photos = [];
            let currentIndex = 0;
            let previousFocus = null;

            function showPhoto(index) {
                if (!photos.length) return;

                currentIndex = (index + photos.length) % photos.length;
                image.src = photos[currentIndex];
                image.alt = title.textContent + ' - Foto ' + (currentIndex + 1);
                counter.textContent = 'Foto ' + (currentIndex + 1) + ' dari ' + photos.length;

                thumbnails.querySelectorAll('button').forEach((button, i) => {
                    const active = i === currentIndex;
                    button.classList.toggle('ring-2', active);
                    button.classList.toggle('ring-white', active);
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                });
            }

            function openGallery(card) {
                try {
                    photos = JSON.parse(card.dataset.facilityGallery || '[]');
                } catch (error) {
                    photos = [];
                }

                photos = photos.filter(photo => typeof photo === 'string' && photo);
                if (!photos.length) return;

                previousFocus = document.activeElement;
                title.textContent = card.dataset.facilityTitle || 'Fasilitas';
                thumbnails.replaceChildren();

                photos.forEach((photo, index) => {
                    const button = document.createElement('button');
                    const thumb = document.createElement('img');

                    button.type = 'button';
                    button.className = 'shrink-0 overflow-hidden rounded border border-white/30';
                    button.setAttribute('aria-label', 'Lihat foto ' + (index + 1));
                    button.setAttribute('aria-pressed', 'false');

                    thumb.src = photo;
                    thumb.alt = '';
                    thumb.loading = 'lazy';
                    thumb.className = 'h-14 w-20 object-cover';

                    button.appendChild(thumb);
                    button.addEventListener('click', () => showPhoto(index));
                    thumbnails.appendChild(button);
                });

                showPhoto(0);
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                document.body.style.overflow = 'hidden';
                closeButton.focus();
            }

            function closeGallery() {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                image.src = '';
                document.body.style.overflow = '';

                if (previousFocus && typeof previousFocus.focus === 'function') {
                    previousFocus.focus();
                }
            }

            document.querySelectorAll('.facility-gallery-trigger[data-facility-gallery]')
                .forEach(card => {
                    card.addEventListener('click', () => openGallery(card));

                    card.addEventListener('keydown', event => {
                        if (event.target !== card) return;

                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            openGallery(card);
                        }
                    });
                });

            closeButton.addEventListener('click', closeGallery);
            prevButton.addEventListener('click', () => showPhoto(currentIndex - 1));
            nextButton.addEventListener('click', () => showPhoto(currentIndex + 1));

            lightbox.addEventListener('click', event => {
                if (event.target === lightbox) closeGallery();
            });

            document.addEventListener('keydown', event => {
                if (lightbox.classList.contains('hidden')) return;

                if (event.key === 'Escape') closeGallery();
                if (event.key === 'ArrowLeft') showPhoto(currentIndex - 1);
                if (event.key === 'ArrowRight') showPhoto(currentIndex + 1);
            });
        });
    </script>

</x-layouts.app>
