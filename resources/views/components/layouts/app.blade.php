@props([
    'title' => 'RSUD R.A.A. Tjokronegoro Purworejo — Melayani dengan Sepenuh Hati',
    'metaDescription' => 'Website Resmi RSUD R.A.A. Tjokronegoro Kabupaten Purworejo. Pusat pelayanan kesehatan paripurna dengan IGD 24 Jam, dokter spesialis lengkap, pendaftaran online mandiri, dan fasilitas modern.',
    'metaKeywords' => 'RSUD RAA Tjokronegoro, RSUD Purworejo, Rumah Sakit Purworejo, Jadwal Dokter RSUD Tjokronegoro, Pendaftaran Online RSUD Tjokronegoro, IGD 24 Jam Purworejo, SAPA RSTN',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="author" content="RSUD R.A.A. Tjokronegoro Purworejo">
    <meta name="robots" content="index, follow">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Open Graph Protocol -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ asset('logo.png') }}">
    <meta property="og:site_name" content="RSUD R.A.A. Tjokronegoro">
    <meta property="og:locale" content="id_ID">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ asset('logo.png') }}">

    <!-- Google Fonts & Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- JSON-LD Structured Data Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "Hospital",
      "name": "RSUD R.A.A. Tjokronegoro Purworejo",
      "image": "{{ asset('logo.png') }}",
      "@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "+62275321118",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Jenderal Sudirman No. 60, Pangenjurutengah",
        "addressLocality": "Purworejo",
        "postalCode": "54114",
        "addressCountry": "ID",
        "addressRegion": "Jawa Tengah"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -7.718872,
        "longitude": 110.0141463
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
        ],
        "opens": "00:00",
        "closes": "23:59"
      }
    }
    </script>

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
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased flex flex-col min-h-screen selection:bg-teal-700 selection:text-white transition-colors duration-200" x-data="{ mobileMenuOpen: false }">

    <!-- Public Top Utility Bar Component -->
    <x-public.top-bar />

    <!-- Public Main Navigation Navbar Component -->
    <x-public.navbar />

    <!-- Main Content Slot -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Public Footer Component -->
    <x-public.footer />

    {{ $scripts ?? '' }}
    @stack('scripts')
</body>
</html>
