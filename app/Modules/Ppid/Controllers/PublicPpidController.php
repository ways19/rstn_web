<?php

namespace App\Modules\Ppid\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PpidDocument;
use App\Models\PpidInformationRequest;
use App\Models\PpidObjection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicPpidController extends Controller
{
    public function profile()
    {
        return view('public.ppid.profile-main');
    }

    public function profileMain()
    {
        $page = Page::where('slug', 'profil-ppid')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.profile-main', compact('page'));
    }

    public function profileTeam()
    {
        $page = Page::where('slug', 'sk-tim-ppid')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.profile-team', compact('page'));
    }

    public function profileStructure()
    {
        $page = Page::where('slug', 'struktur-ppid')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.profile-structure', compact('page'));
    }

    public function profileDuties()
    {
        $page = Page::where('slug', 'tugas-fungsi-ppid')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.profile-duties', compact('page'));
    }

    public function profileStatement()
    {
        $page = Page::where('slug', 'maklumat-pelayanan-informasi')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.profile-statement', compact('page'));
    }

    public function information()
    {
        return view('public.ppid.information');
    }

    public function informationPeriodic()
    {
        $page = Page::where('slug', 'informasi-berkala')
            ->where('is_active', true)
            ->firstOrFail();

        $sections = $page->sections()
            ->where('is_active', true)
            ->with([
                'placements' => function ($query) {
                    $query->whereHas('document', function ($documentQuery) {
                        $documentQuery->where('is_active', true);
                    })->with('document');
                },
            ])
            ->get();

        return view(
            'public.ppid.information-periodic',
            compact('page', 'sections')
        );
    }

    public function informationImmediate()
    {
        $page = Page::where('slug', 'informasi-serta-merta')
            ->where('is_active', true)
            ->firstOrFail();

        $sections = $page->sections()
            ->where('is_active', true)
            ->with([
                'placements' => function ($query) {
                    $query->whereHas('document', function ($documentQuery) {
                        $documentQuery->where('is_active', true);
                    })->with('document');
                },
            ])
            ->get();

        return view(
            'public.ppid.information-immediate',
            compact('page', 'sections')
        );
    }

    public function informationAnytime()
    {
        $page = Page::where('slug', 'informasi-setiap-saat')
            ->where('is_active', true)
            ->firstOrFail();

        $sections = $page->sections()
            ->where('is_active', true)
            ->with([
                'placements' => function ($query) {
                    $query->whereHas('document', function ($documentQuery) {
                        $documentQuery->where('is_active', true);
                    })->with('document');
                },
            ])
            ->get();

        return view(
            'public.ppid.information-anytime',
            compact('page', 'sections')
        );
    }

    public function informationExcluded()
    {
        $page = Page::where('slug', 'informasi-dikecualikan')
            ->where('is_active', true)
            ->firstOrFail();

        $sections = $page->sections()
            ->where('is_active', true)
            ->with([
                'placements' => function ($query) {
                    $query->whereHas('document', function ($documentQuery) {
                        $documentQuery->where('is_active', true);
                    })->with('document');
                },
            ])
            ->get();

        return view(
            'public.ppid.information-excluded',
            compact('page', 'sections')
        );
    }

    public function documentDetail(PpidDocument $ppidDocument)
    {
        abort_unless($ppidDocument->is_active, 404);

        $ppidDocument->load(['placements.section.page']);

        $placement = $ppidDocument->placements->first();
        $page = $placement?->section?->page;

        return view(
            'public.ppid.document-detail',
            compact('ppidDocument', 'page', 'placement')
        );
    }

    public function requestInformation()
    {
        $page = Page::where('slug', 'permintaan-informasi')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.request-information', compact('page'));
    }
    
    public function submitInformationRequest(Request $request)
    {
        $hasVoiceRecording = $request->hasFile('voice_recording');

        $validated = $request->validate([
            // Identitas pemohon
            'kategori_pemohon' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'string', 'digits:16'],

            'applicant_name' => ['required', 'string', 'max:255'],
            'applicant_phone' => ['required', 'regex:/^[0-9]+$/', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'applicant_address' => ['required', 'string'],

            'identity_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            // Rincian informasi dan tujuan
            'rincian_informasi' => [
                $hasVoiceRecording ? 'nullable' : 'required',
                'string',
            ],

            'tujuan' => [
                $hasVoiceRecording ? 'nullable' : 'required',
                'string',
                'max:1000',
            ],

            // Cara memperoleh informasi bersifat opsional
            'cara_memperoleh' => ['nullable', 'string', 'max:100'],

            // Cara pengiriman wajib dipilih
            'cara_pengiriman' => ['required', 'string', 'max:100'],

            // Persetujuan wajib dicentang
            'persetujuan' => ['required', 'accepted'],

            // Rekaman suara opsional
            'voice_recording' => ['nullable', 'file', 'max:10240'],
        ], [
            'kategori_pemohon.required' => 'Kategori pemohon wajib dipilih.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',

            'applicant_name.required' => 'Nama lengkap pemohon wajib diisi.',
            'applicant_phone.required' => 'Nomor WhatsApp atau telepon wajib diisi.',
            'applicant_phone.regex' => 'Nomor WhatsApp atau telepon hanya boleh berisi angka.',
            'email.required' => 'Email aktif wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'applicant_address.required' => 'Alamat lengkap pemohon wajib diisi.',

            'identity_file.required' => 'Berkas identitas wajib diunggah.',
            'identity_file.mimes' => 'Berkas identitas harus berformat JPG, JPEG, PNG, atau PDF.',
            'identity_file.max' => 'Ukuran berkas identitas maksimal 5 MB.',

            'rincian_informasi.required' => 'Rincian informasi yang dibutuhkan wajib diisi jika tidak menggunakan rekaman suara.',
            'tujuan.required' => 'Tujuan penggunaan informasi wajib diisi jika tidak menggunakan rekaman suara.',

            'cara_pengiriman.required' => 'Cara pengiriman salinan informasi wajib dipilih.',
            'persetujuan.required' => 'Pernyataan persetujuan wajib dicentang.',
            'persetujuan.accepted' => 'Anda harus menyetujui pernyataan sebelum mengirim permohonan.',

            'voice_recording.max' => 'Ukuran rekaman suara maksimal 10 MB.',
        ]);

        $identityPath = $request->file('identity_file')
            ->store('ppid/identity', 'public');

        $voiceRecordingPath = null;

        if ($request->hasFile('voice_recording')) {
            $voiceRecordingPath = $request->file('voice_recording')
                ->store('ppid/information', 'public');
        }

        $ticketNumber = 'PPID-' . now()->format('Ymd') . '-'
            . strtoupper(Str::random(6));

        $informationRequest = PpidInformationRequest::create([
            'ticket_number' => $ticketNumber,
            'applicant_category' => $validated['kategori_pemohon'],
            'nik' => $validated['nik'],
            'name' => $validated['applicant_name'],
            'phone' => $validated['applicant_phone'],
            'email' => $validated['email'],
            'address' => $validated['applicant_address'],
            'information_detail' => $validated['rincian_informasi'] ?? null,
            'purpose' => $validated['tujuan'] ?? null,
            'obtaining_method' => $validated['cara_memperoleh'] ?? null,
            'delivery_method' => $validated['cara_pengiriman'],
            'identity_file' => $identityPath,
            'voice_recording' => $voiceRecordingPath,
            'status' => 'diajukan',
        ]);

        return redirect()
            ->route('ppid.request.success', [
                'ticketNumber' => $informationRequest->ticket_number,
            ])
            ->with('success', 'Permohonan informasi berhasil dikirim.');
    }

    public function requestObjection()
    {
        $page = Page::where('slug', 'pengajuan-keberatan')
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.ppid.request-objection', compact('page'));
    }

    /**
     * Memeriksa nomor tiket secara otomatis dari form keberatan.
     */
    
    public function checkObjectionTicket(Request $request)
    {
        $ticketNumber = strtoupper(
            trim((string) $request->input('ticket_number'))
        );

        if ($ticketNumber === '') {
            return response()->json([
                'valid' => false,
                'message' => 'Nomor tiket wajib diisi.',
            ]);
        }

        // 1. Periksa apakah tiket permohonan terdaftar.
        $requestExists = PpidInformationRequest::where(
            'ticket_number',
            $ticketNumber
        )->exists();

        if (!$requestExists) {
            return response()->json([
                'valid' => false,
                'message' => 'Nomor tiket tidak ditemukan. Periksa kembali nomor tiket Anda.',
            ]);
        }

        // 2. Periksa apakah tiket sudah pernah digunakan untuk keberatan.
        $alreadyUsed = PpidObjection::where(
            'ticket_number',
            $ticketNumber
        )->exists();

        if ($alreadyUsed) {
            return response()->json([
                'valid' => false,
                'message' => 'Nomor tiket ini sudah pernah digunakan untuk mengajukan keberatan. Setiap nomor tiket permohonan hanya dapat digunakan satu kali untuk pengajuan keberatan.',
            ]);
        }

        // 3. Tiket terdaftar dan belum pernah digunakan.
        return response()->json([
            'valid' => true,
            'message' => 'Nomor tiket terdaftar. Silakan lanjutkan pengajuan keberatan.',
        ]);
    }


    public function submitObjection(Request $request)
    {
        $request->merge([
            'ticket_number' => strtoupper(
                trim((string) $request->input('ticket_number'))
            ),
        ]);

        $validated = $request->validate([
            'ticket_number' => [
                'required',
                'string',
                'max:100',
                'exists:ppid_information_requests,ticket_number',
                'unique:ppid_objections,ticket_number',
            ],

            'information_purpose' => ['nullable', 'string', 'max:255'],

            'applicant_name' => ['required', 'string', 'max:255'],
            'applicant_phone' => ['required','regex:/^[0-9]+$/','max:20',],
            'applicant_address' => ['required', 'string'],

            'representative_name' => ['nullable', 'string', 'max:255'],
            'representative_phone' => ['nullable', 'string', 'max:50'],
            'representative_address' => ['nullable', 'string'],

            'objection_reasons' => ['required', 'array', 'min:1'],
            'objection_reasons.*' => [
                'required',
                'string',
                'in:ditolak,berkala,tidak_ditanggapi,tidak_sesuai,tidak_dipenuhi,biaya,melewati_batas_waktu',
            ],

            'objection_chronology' => [
                $request->hasFile('voice_recording') ? 'nullable' : 'required',
                'string',
            ],

            'voice_recording' => ['nullable', 'file', 'max:10240'],
        ], [
            'ticket_number.required' => 'Nomor tiket permohonan informasi wajib diisi.',
            'ticket_number.exists' => 'Nomor tiket tidak ditemukan. Periksa kembali nomor tiket Anda.',
            'ticket_number.unique' => 'Nomor tiket ini sudah pernah digunakan untuk mengajukan keberatan.',
            'applicant_phone.required' => 'Nomor WhatsApp atau telepon wajib diisi.',
            'applicant_phone.regex' => 'Nomor WhatsApp atau telepon hanya boleh berisi angka.',
            'objection_reasons.required' => 'Silakan pilih minimal satu alasan pengajuan keberatan.',
            'objection_reasons.array' => 'Format alasan keberatan tidak valid.',
            'objection_reasons.min' => 'Silakan pilih minimal satu alasan pengajuan keberatan.',
            'objection_reasons.*.in' => 'Pilihan alasan keberatan tidak valid.',
        ]);

        $ticketNumber = $validated['ticket_number'];

        $voiceRecordingPath = null;

        if ($request->hasFile('voice_recording')) {
            $voiceRecordingPath = $request->file('voice_recording')
                ->store('ppid/objection', 'public');
        }

        $objectionReasons = null;

        if (!empty($validated['objection_reasons'])) {
            $objectionReasons = implode(
                ', ',
                $validated['objection_reasons']
            );
        }

        PpidObjection::create([
            // Nomor keberatan mengikuti nomor tiket permohonan informasi.
            'objection_ticket_number' => $ticketNumber,
            'ticket_number' => $ticketNumber,

            'information_purpose' => $validated['information_purpose'] ?? null,

            'applicant_name' => $validated['applicant_name'],
            'applicant_phone' => $validated['applicant_phone'],
            'applicant_address' => $validated['applicant_address'],

            'representative_name' => $validated['representative_name'] ?? null,
            'representative_phone' => $validated['representative_phone'] ?? null,
            'representative_address' => $validated['representative_address'] ?? null,

            'objection_reasons' => $objectionReasons,
            'objection_chronology' => $validated['objection_chronology'] ?? null,

            'voice_recording' => $voiceRecordingPath,
            'status' => 'diajukan',
        ]);

        return redirect()
            ->route('ppid.request.objection')
            ->with('success', 'Pengajuan keberatan berhasil dikirim.')
            ->with('objection_ticket_number', $ticketNumber);
    }

    public function requestTrack(Request $request)
    {
        $page = Page::where('slug', 'lacak-permohonan')
            ->where('is_active', true)
            ->firstOrFail();

        // Form pelacakan menggunakan parameter bernama "ticket".
        $validated = $request->validate([
            'ticket' => ['nullable', 'string', 'max:100'],
        ]);

        $ticket = null;
        $objection = null;
        $ticketNumber = strtoupper(trim($validated['ticket'] ?? ''));
        $ticketSearched = $ticketNumber !== '';

        if ($ticketSearched) {
            $ticket = PpidInformationRequest::where(
                'ticket_number',
                $ticketNumber
            )->first();

            if ($ticket) {
                $objection = PpidObjection::where(
                    'ticket_number',
                    $ticket->ticket_number
                )->latest()->first();
            }
        }

        return view('public.ppid.request-track', compact(
            'page',
            'ticket',
            'objection',
            'ticketSearched'
        ));
    }

    public function requestStatistics(Request $request)
    {
        $page = Page::where('slug', 'statistik-permohonan-informasi')
            ->where('is_active', true)
            ->firstOrFail();

        $validated = $request->validate([
            'tahun' => [
                'nullable',
                'integer',
                'min:2020',
                'max:' . now()->year,
            ],
        ]);

        $year = (int) ($validated['tahun'] ?? now()->year);

        $informationRequests = PpidInformationRequest::whereYear(
            'created_at',
            $year
        )->get(['status', 'created_at']);

        $objections = PpidObjection::whereYear(
            'created_at',
            $year
        )->get(['status', 'created_at']);

        $informationStatuses = $informationRequests
            ->groupBy(fn ($item) => strtolower(trim($item->status ?? '')))
            ->map(fn ($items) => $items->count());

        $informationTotal = $informationRequests->count();

        $informationCompleted = $informationRequests
            ->filter(fn ($item) => strtolower(trim($item->status ?? '')) === 'selesai')
            ->count();

        $informationRejected = $informationRequests
            ->filter(fn ($item) => strtolower(trim($item->status ?? '')) === 'ditolak')
            ->count();

        $informationProcessing = $informationRequests
            ->filter(fn ($item) => in_array(
                strtolower(trim($item->status ?? '')),
                ['diajukan', 'diverifikasi', 'diproses'],
                true
            ))
            ->count();

        $objectionStatuses = $objections
            ->groupBy(fn ($item) => strtolower(trim($item->status ?? '')))
            ->map(fn ($items) => $items->count());

        $objectionTotal = $objections->count();

        $monthlyStats = collect(range(1, 12))->map(function ($month) use (
            $informationRequests,
            $objections
        ) {
            return [
                'month' => $month,
                'information' => $informationRequests
                    ->filter(fn ($item) => (int) $item->created_at->format('n') === $month)
                    ->count(),
                'objection' => $objections
                    ->filter(fn ($item) => (int) $item->created_at->format('n') === $month)
                    ->count(),
            ];
        });

        $years = range(now()->year, 2020);

        return view('public.ppid.request-statistics', compact(
            'page',
            'year',
            'years',
            'informationTotal',
            'informationCompleted',
            'informationProcessing',
            'informationRejected',
            'informationStatuses',
            'objectionTotal',
            'objectionStatuses',
            'monthlyStats'
        ));
    }

    public function requestSuccess(string $ticketNumber)
    {
        $request = PpidInformationRequest::where(
            'ticket_number',
            $ticketNumber
        )->firstOrFail();

        return view('public.ppid.request-success', compact('request'));
    }
}
