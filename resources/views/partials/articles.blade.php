{{-- resources/views/partials/articles.blade.php --}}

<div class="mt-8" id="articles-section">
<div class="flex flex-col gap-4 mb-6">

    <div class="flex flex-wrap gap-2">
        <a href="#"
           class="px-4 py-1.5 text-sm font-semibold text-gray-900
                     border border-green-700 rounded-full
                      hover:bg-green-700 hover:text-white
                     transition">
            IDM
          </a>
        <a href="#"
            class="px-4 py-1.5 text-sm font-semibold text-gray-900
                   border border-green-700 rounded-full
                   hover:bg-green-700 hover:text-white
                  transition">
               Galeri
         </a>
         <a href="#"
            class="px-4 py-1.5 text-sm font-semibold text-gray-900
                   border border-green-700 rounded-full
                  hover:bg-green-700 hover:text-white
                  transition">
               Peta
         </a>
        <button id="btn-pemerintah-desa"
            class="px-4 py-1.5 text-sm font-semibold text-gray-900
                    border border-green-700 rounded-full
                    hover:bg-green-700 hover:text-white
                    transition">
            Pemerintah Desa
        </button>
    </div>
    {{-- TOP ROW: Pills (left) + Paging (right) --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">
        Artikel {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
    </h2>


        {{-- RIGHT: Paging --}}
        <div class="text-sm">
            @include('theme::commons.paging', ['paging_page' => $paging_page])
        </div>
    </div>

</div>

{{-- Pemerintah Desa Popup - COMPLETELY FIXED --}}
<div id="pemerintah-popup" class="fixed inset-0 z-50 hidden">

    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-black/60 backdrop-blur-md transition-opacity popup-overlay"
        onclick="closePopup()">
    </div>

    {{-- Popup Container - FIXED: Proper centering and padding --}}
    <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6 z-50 pointer-events-none">

        {{-- Popup Content - FIXED: All height constraints properly set --}}
        <div
            class="pointer-events-auto relative w-full max-w-6xl
                bg-white shadow-2xl
                rounded-2xl sm:rounded-3xl
                flex flex-col
                popup-content"
            style="max-height: 80vh;"
            onclick="event.stopPropagation()">

            {{-- Close Button --}}
            <div class="absolute top-3 right-3 sm:top-4 sm:right-4 z-20">
                <button
                    class="w-10 h-10 rounded-full
                           bg-white/90 backdrop-blur
                           flex items-center justify-center
                           shadow-lg hover:shadow-xl hover:scale-110 active:scale-95 
                           transition-all duration-200"
                    onclick="closePopup()">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="pemerintah-list"
                 class="overflow-y-auto custom-scrollbar w-full"
                 style="max-height: 80vh; min-height: 200px;">

                {{-- Loading State --}}
                <div class="flex items-center justify-center py-20">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <div class="animate-spin w-12 h-12 border-4 border-green-600 border-t-transparent rounded-full"></div>
                        </div>
                        <p class="mt-4 text-sm text-gray-500">Memuat data...</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


    @php
        $filteredArtikel = $artikel->reject(fn($post) => $post['kategori'] === 'agenda');
    @endphp

    @if ($filteredArtikel->count() > 0)
        <!-- Mobile Carousel Container (visible on mobile only) -->
        <div class="block sm:hidden">
            <div class="relative">
                <!-- Carousel Wrapper -->
                <div id="mobile-articles-carousel" 
                     class="flex gap-4 overflow-x-auto scrollbar-hide pb-4 snap-x snap-mandatory"
                     style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                    @foreach ($filteredArtikel->take(6) as $index => $post)
                        <div class="flex-shrink-0 w-80 snap-start">
                            <div class="mobile-article-wrapper">
                                @include('theme::partials.artikel.list', ['post' => $post])
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button id="carousel-prev" 
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-green-600 transition-colors z-10 opacity-90 hover:opacity-100"
                        aria-label="Previous article">
                    <svg class="w-5 h-5 text-green-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button id="carousel-next" 
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-green-600 transition-colors z-10 opacity-90 hover:opacity-100"
                        aria-label="Next article">
                    <svg class="w-5 h-5 text-green-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-4 gap-2" id="carousel-indicators" role="tablist" aria-label="Article navigation">
                    @foreach ($filteredArtikel->take(6) as $index => $post)
                        <button class="w-2 h-2 rounded-full transition-all duration-200 carousel-dot" 
                                data-slide="{{ $index }}"
                                role="tab"
                                aria-label="Go to article {{ $index + 1 }}"
                                style="background-color: {{ $index === 0 ? '#16a34a' : '#d1d5db' }}"></button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Desktop Grid (hidden on mobile, visible on sm and up) - 2 rows with 3 columns each (6 articles total) -->
        <div class="hidden sm:grid sm:grid-cols-3 gap-6">
            @foreach ($filteredArtikel->take(6) as $post)
                @include('theme::partials.artikel.list', ['post' => $post])
            @endforeach
        </div>
    @else
        @include('theme::partials.artikel.empty', ['title' => $title])
    @endif
</div>

<style>
/* ========================================
   PEMERINTAH POPUP STYLES - COMPLETELY FIXED
   ======================================== */

/* CRITICAL: Custom Scrollbar Styles */
.custom-scrollbar {
    /* Force scrollbar to always be visible */
    overflow-y: scroll !important;
    -webkit-overflow-scrolling: touch;
}

/* Webkit browsers (Chrome, Safari, Edge) */
.custom-scrollbar::-webkit-scrollbar {
    width: 12px;
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
    margin: 10px 0;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #16a34a, #15803d);
    border-radius: 10px;
    border: 3px solid #f1f5f9;
    transition: all 0.3s ease;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #15803d, #166534);
    border: 2px solid #f1f5f9;
}

.custom-scrollbar::-webkit-scrollbar-thumb:active {
    background: linear-gradient(180deg, #166534, #14532d);
}

/* Firefox */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #16a34a #f1f5f9;
}

/* Popup Container Animations */
#pemerintah-popup {
    transition: opacity 0.3s ease;
}

#pemerintah-popup .popup-overlay {
    transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    opacity: 0;
}

#pemerintah-popup.show .popup-overlay {
    opacity: 1;
}

#pemerintah-popup .popup-content {
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
}

/* Mobile - Bottom Sheet Style */
@media (max-width: 639px) {
    #pemerintah-popup .popup-content {
        transform: translateY(100%);
        opacity: 1;
        max-height: 85vh !important;
    }
    
    #pemerintah-popup.show .popup-content {
        transform: translateY(0);
    }
    
    #pemerintah-list {
        max-height: 85vh !important;
    }
}

/* Desktop - Scale and Fade */
@media (min-width: 640px) {
    #pemerintah-popup .popup-content {
        transform: scale(0.9) translateY(20px);
        opacity: 0;
        max-height: 85vh !important;
    }
    
    #pemerintah-popup.show .popup-content {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    
    #pemerintah-list {
        max-height: 85vh !important;
    }
}

/* Short screens */
@media (max-height: 700px) {
    #pemerintah-popup .popup-content,
    #pemerintah-list {
        max-height: 80vh !important;
    }
}

@media (max-height: 600px) {
    #pemerintah-popup .popup-content,
    #pemerintah-list {
        max-height: 75vh !important;
    }
}

/* Filter Buttons */
.filter-btn {
    background: white;
    color: #4b5563;
    border: 2px solid #e5e7eb;
    position: relative;
    overflow: hidden;
}

.filter-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.filter-btn:hover::before {
    left: 100%;
}

.filter-btn:hover {
    border-color: #16a34a;
    color: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.15);
}

.filter-btn.active {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: white;
    border-color: #16a34a;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.filter-btn:active {
    transform: scale(0.95);
}

/* Pemerintah Cards - Enhanced Grid Layout */
.pemerintah-item {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
    animation: fadeInUpCard 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes fadeInUpCard {
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1);
    }
}

/* Card Hover Effects */
.pemerintah-item {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.pemerintah-item:hover {
    transform: translateY(-8px);
}

/* Circular Avatar Container */
.pemerintah-item > div:first-child {
    position: relative;
    overflow: visible;
}

.pemerintah-item > div:first-child > div {
    position: relative;
    overflow: hidden;
}

.pemerintah-item > div:first-child > div::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(22, 163, 74, 0.1), rgba(21, 128, 61, 0.1));
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 1;
}

.pemerintah-item:hover > div:first-child > div::before {
    opacity: 1;
}

/* Image Zoom Effect */
.pemerintah-item img {
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), filter 0.5s;
}

.pemerintah-item:hover img {
    transform: scale(1.1);
}

/* Status Badge Animation */
.pemerintah-item .status-badge {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.pemerintah-item:hover .status-badge {
    transform: scale(1.1);
}

/* Status Dot Pulse */
@keyframes statusPulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.7;
        transform: scale(1.2);
    }
}

.status-dot-green {
    animation: statusPulse 2s infinite;
}

/* Search Input Focus Effect */
#search-pemerintah:focus {
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
}

/* Empty State */
.empty-state {
    opacity: 0;
    animation: fadeIn 0.5s ease forwards;
}

@keyframes fadeIn {
    to { opacity: 1; }
}

/* Loading State */
.loading-spinner {
    position: relative;
}

.loading-spinner::after {
    content: '';
    position: absolute;
    inset: -4px;
    border: 2px solid rgba(22, 163, 74, 0.1);
    border-radius: 50%;
    animation: ripple 1.5s infinite;
}

@keyframes ripple {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

/* Responsive Typography */
@media (max-width: 639px) {
    .pemerintah-item h4 {
        font-size: 0.75rem;
        line-height: 1.2;
    }
    
    .pemerintah-item p {
        font-size: 0.65rem;
    }
}

/* ========================================
   MOBILE CAROUSEL STYLES
   ======================================== */

/* Hide scrollbar for mobile carousel */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Scroll snapping for smooth navigation */
.snap-x {
    scroll-snap-type: x mandatory;
}

.snap-start {
    scroll-snap-align: start;
}

/* Mobile article wrapper adjustments */
.mobile-article-wrapper {
    height: 100%;
}

.mobile-article-wrapper > * {
    height: 100%;
    max-width: none;
    width: 100%;
}

/* Responsive adjustments for mobile carousel */
@media (max-width: 639px) {
    .mobile-article-wrapper .grid {
        display: block !important;
    }
    
    .mobile-article-wrapper .md\:grid-cols-2,
    .mobile-article-wrapper .lg\:grid-cols-3 {
        display: block !important;
    }
    
    /* Ensure article cards fit properly in carousel */
    .mobile-article-wrapper [class*="col-span"] {
        width: 100% !important;
    }
}

/* Touch scrolling improvements */
@supports (-webkit-overflow-scrolling: touch) {
    #mobile-articles-carousel {
        -webkit-overflow-scrolling: touch;
    }
}

/* Prevent text selection during drag */
#mobile-articles-carousel.dragging * {
    user-select: none;
}

/* Carousel navigation button improvements */
#carousel-prev,
#carousel-next {
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

#carousel-prev:hover,
#carousel-next:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

#carousel-prev:active,
#carousel-next:active {
    transform: translateY(-50%) scale(0.95);
}

/* Carousel dots improvements */
.carousel-dot {
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.carousel-dot:hover {
    transform: scale(1.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // PEMERINTAH DESA POPUP - COMPLETELY FIXED
    // ========================================
    
    const btnPemerintah = document.getElementById('btn-pemerintah-desa');
    const popup = document.getElementById('pemerintah-popup');
    const pemerintahList = document.getElementById('pemerintah-list');
    
    let pemerintahData = [];
    
    // Make closePopup global so it can be called from overlay onclick
    window.closePopup = function() {
        console.log('Closing popup...');
        popup.classList.remove('show');
        setTimeout(() => {
            popup.classList.add('hidden');
            document.body.style.overflow = '';
        }, 400);
    };
    
    function openPopup() {
        popup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => popup.classList.add('show'), 10);
        
        // Fetch data
        fetch('/internal_api/pemerintah')
            .then(response => response.json())
            .then(data => {
                console.log('Pemerintah Desa Data:', data);
                pemerintahData = data.data;
                renderPemerintah(pemerintahData);
            })
            .catch(error => {
                console.error('Error fetching pemerintah:', error);
                showError();
            });
    }
    
    function showError() {
        pemerintahList.innerHTML = `
            <div class="flex items-center justify-center min-h-[400px] empty-state">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Gagal memuat data</p>
                    <p class="text-sm text-gray-400 mt-2">Silakan coba lagi nanti</p>
                </div>
            </div>
        `;
    }
    
    function renderPemerintah(data) {
        if (!data || data.length === 0) {
            pemerintahList.innerHTML = `
                <div class="flex items-center justify-center min-h-[400px] empty-state">
                    <div class="text-center px-4">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium text-lg">Data tidak tersedia</p>
                        <p class="text-sm text-gray-400 mt-2">Belum ada data pemerintah desa</p>
                    </div>
                </div>
            `;
            return;
        }

        let html = `
            <div class="w-full px-4 sm:px-6 py-6 sm:py-8">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-xl sm:text-xl lg:text-2xl font-bold text-gray-900">
                        Aparatur Desa
                    </h2>
                    <div class="inline-block bg-green-600 px-6 py-2.5 rounded-full shadow-lg">
                        <span class="text-white font-bold text-sm px-1.5 sm:text-base">
                            Pemerintah {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-wrap justify-center gap-4 sm:gap-6 lg:gap-8 pb-8">
        `;
        
        data.forEach((item, index) => {
            const attr = item.attributes;
            const nama = attr.pamong_nama || attr.nama || '-';
            const jabatan = attr.jabatan?.nama || attr.nama_jabatan || '-';
            const foto = attr.foto || '';
            const statusKehadiran = attr.status_kehadiran || 'Tidak diketahui';
            const isHadir = statusKehadiran.toLowerCase().includes('hadir') && !statusKehadiran.toLowerCase().includes('belum');
            
            const statusColor = isHadir ? 'bg-green-500' : 'bg-yellow-400';
            const statusText = isHadir ? 'text-green-600' : 'text-gray-500';
            const statusBg = isHadir ? 'bg-green-50' : 'bg-yellow-50';
            const statusDotClass = isHadir ? 'status-dot-green' : '';

            html += `
                <div class="pemerintah-item group w-24 sm:w-28 lg:w-36 flex-shrink-0" style="animation-delay: ${index * 0.04}s">
                    
                    <div class="relative w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 mx-auto mb-3 sm:mb-4">
                        <div class="w-full h-full rounded-full overflow-hidden bg-gray-100 ring-2 ring-gray-200 group-hover:ring-green-500 transition-all duration-300 shadow-md group-hover:shadow-xl">
                            <img src="${foto}" 
                                 alt="${nama}" 
                                 class="w-full h-full object-cover grayscale-[15%] group-hover:grayscale-0"
                                 onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=f1f5f9&color=64748b&size=200&bold=true'">
                        </div>
                    </div>

                    <div class="w-full px-1">
                        <h4 class="font-bold text-gray-900 text-xs sm:text-sm lg:text-base leading-tight line-clamp-2 min-h-[2.2rem] sm:min-h-[2.5rem] group-hover:text-green-700 transition-colors text-center mb-1">
                            ${nama}
                        </h4>
                        <p class="text-[10px] sm:text-xs lg:text-sm font-semibold text-green-700 tracking-tight mb-2 sm:mb-3 line-clamp-2 text-center">
                            ${jabatan}
                        </p>
                        
                        <div class="flex items-center justify-center gap-1.5 px-2 py-1.5 ${statusBg} rounded-full status-badge">
                            <span class="w-2 h-2 rounded-full ${statusColor} ${statusDotClass}"></span>
                            <span class="text-[10px] sm:text-xs ${statusText} font-medium">
                                ${statusKehadiran}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += `
                </div>
            </div>
        `;
        
        pemerintahList.innerHTML = html;
        
        // Force scroll reset to top
        pemerintahList.scrollTop = 0;
        
        console.log('Rendered', data.length, 'pemerintah items');
        console.log('Scroll height:', pemerintahList.scrollHeight, 'Client height:', pemerintahList.clientHeight);
    }
    
    // Event Listeners
    if (btnPemerintah) {
        btnPemerintah.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Opening pemerintah popup...');
            openPopup();
        });
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (popup && !popup.classList.contains('hidden')) {
            if (e.key === 'Escape') {
                e.preventDefault();
                window.closePopup();
            }
        }
    });

    // ========================================
    // MOBILE CAROUSEL - EXISTING CODE
    // ========================================
    
    const carousel = document.getElementById('mobile-articles-carousel');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');
    const dots = document.querySelectorAll('.carousel-dot');
    
    if (!carousel || dots.length === 0) return;
    
    let currentSlide = 0;
    const slideWidth = 336; // 320px + 16px gap (w-80 + gap-4)
    const totalSlides = dots.length;
    
    // Throttle function for performance
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
    
    // Update carousel position and indicators
    function updateCarousel() {
        if (!carousel) return;
        
        carousel.scrollTo({
            left: currentSlide * slideWidth,
            behavior: 'smooth'
        });
        
        // Update dot indicators
        dots.forEach((dot, index) => {
            const isActive = index === currentSlide;
            dot.style.backgroundColor = isActive ? '#16a34a' : '#d1d5db';
            dot.style.transform = isActive ? 'scale(1.2)' : 'scale(1)';
            dot.setAttribute('aria-selected', isActive);
        });
        
        // Update button states and accessibility
        if (prevBtn) {
            const isDisabled = currentSlide === 0;
            prevBtn.style.opacity = isDisabled ? '0.5' : '0.9';
            prevBtn.disabled = isDisabled;
            prevBtn.setAttribute('aria-disabled', isDisabled);
        }
        if (nextBtn) {
            const isDisabled = currentSlide === totalSlides - 1;
            nextBtn.style.opacity = isDisabled ? '0.5' : '0.9';
            nextBtn.disabled = isDisabled;
            nextBtn.setAttribute('aria-disabled', isDisabled);
        }
    }
    
    // Navigation functions
    function goToPrevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateCarousel();
        }
    }
    
    function goToNextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateCarousel();
        }
    }
    
    function goToSlide(index) {
        if (index >= 0 && index < totalSlides) {
            currentSlide = index;
            updateCarousel();
        }
    }
    
    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', goToPrevSlide);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', goToNextSlide);
    }
    
    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });
    
    // Touch and swipe support
    let touchState = {
        startX: 0,
        currentX: 0,
        isDragging: false,
        startScrollLeft: 0
    };
    
    function handleTouchStart(e) {
        touchState.startX = e.touches[0].clientX;
        touchState.startScrollLeft = carousel.scrollLeft;
        touchState.isDragging = true;
        carousel.classList.add('dragging');
    }
    
    function handleTouchMove(e) {
        if (!touchState.isDragging) return;
        
        touchState.currentX = e.touches[0].clientX;
        const diffX = touchState.startX - touchState.currentX;
        carousel.scrollLeft = touchState.startScrollLeft + diffX;
    }
    
    function handleTouchEnd() {
        if (!touchState.isDragging) return;
        
        touchState.isDragging = false;
        carousel.classList.remove('dragging');
        
        const diffX = touchState.startX - touchState.currentX;
        const threshold = slideWidth / 3;
        
        if (Math.abs(diffX) > threshold) {
            if (diffX > 0 && currentSlide < totalSlides - 1) {
                goToNextSlide();
            } else if (diffX < 0 && currentSlide > 0) {
                goToPrevSlide();
            }
        } else {
            updateCarousel(); // Snap back to current slide
        }
        
        // Reset touch state
        Object.assign(touchState, {
            startX: 0,
            currentX: 0,
            startScrollLeft: 0
        });
    }
    
    carousel.addEventListener('touchstart', handleTouchStart, { passive: true });
    carousel.addEventListener('touchmove', handleTouchMove, { passive: true });
    carousel.addEventListener('touchend', handleTouchEnd, { passive: true });
    
    // Mouse drag support (for desktop testing)
    let mouseState = {
        isDown: false,
        startX: 0,
        scrollLeft: 0
    };
    
    carousel.addEventListener('mousedown', function(e) {
        mouseState.isDown = true;
        mouseState.startX = e.pageX - carousel.offsetLeft;
        mouseState.scrollLeft = carousel.scrollLeft;
        carousel.style.cursor = 'grabbing';
        carousel.classList.add('dragging');
        e.preventDefault();
    });
    
    carousel.addEventListener('mouseleave', function() {
        mouseState.isDown = false;
        carousel.style.cursor = 'grab';
        carousel.classList.remove('dragging');
    });
    
    carousel.addEventListener('mouseup', function() {
        mouseState.isDown = false;
        carousel.style.cursor = 'grab';
        carousel.classList.remove('dragging');
    });
    
    carousel.addEventListener('mousemove', function(e) {
        if (!mouseState.isDown) return;
        e.preventDefault();
        const x = e.pageX - carousel.offsetLeft;
        const walk = (x - mouseState.startX) * 2;
        carousel.scrollLeft = mouseState.scrollLeft - walk;
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (window.innerWidth >= 640) return; // Only on mobile
        
        switch(e.key) {
            case 'ArrowLeft':
                if (currentSlide > 0) {
                    goToPrevSlide();
                    e.preventDefault();
                }
                break;
            case 'ArrowRight':
                if (currentSlide < totalSlides - 1) {
                    goToNextSlide();
                    e.preventDefault();
                }
                break;
        }
    });
    
    // Update current slide based on scroll position (throttled for performance)
    const handleScroll = throttle(function() {
        const newSlide = Math.round(carousel.scrollLeft / slideWidth);
        if (newSlide !== currentSlide && newSlide >= 0 && newSlide < totalSlides) {
            currentSlide = newSlide;
            dots.forEach((dot, index) => {
                const isActive = index === currentSlide;
                dot.style.backgroundColor = isActive ? '#16a34a' : '#d1d5db';
                dot.style.transform = isActive ? 'scale(1.2)' : 'scale(1)';
                dot.setAttribute('aria-selected', isActive);
            });
        }
    }, 100);
    
    carousel.addEventListener('scroll', handleScroll);
    
    // Auto-play functionality with proper cleanup
    let autoPlayState = {
        interval: null,
        isPlaying: false,
        inactivityTimer: null
    };
    
    function startAutoPlay() {
        if (autoPlayState.isPlaying) return;
        
        autoPlayState.isPlaying = true;
        autoPlayState.interval = setInterval(() => {
            if (currentSlide < totalSlides - 1) {
                goToNextSlide();
            } else {
                goToSlide(0);
            }
        }, 4000);
    }
    
    function stopAutoPlay() {
        if (autoPlayState.interval) {
            clearInterval(autoPlayState.interval);
            autoPlayState.interval = null;
            autoPlayState.isPlaying = false;
        }
    }
    
    function resetInactivityTimer() {
        clearTimeout(autoPlayState.inactivityTimer);
        stopAutoPlay();
        
        autoPlayState.inactivityTimer = setTimeout(() => {
            if (window.innerWidth < 640 && document.visibilityState === 'visible') {
                startAutoPlay();
            }
        }, 2000);
    }
    
    // Track user interactions for auto-play
    const interactionEvents = ['touchstart', 'mousedown', 'click', 'keydown'];
    interactionEvents.forEach(event => {
        carousel.addEventListener(event, resetInactivityTimer);
    });
    
    // Pause auto-play when page is not visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoPlay();
        } else {
            resetInactivityTimer();
        }
    });
    
    // Initialize carousel
    updateCarousel();
    resetInactivityTimer();
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        stopAutoPlay();
        clearTimeout(autoPlayState.inactivityTimer);
    });
    
    // Article section scroll functionality
    function scrollToArticles() {
        const articlesSection = document.getElementById('articles-section');
        if (articlesSection) {
            const offsetTop = articlesSection.offsetTop - 100;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    }
    
    // Handle scroll to articles from pagination
    if (sessionStorage.getItem('scrollToArticles') === 'true') {
        sessionStorage.removeItem('scrollToArticles');
        setTimeout(scrollToArticles, 300);
    }
    
    // Handle page parameter
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page');
    
    if (currentPage && currentPage !== '1') {
        setTimeout(scrollToArticles, 300);
    }
    
    // Handle direct anchor links
    if (window.location.hash === '#articles-section') {
        setTimeout(scrollToArticles, 300);
    }
});
</script>