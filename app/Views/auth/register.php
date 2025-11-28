<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Orbitron:wght@500;700;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'JetBrains Mono', monospace;
        }

        .title-font {
            font-family: 'Orbitron', sans-serif;
        }

        body {
            background: #0a0e27;
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(6, 182, 212, 0.05) 0px, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
        }

        .input-glow:focus {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }

        .btn-glow {
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.5);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 40px rgba(168, 85, 247, 0.8);
            transform: translateY(-2px);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slideDown 0.5s ease-out;
        }

        .cyber-border {
            position: relative;
            z-index: 1;
        }

        input,
        select,
        textarea,
        button {
            position: relative;
            z-index: 2;
        }

        .main-content {
            position: relative;
            z-index: 1;
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        cyber: {
                            primary: '#3b82f6',
                            secondary: '#a855f7',
                            accent: '#06b6d4',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="flex items-center justify-center p-4 min-h-screen">

    <div class="w-full max-w-4xl main-content">
        <!-- Header -->
        <div class="text-center mb-8 animate-slide-down">
            <div class="inline-block mb-4">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 rounded-2xl flex items-center justify-center transform rotate-6 hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-user-astronaut text-4xl text-white"></i>
                </div>
            </div>
            <h1 class="title-font text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-cyan-400 mb-2">
                REGISTER SYSTEM
            </h1>
            <p class="text-gray-400 text-sm tracking-wider">// Initialize new user profile</p>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-2xl p-8 animate-slide-down" style="animation-delay: 0.2s">
            <form action="<?= base_url('register/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Username -->
                    <div class="cyber-border">
                        <label class="block text-cyan-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-user text-cyan-500"></i> USERNAME <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" value="<?= old('username') ?>"
                            class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['username']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 transition-all"
                            placeholder="Enter username">
                        <?php if (isset(session('errors')['username'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['username'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">5-20 characters, alphanumeric only</p>
                        <?php endif; ?>
                    </div>

                    <!-- Email -->
                    <div class="cyber-border">
                        <label class="block text-cyan-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-envelope text-cyan-500"></i> EMAIL <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="<?= old('email') ?>"
                            class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['email']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 transition-all"
                            placeholder="user@example.com">
                        <?php if (isset(session('errors')['email'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['email'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Must be a valid email address</p>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div class="cyber-border">
                        <label class="block text-purple-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-lock text-purple-500"></i> PASSWORD <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['password']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-purple-500 transition-all"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-400">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <?php if (isset(session('errors')['password'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['password'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Min 8 chars: A-Z, a-z, 0-9, @$!%*?&#</p>
                        <?php endif; ?>
                    </div>

                    <!-- Confirm Password -->
                    <div class="cyber-border">
                        <label class="block text-purple-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-lock text-purple-500"></i> CONFIRM PASSWORD <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="confirm_password" name="confirm_password"
                                class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['confirm_password']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-purple-500 transition-all"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('confirm_password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-400">
                                <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                            </button>
                        </div>
                        <?php if (isset(session('errors')['confirm_password'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['confirm_password'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Must match password above</p>
                        <?php endif; ?>
                    </div>

                    <!-- Full Name -->
                    <div class="cyber-border">
                        <label class="block text-blue-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-id-card text-blue-500"></i> FULL NAME <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="full_name" value="<?= old('full_name') ?>"
                            class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['full_name']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition-all"
                            placeholder="John Doe">
                        <?php if (isset(session('errors')['full_name'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['full_name'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Letters and spaces only</p>
                        <?php endif; ?>
                    </div>

                    <!-- Phone -->
                    <div class="cyber-border">
                        <label class="block text-blue-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-phone text-blue-500"></i> PHONE NUMBER <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" value="<?= old('phone') ?>"
                            class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['phone']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition-all"
                            placeholder="08123456789">
                        <?php if (isset(session('errors')['phone'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['phone'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Indonesian format: 08xxxxxxxxxx</p>
                        <?php endif; ?>
                    </div>

                    <!-- Birth Date (Bisa diketik manual) -->
                    <div class="cyber-border">
                        <label class="block text-green-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-calendar text-green-500"></i> BIRTH DATE <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="birth_date" value="<?= old('birth_date') ?>"
                            placeholder="YYYY-MM-DD (e.g., 2000-01-15)"
                            class="input-glow w-full bg-gray-900/50 border <?= isset(session('errors')['birth_date']) ? 'border-red-500' : 'border-gray-700' ?> text-white rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 transition-all">
                        <?php if (isset(session('errors')['birth_date'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['birth_date'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Format: YYYY-MM-DD, Min age: 17 years</p>
                        <?php endif; ?>
                    </div>

                    <!-- Gender -->
                    <div class="cyber-border">
                        <label class="block text-green-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-venus-mars text-green-500"></i> GENDER <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4 mt-3">
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="gender" value="Laki-laki" <?= old('gender') == 'Laki-laki' ? 'checked' : '' ?>
                                    class="w-5 h-5 text-blue-500 bg-gray-900 border-gray-700 focus:ring-blue-500">
                                <span class="text-gray-300 group-hover:text-blue-400 transition-colors">
                                    <i class="fas fa-mars text-blue-400"></i> Male
                                </span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="gender" value="Perempuan" <?= old('gender') == 'Perempuan' ? 'checked' : '' ?>
                                    class="w-5 h-5 text-pink-500 bg-gray-900 border-gray-700 focus:ring-pink-500">
                                <span class="text-gray-300 group-hover:text-pink-400 transition-colors">
                                    <i class="fas fa-venus text-pink-400"></i> Female
                                </span>
                            </label>
                        </div>
                        <?php if (isset(session('errors')['gender'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['gender'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-1">Select your gender</p>
                        <?php endif; ?>
                    </div>

                    <!-- Profile Picture (OPTIONAL) -->
                    <div class="col-span-1 md:col-span-2 cyber-border">
                        <label class="block text-yellow-400 text-sm font-semibold mb-2 tracking-wide">
                            <i class="fas fa-image text-yellow-500"></i> PROFILE PICTURE <span class="text-gray-500">(Optional)</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" onchange="previewImage(this)"
                                class="hidden">
                            <label for="profile_picture"
                                class="flex items-center justify-center w-full bg-gray-900/50 border-2 border-dashed <?= isset(session('errors')['profile_picture']) ? 'border-red-500' : 'border-gray-700' ?> rounded-xl px-4 py-6 cursor-pointer hover:border-yellow-500 transition-all group">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-600 group-hover:text-yellow-500 transition-colors mb-2"></i>
                                    <p class="text-gray-400 group-hover:text-yellow-400 transition-colors">
                                        Click to upload or drag and drop
                                    </p>
                                </div>
                            </label>
                        </div>
                        <div class="mt-3" id="imagePreview"></div>
                        <?php if (isset(session('errors')['profile_picture'])): ?>
                            <p class="text-red-400 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['profile_picture'] ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-500 text-xs mt-2">JPG, JPEG, PNG - Max 2MB</p>
                        <?php endif; ?>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="flex items-start space-x-3 cursor-pointer group">
                            <input type="checkbox" name="terms" value="1" <?= old('terms') ? 'checked' : '' ?>
                                class="w-5 h-5 mt-1 text-purple-500 bg-gray-900 border-gray-700 rounded focus:ring-purple-500">
                            <span class="text-gray-300 text-sm group-hover:text-purple-400 transition-colors">
                                I agree to the <a href="#" class="text-purple-400 hover:text-purple-300 underline">Terms and Conditions</a>
                                and <a href="#" class="text-purple-400 hover:text-purple-300 underline">Privacy Policy</a>
                                <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <?php if (isset(session('errors')['terms'])): ?>
                            <p class="text-red-400 text-xs mt-2 ml-8">
                                <i class="fas fa-exclamation-circle mr-1"></i><?= session('errors')['terms'] ?>
                            </p>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit"
                        class="btn-glow w-full bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 text-white font-bold py-4 rounded-xl hover:from-blue-500 hover:via-purple-500 hover:to-cyan-500 transition-all duration-300 text-lg tracking-wider">
                        <i class="fas fa-rocket mr-2"></i>
                        REGISTER NOW
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400 text-sm">
                        Already have an account?
                        <a href="<?= base_url('login') ?>" class="text-cyan-400 hover:text-cyan-300 font-semibold">
                            Login here <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </p>
                </div>

            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-xs">
            <p>© 2025 Registration System. Powered by CodeIgniter 4 & PostgreSQL</p>
        </div>
    </div>

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
                    preview.innerHTML = `
                        <div class="flex items-center gap-4 bg-gray-900/50 border border-gray-700 rounded-xl p-4">
                            <img src="${e.target.result}" class="w-20 h-20 rounded-lg object-cover border-2 border-yellow-500">
                            <div class="flex-1">
                                <p class="text-white font-semibold">${input.files[0].name}</p>
                                <p class="text-gray-400 text-sm">${(input.files[0].size / 1024).toFixed(2)} KB</p>
                            </div>
                            <button onclick="removeImage()" type="button" class="text-red-500 hover:text-red-400">
                                <i class="fas fa-times-circle text-2xl"></i>
                            </button>
                        </div>
                    `;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove Image
        function removeImage() {
            document.getElementById('profile_picture').value = '';
            document.getElementById('imagePreview').innerHTML = '';
        }
    </script>
</body>

</html>