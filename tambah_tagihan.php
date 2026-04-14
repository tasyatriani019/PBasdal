<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

if (isset($_POST['simpan'])) {
    $id_p = $_POST['id_pelanggan'];
    $id_k = $_POST['id_kategori'];
    $jumlah = $_POST['jumlah'];
    $tgl_t = $_POST['tgl_terbit'];
    $tgl_j = $_POST['tgl_jatuh'];

    $sql = "INSERT INTO tagihan (id_pelanggan, id_kategori, jumlah_tagihan, tanggal_terbit, tanggal_jatuh_tempo, status_pembayaran) 
            VALUES ('$id_p', '$id_k', '$jumlah', '$tgl_t', '$tgl_j', 'Belum Lunas')";
    
    if (mysqli_query($conn, $sql)) header("Location: index.php");
}

$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Quicksand', sans-serif; }</style>
</head>
<body class="bg-slate-50 p-6 md:p-20">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Buat Tagihan Baru</h2>
                <p class="text-slate-500 text-sm">Input data tagihan pelanggan dengan teliti.</p>
            </div>
            <a href="index.php" class="text-slate-400 hover:text-slate-600 text-sm font-bold">← Kembali</a>
        </div>

        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-slate-100">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Pilih Pelanggan</label>
                        <select name="id_pelanggan" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                            <?php while($p = mysqli_fetch_assoc($pelanggan)) echo "<option value='".$p['id_pelanggan']."'>".$p['nama_lengkap']."</option>"; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Kategori Layanan</label>
                        <select name="id_kategori" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                            <?php while($k = mysqli_fetch_assoc($kategori)) echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>"; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Jumlah Nominal (Rp)</label>
                    <input type="number" name="jumlah" placeholder="Contoh: 150000" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none font-bold text-slate-700" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Terbit</label>
                        <input type="date" name="tgl_terbit" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Jatuh Tempo</label>
                        <input type="date" name="tgl_jatuh" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="simpan" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-100 transition duration-300">
                        Simpan dan Terbitkan Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>