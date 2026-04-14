<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

$today = date('Y-m-d');
$notif_query = mysqli_query($conn, "SELECT t.*, p.nama_lengkap FROM tagihan t 
               JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan 
               WHERE t.tanggal_jatuh_tempo = '$today' AND t.status_pembayaran != 'Lunas'");

$tagihan = mysqli_query($conn, "SELECT t.*, p.nama_lengkap, k.nama_kategori FROM tagihan t 
           JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan 
           JOIN kategori k ON t.id_kategori = k.id_kategori");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Billing Assistant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #F8FAFC; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="antialiased">

    <header class="sticky top-0 z-50 glass-card border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-sky-500 rounded-xl flex items-center justify-center shadow-lg shadow-sky-200">
                    <span class="text-white font-bold text-xl">S</span>
                </div>
                <h1 class="text-xl font-bold tracking-tight text-slate-800">Smart<span class="text-sky-500">Billing</span></h1>
            </div>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600 uppercase tracking-wider">
                <a href="index.php" class="text-sky-500 border-b-2 border-sky-500 pb-1">Dashboard</a>
                <a href="profile.php" class="hover:text-sky-500 transition">Profile</a>
                <a href="tambah_tagihan.php" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-full shadow-md shadow-amber-100 transition flex items-center gap-2">
                   <span>+</span> Tambah Tagihan
                </a>
                <a href="logout.php" class="text-rose-500 hover:text-rose-600 transition border border-rose-200 px-4 py-2 rounded-lg">Logout</a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-slate-800">Selamat Datang, <?= explode(' ', $_SESSION['user']['nama_lengkap'])[0] ?>! 👋</h2>
            <p class="text-slate-500">Kelola semua tagihan pelanggan dengan lebih cerdas dan efisien.</p>
        </div>

        <?php if(mysqli_num_rows($notif_query) > 0): ?>
        <div class="mb-10 space-y-3">
            <?php while($row = mysqli_fetch_assoc($notif_query)): ?>
            <div class="flex items-center gap-4 bg-rose-50 border border-rose-100 p-4 rounded-2xl shadow-sm">
                <div class="w-12 h-12 bg-rose-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-rose-600 text-xl font-bold">!</span>
                </div>
                <div class="flex-grow">
                    <h4 class="font-bold text-rose-800">Tagihan Jatuh Tempo Hari Ini</h4>
                    <p class="text-sm text-rose-600">Pelanggan <strong><?= $row['nama_lengkap'] ?></strong> belum membayar tagihan sebesar Rp <?= number_format($row['jumlah_tagihan'], 0, ',', '.') ?></p>
                </div>
                <a href="edit_tagihan.php?id=<?= $row['id_tagihan'] ?>" class="bg-rose-500 text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-rose-600">Update Status</a>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-lg">Daftar Tagihan Aktif</h3>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total: <?= mysqli_num_rows($tagihan) ?> Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-widest font-bold">
                            <th class="px-8 py-4 text-left">Pelanggan</th>
                            <th class="px-6 py-4 text-left">Kategori</th>
                            <th class="px-6 py-4 text-left">Jumlah Tagihan</th>
                            <th class="px-6 py-4 text-left">Jatuh Tempo</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-8 py-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php while($t = mysqli_fetch_assoc($tagihan)): ?>
                        <tr class="hover:bg-sky-50/30 transition group">
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-700 block"><?= $t['nama_lengkap'] ?></span>
                                <span class="text-xs text-slate-400">#INV-<?= $t['id_tagihan'] ?></span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="bg-sky-100 text-sky-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">
                                    <?= $t['nama_kategori'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 font-bold text-slate-700">
                                Rp <?= number_format($t['jumlah_tagihan'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm text-slate-600"><?= date('d M Y', strtotime($t['tanggal_jatuh_tempo'])) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <?php 
                                    $status = $t['status_pembayaran'];
                                    if ($status == 'Lunas') $badge = "bg-emerald-500/10 text-emerald-600";
                                    elseif ($status == 'Terlambat') $badge = "bg-rose-500/10 text-rose-600";
                                    else $badge = "bg-amber-500/10 text-amber-600";
                                ?>
                                <span class="<?= $badge ?> px-4 py-1.5 rounded-xl text-xs font-bold shadow-sm">
                                    <?= $status ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right space-x-2">
                                <a href="edit_tagihan.php?id=<?= $t['id_tagihan'] ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-sky-500 hover:text-white transition shadow-sm">
                                    ✎
                                </a>
                                <a href="hapus_tagihan.php?id=<?= $t['id_tagihan'] ?>" onclick="return confirm('Hapus tagihan ini?')" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-rose-500 hover:text-white transition shadow-sm">
                                    ✕
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php if(mysqli_num_rows($tagihan) == 0): ?>
            <div class="py-20 text-center">
                <p class="text-slate-400">Tidak ada data tagihan ditemukan.</p>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="mt-20 py-10 border-t border-slate-100 text-center text-slate-400 text-sm italic">
        &copy; 2026 Smart Billing Assistant - Startup Dashboard
    </footer>

</body>
</html>