<section class="relative overflow-hidden">
    <img
        src="{{ asset('images/rsud-header.png') }}"
        alt="RSUD R.A.A. Tjokronegoro"
        class="w-full h-auto block"
    >

    <div class="absolute inset-0 flex items-center">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight text-slate-900">
                    {{ $title }}
                </h1>

                @if($description)
                    <p class="text-slate-800 text-sm sm:text-base mt-3 leading-relaxed font-medium">
                        {{ $description }}
                    </p>
                @endif

            </div>
        </div>
    </div>
</section>