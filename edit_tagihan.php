<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['user'])) header("Location: login.php");
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT t.*, p.nama_lengkap FROM tagihan t JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan WHERE id_tagihan = $id");
$t = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];
    $query = "UPDATE tagihan SET jumlah_tagihan='$jumlah', status_pembayaran='$status' WHERE id_tagihan=$id";
    if (mysqli_query($conn, $query)) header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Quicksand', sans-serif; }</style>
</head>
<body class="bg-slate-50 p-6 md:p-20">
    <div class="max-w-md mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-800 text-center">Update Status</h2>
            <p class="text-slate-500 text-sm text-center italic mt-1">Pelanggan: <?= $t['nama_lengkap'] ?></p>
        </div>

        <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Revisi Nominal (Rp)</label>
                    <input type="number" name="jumlah" value="<?= $t['jumlah_tagihan'] ?>" class="w-full p-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-400 focus:outline-none font-bold text-slate-700">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Status Pembayaran</label>
                    <select name="status" class="w-full p-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-emerald-400 focus:outline-none font-semibold">
                        <option value="Belum Lunas" <?= $t['status_pembayaran'] == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                        <option value="Lunas" <?= $t['status_pembayaran'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="Terlambat" <?= $t['status_pembayaran'] == 'Terlambat' ? 'selected' : '' ?>>Terlambat</option>
                    </select>
                </div>
                <button type="submit" name="update" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-100 transition duration-300">
                    Perbarui Data
                </button>
                <a href="index.php" class="block text-center text-slate-400 text-sm font-bold hover:text-slate-600">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>