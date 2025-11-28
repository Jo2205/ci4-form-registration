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
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(34, 197, 94, 0.1) 0px, transparent 50%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.6);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="glass-card border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 rounded-xl flex items-center justify-center transform rotate-6">
                        <i class="fas fa-rocket text-2xl text-white"></i>
                    </div>
                    <span class="ml-3 title-font text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                        DASHBOARD
                    </span>
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-white font-semibold"><?= esc($user['full_name']) ?></p>
                        <p class="text-gray-400 text-sm">@<?= esc($user['username']) ?></p>
                    </div>

                    <?php if ($user['profile_picture']): ?>
                        <img src="<?= base_url('writable/uploads/' . $user['profile_picture']) ?>"
                            alt="Profile"
                            class="w-12 h-12 rounded-full border-2 border-purple-500 object-cover">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">
                                <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <a href="<?= base_url('login/logout') ?>"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Welcome Message -->
        <?php if (session()->has('success')): ?>
            <div class="glass-card rounded-xl p-4 mb-8 border-l-4 border-green-500 animate-slide-down">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3 mt-1"></i>
                    <p class="text-green-400 font-semibold"><?= session('success') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- User Profile Card -->
        <div class="glass-card rounded-2xl p-8 mb-8 animate-slide-down">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Profile Picture -->
                <div class="relative">
                    <?php if ($user['profile_picture']): ?>
                        <img src="<?= base_url('writable/uploads/' . $user['profile_picture']) ?>"
                            alt="Profile"
                            class="w-32 h-32 rounded-2xl border-4 border-purple-500 object-cover shadow-2xl">
                    <?php else: ?>
                        <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center border-4 border-purple-500 shadow-2xl">
                            <span class="text-white font-bold text-5xl">
                                <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-full border-4 border-gray-900 flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-1 text-center md:text-left">
                    <h2 class="title-font text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-2">
                        <?= esc($user['full_name']) ?>
                    </h2>
                    <p class="text-gray-400 text-lg mb-4">@<?= esc($user['username']) ?></p>
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        <span class="px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg text-sm border border-blue-500/30">
                            <i class="fas fa-envelope mr-2"></i><?= esc($user['email']) ?>
                        </span>
                        <span class="px-4 py-2 bg-green-500/20 text-green-400 rounded-lg text-sm border border-green-500/30">
                            <i class="fas fa-phone mr-2"></i><?= esc($user['phone']) ?>
                        </span>
                        <span class="px-4 py-2 bg-purple-500/20 text-purple-400 rounded-lg text-sm border border-purple-500/30">
                            <i class="fas fa-<?= $user['gender'] == 'Laki-laki' ? 'mars' : 'venus' ?> mr-2"></i><?= esc($user['gender']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in" style="animation-delay: 0.2s">

            <!-- Account Age -->
            <div class="glass-card rounded-xl p-6 stat-card border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-2xl text-blue-500"></i>
                    </div>
                    <span class="text-xs text-gray-400">MEMBER SINCE</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-1">
                    <?= date('d M Y', strtotime($user['created_at'])) ?>
                </h3>
                <p class="text-gray-400 text-sm">
                    <?php
                    $diff = date_diff(date_create($user['created_at']), date_create('now'));
                    echo $diff->days . ' days ago';
                    ?>
                </p>
            </div>

            <!-- Birth Date -->
            <div class="glass-card rounded-xl p-6 stat-card border-l-4 border-purple-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-birthday-cake text-2xl text-purple-500"></i>
                    </div>
                    <span class="text-xs text-gray-400">BIRTH DATE</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-1">
                    <?= date('d M Y', strtotime($user['birth_date'])) ?>
                </h3>
                <p class="text-gray-400 text-sm">
                    <?php
                    $age = date_diff(date_create($user['birth_date']), date_create('now'))->y;
                    echo $age . ' years old';
                    ?>
                </p>
            </div>

            <!-- Profile Status -->
            <div class="glass-card rounded-xl p-6 stat-card border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                    </div>
                    <span class="text-xs text-gray-400">STATUS</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-1">Active</h3>
                <p class="text-gray-400 text-sm">Profile Complete</p>
            </div>

            <!-- Last Update -->
            <div class="glass-card rounded-xl p-6 stat-card border-l-4 border-cyan-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sync-alt text-2xl text-cyan-500"></i>
                    </div>
                    <span class="text-xs text-gray-400">LAST UPDATE</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-1">
                    <?= date('d M Y', strtotime($user['updated_at'])) ?>
                </h3>
                <p class="text-gray-400 text-sm">
                    <?= date('H:i', strtotime($user['updated_at'])) ?> WIB
                </p>
            </div>

        </div>

        <!-- Detailed Info Card -->
        <div class="glass-card rounded-2xl p-8 animate-fade-in" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between mb-6">
                <h3 class="title-font text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                    <i class="fas fa-user-circle mr-2"></i>PROFILE DETAILS
                </h3>
                <span class="px-4 py-2 bg-purple-500/20 text-purple-400 rounded-lg text-sm border border-purple-500/30">
                    <i class="fas fa-database mr-2"></i>PostgreSQL
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">User ID</p>
                    <p class="text-white font-semibold text-lg">#<?= $user['id'] ?></p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Username</p>
                    <p class="text-white font-semibold text-lg">@<?= esc($user['username']) ?></p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Email Address</p>
                    <p class="text-white font-semibold text-lg"><?= esc($user['email']) ?></p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Phone Number</p>
                    <p class="text-white font-semibold text-lg"><?= esc($user['phone']) ?></p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Full Name</p>
                    <p class="text-white font-semibold text-lg"><?= esc($user['full_name']) ?></p>
                </div>
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Gender</p>
                    <p class="text-white font-semibold text-lg">
                        <i class="fas fa-<?= $user['gender'] == 'Laki-laki' ? 'mars' : 'venus' ?> mr-2"></i>
                        <?= esc($user['gender']) ?>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="mt-16 py-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-500 text-sm">
                © 2025 Dashboard System. Powered by CodeIgniter 4 & PostgreSQL
            </p>
        </div>
    </footer>

</body>

</html>