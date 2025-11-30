# 🚀 Script Presentasi Teknis: Form Registration System CI4
## **VERSI 2 - Complete Technical Walkthrough**

---

## 📋 **OVERVIEW PRESENTASI**

**Durasi**: 15-20 menit  
**Fokus**: Penjelasan teknis koding dari awal pembuatan sampai jadi  
**Target Audience**: Teman sekelas & Dosen  
**Tujuan**: Mendapatkan nilai bagus dengan demonstrasi yang jelas

---

## 🎬 **OPENING (1 menit)**

### **Yang Disampaikan:**

> "Halo semuanya! Hari ini saya akan mempresentasikan **Form Registration System** yang saya buat menggunakan **CodeIgniter 4** dan **PostgreSQL**. 
>
> Saya akan menjelaskan **proses pembuatan dari awal**, mulai dari setup database, routing, controller logic, validasi kompleks, sampai keamanan aplikasi.
>
> Project ini menerapkan **MVC Architecture**, **Input Validation**, **Password Hashing**, **File Upload**, dan **Session Management**.
>
> Mari kita mulai dari langkah pertama pembuatan."

---

## 📂 **BAGIAN 1: PERSIAPAN & STRUKTUR PROJECT (2 menit)**

### **1.1 Setup Database**

**Screen**: Tunjukkan database PostgreSQL

**Yang Dijelaskan:**

> "Langkah pertama saya membuat database PostgreSQL bernama `ci4_db`. PostgreSQL saya pilih karena lebih robust untuk production dan support data type yang lebih banyak.
>
> Struktur tabel `users` saya design seperti ini:"

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    birth_date DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    profile_picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Penjelasan Detail:**

| Kolom | Type | Alasan |
|-------|------|--------|
| `id SERIAL` | Auto increment | Primary key otomatis naik |
| `password VARCHAR(255)` | 255 karakter | Cukup untuk hash Bcrypt (60 char) + buffer |
| `UNIQUE` constraint | Email, username, phone | Mencegah duplicate data |
| `created_at`, `updated_at` | Timestamp | Audit trail untuk tracking |

**Talking Point:**
> "Kenapa `password` 255 karakter? Karena hash Bcrypt menghasilkan string 60 karakter. Saya beri extra space untuk antisipasi algoritma hash yang lebih panjang di masa depan."

---

### **1.2 Konfigurasi Database**

**Screen**: Tunjukkan file `.env`

**Yang Dijelaskan:**

> "Setelah database dibuat, saya konfigurasi koneksi di file `.env`:"

```ini
database.default.hostname = localhost
database.default.database = ci4_db
database.default.username = postgres
database.default.password = admin123
database.default.DBDriver = Postgre
database.default.port = 5432
```

**Talking Point:**
> "File `.env` ini **tidak boleh di-push ke GitHub** karena berisi kredensial sensitif. Saya sudah tambahkan ke `.gitignore`."

---

### **1.3 Struktur Project MVC**

**Screen**: Tunjukkan struktur folder di VS Code

**Yang Dijelaskan:**

> "Project ini menggunakan pola **MVC (Model-View-Controller)**. Ini adalah separation of concerns dimana:
> - **Model** = Database layer (UserModel.php)
> - **View** = Presentation layer (HTML/PHP files)
> - **Controller** = Business logic (Register.php, Login.php)"

```
app/
├── Config/
│   ├── Routes.php          → URL Routing
│   └── Filters.php         → Security Filters (CSRF)
├── Controllers/
│   ├── Register.php        → Registrasi logic
│   ├── Login.php           → Login/logout logic
│   └── Dashboard.php       → Dashboard logic
├── Models/
│   └── UserModel.php       → Database operations
└── Views/
    ├── auth/
    │   ├── register.php    → Form registrasi
    │   └── login.php       → Form login
    └── dashboard/
        └── index.php       → Dashboard user
```

---

## 🛣️ **BAGIAN 2: ROUTING - PETA JALAN APLIKASI (3 menit)**

**File**: `app/Config/Routes.php`

### **2.1 Konsep Routing**

**Yang Dijelaskan:**

> "Routing adalah **peta jalan aplikasi** yang menentukan URL mana akan diarahkan ke Controller mana.
>
> Saya menggunakan **RESTful convention**: `GET` untuk menampilkan halaman, `POST` untuk submit data."

### **2.2 Penjelasan Setiap Route**

**Screen**: Buka file `Routes.php`

```php
<?php

use CodeIgniter\Router\RouteCollection;

// 1. Homepage
$routes->get('/', 'Home::index');

// 2. Registration Flow
$routes->get('register', 'Register::index');           // Tampilkan form
$routes->post('register/store', 'Register::store');    // Proses data
$routes->get('register/success', 'Register::success'); // Halaman sukses

// 3. Login Flow
$routes->get('login', 'Login::index');                 // Tampilkan form
$routes->post('login/authenticate', 'Login::authenticate'); // Proses login
$routes->get('login/logout', 'Login::logout');         // Logout

// 4. Dashboard (Protected)
$routes->get('dashboard', 'Dashboard::index');
```

**Penjelasan Per Route:**

| URL | HTTP Method | Controller | Method | Fungsi |
|-----|-------------|-----------|--------|--------|
| `/` | GET | Home | index() | Halaman utama/welcome |
| `/register` | GET | Register | index() | Tampilkan form registrasi |
| `/register/store` | POST | Register | store() | **Proses & validasi data registrasi** ⭐ |
| `/register/success` | GET | Register | success() | Halaman konfirmasi sukses |
| `/login` | GET | Login | index() | Tampilkan form login |
| `/login/authenticate` | POST | Login | authenticate() | **Proses login & verifikasi** ⭐ |
| `/login/logout` | GET | Login | logout() | Hapus session & logout |
| `/dashboard` | GET | Dashboard | index() | Dashboard user setelah login |

**Demonstrasi Flow:**

**Screen**: Gambar diagram atau whiteboard

```
User Journey:
┌─────────────┐    GET      ┌──────────────┐
│   Browser   │ ────────────→│ /register    │
└─────────────┘              └──────────────┘
                                    │
                                    ▼
                         Tampilkan Form Register
                                    │
                              User isi form
                                    │
                                    ▼
                    POST /register/store
                         (Validasi + Simpan)
                                    │
                                    ▼
                         GET /register/success
                         (Redirect ke halaman sukses)
```

**Talking Point:**
> "Perhatikan saya pisahkan route `GET` dan `POST`. Ini best practice untuk keamanan karena operasi write (insert/update) hanya boleh lewat `POST`, tidak bisa lewat URL."

---

## 🎯 **BAGIAN 3: MODEL - DATABASE LAYER (3 menit)**

**File**: `app/Models/UserModel.php`

### **3.1 Pengenalan Model**

**Yang Dijelaskan:**

> "Model adalah **jembatan antara Controller dan Database**. Model ini extend dari `CodeIgniter\Model` yang sudah punya built-in features seperti CRUD, validation, dan callbacks."

### **3.2 Struktur UserModel**

**Screen**: Buka `UserModel.php`

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // 1. Table Configuration
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // 2. Mass Assignment Protection
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'password',
        'full_name',
        'phone',
        'birth_date',
        'gender',
        'profile_picture'
    ];

    // 3. Automatic Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // 4. Model Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    // 5. Hash Password Function
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'], 
                PASSWORD_DEFAULT
            );
        }
        return $data;
    }
}
```

### **3.3 Penjelasan Detail Setiap Bagian**

#### **A. Mass Assignment Protection** ⭐ PENTING

```php
protected $allowedFields = ['username', 'email', 'password', ...];
```

**Yang Dijelaskan:**

> "Ini adalah **security feature** yang sangat penting. Hanya field yang ada di array ini yang bisa diisi lewat `insert()` atau `update()`.
>
> Contoh: Kalau ada hacker inject `is_admin=1` lewat form, tetap akan ditolak karena `is_admin` tidak ada di `$allowedFields`.
>
> Ini mencegah serangan **Mass Assignment Vulnerability**."

#### **B. Automatic Timestamps**

```php
protected $useTimestamps = true;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
```

**Yang Dijelaskan:**

> "Dengan setting ini, CodeIgniter **otomatis mengisi**:
> - `created_at` saat insert data
> - `updated_at` saat update data
>
> Saya tidak perlu coding manual untuk tracking waktu."

#### **C. Model Callbacks (Event Hooks)** ⭐ FITUR UTAMA

```php
protected $beforeInsert = ['hashPassword'];
protected $beforeUpdate = ['hashPassword'];
```

**Yang Dijelaskan:**

> "Ini adalah **Event Hooks**. Sebelum data masuk ke database (insert/update), fungsi `hashPassword()` akan dipanggil otomatis.
>
> Jadi **password otomatis di-hash tanpa Controller perlu tahu**. Ini adalah prinsip **Separation of Concerns**."

#### **D. Password Hashing Function** ⭐ KEAMANAN UTAMA

```php
protected function hashPassword(array $data)
{
    if (isset($data['data']['password'])) {
        $data['data']['password'] = password_hash(
            $data['data']['password'], 
            PASSWORD_DEFAULT
        );
    }
    return $data;
}
```

**Demonstrasi:**

**Screen**: Buka pgAdmin dan tunjukkan data password yang sudah ter-hash

**Yang Dijelaskan:**

> "Fungsi `password_hash()` menggunakan algoritma **Bcrypt** dengan default cost factor 10.
>
> Contoh transformasi:
> - Input: `Password123!`
> - Output (di database): `$2y$10$AbCd...xyz` (60 karakter)
>
> Bcrypt sengaja **lambat** (~50-100ms per hash) agar sulit di-brute force. Ini trade-off antara security dan performance."

**Talking Point:**
> "Kenapa tidak pakai MD5 atau SHA1? Karena algoritma itu terlalu cepat dan mudah di-crack. Bcrypt adalah industry standard untuk password hashing."

---

## 🎛️ **BAGIAN 4: CONTROLLER - BUSINESS LOGIC (5 menit)**

### **4.1 Register Controller - Proses Registrasi**

**File**: `app/Controllers/Register.php`

#### **Method 1: `index()` - Tampilkan Form**

```php
public function index()
{
    $data = [
        'title' => 'Form Registrasi User',
        'validation' => \Config\Services::validation()
    ];

    return view('auth/register', $data);
}
```

**Yang Dijelaskan:**

> "Method ini sederhana: kirim data title dan validation object ke View. Validation object ini untuk menampilkan error message jika ada."

---

#### **Method 2: `store()` - INTI PROSES REGISTRASI** ⭐⭐⭐

**Yang Dijelaskan:**

> "Ini adalah **method terpenting** dalam registrasi. Ada 4 tahap utama:
> 1. Validasi input
> 2. Upload file (optional)
> 3. Simpan ke database
> 4. Redirect ke success page
>
> Mari kita bahas satu per satu."

##### **TAHAP 1: Validation Rules** (FOCUS UTAMA)

**Screen**: Buka `Register.php` method `store()`

```php
$rules = [
    'username' => [
        'rules' => 'required|min_length[5]|max_length[20]|regex_match[/^[a-zA-Z0-9._-]+$/]|is_unique[users.username]',
        'errors' => [
            'required' => 'Username wajib diisi',
            'min_length' => 'Username minimal 5 karakter',
            'max_length' => 'Username maksimal 20 karakter',
            'regex_match' => 'Username hanya boleh huruf, angka, underscore, dash, dan titik',
            'is_unique' => 'Username sudah digunakan'
        ]
    ],
    'password' => [
        'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&#])[A-Za-z\\d@$!%*?&#]{8,}$/]',
        'errors' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 8 karakter',
            'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol'
        ]
    ],
    'phone' => [
        'rules' => 'required|numeric|min_length[10]|max_length[15]|is_unique[users.phone]|regex_match[/^(\\+62|62|0)[0-9]{9,13}$/]',
        'errors' => [
            'required' => 'Nomor telepon wajib diisi',
            'regex_match' => 'Format nomor Indonesia tidak valid'
        ]
    ],
    // ... field lainnya
];
```

**Penjelasan Regex (PALING SERING DITANYA):**

##### **A. Username Regex**

```regex
/^[a-zA-Z0-9._-]+$/
```

**Breakdown:**

| Bagian | Artinya |
|--------|---------|
| `^` | Mulai dari awal string |
| `[a-zA-Z0-9._-]` | Karakter yang diperbolehkan: huruf, angka, titik, underscore, dash |
| `+` | Minimal 1 karakter, bisa lebih |
| `$` | Sampai akhir string |

**Contoh:**
- ✅ Valid: `john_doe`, `user.123`, `admin-2024`
- ❌ Invalid: `john doe` (ada spasi), `user@123` (ada @)

---

##### **B. Password Regex** ⭐ PALING KOMPLEKS

```regex
/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/
```

**Breakdown:**

| Bagian | Artinya |
|--------|---------|
| `(?=.*[a-z])` | **Lookahead**: Harus ada minimal 1 huruf kecil |
| `(?=.*[A-Z])` | **Lookahead**: Harus ada minimal 1 huruf besar |
| `(?=.*\d)` | **Lookahead**: Harus ada minimal 1 angka |
| `(?=.*[@$!%*?&#])` | **Lookahead**: Harus ada minimal 1 simbol |
| `[A-Za-z\d@$!%*?&#]{8,}` | Karakter yang boleh, minimal 8 karakter |

**Demonstrasi Live:**

**Screen**: Buka aplikasi dan test password

| Password | Valid? | Alasan |
|----------|--------|--------|
| `Password` | ❌ | Tidak ada angka & simbol |
| `password123` | ❌ | Tidak ada huruf besar & simbol |
| `Password123` | ❌ | Tidak ada simbol |
| `Password123!` | ✅ | Memenuhi semua kriteria |

**Talking Point:**
> "Regex ini disebut **Positive Lookahead Assertion**. Ini adalah teknik advanced regex untuk memvalidasi password kompleks. Standard ini dipakai oleh banyak website besar seperti Google dan Facebook."

---

##### **C. Phone Number Regex (Indonesia)**

```regex
/^(\+62|62|0)[0-9]{9,13}$/
```

**Breakdown:**

| Bagian | Artinya |
|--------|---------|
| `(\+62|62|0)` | Awalan: `+62` atau `62` atau `0` |
| `[0-9]{9,13}` | Diikuti 9-13 digit angka |

**Contoh:**
- ✅ `08123456789`
- ✅ `628123456789`
- ✅ `+628123456789`
- ❌ `8123456789` (tidak ada awalan)

---

##### **TAHAP 2: Validasi & Error Handling**

```php
if (!$this->validate($rules)) {
    return redirect()
        ->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
}
```

**Yang Dijelaskan:**

> "Jika validasi gagal:
> 1. `->back()` = kembali ke form
> 2. `->withInput()` = data yang sudah diisi tidak hilang (UX bagus!)
> 3. `->with('errors', ...)` = kirim error message ke view
>
> Ini membuat user tidak perlu isi ulang semua field kalau ada error."

---

##### **TAHAP 3: File Upload**

```php
$fileName = null;
$file = $this->request->getFile('profile_picture');

if ($file && $file->isValid() && !$file->hasMoved()) {
    $fileName = $file->getRandomName();
    $file->move(WRITEPATH . 'uploads', $fileName);
}
```

**Yang Dijelaskan:**

> "Upload file harus dicek dengan:
> - `isValid()` → Pastikan file tidak corrupt
> - `hasMoved()` → Pastikan belum pernah di-upload
> - `getRandomName()` → Generate nama random untuk keamanan
>
> Nama random mencegah:
> 1. Konflik filename
> 2. Path traversal attack
> 3. Overwrite file yang sudah ada"

**Contoh:**
- Original: `photo.jpg`
- Random: `1732981234_abc123def456.jpg`

---

##### **TAHAP 4: Simpan ke Database**

```php
$data = [
    'username' => $this->request->getPost('username'),
    'email' => $this->request->getPost('email'),
    'password' => $this->request->getPost('password'), // Masih plain text
    'full_name' => $this->request->getPost('full_name'),
    'phone' => $this->request->getPost('phone'),
    'birth_date' => $this->request->getPost('birth_date'),
    'gender' => $this->request->getPost('gender'),
    'profile_picture' => $fileName
];

$this->userModel->insert($data);

return redirect()->to('/register/success')->with('success', 'Registrasi berhasil!');
```

**Yang Dijelaskan:**

> "Perhatikan password masih plain text di sini. TAPI begitu sampai Model, otomatis di-hash oleh callback `beforeInsert`.
>
> Setelah sukses insert, redirect ke halaman success dengan flash message."

---

### **4.2 Login Controller - Autentikasi**

**File**: `app/Controllers/Login.php`

#### **Method: `authenticate()`** ⭐ PROSES LOGIN

```php
public function authenticate()
{
    // 1. Validasi input
    $rules = [
        'email' => 'required|valid_email',
        'password' => 'required'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // 2. Cari user berdasarkan email
    $user = $this->userModel->where('email', $email)->first();

    if (!$user) {
        return redirect()->back()->withInput()
            ->with('error', 'Email tidak terdaftar');
    }

    // 3. Verifikasi password
    if (!password_verify($password, $user['password'])) {
        return redirect()->back()->withInput()
            ->with('error', 'Password salah');
    }

    // 4. Set session
    $sessionData = [
        'user_id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'full_name' => $user['full_name'],
        'profile_picture' => $user['profile_picture'],
        'logged_in' => true
    ];

    session()->set($sessionData);

    return redirect()->to('/dashboard')
        ->with('success', 'Login berhasil! Selamat datang ' . $user['full_name']);
}
```

**Penjelasan 4 Tahap Login:**

#### **Tahap 1: Validasi**
> "Pastikan email dan password terisi."

#### **Tahap 2: Query Database**

```php
$user = $this->userModel->where('email', $email)->first();
```

**Yang Dijelaskan:**

> "Ini menggunakan **Query Builder** CodeIgniter. Dibelakang layar jadi:
>
> ```sql
> SELECT * FROM users WHERE email = ? LIMIT 1
> ```
>
> Parameter di-bind otomatis, jadi **aman dari SQL Injection**."

#### **Tahap 3: Password Verification** ⭐ KRUSIAL

```php
password_verify($password, $user['password'])
```

**Demonstrasi:**

**Screen**: Tunjukkan di pgAdmin password yang ter-hash

**Yang Dijelaskan:**

> "Karena password di database sudah di-hash, kita **TIDAK BISA** pakai `==` untuk compare.
>
> Contoh:
> - Input user: `Password123!`
> - Di database: `$2y$10$AbCdEf...xyz`
>
> Fungsi `password_verify()` akan:
> 1. Hash input password dengan salt yang sama
> 2. Compare kedua hash
> 3. Return true jika cocok
>
> Ini adalah fungsi native PHP yang secure."

#### **Tahap 4: Session Management**

```php
$sessionData = [
    'user_id' => $user['id'],
    'username' => $user['username'],
    // ...
    'logged_in' => true
];

session()->set($sessionData);
```

**Yang Dijelaskan:**

> "Session adalah **data temporary** yang disimpan di server dan di-link ke browser user lewat cookie.
>
> Dengan session ini:
> - User tetap login meskipun pindah halaman
> - Kita bisa cek `session('logged_in')` untuk proteksi halaman
> - Data user bisa diakses di seluruh aplikasi
>
> Session otomatis expire setelah user tutup browser atau timeout (default 2 jam)."

---

## 🖼️ **BAGIAN 5: VIEW - FRONTEND (2 menit)**

**File**: `app/Views/auth/register.php`

### **5.1 Form Structure & Security**

```html
<form action="<?= base_url('register/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <!-- Email Field -->
    <input type="email" name="email" value="<?= old('email') ?>">
    
    <!-- Error Display -->
    <?php if (isset(session('errors')['email'])): ?>
        <p class="text-red-400"><?= session('errors')['email'] ?></p>
    <?php endif; ?>
</form>
```

### **5.2 Security Features di View**

#### **A. CSRF Protection**

```php
<?= csrf_field() ?>
```

**Yang Dijelaskan:**

> "Ini generate hidden input dengan token random. Tanpa token ini, form tidak bisa di-submit.
>
> Contoh output:
> ```html
> <input type=\"hidden\" name=\"csrf_token\" value=\"a1b2c3d4e5f6...\">
> ```
>
> Ini mencegah **CSRF Attack** dimana website lain mencoba submit form ke aplikasi kita."

#### **B. Old Input (UX Enhancement)**

```php
value="<?= old('email') ?>"
```

**Yang Dijelaskan:**

> "Jika validasi gagal, data yang sudah diisi tetap muncul. User tidak perlu ketik ulang semua field."

#### **C. XSS Prevention**

```php
<?= esc($user['username']) ?>
```

**Yang Dijelaskan:**

> "Fungsi `esc()` mengubah karakter khusus jadi HTML entities.
>
> Contoh:
> - Input: `<script>alert('hack')</script>`
> - Output: `&lt;script&gt;alert('hack')&lt;/script&gt;`
>
> Browser tidak akan execute sebagai kode, hanya tampilkan sebagai text."

---

## 🔐 **BAGIAN 6: SECURITY SUMMARY (2 menit)**

**Screen**: Tunjukkan tabel ringkasan

### **Fitur Keamanan yang Diimplementasikan**

| #  | Aspek Keamanan | Implementasi | Lokasi | Status |
|----|----------------|--------------|--------|--------|
| 1  | **Password Hashing** | Bcrypt (cost 10) | `UserModel.php` | ✅ |
| 2  | **SQL Injection Protection** | Query Builder (Prepared Statements) | `UserModel.php`, Controllers | ✅ |
| 3  | **CSRF Protection** | Token di setiap form | `register.php`, `login.php` | ✅ |
| 4  | **XSS Prevention** | `esc()` helper | Semua Views | ✅ |
| 5  | **Mass Assignment Protection** | `$allowedFields` | `UserModel.php` | ✅ |
| 6  | **Input Validation** | Complex Regex Rules | `Register.php` | ✅ |
| 7  | **Session Security** | Built-in CI4 Session | `Login.php` | ✅ |
| 8  | **File Upload Security** | `isValid()`, random filename | `Register.php` | ✅ |

**Talking Point:**
> "Keamanan adalah prioritas utama. Saya implement 8 security layers untuk memastikan aplikasi ini production-ready."

---

## 🎯 **BAGIAN 7: DEMONSTRASI LIVE (3 menit)**

### **Demo 1: Registrasi User Baru**

**Action Steps:**

1. **Buka browser**: `http://localhost:8080/register`
2. **Isi form dengan data invalid**:
   - Username: `ab` (terlalu pendek)
   - Password: `123` (tidak memenuhi kriteria)
   - Phone: `123` (format salah)
3. **Submit** → Tunjukkan error message
4. **Isi ulang dengan data valid** → Submit sukses
5. **Buka pgAdmin** → Tunjukkan data tersimpan dengan password ter-hash

### **Demo 2: Login**

1. **Login dengan email yang baru didaftar**
2. **Tunjukkan redirect ke dashboard**
3. **Tunjukkan data user di dashboard**
4. **Klik logout** → Redirect ke login page

### **Demo 3: Security Test**

**SQL Injection Test:**
- Input di email field: `test@test.com' OR '1'='1`
- Tunjukkan: Tidak berhasil karena prepared statements

**XSS Test:**
- Register dengan username: `<script>alert('XSS')</script>`
- Tunjukkan di dashboard: Hanya tampil sebagai text, tidak execute

---

## 💡 **BAGIAN 8: TANTANGAN & SOLUSI (1 menit)**

### **Tabel Challenges**

| Tantangan | Solusi | Pembelajaran |
|-----------|--------|--------------|
| **Regex Password Kompleks** | Pakai lookahead assertion `(?=...)` | Advanced regex untuk multiple kondisi |
| **Password Hashing di Model** | Gunakan Model Callbacks (`beforeInsert`) | Separation of Concerns |
| **File Upload Validation** | `isValid()`, `hasMoved()`, random name | Security best practice |
| **Session Persistence** | CI4 built-in session management | Framework features |

---

## 🎓 **BAGIAN 9: KESIMPULAN & LEARNING OUTCOMES (1 menit)**

**Yang Disampaikan:**

> "Dari project ini, saya belajar:
>
> 1. **MVC Architecture** untuk memisahkan logika aplikasi
> 2. **Advanced Validation** dengan regex kompleks
> 3. **Security Best Practices**: password hashing, CSRF, XSS prevention
> 4. **Database Design** dengan constraints dan indexing
> 5. **Session Management** untuk autentikasi user
>
> Project ini sudah **production-ready** dengan security yang solid.
>
> Terima kasih! Ada pertanyaan?"

---

## ❓ **ANTISIPASI PERTANYAAN (Backup)**

### **Q1: Kenapa pakai PostgreSQL, bukan MySQL?**

**Jawaban:**
> "PostgreSQL punya fitur lebih advanced:
> - Support JSON data type (untuk data kompleks)
> - Constraint checking lebih ketat (data integrity lebih baik)
> - Performance untuk query kompleks lebih optimal
> - Open source penuh tanpa lisensi enterprise
>
> Cocok untuk aplikasi yang akan scale up di masa depan."

---

### **Q2: Berapa lama proses hash password?**

**Jawaban:**
> "Bcrypt dengan cost 10 memakan waktu sekitar 50-100 milliseconds per hash.
>
> Ini memang **sengaja lambat** agar sulit di-brute force. Trade-off antara keamanan dan performa.
>
> Untuk user experience, delay 100ms saat registrasi/login itu acceptable."

---

### **Q3: Apakah bisa tambah fitur forgot password?**

**Jawaban:**
> "Bisa! Prosesnya:
> 1. User input email
> 2. Generate token random (UUID)
> 3. Simpan token + expiry time ke tabel `password_resets`
> 4. Kirim email dengan link reset (token di URL)
> 5. User klik link, input password baru
> 6. Validate token, update password
>
> Ini bisa jadi enhancement di versi berikutnya."

---

### **Q4: Bagaimana cara deploy ke production?**

**Jawaban:**
> "Step deployment:
> 1. Set `CI_ENVIRONMENT = production` di `.env`
> 2. Aktifkan HTTPS (force HTTPS di `Filters.php`)
> 3. Ganti database ke production server
> 4. Disable debug mode
> 5. Deploy ke VPS (seperti DigitalOcean, AWS, atau Heroku)
> 6. Setup SSL certificate (Let's Encrypt gratis)
>
> CodeIgniter 4 sudah production-ready, tinggal konfigurasi."

---

### **Q5: Kenapa tidak pakai framework JavaScript seperti React?**

**Jawaban:**
> "Untuk scope project ini, saya fokus pada:
> - Backend security & validation
> - Database design
> - Server-side rendering
>
> React/Vue bisa ditambahkan nanti untuk:
> - Real-time validation (AJAX)
> - Single Page Application (SPA)
> - Better UX dengan client-side rendering
>
> Tapi untuk MVP (Minimum Viable Product), server-side rendering sudah cukup dan lebih SEO-friendly."

---

## ✅ **CHECKLIST PRESENTASI**

**Sebelum Presentasi:**
- [ ] Pastikan server running: `php spark serve`
- [ ] Database PostgreSQL aktif
- [ ] Buka VS Code dengan file yang relevan
- [ ] Buka browser dengan tab: localhost:8080, pgAdmin
- [ ] Siapkan dummy data untuk demo
- [ ] Test demo flow 1x (registrasi + login)

**Saat Presentasi:**
- [ ] Jelaskan konsep dulu, baru tunjukkan kode
- [ ] Gunakan analogi untuk konsep teknis
- [ ] Tunjukkan diagram flow user journey
- [ ] Demo live untuk setiap fitur
- [ ] Highlight bagian kompleks (regex, password hashing)
- [ ] Tunjukkan database untuk proof

**Tips Tambahan:**
- Jangan baca kode baris per baris
- Fokus pada **WHY** (kenapa pakai teknik ini)
- Siapkan backup answer untuk pertanyaan umum
- Percaya diri dan maintain eye contact

---

## 🎬 **PENUTUP**

**Script Closing:**

> "Sebagai penutup, project Form Registration ini menunjukkan kemampuan saya dalam:
> - **Backend Development** dengan CodeIgniter 4
> - **Database Management** dengan PostgreSQL
> - **Security Implementation** dengan multiple layers
> - **Clean Code** dengan MVC architecture
>
> Saya siap untuk pertanyaan atau diskusi lebih lanjut. Terima kasih!"

---

**Good luck dengan presentasinya! 🚀**

**Total waktu ideal: 15-20 menit + 5 menit Q&A**
