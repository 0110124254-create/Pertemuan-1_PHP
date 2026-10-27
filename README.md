# Tugas Form Processing & Struktur Kendali PHP

Proyek ini adalah halaman PHP sederhana untuk mengisi data peserta dan nilai ujian, memvalidasi masukan, lalu menampilkan hasil kelulusan.

## Fitur

- Formulir dengan input nama, e-mail, dan nilai ujian.
- Validasi kolom wajib, format e-mail, serta nilai antara 0 dan 100.
- Menampilkan keterangan **Lulus** untuk nilai di atas 70 dan **Remedial** untuk nilai 70 atau kurang.
- Mempertahankan isian formulir setelah dikirim dan mengamankan output menggunakan `htmlspecialchars()`.
- Tampilan responsif dengan CSS di dalam halaman.

## Cara Menjalankan dengan XAMPP

1. Salin file `index.php` ke folder `C:\xampp\htdocs\tugas-form-php`. Buat folder `tugas-form-php` di dalam `htdocs` jika belum ada.
2. Buka **XAMPP Control Panel**, lalu klik **Start** pada baris **Apache**.
3. Buka alamat berikut di browser:

   [http://localhost/tugas-form-php/](http://localhost/tugas-form-php/)

