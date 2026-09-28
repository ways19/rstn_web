<!-- AdminKit Footer Component -->
<footer class="bg-white dark:bg-slate-900 border-t border-slate-200/80 dark:border-slate-800 py-4 px-6 md:px-8 text-xs md:text-sm text-slate-500 dark:text-slate-400 flex flex-col md:flex-row items-center justify-between gap-4 transition-colors duration-200">
    <div>
        <span class="font-bold text-slate-700 dark:text-slate-200">RSUD R.A.A. Tjokronegoro</span> &copy; {{ date('Y') }} — Hak Cipta Dilindungi
    </div>
    <div class="flex items-center space-x-4 font-medium">
        <a href="{{ route('home') }}" target="_blank" class="hover:text-[#3b7ddd] transition">Web Publik</a>
        <span>&bull;</span>
        <a href="{{ route('admin.beds.index') }}" target="_blank" class="hover:text-[#3b7ddd] transition">Bed Monitoring</a>
        <span>&bull;</span>
        <a href="{{ route('admin.settings.index') }}" class="hover:text-[#3b7ddd] transition">Pengaturan</a>
    </div>
</footer>
