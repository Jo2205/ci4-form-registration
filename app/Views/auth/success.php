<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
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
                radial-gradient(at 0% 0%, rgba(34, 197, 94, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.15) 0px, transparent 50%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(0deg);
                opacity: 0;
            }

            50% {
                transform: scale(1.2) rotate(180deg);
            }

            100% {
                transform: scale(1) rotate(360deg);
                opacity: 1;
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .animate-checkmark {
            animation: checkmark 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .btn-glow {
            box-shadow: 0 0 30px rgba(34, 197, 94, 0.5);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 40px rgba(34, 197, 94, 0.8);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="flex items-center justify-center p-4 min-h-screen">

    <div class="w-full max-w-2xl">

        <!-- Success Card -->
        <div class="glass-card rounded-2xl p-12 text-center animate-slide-up">

            <!-- Success Icon with Pulse Effect -->
            <div class="relative inline-block mb-8">
                <!-- Pulse Rings -->
                <div class="absolute inset-0 rounded-full bg-green-500 opacity-20 pulse-ring"></div>
                <div class="absolute inset-0 rounded-full bg-green-500 opacity-20 pulse-ring" style="animation-delay: 0.5s"></div>

                <!-- Icon Container -->
                <div class="relative w-32 h-32 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center animate-checkmark">
                    <i class="fas fa-check text-6xl text-white"></i>
                </div>
            </div>

            <!-- Success Title -->
            <h1 class="title-font text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400 mb-4">
                SUCCESS!
            </h1>

            <div class="mb-8">
                <p class="text-gray-300 text-lg mb-2">
                    Your account has been created successfully
                </p>
                <p class="text-gray-500 text-sm">
                    // Registration completed and saved to database
                </p>
            </div>

            <!-- Success Message from Session -->
            <?php if (session()->has('success')): ?>
                <div class="glass-card rounded-xl p-4 mb-8 border-l-4 border-green-500">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-info-circle text-green-500 text-xl mr-3"></i>
                        <p class="text-green-400 font-semibold">
                            <?= session('success') ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Features Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="glass-card rounded-xl p-4 border border-green-500/30">
                    <i class="fas fa-shield-alt text-3xl text-green-500 mb-2"></i>
                    <p class="text-gray-300 text-sm font-semibold">Secure Account</p>
                </div>
                <div class="glass-card rounded-xl p-4 border border-blue-500/30">
                    <i class="fas fa-database text-3xl text-blue-500 mb-2"></i>
                    <p class="text-gray-300 text-sm font-semibold">Data Saved</p>
                </div>
                <div class="glass-card rounded-xl p-4 border border-purple-500/30">
                    <i class="fas fa-rocket text-3xl text-purple-500 mb-2"></i>
                    <p class="text-gray-300 text-sm font-semibold">Ready to Go</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= base_url('login') ?>"
                    class="btn-glow inline-flex items-center justify-center bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-4 px-8 rounded-xl hover:from-green-500 hover:to-emerald-500 transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login Now
                </a>

                <a href="<?= base_url('register') ?>"
                    class="inline-flex items-center justify-center bg-gray-800 border border-gray-700 text-gray-300 font-bold py-4 px-8 rounded-xl hover:bg-gray-700 hover:text-white transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Register
                </a>
            </div>

            <!-- Countdown to redirect (optional) -->
            <div class="mt-8 text-gray-500 text-sm">
                <p>You will be redirected to login page in <span id="countdown" class="text-green-400 font-bold">5</span> seconds...</p>
            </div>

        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-xs">
            <p>© 2025 Registration System. Powered by CodeIgniter 4 & PostgreSQL</p>
        </div>

    </div>

    <script>
        // Auto redirect countdown
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');

        const countdown = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '<?= base_url('login') ?>';
            }
        }, 1000);
    </script>
</body>

</html>