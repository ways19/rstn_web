
<x-layouts.app title="Riwayat Pendaftaran Diklat — RSUD R.A.A. Tjokronegoro">

    <x-page-header
        title="Riwayat Pendaftaran"
        description="Lihat status pendaftaran Pendidikan dan Pelatihan yang pernah kamu lakukan."
    />

    <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a
                href="{{ url('/informasi/pendidikan-pelatihan') }}"
                class="text-sm font-medium text-blue-700 hover:underline"
            >
                ← Kembali ke Pendidikan & Pelatihan
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            <h2 class="text-lg font-semibold text-slate-900">
                Riwayat Pendaftaran Diklat
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-600">
                Riwayat yang ditampilkan berasal dari pendaftaran yang tersimpan
                pada browser ini. Jika menggunakan perangkat atau browser lain,
                riwayat mungkin tidak tersedia.
            </p>

            <div id="historyMessage" class="mt-6 text-sm text-slate-600">
                Memuat riwayat pendaftaran...
            </div>

            <div id="historyList" class="mt-5 space-y-4"></div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', async function () {
                const message = document.getElementById('historyMessage');
                const list = document.getElementById('historyList');

                try {
                    const stored = JSON.parse(
                        localStorage.getItem('diklat_registration_tokens') || '[]'
                    );

                    const tokens = [...new Set(
                        (Array.isArray(stored) ? stored : [])
                            .filter(token =>
                                typeof token === 'string' &&
                                /^[a-zA-Z0-9]{64}$/.test(token)
                            )
                    )];

                    if (tokens.length === 0) {
                        message.textContent =
                            'Belum ada riwayat pendaftaran di browser ini.';
                        return;
                    }

                    const response = await fetch(
                        @json(route('information.diklat.registration.history.lookup')),
                        {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': @json(csrf_token()),
                            },
                            body: JSON.stringify({ tokens }),
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Riwayat gagal dimuat.');
                    }

                    const data = await response.json();
                    const registrations = data.registrations || [];

                    list.replaceChildren();

                    if (registrations.length === 0) {
                        message.textContent =
                            'Data pendaftaran tidak ditemukan. Pastikan token masih tersimpan di browser ini.';
                        return;
                    }

                    message.textContent =
                        `${registrations.length} pendaftaran ditemukan.`;

                    registrations.forEach(registration => {
                        const card = document.createElement('article');
                        card.className =
                            'rounded-xl border border-slate-200 p-4 sm:p-5';

                        const title = document.createElement('h3');
                        title.className =
                            'font-semibold text-slate-900';
                        title.textContent = registration.program_name;

                        const number = document.createElement('p');
                        number.className =
                            'mt-2 text-sm text-slate-600';
                        number.textContent =
                            'Nomor pendaftaran: ' +
                            registration.registration_number;

                        const status = document.createElement('p');
                        status.className =
                            'mt-1 text-sm text-slate-600';

                        status.textContent = registration.completion_confirmed
                            ? 'Status: Penyelesaian telah dikonfirmasi'
                            : 'Status: ' + registration.status;

                        const link = document.createElement('a');
                        link.href = registration.status_url;
                        link.className =
                            'mt-4 inline-flex rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800';
                        link.textContent = 'Lihat Detail Status';

                        card.append(title, number, status, link);
                        list.appendChild(card);
                    });
                } catch (error) {
                    message.textContent =
                        'Riwayat belum dapat dimuat. Silakan muat ulang halaman.';
                    console.error(error);
                }
            });
        </script>
    @endpush

</x-layouts.app>
