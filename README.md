# 🔐 GEMBOK LARA - ISP Billing & Management System

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)

**GEMBOK LARA** adalah sistem manajemen tagihan dan operasional ISP (Internet Service Provider) yang dibangun ulang menggunakan **Laravel 12**. Proyek ini merupakan porting modern dari aplikasi Node.js "Gembok Bill", dirancang untuk skalabilitas, keamanan, dan kemudahan penggunaan.

---

## 🚀 Fitur Utama

Aplikasi ini mencakup seluruh siklus bisnis ISP, dari manajemen pelanggan hingga infrastruktur jaringan.

### 👥 Manajemen Pelanggan (CRM)
- **Database Terpusat**: Simpan data lengkap pelanggan, paket langganan, dan riwayat.
- **Status Tracking**: Monitor status pelanggan (Active, Inactive, Suspended).
- **Billing History**: Riwayat tagihan dan pembayaran yang transparan.

### 💰 Sistem Billing & Invoice
- **Auto-Invoicing**: Generate tagihan bulanan secara otomatis.
- **Invoice Management**: Buat, edit, hapus, dan cetak invoice profesional.
- **Payment Tracking**: Pelacakan status pembayaran (Paid/Unpaid) dengan tanggal bayar.
- **Revenue Stats**: Dashboard statistik pendapatan real-time.

### 📦 Manajemen Paket Internet
- **Flexible Pricing**: Buat paket dengan harga, kecepatan, dan deskripsi custom.
- **Tax Configuration**: Dukungan pengaturan PPN otomatis.
- **PPPoE Integration**: Mapping profil paket ke profil PPPoE Mikrotik (Placeholder).

### 🎫 Sistem Voucher (Hotspot)
- **Voucher Generator**: Generate ribuan voucher sekaligus dengan prefix custom.
- **Pricing Tiers**: Harga berbeda untuk Customer vs Reseller/Agen.
- **Sales Tracking**: Laporan penjualan voucher harian/bulanan.
- **Agent Portal**: Portal khusus agen untuk topup saldo dan beli voucher (Coming Soon).

### 🛠️ Manajemen Staff & Operasional
- **Teknisi**: Pelacakan area coverage dan penugasan teknisi.
- **Kolektor**: Manajemen kolektor lapangan dengan sistem komisi.
- **Agen**: Manajemen saldo deposit agen dan riwayat transaksi.

### 🌐 Manajemen Jaringan (ODP)
- **ODP Mapping**: Database Optical Distribution Point dengan koordinat GPS.
- **Capacity Planning**: Visualisasi kapasitas port (Terpakai vs Tersedia).
- **Status Monitoring**: Monitor status ODP (Active, Maintenance, Full).

### ⚙️ Pengaturan Sistem
- **Company Profile**: Kustomisasi nama, alamat, dan logo perusahaan pada invoice.
- **Integrasi Payment**: Konfigurasi Midtrans Gateway (Sandbox/Production).
- **WhatsApp Gateway**: Konfigurasi API untuk notifikasi otomatis.

---

## 🔒 Keamanan (Security)

GEMBOK LARA dibangun dengan standar keamanan Laravel yang ketat:

1.  **Authentication**: Menggunakan sistem autentikasi session-based yang aman dengan hashing password **Bcrypt**.
2.  **CSRF Protection**: Semua form dilindungi dari serangan Cross-Site Request Forgery.
3.  **SQL Injection Protection**: Menggunakan Eloquent ORM yang secara otomatis mem-binding parameter query.
4.  **XSS Protection**: Blade templating engine otomatis meng-escape output untuk mencegah Cross-Site Scripting.
5.  **Role-Based Access Control (RBAC)**: Struktur database siap untuk implementasi multi-role (Admin, Teknisi, Kolektor, Pelanggan).
6.  **Input Validation**: Validasi ketat pada setiap input form menggunakan Form Requests.

---

## 🛠️ Instalasi & Setup

Ikuti langkah ini untuk menjalankan aplikasi di lingkungan lokal Anda.

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1.  **Clone Repository**
    ```bash
    git clone https://github.com/username/gembok-lara.git
    cd gembok-lara
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` ke `.env` dan sesuaikan database credentials.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Setup Database**
    Jalankan migrasi dan seeder untuk mengisi data dummy.
    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Build Assets**
    ```bash
    npm run build
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

Akses aplikasi di: `http://localhost:8000`

---

## 🔑 Akun Demo

Gunakan kredensial berikut untuk masuk ke sistem:

| Role | Email | Password |
|------|-------|----------|
| **Administrator** | `admin@gembok.com` | `admin123` |

---

## 📚 Struktur Proyek

- `app/Http/Controllers/Admin`: Logika bisnis utama (Customer, Invoice, dll).
- `app/Models`: Representasi tabel database (Eloquent).
- `resources/views/admin`: Tampilan antarmuka (Blade Templates).
- `routes/web.php`: Definisi routing aplikasi.
- `database/migrations`: Skema database.

---

## 🤝 Kontribusi

Proyek ini dikembangkan sebagai porting dari sistem legacy. Kontribusi untuk fitur baru atau perbaikan bug sangat diterima.

1.  Fork repository ini.
2.  Buat branch fitur (`git checkout -b fitur-baru`).
3.  Commit perubahan (`git commit -m 'Menambah fitur X'`).
4.  Push ke branch (`git push origin fitur-baru`).
5.  Buat Pull Request.

---

**GEMBOK LARA** - _Simplifying ISP Management_
