{{-- resources/views/partials/statistics.blade.php --}}
<div class="mt-16">
    <h2 class="text-xl md:text-2xl font-bold mb-1">Data Statistik</h2>
    <h3 class="text-green-600 text-xl md:text-2xl font-bold mb-6 leading-tight">{{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}, {{ ucfirst(setting('sebutan_kecamatan_singkat')) }} {{ ucwords($desa['nama_kecamatan']) }}</h3>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
        
        <!-- 1. Data Warga Administratif -->
        <a href="<?= site_url(); ?>data-wilayah" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="users" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Warga Administratif</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info detail jumlah masyarakat sesuai administrasi {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 2. Data Pendidikan Dalam KK -->
        <a href="<?= site_url(); ?>data-statistik/pendidikan-dalam-kk" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="graduation-cap" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Pendidikan</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info detail jumlah warga pendidikan dalam {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 3. Data Pendidikan Sedang Ditempuh -->
        <a href="<?= site_url(); ?>data-statistik/pendidikan-sedang-ditempuh" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="building" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Pendidikan Sedang Ditempuh</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info detail jumlah warga pendidikan yang ditempuh di {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 4. Data Pekerjaan -->
        <a href="<?= site_url(); ?>data-statistik/pekerjaan" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="briefcase" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Pekerjaan</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info detail klasifikasi mata pencaharian warga {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 5. Data Rentang Umur -->
        <a href="<?= site_url(); ?>data-statistik/rentang-umur" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="clock" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Rentang Umur</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info detail sebaran rentang umur warga di {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 6. Data Status Perkawinan -->
        <a href="<?= site_url(); ?>data-statistik/status-perkawinan" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="heart" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Status Perkawinan</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info detail status perkawinan masyarakat {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 7. Data Pemeluk Agama -->
        <a href="<?= site_url(); ?>data-statistik/agama" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="book-open" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Pemeluk Agama</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info sebaran pemeluk agama warga di {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 8. Data Jenis Kelamin -->
        <a href="<?= site_url(); ?>data-statistik/jenis-kelamin" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="user-check" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Data Jenis Kelamin</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Info demografi rasio laki-laki dan perempuan {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

        <!-- 9. Status IDM Desa -->
        <a href="<?= site_url(); ?>status-idm" class="block">
            <div class="border border-gray-200 rounded-lg p-3 md:p-4 hover:shadow-lg transition-shadow h-full bg-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-2">
                    <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                        <i data-lucide="award" class="h-5 w-5 md:h-6 md:w-6 text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-sm md:text-base leading-tight">Status IDM Desa</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">Capaian Indeks Desa Membangun (IDM) {{ ucfirst(setting('sebutan_desa')) }} {{ ucwords($desa['nama_desa']) }}</p>
            </div>
        </a>

    </div>
</div>