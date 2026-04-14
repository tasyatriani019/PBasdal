<?php
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Smart Billing Assistant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full">
        <div class="mb-6">
            <a href="index.php" class="text-slate-400 hover:text-sky-500 font-bold text-sm transition flex items-center gap-2">
                <span>←</span> Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-br from-sky-400 to-sky-600 h-32 flex justify-center">
                <div class="relative mt-12">
                    <div class="w-28 h-28 bg-white rounded-3xl shadow-xl flex items-center justify-center border-4 border-white overflow-hidden">
                        <span class="text-4xl font-bold text-sky-500 italic">
                            <?= strtoupper(substr($user['nama_lengkap'], 0, 1)); ?>
                        </span>
                    </div>
                    <div class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full"></div>
                </div>
            </div>

            <div class="pt-16 pb-10 px-8 text-center">
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight"><?= $user['nama_lengkap']; ?></h2>
                <p class="text-sky-500 font-semibold text-sm uppercase tracking-widest mt-1">Administrator System</p>

                <div class="mt-8 space-y-4 text-left">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Username</span>
                        <span class="text-slate-700 font-bold italic">@<?= $user['username']; ?></span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">ID Anggota</span>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-700 font-bold tracking-wider">#USR-00<?= $user['id_user']; ?></span>
                            <span class="text-[10px] bg-sky-100 text-sky-600 px-2 py-0.5 rounded font-bold">VERIFIED</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100">
                    <a href="logout.php" class="inline-flex items-center gap-2 text-rose-500 font-bold hover:text-rose-600 transition text-sm">
                        Keluar dari Sesi
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center text-slate-400 text-xs mt-8">
            Data dikelola oleh sistem <strong>Smart Billing v1.0</strong>
        </p>
    </div>

</body>
</html>