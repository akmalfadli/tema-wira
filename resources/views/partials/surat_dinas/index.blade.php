<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Verifikasi & Pratinjau Surat Dinas - {{ setting('admin_title') . ' ' . ucwords(setting('sebutan_desa')) . ' ' . identitas('nama_desa') }}
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Google Fonts & Lucide Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* Paper Preview Container */
        .paper-wrapper {
            background-color: #cbd5e1;
            padding: 1.25rem;
            border-radius: 0.5rem;
            border: 1px solid #94a3b8;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
            max-height: 85vh;
            overflow-y: auto;
        }

        .letter-paper {
            background: #ffffff;
            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.1), 0 2px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 2px;
            padding: 2.5rem 2.25rem;
            margin: 0 auto;
            max-width: 100%;
            min-height: 850px;
            color: #000000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 13.5px;
            line-height: 1.5;
        }

        .letter-paper table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .letter-paper img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-5">

        <!-- Minimalism Branding Header -->
        <header class="bg-white rounded-lg p-4 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <img class="w-11 h-11 object-contain flex-shrink-0" src="{{ gambar_desa(identitas('logo')) }}" alt="Logo Desa">
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">
                        Pemerintah {{ ucwords(setting('sebutan_kabupaten') . ' ' . identitas('nama_kabupaten')) }}
                    </h1>
                    <p class="text-xs font-medium text-slate-500">
                        {{ ucwords(setting('sebutan_kecamatan') . ' ' . identitas('nama_kecamatan')) }} - {{ ucwords(setting('sebutan_desa') . ' ' . identitas('nama_desa')) }}
                    </p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-emerald-700 bg-emerald-50 px-3 py-1 rounded-md border border-emerald-200 text-xs font-semibold">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i> Verifikasi Surat Dinas Resmi
            </div>
        </header>

        <!-- Main Content Area -->
        <div id="content-container">
            <!-- Loading State -->
            <div id="loading-state" class="bg-white rounded-lg border border-slate-200/80 p-14 text-center shadow-sm">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-3 border-emerald-600 border-t-transparent mb-3"></div>
                <p class="text-slate-600 font-medium text-sm">Memeriksa keabsahan dan memuat dokumen surat dinas...</p>
            </div>

            <!-- Error State -->
            <div id="error-state" class="hidden bg-white rounded-lg border border-slate-200/80 p-10 text-center shadow-sm">
                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-lg flex items-center justify-center mx-auto mb-3 border border-rose-100">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">Surat Dinas Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-5">
                    Dokumen surat dinas dengan ID ini tidak tercatat dalam database resmi sistem informasi kami atau telah dibatalkan.
                </p>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs rounded-md transition">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Beranda
                </a>
            </div>

            <!-- Verified 2-Column Layout -->
            <div id="verified-state" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

                <!-- Left Column: Verification Details -->
                <div class="lg:col-span-5 space-y-4">

                    <!-- Verified Status Banner -->
                    <div class="bg-emerald-600 text-white rounded-lg p-4 shadow-sm space-y-1.5">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-200"></i>
                            <h2 class="text-sm font-bold">Dokumen Sah & Terverifikasi</h2>
                        </div>
                        <p class="text-xs text-emerald-100 leading-relaxed">
                            Surat dinas ini secara sah terdaftar dan tercatat dalam database resmi Sistem Informasi Desa {{ ucwords(identitas('nama_desa')) }}.
                        </p>
                    </div>

                    <!-- Details Card -->
                    <div class="bg-white rounded-lg border border-slate-200/80 p-4 shadow-sm space-y-3.5">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2.5 flex items-center gap-1.5">
                            <i data-lucide="file-check-2" class="w-3.5 h-3.5 text-emerald-600"></i> Rincian Informasi Surat Dinas
                        </h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400">Nomor Surat</span>
                                <span id="surat-nomor" class="font-bold text-slate-900 mt-0.5 text-base">-</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400">Perihal / Subjek Surat</span>
                                <span id="surat-perihal" class="font-medium text-slate-800 mt-0.5 text-xs sm:text-sm">-</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400">Tanggal Terbit</span>
                                <span id="surat-tanggal" class="font-medium text-slate-700 mt-0.5 text-xs sm:text-sm">-</span>
                            </div>
                        </div>

                        <!-- Signer Information -->
                        <div class="bg-slate-50 rounded-md p-3.5 border border-slate-100 space-y-1.5 mt-3">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block border-b border-slate-200/60 pb-1">
                                Penandatangan Dokumen
                            </span>
                            <div>
                                <span class="text-xs font-medium text-slate-400">Nama Pejabat</span>
                                <p id="surat-pamong-nama" class="font-bold text-slate-900 text-xs sm:text-sm mt-0.5">-</p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-slate-400">Jabatan</span>
                                <p id="surat-pamong-jabatan" class="font-medium text-slate-700 text-xs mt-0.5">-</p>
                            </div>
                            <div id="tte-badge" class="hidden pt-1">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    <i data-lucide="shield" class="w-3 h-3"></i> Terverifikasi TTE
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Document Preview -->
                <div class="lg:col-span-7 space-y-2.5">
                    <div class="flex items-center justify-between px-0.5">
                        <div class="flex items-center gap-1.5 text-slate-700 font-bold text-xs sm:text-sm">
                            <i data-lucide="file-text" class="w-4 h-4 text-emerald-600"></i> Pratinjau Dokumen
                        </div>
                        <span class="text-xs text-slate-400">Format Resmi Surat</span>
                    </div>

                    <!-- Paper Preview Container -->
                    <div class="paper-wrapper">
                        <div id="letter-content" class="letter-paper">
                            <!-- Content loaded dynamically -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-xs text-slate-400 py-3">
            &copy; {{ date('Y') }} {{ setting('admin_title') }} - {{ ucwords(setting('sebutan_desa') . ' ' . identitas('nama_desa')) }}. Hak cipta dilindungi.
        </footer>

    </div>

    <!-- Script Logic -->
    <script type="text/javascript">
        // Clean HTML2PDF tags (<page>, <page_header>, etc.) into standard HTML
        function sanitizeLetterHtml(rawHtml) {
            if (!rawHtml) return '<div class="text-center py-12 text-slate-400 text-xs">Pratinjau isi surat tidak tersedia.</div>';
            
            let formatted = rawHtml
                .replace(/<page_header>/gi, '<div class="letter-header">')
                .replace(/<\/page_header>/gi, '</div>')
                .replace(/<page[^>]*>/gi, '<div class="letter-page-body">')
                .replace(/<\/page>/gi, '</div>');

            return formatted;
        }

        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();

            fetch("{{ route('api.verifikasi-surat-dinas') }}?filter[id]={{ $id }}", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("HTTP error " + response.status);
            }).then(result => {
                document.getElementById('loading-state').classList.add('hidden');

                if (result && result.data && result.data.length > 0) {
                    const surat = result.data[0].attributes;

                    // Populate Info Fields with Fallbacks
                    const nomorSurat = surat.no_surat || surat.nomor_surat || '-';
                    const tanggalSurat = surat.tanggal || '-';
                    const pamongNama = surat.nama_pamong || surat.pamong_nama || '-';
                    const pamongJabatan = surat.nama_jabatan || surat.pamong_jabatan || '-';
                    
                    let perihal = surat.perihal || surat.nama_surat || 'Surat Dinas';
                    if (surat.nama_surat && surat.nama_surat.includes('.docx')) {
                        perihal = surat.nama_surat.split('_')[0].replace(/-/g, ' ');
                        perihal = perihal.charAt(0).toUpperCase() + perihal.slice(1);
                    }

                    document.getElementById('surat-nomor').textContent = nomorSurat;
                    document.getElementById('surat-perihal').textContent = perihal;
                    document.getElementById('surat-tanggal').textContent = tanggalSurat;
                    document.getElementById('surat-pamong-nama').textContent = pamongNama;
                    document.getElementById('surat-pamong-jabatan').textContent = pamongJabatan;

                    if (surat.tte) {
                        document.getElementById('tte-badge').classList.remove('hidden');
                    }

                    // Render Letter Content Preview
                    const rawIsiSurat = surat.isi_surat || surat.isi_surat_temp || '';
                    document.getElementById('letter-content').innerHTML = sanitizeLetterHtml(rawIsiSurat);

                    // Show Verified State Container
                    document.getElementById('verified-state').classList.remove('hidden');
                    lucide.createIcons();
                } else {
                    document.getElementById('error-state').classList.remove('hidden');
                }
            }).catch(error => {
                console.error("Fetch error:", error);
                document.getElementById('loading-state').classList.add('hidden');
                document.getElementById('error-state').classList.remove('hidden');
            });
        });
    </script>
</body>

</html>

