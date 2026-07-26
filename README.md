# Tema Wira (OpenSID)

Tema Wira adalah tema untuk aplikasi Sistem Informasi Desa **OpenSID**. Tema ini dirancang untuk menyajikan informasi desa secara modern, dinamis, dan terstruktur.

## Validasi & Persyaratan

Tema ini memerlukan status berlangganan premium aktif:
* **Mekanisme**: Melakukan validasi melalui cookie `langganan-premium`.
* **Halaman Aktivasi**: Jika cookie `langganan-premium` tidak bernilai `'true'`, pengguna akan secara otomatis diarahkan ke halaman `/aktivasi-tema` untuk menyelesaikan proses verifikasi.

## Konfigurasi Utama (`config.json`)

Beberapa opsi pada tema ini dikunci secara default (`readonly: true`). Untuk membuka fitur-fitur ini secara penuh, pengguna disarankan untuk menggunakan versi berbayar (**Tema Perwira**).
* **Fitur Terbatas**: 
  * Visi Misi Desa (`vision_mission`)
  * Arah Pengembangan Desa (`development`)
  * Sejarah Desa (`history`)
  * Lokasi Kantor (`office_location`)
  * Pemerintah dan Aparatur Desa (`village_officials`)
