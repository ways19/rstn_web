<x-layouts.app title="Dokumentasi — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Dokumentasi"
        description="Dokumentasi kegiatan pendidikan dan pelatihan di RSUD R.A.A. Tjokronegoro."
    />

    {{-- Submenu Pendidikan & Pelatihan --}}
    <x-submenus.diklat active="documentation" />

    {{-- Breadcrumb --}}
    <div class="bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <nav
                class="flex items-center gap-2 py-5 text-sm"
                aria-label="Breadcrumb"
            >

                <a href="{{ url('/informasi/diklat') }}" class="font-medium text-slate-500 hover:text-[#007b83]">
                    Informasi
                </a>

                <span class="text-slate-300">
                    ›
                </span>

                <span class="font-semibold text-[#007b83]">
                    Dokumentasi
                </span>

            </nav>

        </div>

    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {!! $page->content !!}
    </main>

    
    {{-- Penggeser galeri kategori --}}
    <script>
        function scrollDokumentasi(kategori, arah) {
            const galeri = document.getElementById('galeri-' + kategori);

            if (!galeri) return;

            const kartu = galeri.querySelector('.diklat-dokumentasi__card');

            const style = window.getComputedStyle(galeri);
            const gap = parseFloat(style.columnGap || style.gap) || 20;

            const jarak = kartu
                ? kartu.getBoundingClientRect().width + gap
                : galeri.clientWidth * 0.8;

            galeri.scrollBy({
                left: arah * jarak,
                behavior: 'smooth'
            });
        }

        
       
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.querySelector('.diklat-dokumentasi');
            if (!root) return;

            const grid = root.querySelector('#dokumentasi-grid');
            const pagination = root.querySelector('#dokumentasi-pagination');
            const status = root.querySelector('#dokumentasi-filter-status');
            const buttons = root.querySelectorAll('.dokumentasi-filter__item');

            if (!grid || !pagination) return;

            const cards = Array.from(
                grid.querySelectorAll('.diklat-dokumentasi__card')
            );

            const perPage = 6;
            let selectedCategory = 'semua';
            let currentPage = 1;

            function getFilteredCards() {
                return cards.filter(function (card) {
                    const cardCategory = (
                        card.dataset.category || ''
                    ).trim().toLowerCase();

                    return selectedCategory === 'semua' ||
                        cardCategory === selectedCategory;
                });
            }

            function render() {
                const filteredCards = getFilteredCards();
                const totalPages = Math.ceil(filteredCards.length / perPage);

                currentPage = Math.max(
                    1,
                    Math.min(currentPage, totalPages || 1)
                );

                cards.forEach(function (card) {
                    card.hidden = true;
                });

                const start = (currentPage - 1) * perPage;

                filteredCards
                    .slice(start, start + perPage)
                    .forEach(function (card) {
                        card.hidden = false;
                    });

                if (status) {
                    status.textContent = filteredCards.length
                        ? 'Menampilkan ' + (start + 1) + '–' +
                            Math.min(start + perPage, filteredCards.length) +
                            ' dari ' + filteredCards.length + ' dokumentasi'
                        : 'Belum ada dokumentasi pada kategori ini.';
                }

                pagination.replaceChildren();

                if (totalPages <= 1) return;

                function addButton(label, page, active, disabled) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = label;
                    button.disabled = disabled;

                    if (active) button.classList.add('is-active');

                    button.addEventListener('click', function () {
                        currentPage = page;
                        render();

                        grid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });

                    pagination.appendChild(button);
                }

                addButton('‹', currentPage - 1, false, currentPage === 1);

                for (let page = 1; page <= totalPages; page++) {
                    addButton(
                        String(page),
                        page,
                        page === currentPage,
                        false
                    );
                }

                addButton(
                    '›',
                    currentPage + 1,
                    false,
                    currentPage === totalPages
                );
            }

            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    selectedCategory = (
                        button.dataset.filter || 'semua'
                    ).trim().toLowerCase();

                    currentPage = 1;

                    buttons.forEach(function (item) {
                        const active = item === button;

                        item.classList.toggle('is-active', active);
                        item.setAttribute('aria-pressed', String(active));
                    });

                    render();
                });
            });

            render();
        });


    </script>

</x-layouts.app>