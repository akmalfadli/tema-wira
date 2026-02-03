{{-- resources/views/partials/footer.blade.php --}}
<div class="container">
    @includeWhen($transparansi, 'theme::partials.apbdesa', $transparansi)
</div>
@include('theme::commons.back_to_top')

<!-- Bottom Navigation for Mobile (Fixed at bottom) -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 block md:hidden">
    <div class="flex justify-around py-2">
        <a href="/" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-green-700 transition-colors">
            <i data-lucide="home" class="w-5 h-5 mb-1"></i>
            <span class="text-xs">Beranda</span>
        </a>
        <a href="/" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-green-700 transition-colors">
            <i data-lucide="newspaper" class="w-5 h-5 mb-1"></i>
            <span class="text-xs">Artikel</span>
        </a>
        <a href="/data-wilayah" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-green-700 transition-colors">
            <i data-lucide="bar-chart-3" class="w-5 h-5 mb-1"></i>
            <span class="text-xs">Statistik</span>
        </a>
        <a href="/peta" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-green-700 transition-colors">
            <i data-lucide="map" class="w-5 h-5 mb-1"></i>
            <span class="text-xs">Peta</span>
        </a>
        <button onclick="toggleSocialMenu()" 
                class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-green-700 transition-colors"
                aria-label="Toggle social media menu">
            <i data-lucide="share-2" class="w-5 h-5 mb-1"></i>
            <span class="text-xs">Sosmed</span>
        </button>
    </div>
    
    <!-- Social Media Popup -->
    <div id="social-popup" 
         class="hidden absolute bottom-full left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg"
         role="dialog"
         aria-labelledby="social-popup-title">
        <h4 id="social-popup-title" class="text-sm font-semibold text-gray-800 mb-3 text-center">
            Ikuti Sosial Media Kami
        </h4>
        <div class="flex gap-3 justify-center mb-3 flex-wrap">
            @if (isset($sosmed) && !empty($sosmed))
                @foreach ($sosmed as $data)
                    @if (!empty($data['link']))
                        <a href="{{ $data['link'] }}" 
                           class="bg-green-600 p-3 rounded-full hover:bg-green-500 transition-colors" 
                           target="_blank" 
                           rel="noopener"
                           aria-label="Follow us on {{ ucfirst($data['nama']) }}">
                            <i data-lucide="{{ $data['nama'] }}" class="w-5 h-5 text-white"></i>
                        </a>
                    @endif
                @endforeach
            @else
                <p class="text-sm text-gray-500">Tidak ada sosial media tersedia</p>
            @endif
        </div>
        <button onclick="toggleSocialMenu()" 
                class="w-full bg-gray-100 text-gray-600 py-2 px-4 rounded-lg text-sm hover:bg-gray-200 transition-colors"
                aria-label="Close social media menu">
            Tutup
        </button>
    </div>
</div>

<!-- Main Footer -->
<footer class="bg-green-700 text-white py-6 md:py-8" role="contentinfo">
    <div class="max-w-6xl mx-auto px-4 md:px-6 lg:px-8">
        
        <!-- Mobile Layout - Single Row with Desa Info and Copyright -->
        <div class="block md:hidden">
            <div class="flex items-start justify-between gap-4 py-0">
                <!-- Desa Info - Mobile -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <div class="w-10 h-10 flex items-center justify-center">
                        @if (!empty($desa['logo']))
                            <img src="{{ gambar_desa($desa['logo']) }}" 
                                 alt="Logo {{ ucfirst(setting('sebutan_desa')) . ' ' . ucwords($desa['nama_desa']) }}" 
                                 class="h-8 w-auto">
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold leading-tight">
                            {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
                        </p>
                        <p class="text-[10px]">
                            {{ ucfirst(setting('sebutan_kecamatan')) }} {{ ucwords($desa['nama_kecamatan']) }}
                        </p>
                        <p class="text-[10px]">
                            {{ ucfirst(setting('sebutan_kabupaten')) }} {{ ucwords($desa['nama_kabupaten']) }}
                        </p>
                        <p class="text-[10px]">
                            Provinsi {{ ucwords($desa['nama_propinsi']) }}
                        </p>
                    </div>
                </div>
                
                <!-- Copyright - Mobile -->
                <div class="text-right text-xs flex-shrink-0 max-w-[40%]">
                    <p class="text-green-200 mb-1">&copy; {{ date('Y') }}</p>
                    <p class="text-green-300 text-[10px] leading-tight">
                        {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
                    </p>
                    @if (isset($themeVersion))
                        <p class="text-[10px] leading-tight">
                            <a href="https://akmalfadli.github.io" 
                               class="text-green-300 hover:text-pink-200 transition-colors" 
                               target="_blank" 
                               rel="noopener">
                                Tema Perwira {{ $themeVersion }}
                            </a>
                        </p>
                    @endif
                    @if (function_exists('ambilVersi'))
                        <p class="text-[10px] leading-tight">
                            <a href="https://opensid.my.id" 
                               class="text-green-300 hover:text-green-200 transition-colors" 
                               target="_blank" 
                               rel="noopener">
                                OpenSID {{ ambilVersi() }}
                            </a> 
                        </p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Desktop Layout -->
        <div class="hidden md:flex md:flex-row md:gap-8">
            <!-- Desa Info Column -->
            <div class="md:w-1/3">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                        @if (!empty($desa['logo']))
                            <img src="{{ gambar_desa($desa['logo']) }}" 
                                 alt="Logo {{ ucfirst(setting('sebutan_desa')) . ' ' . ucwords($desa['nama_desa']) }}" 
                                 class="h-10 w-auto">
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ ucfirst(setting('sebutan_desa')) }}</p>
                        <p class="text-sm font-semibold -mt-1">{{ ucwords($desa['nama_desa']) }}</p>
                    </div>
                </div>
                <div class="text-sm space-y-1">
                    <p>{{ ucfirst(setting('sebutan_kecamatan')) }} {{ ucwords($desa['nama_kecamatan']) }}</p>
                    <p>{{ ucfirst(setting('sebutan_kabupaten')) }} {{ ucwords($desa['nama_kabupaten']) }}</p>
                    <p class="mb-4">Provinsi {{ ucwords($desa['nama_propinsi']) }}</p>
                    @if (!empty($desa['email_desa']))
                        <p>
                            <span class="text-green-200">Email:</span> 
                            <a href="mailto:{{ $desa['email_desa'] }}" 
                               class="hover:text-green-200 transition-colors">
                                {{ $desa['email_desa'] }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
                    
            <!-- Social Media Column -->
            <div class="md:w-1/3 flex flex-col items-center text-center">
                <h3 class="font-semibold mb-3">Sosial Media</h3>
                <div class="flex gap-3 justify-center flex-wrap">
                    @if (isset($sosmed) && !empty($sosmed))
                        @php $hasSocial = false; @endphp
                        @foreach ($sosmed as $data)
                            @if (!empty($data['link']))
                                @php $hasSocial = true; @endphp
                                <a href="{{ $data['link'] }}" 
                                   class="bg-green-600 p-2 rounded-md hover:bg-green-500 transition-colors"
                                   target="_blank" 
                                   rel="noopener"
                                   aria-label="Follow us on {{ ucfirst($data['nama']) }}">
                                    <i data-lucide="{{ $data['nama'] }}" class="w-5 h-5"></i>
                                </a>
                            @endif
                        @endforeach
                        @if (!$hasSocial)
                            <p class="text-sm text-green-200">Tidak ada sosial media tersedia</p>
                        @endif
                    @else
                        <p class="text-sm text-green-200">Tidak ada sosial media tersedia</p>
                    @endif
                </div>
            </div>
                    
            <!-- Links Column -->
            <div class="md:w-1/3 md:text-right">
                <h3 class="font-semibold mb-3">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm inline-block text-left">
                    <li>
                        <a href="{{ ci_route('first') }}" 
                           class="hover:text-green-200 transition-colors">
                            &gt; Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ ci_route('first.artikel') }}" 
                           class="hover:text-green-200 transition-colors">
                            &gt; Artikel
                        </a>
                    </li>
                    <li>
                        <a href="{{ ci_route('statistik.chart') }}" 
                           class="hover:text-green-200 transition-colors">
                            &gt; Data Statistik
                        </a>
                    </li>
                    <li>
                        <a href="{{ ci_route('first.aparatur_desa') }}" 
                           class="hover:text-green-200 transition-colors">
                            &gt; Aparatur Desa
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright (Desktop Only) -->
        <div class="hidden md:block border-t border-green-600 mt-6 md:mt-8 pt-4 text-center text-xs">
            <p class="mb-2">
                Hak cipta situs &copy; {{ date('Y') }} - {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
            </p>
            <div class="flex justify-center items-center gap-2 flex-wrap">
                @if (isset($themeVersion))
                    <a href="https://akmalfadli.github.io" 
                       class="underline decoration-pink-500 underline-offset-1 decoration-2 hover:text-pink-200 transition-colors" 
                       target="_blank" 
                       rel="noopener">
                        Tema Perwira {{ $themeVersion }}
                    </a>
                @endif
                @if (isset($themeVersion) && function_exists('ambilVersi'))
                    <span>-</span>
                @endif
                @if (function_exists('ambilVersi'))
                    <a href="https://opensid.my.id" 
                       class="underline decoration-green-500 underline-offset-1 decoration-2 hover:text-green-200 transition-colors" 
                       target="_blank" 
                       rel="noopener">
                        OpenSID {{ ambilVersi() }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</footer>

<style>
    /* Mobile Bottom Padding */
    @media (max-width: 768px) {
        body {
            padding-bottom: 80px;
        }
    }
    
    /* Prevent text selection during interaction */
    .fixed.bottom-0 {
        user-select: none;
        -webkit-user-select: none;
    }
    
    /* Smooth transitions for popup */
    #social-popup {
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
    }
    
    /* Touch-friendly button sizing */
    @media (pointer: coarse) {
        .fixed.bottom-0 button,
        .fixed.bottom-0 a {
            min-height: 44px;
            min-width: 44px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const socialPopup = document.getElementById('social-popup');
    const navLinks = document.querySelectorAll('.fixed.bottom-0 a');
    
    // Social menu toggle with better error handling
    window.toggleSocialMenu = function() {
        if (!socialPopup) return;
        
        const isHidden = socialPopup.classList.contains('hidden');
        socialPopup.classList.toggle('hidden');
        
        // Manage focus for accessibility
        if (!isHidden) {
            // Closing popup - return focus to trigger button
            const triggerButton = document.querySelector('button[onclick="toggleSocialMenu()"]');
            if (triggerButton) triggerButton.focus();
        } else {
            // Opening popup - focus first interactive element
            const firstLink = socialPopup.querySelector('a');
            if (firstLink) firstLink.focus();
        }
        
        // Prevent body scroll on mobile when popup is open
        if (window.innerWidth < 768) {
            document.body.style.overflow = isHidden ? 'hidden' : '';
        }
    };
    
    // Close popup when clicking outside
    document.addEventListener('click', function(event) {
        if (!socialPopup) return;
        
        const triggerButton = event.target.closest('button[onclick="toggleSocialMenu()"]');
        const isClickInside = socialPopup.contains(event.target) || triggerButton;
        
        if (!isClickInside && !socialPopup.classList.contains('hidden')) {
            socialPopup.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(event) {
        if (!socialPopup) return;
        
        // Close popup with Escape key
        if (event.key === 'Escape' && !socialPopup.classList.contains('hidden')) {
            socialPopup.classList.add('hidden');
            document.body.style.overflow = '';
            
            // Return focus to trigger button
            const triggerButton = document.querySelector('button[onclick="toggleSocialMenu()"]');
            if (triggerButton) triggerButton.focus();
        }
    });
    
    // Bottom navigation active state with improved logic
    function updateActiveNavigation() {
        const currentPath = window.location.pathname;
        const currentSearch = window.location.search;
        const fullUrl = currentPath + currentSearch;
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            let isActive = false;
            
            // More precise matching logic
            if (href === fullUrl) {
                isActive = true;
            } else if (href === '/' && currentPath === '/') {
                isActive = true;
            } else if (href !== '/' && currentPath.includes(href.replace(/^\//, ''))) {
                isActive = true;
            }
            
            // Update classes
            if (isActive) {
                link.classList.remove('text-gray-600');
                link.classList.add('text-green-700');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.remove('text-green-700');
                link.classList.add('text-gray-600');
                link.removeAttribute('aria-current');
            }
        });
    }
    
    // Initialize active navigation
    updateActiveNavigation();
    
    // Update on navigation change (for SPAs)
    window.addEventListener('popstate', updateActiveNavigation);
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        document.body.style.overflow = '';
    });
    
    // Handle visibility change to close popup when tab is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && socialPopup && !socialPopup.classList.contains('hidden')) {
            socialPopup.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
});
</script>