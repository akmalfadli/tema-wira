{{-- resources/views/partials/hero.blade.php --}}
@php
    $bg_header = $latar_website;
@endphp
<div class="relative h-[275px] sm:h-[300px] md:h-[350px] lg:h-[450px] bg-white text-gray-900 overflow-hidden">
    
    {{-- Navigation Menu at the top --}}
    <header class="absolute top-0 left-0 right-0 z-30">
    <div class="relative z-10">
        {{-- Desktop Header --}}
        <div class="hidden lg:flex items-center justify-between mt-4">

            {{-- LEFT: Logo + Menu --}}
            <div class="flex items-center">

                {{-- Logo --}}
                <div class="flex items-center pr-8">
                    <a href="{{ ci_route() }}" class="block">
                        <img
                            src="{{ gambar_desa($desa['logo']) }}"
                            alt="Logo {{ ucfirst(setting('sebutan_desa')) . ' ' . ucwords($desa['nama_desa']) }}"
                            class="h-12"
                        >
                    </a>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ ucfirst(setting('sebutan_desa')) }}
                        </p>
                        <p class="text-sm font-semibold -mt-1 text-gray-900">
                            {{ ucwords($desa['nama_desa']) }}
                        </p>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="text-sm text-gray-900">
                    <ul class="flex items-center">
                        @if (menu_tema())
                            @foreach (menu_tema() as $menu)
                                @php $has_dropdown = count($menu['childrens'] ?? []) > 0; @endphp
                                <li class="relative" @if($has_dropdown) x-data="{dropdown:false}" @endif>
                                    <a
                                        href="{{ $has_dropdown ? '#!' : $menu['link_url'] }}"
                                        class="px-3 py-2 font-medium hover:text-green-600 transition"
                                        @if($has_dropdown)
                                            @mouseover="dropdown=true"
                                            @mouseleave="dropdown=false"
                                            @click.prevent="dropdown=!dropdown"
                                        @endif
                                    >
                                        {{ $menu['nama'] }}
                                        @if($has_dropdown)
                                            <i class="fas fa-chevron-down text-xs ml-1"
                                               :class="{'rotate-180':dropdown}"></i>
                                        @endif
                                    </a>

                                    @if($has_dropdown)
                                        <ul
                                            class="absolute top-full left-0 bg-white shadow-lg rounded-md border mt-1 min-w-max"
                                            x-show="dropdown"
                                            x-transition
                                            @mouseover="dropdown=true"
                                            @mouseleave="dropdown=false"
                                        >
                                            @foreach ($menu['childrens'] as $child)
                                                <li>
                                                    <a
                                                        href="{{ $child['link_url'] }}"
                                                        class="block px-5 py-3 hover:bg-green-50 hover:text-green-600"
                                                    >
                                                        {{ $child['nama'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </nav>
            </div>

            {{-- RIGHT: Login Button --}}
            <div class="p-0">
                <a
                    href="#"
                    class="inline-flex items-center px-6 py-2 text-sm font-semibold text-white
                           bg-green-600 rounded-full shadow-md
                           hover:bg-green-700 hover:shadow-lg
                           transition">
                    Login
                </a>
            </div>
        </div>

        {{-- Mobile Header (UNCHANGED) --}}
        <div class="lg:hidden fixed top-0 left-0 right-0 z-40">
            <div class="bg-green-700 lg:bg-white shadow-md flex items-center justify-between px-4 py-2">
                <div class="flex items-center gap-2">
                    <img src="{{ gambar_desa($desa['logo']) }}" class="h-10">
                    <div>
                        <p class="text-white lg:text-blacktext-sm font-semibold">{{ ucfirst(setting('sebutan_desa')) }}</p>
                        <p class="text-white lg:text-black text-sm font-semibold -mt-1">{{ ucwords($desa['nama_desa']) }}</p>
                    </div>
                </div>
                @include('theme::commons.mobile_menu')
            </div>
        </div>
    </div>
</header>

    
    {{-- Hero content --}}
    <div class="relative z-10 h-full flex flex-col lg:flex-row pt-16 lg:pt-16">
        {{-- Desktop content --}}
        <div class="hidden lg:flex flex-1 flex-col justify-center">
            <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold mb-3 leading-tight text-gray-900">
                Website Resmi
            </h1>
            <h2 class="text-5xl lg:text-6xl xl:text-7xl font-bold mb-5 leading-tight text-gray-900">
                {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
            </h2>
            <div class="text-sm lg:text-base xl:text-lg space-y-1 text-gray-600">
                <p>{{ ucfirst(setting('sebutan_kecamatan')) }} {{ ucwords($desa['nama_kecamatan']) }} 
                   {{ ucfirst(setting('sebutan_kabupaten')) }} {{ ucwords($desa['nama_kabupaten']) }}</p>
                <p>Provinsi {{ ucwords($desa['nama_propinsi']) }}</p>
            </div>
        </div>
                   
        {{-- Mobile content --}}
        <div class="lg:hidden flex-1 relative">

            {{-- Background Image --}}
            <div
                class="torn-paper-mobile mt-16 absolute inset-0 bg-center bg-cover"
                style="background-image: url('{{ $bg_header }}');">
            </div>

            {{-- Overlay Content --}}
            <div class="relative z-10 flex flex-col items-left justify-center h-full px-4 text-center">

                <h1 class="text-2xl font-bold text-white">Website Resmi</h1>
                <h2 class="text-2xl font-bold text-white">
                    {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
                </h2>

                <div class="text-xs text-bold text-white mt-1">
                    <p>
                        {{ ucfirst(setting('sebutan_kecamatan')) }} {{ ucwords($desa['nama_kecamatan']) }}
                        {{ ucfirst(setting('sebutan_kabupaten')) }} {{ ucwords($desa['nama_kabupaten']) }}
                    </p>
                    <p>Provinsi {{ ucwords($desa['nama_propinsi']) }}</p>
                </div>
            </div>

            {{-- Marquee --}}
            @if ($teks_berjalan)
                <div class="absolute bottom-0 left-0 right-0 py-1 text-white text-xs z-20 bg-black/40">
                    <marquee onmouseover="this.stop();" onmouseout="this.start();">
                        @foreach ($teks_berjalan as $marquee)
                            <span class="px-3">
                                {{ $marquee['teks'] }}
                                @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                                    <a href="{{ $marquee['tautan'] }}"
                                    class="underline hover:text-green-300 ml-1">
                                        {{ $marquee['judul_tautan'] }}
                                    </a>
                                @endif
                            </span>
                        @endforeach
                    </marquee>
                </div>
            @endif

        </div>


        {{-- Torn Paper Image - Desktop (15% width) --}}
        <div class="hidden mt-12 mb-12 lg:flex w-100px h-100px items-center justify-center">
            <div class="torn-paper-image w-full h-full">
                <img src="{{ $bg_header }}" alt="Desa Image" class="w-full h-full object-cover">
                 @if ($teks_berjalan)
                    <div class="absolute mb-2 bottom-0 left-0 right-0 py-1 sm:py-1.5 bg-green-600 bg-opacity-15 text-white text-xs z-20">
                        <div class="marquee-container">
                            <marquee onmouseover="this.stop();" onmouseout="this.start();" class="block">
                                @foreach ($teks_berjalan as $marquee)
                                    <span class="px-2 sm:px-3">
                                        {{ $marquee['teks'] }}
                                        @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                                            <a href="{{ $marquee['tautan'] }}" class="hover:text-link underline">{{ $marquee['judul_tautan'] }}</a>
                                        </li>
                                        @endif
                                    </span>
                                @endforeach
                            </marquee>
                        </div>
                    </div>
                    @endif
            </div>
            
        </div>
    </div>

</div>

<style>
    .bg-green {
        --tw-bg-opacity: 1;
        background-color: rgb(34 197 94 / var(--tw-bg-opacity));
        }
    .min-w-max {
        min-width: max-content;
    }
    
    nav a {
        transition: all 0.3s ease;
    }
    
    .torn-paper-image {
        filter: url(#filter_tornpaper);
        border-radius: 50%;
    }
    
    .torn-paper-mobile {
        filter: url(#filter_tornpaper);
        background-size: cover;
        background-position: center;
    }
    .torn-paper-mobile::after {
        content: "";
        position: absolute;
        inset: 0;
        background-color: #094822; /* green-900 */
        opacity: 0.2;             /* 20% */
        pointer-events: none;
    }
    @media (max-width: 1024px) {
        [x-cloak] { 
            display: none !important; 
        }
        
        .mobile-menu-nav {
            z-index: 999999;
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 320px;
            max-width: 90vw;
        }
        
        .lg\\:hidden.fixed {
            z-index: 40 !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Tornpaper({
            filterName: "filter_tornpaper",
            seed: 5,
            tornFrequency: 0.04,
            tornScale: 20,
            grungeFrequency: 0.02,
            grungeScale: 2
        });
    });
</script>
