<x-layouts.guest title="Sign In — AdminKit CMS RSUD R.A.A. Tjokronegoro">
    <div class="max-w-md w-full space-y-4">
        
        <!-- Header Text (AdminKit style) -->
        <div class="text-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#212529] dark:text-white tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-sm text-[#6c757d] dark:text-slate-400 mt-1">Masuk ke panel administrator RSUD R.A.A. Tjokronegoro</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-[0_0_0.875rem_0_rgba(33,37,41,0.05)] border border-slate-200/80 dark:border-slate-800 space-y-6">
            
            <div class="text-center">
                <img src="{{ asset('logo.png') }}" alt="Logo RSUD" class="h-20 mx-auto object-contain drop-shadow-md transition-transform hover:scale-105" onerror="this.src='https://ui-avatars.com/api/?name=RSTN&background=3b7ddd&color=fff'">
            </div>

            @if($errors->any())
                <div class="bg-[#f8d7da] dark:bg-rose-950/40 border border-[#f5c2c7] dark:border-rose-800 text-[#842029] dark:text-rose-200 px-4 py-3 rounded-md text-xs sm:text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4 text-sm">
                @csrf
                <div>
                    <label class="block font-semibold text-[#212529] dark:text-slate-200 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', 'admin@rstjokronegoro.id') }}" required autofocus
                           placeholder="Enter your email"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/40 focus:border-[#3b7ddd]">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="font-semibold text-[#212529] dark:text-slate-200">Password</label>
                        <span class="text-xs text-[#6c757d] dark:text-slate-400">Default: <code>password</code></span>
                    </div>
                    <input type="password" name="password" value="password" required
                           placeholder="Enter your password"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/40 focus:border-[#3b7ddd]">
                </div>

                <!-- Captcha Verification -->
                <div x-data="{
                    captchaSrc: '{{ $captchaImage ?? '' }}',
                    loading: false,
                    refresh() {
                        this.loading = true;
                        fetch('{{ route('captcha.refresh') }}')
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.captcha) {
                                    this.captchaSrc = data.captcha;
                                }
                            })
                            .catch(err => console.error('Gagal memperbarui captcha:', err))
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="font-semibold text-[#212529] dark:text-slate-200">Kode Keamanan (Captcha)</label>
                        <span class="text-xs text-[#6c757d] dark:text-slate-400">6 karakter (angka, huruf besar & kecil)</span>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <div class="relative flex-1 bg-slate-100 dark:bg-slate-800 rounded-xl p-1 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden min-h-[46px]">
                            <img :src="captchaSrc" alt="Captcha" class="h-10 w-auto rounded object-contain select-none">
                            <div x-show="loading" class="absolute inset-0 bg-white/70 dark:bg-slate-900/70 flex items-center justify-center">
                                <svg class="animate-spin h-5 w-5 text-[#3b7ddd]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                            </div>
                        </div>
                        <button type="button" @click="refresh()" title="Muat ulang kode captcha"
                                class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-[#3b7ddd] hover:border-[#3b7ddd]/50 dark:hover:border-[#3b7ddd]/50 transition shadow-xs cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform" :class="{ 'animate-spin': loading }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>

                    <input type="text" name="captcha" required autocomplete="off" maxlength="6"
                           placeholder="Masukkan 6 karakter kode di atas"
                           class="w-full px-3.5 py-2.5 tracking-wider font-mono rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-[#3b7ddd]/40 focus:border-[#3b7ddd]">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-[#3b7ddd] focus:ring-[#3b7ddd]">
                        <span class="text-[#6c757d] dark:text-slate-400">Ingat saya</span>
                    </label>
                    <a href="{{ route('home') }}" class="text-[#3b7ddd] hover:underline">Ke Web Publik &rarr;</a>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl font-bold text-sm text-white bg-[#3b7ddd] hover:bg-[#326abc] shadow-sm transition">
                    Sign in
                </button>
            </form>
        </div>

        <!-- Footer Notice -->
        <div class="text-center text-xs sm:text-sm text-[#6c757d] dark:text-slate-500">
            RSUD R.A.A. Tjokronegoro Purworejo &bull; AdminKit Theme
        </div>
    </div>
</x-layouts.guest>