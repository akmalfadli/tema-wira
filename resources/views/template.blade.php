@php
    $themeVersion = 'v2604.0.0';
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
    {{--
    <script src="https://cdn.tailwindcss.com"></script> --}}
    <link rel="stylesheet" href="{{ theme_asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        .theme-container {
            max-width: 1440px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }
    </style>
    @stack('styles')

</head>
@php
    $post = $single_artikel;
@endphp

<body class="w-full bg-white">
    <div class="theme-container px-4 md:px-6 lg:px-8 mb-16">
        @include('theme::commons.loading_screen')
        {{-- @include('theme::partials.header') --}}
        @if(theme_config('hero_klasik') == '1')
            @include('theme::partials.hero_klasik')
        @else
            @include('theme::partials.hero')
        @endif

        @yield('layout')
        @if (request()->path() === '/' || request()->path() === '')
            <div class="px-2 md:px-6 lg:px-4">

                <div class="flex flex-col gap-0 mt-0">

                    @include('theme::partials.articles')
                    @include('theme::partials.statistics')
                    @if(theme_config('village_officials') == '1')
                        @include('theme::partials.officials')
                    @endif

                </div>
            </div>

        @endif

    </div>

    @include('theme::partials.footer')
    @if(theme_config('ai_assistant') == '1')
        @include('theme::commons.ai_chat')
    @endif
    <script>
        lucide.createIcons()
    </script>
    @stack('scripts')

    <!-- Theme Tracker -->
    <script src="{{ theme_asset('js/theme_tracker.js') }}"></script>


</body>

</html>