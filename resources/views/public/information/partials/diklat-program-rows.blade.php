<div class="diklat-table-wrapper">
    <div class="diklat-table-scroll">
       <table class="diklat-table">
            @forelse ($diklatPrograms as $program)
                <tr>
                    <td>
                        <span class="diklat-category {{ in_array(strtolower($program->category), ['pelatihan', 'orientasi']) ? 'diklat-category-orange' : 'diklat-category-blue' }}">
                            {{ strtoupper($program->category) }}
                        </span>

                        <strong>{{ $program->name }}</strong>

                        @if ($program->description)
                            <small>{{ $program->description }}</small>
                        @endif
                    </td>

                    <td class="diklat-target-cell">
                        <strong>{{ $program->target ?: 'Belum ditentukan' }}</strong>

                        @if ($program->target_description)
                            <small>{{ $program->target_description }}</small>
                        @endif
                    </td>

                    <td>
                        @php
                            $isEduRow = ($program->category ?? '') === 'Pendidikan';
                            if (!$isEduRow && $program->start_at) {
                                $rowSched = $program->start_at->translatedFormat('d M Y');
                                if ($program->end_at && !$program->end_at->isSameDay($program->start_at)) {
                                    $rowSched .= ' - ' . $program->end_at->translatedFormat('d M Y');
                                }
                            } else {
                                $rowSched = $program->schedule ?: ($isEduRow ? 'Sesuai pengajuan RS' : 'Sesuai konfirmasi');
                            }
                        @endphp
                        <span>{{ $rowSched }}</span>

                        @if ($program->duration)
                            <small>{{ $program->duration }}</small>
                        @endif
                    </td>

                    <td>
                        <strong>{{ $program->remaining_quota }} / {{ $program->quota }}</strong>
                    </td>

                    <td>
                        @php
                            $statusLabel = [
                                'dibuka' => 'Pendaftaran dibuka',
                                'terbatas' => 'Kuota terbatas',
                                'penuh' => 'Kuota penuh',
                                'ditutup' => 'Ditutup',
                            ][$program->status] ?? ucfirst($program->status);
                        @endphp

                        <span class="diklat-status diklat-status-info">
                            {{ $statusLabel }}
                        </span>
                    </td>


                    <td>
                        @if (
                            in_array($program->status, ['dibuka', 'terbatas']) &&
                            $program->remaining_quota > 0
                        )
                            <a
                                href="{{ route('information.diklat.registration.create', $program->id) }}"
                                class="diklat-action diklat-action-register"
                            >
                                Daftar →
                            </a>
                        @elseif ($program->status === 'penuh' || $program->remaining_quota <= 0)
                            <span class="diklat-action-disabled">
                                Kuota Penuh
                            </span>
                        @else
                            <span class="diklat-action-disabled">
                                Pendaftaran Ditutup
                            </span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Belum ada program yang tersedia.
                    </td>
                </tr>
            @endforelse
         </table>
    </div>
        <div class="diklat-table-note">
        <span>ⓘ</span>
        <p>
            Pengajuan pendidikan klinis dan pelatihan mengikuti persyaratan,
            kuota, serta jadwal resmi RSUD R.A.A. Tjokronegoro.
        </p>
        <a href="#diklat-dokumen">Lihat dokumen persyaratan →</a>
    </div>
</div>