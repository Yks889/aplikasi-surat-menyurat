
# Aplikasi Surat Menyurat

Aplikasi web berbasis PHP CodeIgniter untuk mengelola surat masuk dan keluar secara digital. Mendukung fitur multi-role: **Admin**, **Operator**, dan **User**.

## 🔐 Fitur Autentikasi
- Login sesuai user yang terdaftar (tanpa memilih role).
- Registrasi untuk user baru.
- Setiap user memiliki role: Admin, Operator, atau User Biasa.

## 🧑‍💼 Role & Akses
### Admin:
- Dashboard: Menampilkan daftar surat masuk dan keluar dengan filter.
- Kelola User: Tambah/edit/hapus user & role.
- Surat Masuk: Index, tambah, edit, hapus.
- Surat Keluar: Index, tambah (nomor surat otomatis via AJAX), edit, hapus.
- Tanda Tangan: Upload tanda tangan admin.
- Perusahaan: CRUD data perusahaan (untuk nomor surat).
- Jenis Surat: CRUD jenis surat keluar.
- Profil: Edit nama & foto profil.

### Operator:
- Dashboard
- Surat Masuk
- Surat Keluar
- Kelola User Biasa
- Profil

### User Biasa:
- Dashboard
- Form Surat Masuk
- Riwayat Surat Masuk & Keluar
- Profil

## 📦 Teknologi
- PHP CodeIgniter
- Bootstrap (UI)
- jQuery & AJAX (auto-generate nomor surat)
- MySQL (Database)

## 📂 Struktur Folder Penting
- `/application/controllers/`: Logic halaman
- `/application/models/`: Koneksi DB
- `/application/views/`: Halaman frontend
- `/assets/`: Gambar, JS, CSS

## 📌 Fitur Tambahan
- AJAX untuk nomor surat otomatis
- Filtering data di dashboard
- Upload tanda tangan
- Upload foto profil

## 📥 Instalasi
1. Clone repo:  
   `git clone https://github.com/Yks889/aplikasi-surat-menyurat`
2. Buat database dan import file SQL (jika ada).
3. Konfigurasi koneksi DB di:
   `application/config/database.php`
4. Jalankan di `localhost` dengan Apache (XAMPP/Laragon).

## 👨‍💻 Kontribusi
Pull Request & Issue sangat disambut!
