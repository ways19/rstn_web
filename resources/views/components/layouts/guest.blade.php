@props([
'title' => 'Sign In — CMS RSUD R.A.A. Tjokronegoro'
])

<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f5f7fb] dark:bg-slate-950">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Dark Theme Initialization Script (Anti-FOUC) -->
    <script>
        if (localStorage.getItem('rstn_theme') === 'dark' || (!('rstn_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $styles ?? '' }}
    @stack('styles')
</head>

<body class="bg-[#f5f7fb] dark:bg-slate-950 text-[#495057] dark:text-slate-200 antialiased min-h-screen flex items-center justify-center p-4 relative transition-colors duration-200">
    <!-- Top Right Theme Switcher -->
    <div class="absolute top-6 right-6">
        <x-theme-toggle size="md" />
    </div>

    {{ $slot }}
    {{ $scripts ?? '' }}
    @stack('scripts')
</body>

</html>