@php
    $themeVersion = 'v2601.0.0';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', 'Website Resmi ' . ucfirst(setting('sebutan_desa')) . ' ' . ucwords($desa['nama_desa']))
    </title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        @include('theme::commons.meta')
        @include('theme::commons.source_css')
        @include('theme::commons.source_js')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link rel="stylesheet" href="{{ theme_asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
</head>
@php
    $post = $single_artikel;
@endphp
<body class="w-full bg-white">
    <div class="max-w-6xl mx-auto mb-2">
        @include('theme::commons.loading_screen')
        {{-- @include('theme::partials.header') --}}
        @include('theme::partials.hero')
        
        @yield('layout')
        @if (request()->path() === '/' || request()->path() === '')
            <div class="px-2 md:px-6 lg:px-2">
                <div class="flex flex-col gap-8 mt-8">
                    @include('theme::partials.articles')
                    @include('theme::partials.statistics')
                    @include('theme::partials.officials')
                </div>
            </div>
        @endif
    </div>
        
    @include('theme::partials.footer')
    @stack('scripts')
    <script src="{{ theme_asset('js/script.min.js') }}&{{ $themeVersion }}"></script>
    <script>
        lucide.createIcons()
    </script>
    @stack('scripts')

    
</body>
</html>