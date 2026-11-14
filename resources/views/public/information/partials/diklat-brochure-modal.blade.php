{{-- MODAL PDF VIEWER BROSUR PELATIHAN --}}
<div
    id="diklat-brochure-modal"
    class="diklat-pdf-modal-backdrop"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="diklat-brochure-modal-title"
>
    <div class="diklat-pdf-modal-container">
        {{-- Header Modal --}}
        <div class="diklat-pdf-modal-header">
            <div class="diklat-pdf-modal-header-left">
                <div class="diklat-pdf-modal-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="diklat-pdf-modal-title-wrap">
                    <h3 id="diklat-brochure-modal-title">Brosur Pelatihan</h3>
                    <p>Pratinjau Brosur Resmi Diklat RSUD R.A.A. Tjokronegoro</p>
                </div>
            </div>

            <div class="diklat-pdf-modal-actions">
                <a
                    id="diklat-brochure-open-new-tab"
                    href="#"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="diklat-pdf-btn-secondary"
                    title="Buka dokumen di tab baru"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Tab Baru</span>
                </a>

                <a
                    id="diklat-brochure-download"
                    href="#"
                    download
                    class="diklat-pdf-btn-primary"
                    title="Unduh berkas PDF"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Unduh PDF</span>
                </a>

                <button
                    type="button"
                    onclick="closeDiklatBrochureModal()"
                    class="diklat-pdf-close-btn"
                    aria-label="Tutup pratinjau"
                >
                    &times;
                </button>
            </div>
        </div>

        {{-- Body: Iframe PDF Viewer --}}
        <div class="diklat-pdf-modal-body">
            <div id="diklat-brochure-loading" class="diklat-pdf-loading-spinner">
                <div class="diklat-spinner-circle"></div>
                <span>Menyiapkan Brosur PDF...</span>
            </div>
            <iframe
                id="diklat-brochure-iframe"
                src="about:blank"
                class="diklat-pdf-iframe"
                title="Viewer Brosur PDF"
            ></iframe>
        </div>
    </div>
</div>

<script>
function openDiklatBrochureModal(url, title) {
    const modal = document.getElementById('diklat-brochure-modal');
    const iframe = document.getElementById('diklat-brochure-iframe');
    const modalTitle = document.getElementById('diklat-brochure-modal-title');
    const newTabBtn = document.getElementById('diklat-brochure-open-new-tab');
    const downloadBtn = document.getElementById('diklat-brochure-download');
    const loader = document.getElementById('diklat-brochure-loading');

    if (!modal || !iframe) return;

    modalTitle.textContent = title ? ('Brosur — ' + title) : 'Brosur Pelatihan';
    newTabBtn.href = url;
    downloadBtn.href = url;

    if (loader) loader.style.display = 'flex';
    iframe.onload = function() {
        if (loader) loader.style.display = 'none';
    };

    iframe.src = url + '#toolbar=1&navpanes=0';

    modal.classList.add('is-open');
    modal.style.setProperty('display', 'flex', 'important');
    document.body.style.overflow = 'hidden';
}

function closeDiklatBrochureModal() {
    const modal = document.getElementById('diklat-brochure-modal');
    const iframe = document.getElementById('diklat-brochure-iframe');

    if (!modal) return;

    modal.classList.remove('is-open');
    modal.style.setProperty('display', 'none', 'important');
    if (iframe) {
        iframe.src = 'about:blank';
    }
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDiklatBrochureModal();
    }
});

document.addEventListener('click', function(e) {
    const modal = document.getElementById('diklat-brochure-modal');
    if (modal && e.target === modal) {
        closeDiklatBrochureModal();
    }
});
</script>
