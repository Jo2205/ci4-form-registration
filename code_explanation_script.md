# 💻 Panduan Penjelasan Kode: Technical Deep Dive (Detail)

Panduan ini membantu Anda menjelaskan **setiap detail kode** secara mendalam saat presentasi. Cocok untuk bagian fokus coding.

---

## 📂 Struktur Proyek (Overview)

**Script Penjelasan**:
> "Proyek ini menggunakan pola **MVC (Model-View-Controller)** yang merupakan standar di CodeIgniter 4. Strukturnya seperti ini:"

```
ci4_project/
├── app/
│   ├── Config/
│   │   ├── Routes.php        → Routing (URL mapping)
│   │   └── App.php            → Konfigurasi aplikasi (timezone, dsb)
│   ├── Controllers/
│   │   ├── Login.php          → Logika autentikasi
│   │   ├── Register.php       → Logika pendaftaran
│   │   └── Dashboard.php      → Logika dashboard
│   ├── Models/
│   │   └── UserModel.php      → Interaksi dengan database
│   └── Views/
│       ├── auth/login.php     → Tampilan halaman login
│       ├── auth/register.php  → Tampilan halaman register
│       └── dashboard/index.php → Tampilan dashboard
├── writable/uploads/          → Folder upload foto profil
└── .env                       → Konfigurasi database
```

---

## 1️⃣ Routes: Pintu Masuk Aplikasi

**Lokasi**: `app/Config/Routes.php`

### Penjelasan Konsep
> "Routes adalah peta jalan aplikasi. Setiap URL yang diakses user akan diarahkan ke Controller tertentu."

### Kode Lengkap
```php
<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Home::index');

// Auth Routes
$routes->get('register', 'Register::index');
$routes->post('register/store', 'Register::store');
$routes->get('register/success', 'Register::success');

$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('login/logout', 'Login::logout');

// Dashboard (Protected)
$routes->get('dashboard', 'Dashboard::index');
```

### Penjelasan Line-by-Line

| Route | Method | Artinya |
|-------|--------|---------|
| `$routes->get('register', 'Register::index')` | GET | Ketika user akses `/register`, jalankan fungsi `index()` di `Register` Controller |
| `$routes->post('register/store', 'Register::store')` | POST | Ketika form register di-submit, jalankan fungsi `store()` |
| `$routes->get('login', 'Login::index')` | GET | Menampilkan halaman login |
| `$routes->post('login/authenticate', 'Login::authenticate')` | POST | Memproses login |
| `$routes->get('dashboard', 'Dashboard::index')` | GET | Menampilkan dashboard |

**Talking Point**:
> "Saya memisahkan route GET (menampilkan halaman) dan POST (memproses form). Ini best practice untuk keamanan karena operasi berbahaya seperti insert/update hanya boleh lewat POST."

---

## 2️⃣ Controller: Otak Logika Aplikasi

### A. Register Controller (`app/Controllers/Register.php`)

**Konsep**:
> "Controller ini menangani 3 hal: menampilkan form, validasi input, dan menyimpan ke database."

#### Fungsi 1: `index()` - Menampilkan Form

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

**Penjelasan**:
> "Fungsi ini sederhana: kirim data (title dan validation) ke View. Validation di sini untuk menampilkan error jika ada."

---

#### Fungsi 2: `store()` - Proses Registrasi (INTI)

**Bagian 1: Validation Rules**

```php
$rules = [
    'username' => [
        'rules' => 'required|min_length[5]|max_length[20]|regex_match[/^[a-zA-Z0-9._-]+$/]|is_unique[users.username]',
        'errors' => [
            'required' => 'Username wajib diisi',
            'min_length' => 'Username minimal 5 karakter',
            'max_length' => 'Username maksimal 20 karakter',
            'regex_match' => 'Username hanya boleh huruf, angka, underscore (_), dash (-), dan titik (.)',
            'is_unique' => 'Username sudah digunakan'
        ]
    ],
    'email' => [
        'rules' => 'required|valid_email|is_unique[users.email]',
        'errors' => [
            'required' => 'Email wajib diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah terdaftar'
        ]
    ],
    'password' => [
        'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/]',
        'errors' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 8 karakter',
            'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol (@$!%*?&#)'
        ]
    ],
    'phone' => [
        'rules' => 'required|numeric|min_length[10]|max_length[15]|is_unique[users.phone]|regex_match[/^(\+62|62|0)[0-9]{9,13}$/]',
        'errors' => [
            'required' => 'Nomor telepon wajib diisi',
            'regex_match' => 'Format nomor telepon tidak valid (contoh: 08123456789)'
        ]
    ],
    // ... dan seterusnya
];
```

**Penjelasan Detail**:
> "Ini validation rules yang kompleks. Mari saya jelaskan beberapa yang menarik:"

1. **Username Regex**: `/^[a-zA-Z0-9._-]+$/`
   - `^` = mulai dari awal
   - `[a-zA-Z0-9._-]+` = boleh huruf, angka, titik, underscore, dash
   - `$` = sampai akhir
   - Artinya: username tidak boleh ada karakter aneh seperti spasi atau simbol lain.

2. **Password Regex**: `/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/`
   - `(?=.*[a-z])` = harus ada huruf kecil
   - `(?=.*[A-Z])` = harus ada huruf besar
   - `(?=.*\d)` = harus ada angka
   - `(?=.*[@$!%*?&#])` = harus ada simbol
   - Ini disebut **"lookahead assertion"** dalam regex.

3. **Phone Regex**: `/^(\+62|62|0)[0-9]{9,13}$/`
   - Menerima format: `08xx`, `62xx`, atau `+62xx`

**Talking Point**:
> "Regex ini mungkin terlihat rumit, tapi ini standar industri untuk validasi password kuat. Tujuannya mencegah user pakai password seperti '12345678'."

---

**Bagian 2: Validasi dan Error Handling**

```php
if (!$this->validate($rules)) {
    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
}
```

**Penjelasan**:
> "Jika validasi gagal, user dikembalikan ke form dengan pesan error. `withInput()` membuat data yang sudah diisi tidak hilang, jadi user tidak perlu ketik ulang semua."

---

**Bagian 3: Upload File**

```php
$fileName = null;
$file = $this->request->getFile('profile_picture');

if ($file && $file->isValid() && !$file->hasMoved()) {
    $fileName = $file->getRandomName();
    $file->move(WRITEPATH . 'uploads', $fileName);
}
```

**Penjelasan**:
> "Upload file harus dicek dulu dengan `isValid()` dan `hasMoved()` untuk keamanan. Nama file saya random menggunakan `getRandomName()` agar tidak ada konflik nama dan tidak bisa ditebak hacker."

---

**Bagian 4: Menyimpan ke Database**

```php
$data = [
    'username' => $this->request->getPost('username'),
    'email' => $this->request->getPost('email'),
    'password' => $this->request->getPost('password'),
    'full_name' => $this->request->getPost('full_name'),
    'phone' => $this->request->getPost('phone'),
    'birth_date' => $this->request->getPost('birth_date'),
    'gender' => $this->request->getPost('gender'),
    'profile_picture' => $fileName
];

$this->userModel->insert($data);

return redirect()->to('/register/success')->with('success', 'Registrasi berhasil! Silakan login.');
```

**Penjelasan**:
> "Password masih dalam bentuk plain text di sini, TAPI akan di-hash otomatis oleh Model sebelum disimpan ke database. Nanti saya tunjukkan di bagian Model."

---

### B. Login Controller (`app/Controllers/Login.php`)

#### Fungsi: `authenticate()` - Proses Login

**Kode Lengkap**:
```php
public function authenticate()
{
    // 1. Validasi input
    $rules = [
        'email' => 'required|valid_email',
        'password' => 'required'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // 2. Cari user berdasarkan email
    $user = $this->userModel->where('email', $email)->first();

    if (!$user) {
        return redirect()->back()->withInput()->with('error', 'Email tidak terdaftar');
    }

    // 3. Verifikasi password
    if (!password_verify($password, $user['password'])) {
        return redirect()->back()->withInput()->with('error', 'Password salah');
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

    return redirect()->to('/dashboard')->with('success', 'Login berhasil! Selamat datang ' . $user['full_name']);
}
```

**Penjelasan Step-by-Step**:

1. **Validasi**: "Pastikan email dan password terisi."

2. **Cari User**: 
   ```php
   $user = $this->userModel->where('email', $email)->first();
   ```
   > "Saya pakai Query Builder CodeIgniter. `where()` seperti `WHERE email = '...'` di SQL, dan `first()` mengambil 1 record pertama."

3. **Verifikasi Password** (INI PENTING):
   ```php
   password_verify($password, $user['password'])
   ```
   > "Ini fungsi PHP native untuk mengecek password. Karena password di database sudah di-hash, kita TIDAK BISA pakai `==` untuk bandingkan. Harus pakai `password_verify()`."

4. **Session Management**:
   > "Setelah berhasil, saya simpan data user ke session. Session ini yang membuat user tetap login meskipun pindah halaman."

---

## 3️⃣ Model: Jembatan ke Database

**Lokasi**: `app/Models/UserModel.php`

### Kode Lengkap

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
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

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    // Hash password sebelum disimpan ke database
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
```

### Penjelasan Detail

#### 1. Protected Fields (Keamanan)
```php
protected $allowedFields = ['username', 'email', 'password', ...];
```

**Penjelasan**:
> "Ini disebut **Mass Assignment Protection**. Hanya field di sini yang boleh diisi lewat `insert()` atau `update()`. Jadi kalau hacker coba inject field seperti `is_admin=1`, akan ditolak."

#### 2. Timestamps Otomatis
```php
protected $useTimestamps = true;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
```

**Penjelasan**:
> "CodeIgniter otomatis mengisi `created_at` saat insert dan `updated_at` saat update. Saya tidak perlu coding manual."

#### 3. Callbacks: `beforeInsert` dan `beforeUpdate`
```php
protected $beforeInsert = ['hashPassword'];
protected $beforeUpdate = ['hashPassword'];
```

**Penjelasan**:
> "Ini adalah **Event Hooks**. Sebelum data di-insert atau di-update, fungsi `hashPassword()` akan dipanggil otomatis."

#### 4. Fungsi `hashPassword()` (KUNCI KEAMANAN)
```php
protected function hashPassword(array $data)
{
    if (isset($data['data']['password'])) {
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    }
    return $data;
}
```

**Penjelasan**:
> "Ini yang membuat password otomatis di-hash sebelum masuk database. Jadi meskipun di Controller password masih plain text, begitu sampai Model, langsung di-hash."
>
> "`PASSWORD_DEFAULT` saat ini menggunakan **Bcrypt** dengan cost 10. Algoritma ini sangat lambat (sengaja), jadi hacker butuh waktu lama untuk brute force."

**Talking Point**:
> "Kenapa hash di Model, bukan di Controller? Karena ini prinsip **Separation of Concerns**. Model yang bertanggung jawab atas integritas data."

---

## 4️⃣ View: Antarmuka Pengguna

### A. Register View (`app/Views/auth/register.php`)

**Fokus Penjelasan**: Form + Security

```html
<form action="<?= base_url('register/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <!-- Email Field -->
    <div class="mb-6">
        <label>EMAIL ADDRESS</label>
        <input type="email" name="email" value="<?= old('email') ?>" 
               class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-xl px-4 py-4"
               placeholder="Enter your email">
    </div>
    
    <!-- Password Field -->
    <div class="mb-6">
        <label>PASSWORD</label>
        <input type="password" name="password" 
               class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-xl px-4 py-4"
               placeholder="Create password">
    </div>
    
    <button type="submit" class="btn-glow w-full bg-gradient-to-r from-blue-600 to-purple-600">
        REGISTER NOW
    </button>
</form>
```

**Penjelasan Security**:

1. **CSRF Protection**:
   ```php
   <?= csrf_field() ?>
   ```
   > "Ini generate hidden input dengan token unik. Jadi kalau ada website lain coba submit form ke aplikasi saya, akan ditolak karena tokennya tidak valid."

2. **Old Input**:
   ```php
   value="<?= old('email') ?>"
   ```
   > "Jika ada error, data lama akan tetap muncul. Ini meningkatkan UX."

3. **XSS Prevention** (di output):
   ```php
   <?= esc($user['username']) ?>
   ```
   > "Fungsi `esc()` mengubah karakter khusus seperti `<script>` menjadi HTML entities, jadi tidak bisa dieksekusi sebagai kode."

---

### B. Dashboard View (`app/Views/dashboard/index.php`)

**Fokus Penjelasan**: Session Data + Timezone

```php
<!-- User Info -->
<h2><?= esc($user['full_name']) ?></h2>
<p>@<?= esc($user['username']) ?></p>

<!-- Last Update -->
<p><?= date('d M Y', strtotime($user['updated_at'])) ?></p>
<p><?= date('H:i', strtotime($user['updated_at'])) ?> WIB</p>
```

**Penjelasan**:
> "Data `$user` ini berasal dari session yang di-set saat login. Fungsi `date()` akan mengikuti timezone yang sudah saya set di `app/Config/App.php`."

**Tunjukkan Konfigurasi Timezone**:
```php
// app/Config/App.php
public string $appTimezone = 'Asia/Jakarta';
```

> "Ini membuat semua fungsi waktu di PHP otomatis pakai WIB."

---

## 5️⃣ Konfigurasi Database (`.env`)

**Lokasi**: `.env` (di root project)

```ini
database.default.hostname = localhost
database.default.database = ci4_db
database.default.username = postgres
database.default.password = your_password
database.default.DBDriver = Postgre
database.default.DBPrefix =
database.default.port = 5432
```

**Penjelasan**:
> "File `.env` menyimpan konfigurasi sensitif. File ini **TIDAK BOLEH** di-commit ke GitHub karena berisi password."

---

## 6️⃣ Security Highlights (Rangkuman)

| Aspek | Implementasi | Lokasi |
|-------|-------------|--------|
| **Password Hashing** | Bcrypt (via `password_hash()`) | `UserModel.php` |
| **CSRF Protection** | `<?= csrf_field() ?>` | Semua form |
| **XSS Prevention** | `esc()` pada output | Semua Views |
| **Mass Assignment** | `$allowedFields` | `UserModel.php` |
| **Input Validation** | Regex + Rules | `Register.php` |
| **Session Security** | Built-in CI4 session | `Login.php` |

---

## 💬 Antisipasi Pertanyaan

**Q**: "Kenapa pakai PostgreSQL, bukan MySQL?"
- **A**: "PostgreSQL punya fitur lebih advanced seperti JSON support dan data integrity lebih kuat. Cocok untuk aplikasi skala enterprise."

**Q**: "Berapa lama kode hash password?"
- **A**: "Bcrypt sengaja lambat (~50-100ms) agar sulit di-brute force. Ini trade-off antara keamanan dan performa."

**Q**: "Kenapa tidak pakai AJAX untuk validasi real-time?"
- **A**: "Sebenarnya bisa, tapi untuk scope proyek ini saya fokus pada backend security dulu. AJAX bisa jadi pengembangan berikutnya."

---

## ✅ Tips Presentasi Coding

1. **Jangan Baca Kode**: Jelaskan *apa yang dilakukan*, bukan baca baris per baris.
2. **Gunakan Analogi**: Misal: "Session itu seperti KTP digital yang disimpan browser."
3. **Tunjukkan di Kode Editor**: Buka VS Code saat presentasi agar lebih jelas.
4. **Highlight Regex**: Ini biasanya yang paling ditanya dosen.

---

**Good luck! Semoga penjelasan ini membantu! 🚀**
