<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: #667eea;
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .required {
            color: red;
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .invalid-feedback {
            display: block;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                <h2><?= $title ?></h2>
                <p class="text-muted">Silakan lengkapi form di bawah ini</p>
            </div>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i> Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="fas fa-user"></i> Username <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>"
                        id="username" name="username" value="<?= old('username') ?>"
                        placeholder="Masukkan username (5-20 karakter, huruf & angka)">
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                    </label>
                    <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>"
                        id="email" name="email" value="<?= old('email') ?>"
                        placeholder="contoh@email.com">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email') ?>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>"
                            id="password" name="password"
                            placeholder="Min 8 karakter (huruf besar, kecil, angka, simbol)">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                    <small class="text-muted">Harus mengandung: huruf besar, huruf kecil, angka, dan simbol (@$!%*?&#)</small>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">
                        <i class="fas fa-lock"></i> Konfirmasi Password <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>"
                            id="confirm_password" name="confirm_password"
                            placeholder="Ulangi password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                            <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                        </button>
                        <div class="invalid-feedback">
                            <?= $validation->getError('confirm_password') ?>
                        </div>
                    </div>
                </div>

                <!-- Full Name -->
                <div class="mb-3">
                    <label for="full_name" class="form-label">
                        <i class="fas fa-id-card"></i> Nama Lengkap <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control <?= $validation->hasError('full_name') ? 'is-invalid' : '' ?>"
                        id="full_name" name="full_name" value="<?= old('full_name') ?>"
                        placeholder="Masukkan nama lengkap">
                    <div class="invalid-feedback">
                        <?= $validation->getError('full_name') ?>
                    </div>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone"></i> Nomor Telepon <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>"
                        id="phone" name="phone" value="<?= old('phone') ?>"
                        placeholder="08123456789">
                    <div class="invalid-feedback">
                        <?= $validation->getError('phone') ?>
                    </div>
                </div>

                <!-- Birth Date -->
                <div class="mb-3">
                    <label for="birth_date" class="form-label">
                        <i class="fas fa-calendar"></i> Tanggal Lahir <span class="required">*</span>
                    </label>
                    <input type="date" class="form-control <?= $validation->hasError('birth_date') ? 'is-invalid' : '' ?>"
                        id="birth_date" name="birth_date" value="<?= old('birth_date') ?>"
                        max="<?= date('Y-m-d', strtotime('-17 years')) ?>">
                    <small class="text-muted">Minimal umur 17 tahun</small>
                    <div class="invalid-feedback">
                        <?= $validation->getError('birth_date') ?>
                    </div>
                </div>

                <!-- Gender -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-venus-mars"></i> Jenis Kelamin <span class="required">*</span>
                    </label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?= $validation->hasError('gender') ? 'is-invalid' : '' ?>"
                                type="radio" name="gender" id="male" value="Laki-laki"
                                <?= old('gender') == 'Laki-laki' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="male">
                                <i class="fas fa-mars"></i> Laki-laki
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?= $validation->hasError('gender') ? 'is-invalid' : '' ?>"
                                type="radio" name="gender" id="female" value="Perempuan"
                                <?= old('gender') == 'Perempuan' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="female">
                                <i class="fas fa-venus"></i> Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <?= $validation->getError('gender') ?>
                    </div>
                </div>

                <!-- Profile Picture -->
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">
                        <i class="fas fa-image"></i> Foto Profil <span class="required">*</span>
                    </label>
                    <input type="file" class="form-control <?= $validation->hasError('profile_picture') ? 'is-invalid' : '' ?>"
                        id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    <div class="invalid-feedback">
                        <?= $validation->getError('profile_picture') ?>
                    </div>
                    <div class="mt-2" id="imagePreview"></div>
                </div>

                <!-- Terms & Conditions -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input <?= $validation->hasError('terms') ? 'is-invalid' : '' ?>"
                            type="checkbox" name="terms" id="terms" value="1"
                            <?= old('terms') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">syarat dan ketentuan</a> <span class="required">*</span>
                        </label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('terms') ?>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-register">
                    <i class="fas fa-user-check"></i> Daftar Sekarang
                </button>

                <div class="text-center mt-3">
                    <small>Sudah punya akun? <a href="#">Login disini</a></small>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Terms & Conditions -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Syarat dan Ketentuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Dengan mendaftar, Anda menyetujui:</p>
                    <ul>
                        <li>Data yang Anda berikan adalah benar dan valid</li>
                        <li>Anda bertanggung jawab atas keamanan akun Anda</li>
                        <li>Kami berhak memproses data Anda sesuai kebijakan privasi</li>
                        <li>Anda berusia minimal 17 tahun</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('toggle' + fieldId.charAt(0).toUpperCase() + fieldId.slice(1) + 'Icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Preview Image
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>