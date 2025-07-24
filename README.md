# 📚 Laravel 12 - API Manajemen Buku

Proyek ini adalah RESTful API untuk sistem manajemen data buku berbasis **Laravel 12**, yang menerapkan prinsip-prinsip arsitektur yang bersih seperti **Service Layer**, **Repository Pattern**, **Interface Abstraction**, serta penggunaan **Helper**, **Observer**, dan **Error Handling Custom**.

---

## 🚀 Fitur yang Sudah Dibuat

- ✅ CRUD Buku
- ✅ Validasi data dengan Form Request (Store & Update)
- ✅ Autogenerate slug dari judul buku
- ✅ Soft Delete (menghapus tanpa benar-benar hilang dari database)
- ✅ Restore data yang telah dihapus
- ✅ Ambil data berdasarkan `id` maupun `slug`
- ✅ Custom API response dengan `ApiResponse Helper`
- ✅ Error handling dengan try-catch dan HTTP code sesuai konteks
- ✅ Struktur clean code: pakai Service, Repository, Interface
- ✅ Observer untuk handle event otomatis (generate slug saat create/update)

---

## 🧠 Arsitektur & Struktur

### 1. 📁 **Service**
- Lokasi: `App\Services\BukuService.php`
- **Fungsi:** Menjadi perantara antara controller dan repository.
- Menyimpan logika bisnis seperti pengecekan, transformasi data sebelum dikirim ke repository.
  
### 2. 📁 **Repository**
- Lokasi: `App\Repositories\BukuRepository.php`
- **Fungsi:** Abstraksi untuk query database. Menyimpan logika untuk CRUD dan query kompleks.
- Dipanggil oleh Service.

### 3. 📁 **Interface**
- Lokasi: `App\Repositories\Interfaces\BukuRepositoryInterface.php`
- **Fungsi:** Kontrak untuk repository. Membantu menerapkan prinsip *Dependency Inversion* dan mempermudah testing atau perubahan implementasi.

### 4. 📁 **Helper**
- Lokasi: `App\Helpers\ApiResponse.php`
- **Fungsi:** Format response JSON agar konsisten di seluruh API. Digunakan untuk `success()` dan `error()`.

### 5. 📁 **Observer**
- Lokasi: `App\Observers\BukuObserver.php`
- **Fungsi:** Otomatis generate slug berdasarkan judul buku saat `creating` dan `updating`.
- Terdaftar di `App\Providers\AppServiceProvider.php`.

### 6. 📁 **Form Request**
- Lokasi: `App\Http\Requests\StoreBukuRequest.php` dan `UpdateBukuRequest.php`
- **Fungsi:** Validasi data inputan sebelum masuk ke controller.

---

## 🛠️ Cara Menjalankan

```bash
git clone <repo-ini>
cd nama-folder
composer install
cp .env.example .env
php artisan key:generate
