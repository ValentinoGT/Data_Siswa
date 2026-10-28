# Dokumentasi Website Data Siswa XI RPL

## 1. Gambaran Umum

Website **Data Siswa XI RPL** adalah aplikasi web untuk mengelola data siswa kelas XI Rekayasa Perangkat Lunak (RPL). Website ini dibuat menggunakan **PHP dengan framework CodeIgniter 4**, database **MySQL**, serta HTML, CSS, JavaScript, dan Bootstrap 5 untuk tampilan antarmuka.

Aplikasi menyediakan halaman daftar siswa yang memungkinkan pengguna melihat, menambahkan, mengubah, menghapus, mencari, memfilter, mengurutkan, dan menelusuri data siswa melalui pagination.

## 2. Tujuan Website

- Mempermudah pengelolaan data siswa dalam satu halaman.
- Menyimpan data siswa ke database agar dapat ditampilkan kembali.
- Membantu pencarian data berdasarkan nama atau NIS.
- Memudahkan pengelompokan data berdasarkan jenis kelamin.
- Menyediakan antarmuka yang rapi, responsif, dan mudah digunakan.

## 3. Fitur Utama

### A. Menampilkan data siswa
Website mengambil data dari tabel `siswa` pada database, lalu menampilkannya dalam tabel. Informasi yang ditampilkan meliputi:
- Nomor urut
- NIS
- Nama lengkap
- Jenis kelamin
- Kelas
- Tombol aksi untuk mengedit dan menghapus data

### B. Menambahkan siswa
Tombol **Tambah Siswa Baru** membuka formulir dalam modal. Pengguna mengisi NIS, nama, jenis kelamin, dan kelas, lalu menekan tombol simpan. Data divalidasi dan dikirim ke server untuk disimpan ke database.

### C. Mengedit siswa
Tombol edit membuka formulir untuk data siswa yang dipilih. Setelah formulir dikirim, aplikasi memeriksa data dan memperbarui catatan siswa berdasarkan ID.

### D. Menghapus siswa
Tombol hapus mengirim permintaan penghapusan berdasarkan ID siswa. Website menampilkan konfirmasi sebelum data dihapus agar pengguna tidak melakukannya secara tidak sengaja.

### E. Pencarian
Kolom pencarian dapat digunakan untuk mencari siswa berdasarkan **nama atau NIS**. Hasil akan diperbarui saat pengguna mengetik.

### F. Pengurutan data
Data dapat diurutkan berdasarkan:
- Nama A–Z
- Nama Z–A
- NIS terkecil
- NIS terbesar

Pengurutan ini dilakukan di sisi browser menggunakan JavaScript.

### G. Filter jenis kelamin
Pengguna dapat menampilkan semua siswa, hanya laki-laki, atau hanya perempuan.

### H. Pagination
Tabel menampilkan maksimal **5 siswa per halaman**. Tombol Prev, nomor halaman, dan Next membantu pengguna berpindah halaman. Status tabel juga menunjukkan rentang data yang sedang ditampilkan.

### I. Notifikasi dan validasi
Website menampilkan notifikasi ketika operasi berhasil atau gagal. Formulir memerlukan NIS, nama, jenis kelamin, dan kelas. Jenis kelamin dibatasi pada nilai `L` (laki-laki) atau `P` (perempuan).

## 4. Teknologi yang Digunakan

| Teknologi | Fungsi |
|---|---|
| PHP | Menangani logika server dan pemrosesan formulir |
| CodeIgniter 4 | Framework aplikasi, routing, validasi, dan akses database |
| MySQL | Menyimpan data siswa |
| HTML | Menyusun struktur halaman |
| CSS | Mengatur warna, jarak, tabel, tombol, dan responsivitas |
| JavaScript | Menjalankan pencarian, pengurutan, filter, dan pagination pada tabel |
| Bootstrap 5 | Membantu membuat layout, tombol, tabel, dan modal |
| Bootstrap Icons | Menampilkan ikon antarmuka |

## 5. Struktur Data Siswa

Aplikasi menggunakan tabel database bernama `siswa`. Berdasarkan kode aplikasi, kolom yang digunakan adalah:

| Kolom | Kegunaan |
|---|---|
| `id` | ID unik siswa dan kunci utama |
| `nis` | Nomor Induk Siswa |
| `nama` | Nama lengkap siswa |
| `jenis_kelamin` | Jenis kelamin (`L` atau `P`) |
| `kelas` | Kelas siswa |

Kolom `jenis_kelamin` juga disiapkan melalui file migration `AddJenisKelaminToSiswa.php`. Pastikan migration atau struktur tabel database sudah diterapkan sebelum menjalankan aplikasi.

## 6. Alur Kerja Aplikasi

1. Pengguna membuka halaman `/siswa`.
2. Controller mengambil data siswa dari database.
3. Data dikirim ke view untuk ditampilkan dalam tabel.
4. Pengguna dapat mencari, mengurutkan, memfilter, atau berpindah halaman tanpa memuat ulang data dari server.
5. Saat pengguna menambah, mengedit, atau menghapus data, formulir dikirim ke endpoint server yang sesuai.
6. Server memvalidasi input dan menjalankan operasi database.
7. Pengguna diarahkan kembali ke daftar siswa dan menerima notifikasi hasil operasi.

## 7. Penjelasan Bagian Kode

### `app/Controllers/Home.php`
Controller utama yang menangani:
- `index()` — mengambil dan menampilkan data siswa.
- `simpan()` — memvalidasi dan menyimpan siswa baru.
- `edit($id)` — memvalidasi dan memperbarui data siswa.
- `hapus($id)` — menghapus data siswa berdasarkan ID.

### `app/Models/SiswaModel.php`
Model mendefinisikan tabel `siswa`, primary key `id`, serta kolom yang diizinkan untuk operasi model. Pada controller yang digunakan saat ini, operasi CRUD dilakukan langsung melalui Query Builder CodeIgniter.

### `app/Views/siswa_view.php`
View yang berisi tampilan utama website, tabel siswa, modal formulir tambah/edit, notifikasi, serta JavaScript untuk pencarian, pengurutan, filter, dan pagination.

### `public/siswa.css`
File CSS yang mengatur gaya tampilan seperti navbar, kartu, tabel, formulir, tombol, modal, warna, dan penyesuaian layar kecil.

### `app/Config/Routes.php`
Mendefinisikan alamat halaman dan endpoint untuk operasi data:
- `GET /` — halaman utama.
- `GET /siswa` — daftar siswa.
- `POST /siswa/simpan` — menyimpan siswa.
- `POST /siswa/edit/{id}` — memperbarui siswa.
- `POST /siswa/hapus/{id}` — menghapus siswa.

### `app/Config/Database.php`
Berisi konfigurasi koneksi database. Pada konfigurasi proyek ini, nama database yang digunakan adalah `db_rpl_siswa`, dengan MySQLi pada `localhost`.

## 8. Cara Menjalankan Website

1. Pastikan PHP yang digunakan memenuhi kebutuhan CodeIgniter 4 proyek ini, yaitu PHP 8.2 atau lebih baru.
2. Pastikan ekstensi PHP `intl` dan `mbstring` aktif. Untuk koneksi MySQL, pastikan ekstensi MySQLi tersedia.
3. Jalankan layanan web server dan MySQL melalui XAMPP atau Laragon.
4. Buat database bernama `db_rpl_siswa` melalui phpMyAdmin atau alat database lainnya.
5. Buat tabel `siswa` dengan kolom yang sesuai pada bagian Struktur Data Siswa.
6. Pastikan pengaturan koneksi di `app/Config/Database.php` sesuai dengan konfigurasi MySQL lokal.
7. Buka terminal di folder proyek dan jalankan perintah berikut jika dependency belum tersedia atau perlu dipasang ulang:

   ```bash
   composer install
   ```

8. Jalankan aplikasi menggunakan server pengembangan CodeIgniter:

   ```bash
   php spark serve
   ```

9. Buka alamat lokal yang ditampilkan oleh terminal, biasanya `http://localhost:8080/siswa`.

**Catatan:** Folder `public` merupakan document root yang disarankan untuk web server. Jangan mengekspos folder root proyek ke publik. Jika proyek baru dipindahkan ke komputer lain, periksa kembali konfigurasi database, versi PHP, dan ekstensi yang aktif.

## 9. Validasi dan Keamanan Dasar

- Field NIS, nama, jenis kelamin, dan kelas wajib diisi.
- Nilai jenis kelamin dibatasi pada `L` dan `P`.
- Data yang ditampilkan di view menggunakan fungsi `esc()` pada sejumlah bagian untuk membantu mencegah output HTML yang tidak aman.
- Formulir penghapusan menggunakan token CSRF melalui `csrf_field()`.
- Penghapusan meminta konfirmasi dari pengguna di browser.

Untuk penggunaan nyata, aplikasi sebaiknya dilengkapi autentikasi dan otorisasi admin, validasi keunikan NIS, penanganan error yang ramah pengguna, serta pengaturan keamanan produksi.

## 10. Batasan yang Perlu Diperhatikan

- Pencarian, filter, pengurutan, dan pagination berjalan pada data yang sudah dirender di halaman browser; pagination database belum diterapkan.
- Kode controller menggunakan tabel `siswa` secara langsung melalui Query Builder, sehingga `SiswaModel` belum menjadi jalur utama operasi CRUD.
- Konfigurasi database saat ini memakai username `root` dan password kosong. Ini mungkin sesuai untuk lingkungan lokal tertentu, tetapi harus disesuaikan dan diamankan untuk deployment.
- Fitur login atau autentikasi belum terlihat pada kode yang diperiksa; label “RPL ADMIN” di tampilan bukan bukti bahwa sistem login sudah diterapkan.

## 11. Kesimpulan

Website Data Siswa XI RPL adalah aplikasi CRUD sederhana untuk membantu pengelolaan data siswa. Dengan CodeIgniter 4 dan MySQL sebagai sisi server, serta Bootstrap dan JavaScript sebagai pendukung antarmuka, aplikasi menyediakan fitur pengelolaan data dasar dalam tampilan yang rapi dan mudah dipahami.

Dokumentasi ini menjelaskan fitur dan struktur berdasarkan kode proyek yang diperiksa. Sebelum digunakan, pastikan database dan konfigurasi lingkungan sudah disiapkan dengan benar.
