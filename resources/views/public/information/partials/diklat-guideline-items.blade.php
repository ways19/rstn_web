<div class="diklat-file-list">
    @forelse ($guidelines as $guideline)
        <a
            href="{{ $guideline->download_url }}"
            @if ($guideline->external_url)
                target="_blank" rel="noopener noreferrer"
            @else
                download="{{ $guideline->clean_filename }}"
            @endif
            class="diklat-file-item"
        >
            <div class="diklat-file-icon">{{ $guideline->formatted_file_type }}</div>
            <div>
                <strong>{{ $guideline->title }}</strong>
                @if ($guideline->description)
                    <small>{{ $guideline->description }}</small>
                @endif
            </div>
            <div class="diklat-download-icon">↓</div>
        </a>
    @empty
        <p class="text-sm text-slate-500 py-3">Belum ada dokumen pedoman yang tersedia.</p>
    @endforelse
</div>
