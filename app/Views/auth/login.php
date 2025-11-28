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
            background-image:
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.2) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(6, 182, 212, 0.1) 0px, transparent 50%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
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
        }

        .cyber-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 2px;
            background: linear-gradient(45deg, #3b82f6, #a855f7, #06b6d4);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            border-radius: 0.75rem;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .cyber-border:focus-within::before {
            opacity: 1;
        }
    </style>
</head>

<body class="flex items-center justify-center p-4 min-h-screen">

    <div class="w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-8 animate-slide-down">
            <div class="inline-block mb-6 animate-float">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 rounded-2xl flex items-center justify-center transform rotate-6">
                    <i class="fas fa-shield-alt text-5xl text-white"></i>
                </div>
            </div>
            <h1 class="title-font text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-cyan-400 mb-2">
                LOGIN
            </h1>
            <p class="text-gray-400 text-sm tracking-wider">// Access your secure account</p>
        </div>

        <!-- Alert Success -->
        <?php if (session()->has('success')): ?>
            <div class="glass-card rounded-xl p-4 mb-6 border-l-4 border-green-500 animate-slide-down">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="text-green-400 font-semibold"><?= session('success') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alert Error -->
        <?php if (session()->has('error')): ?>
            <div class="glass-card rounded-xl p-4 mb-6 border-l-4 border-red-500 animate-slide-down">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="text-red-400 font-semibold"><?= session('error') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alert Validation Errors -->
        <?php if (session()->has('errors')): ?>
            <div class="glass-card rounded-xl p-4 mb-6 border-l-4 border-red-500 animate-slide-down">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3 mt-1"></i>
                    <div class="flex-1">
                        <h3 class="text-red-400 font-bold mb-2">VALIDATION ERROR</h3>
                        <ul class="text-red-300 text-sm space-y-1">
                            <?php foreach (session('errors') as $error): ?>
                                <li class="flex items-start">
                                    <span class="text-red-500 mr-2">›</span>
                                    <?= esc($error) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login Card -->
        <div class="glass-card rounded-2xl p-8 animate-slide-down" style="animation-delay: 0.2s">
            <form action="<?= base_url('login/authenticate') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="mb-6 cyber-border">
                    <label class="block text-cyan-400 text-sm font-semibold mb-2 tracking-wide">
                        <i class="fas fa-envelope text-cyan-500"></i> EMAIL ADDRESS
                    </label>
                    <input type="email" name="email" value="<?= old('email') ?>"
                        class="input-glow w-full bg-gray-900/50 border border-gray-700 text-white rounded-xl px-4 py-4 focus:outline-none focus:border-cyan-500 transition-all text-lg"
                        placeholder="Enter your email"
                        autofocus>
                </div>

                <!-- Password -->
                <div class="mb-6 cyber-border">
                    <label class="block text-purple-400 text-sm font-semibold mb-2 tracking-wide">
                        <i class="fas fa-lock text-purple-500"></i> PASSWORD
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="input-glow w-full bg-gray-900/50 border border-gray-700 text-white rounded-xl px-4 py-4 pr-12 focus:outline-none focus:border-purple-500 transition-all text-lg"
                            placeholder="Enter your password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-400 transition-colors">
                            <i class="fas fa-eye text-xl" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn-glow w-full bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 text-white font-bold py-4 rounded-xl hover:from-blue-500 hover:via-purple-500 hover:to-cyan-500 transition-all duration-300 text-lg tracking-wider mb-6">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    LOGIN NOW
                </button>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-gray-900/50 text-gray-400">OR</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-400 text-sm mb-4">
                        Don't have an account yet?
                    </p>
                    <a href="<?= base_url('register') ?>"
                        class="inline-flex items-center justify-center w-full bg-gray-800 border border-gray-700 text-gray-300 font-bold py-4 rounded-xl hover:bg-gray-700 hover:text-white hover:border-cyan-500 transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create New Account
                    </a>
                </div>
            </form>
        </div>

        <!-- Security Info -->
        <div class="mt-8 text-center">
            <div class="flex items-center justify-center gap-6 text-gray-500 text-xs">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-alt text-green-500"></i>
                    <span>Secure Login</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-lock text-blue-500"></i>
                    <span>Encrypted</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-database text-purple-500"></i>
                    <span>PostgreSQL</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-xs">
            <p>© 2025 Login System. Powered by CodeIgniter 4</p>
        </div>

    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const field = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

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
    </script>
</body>

</html>