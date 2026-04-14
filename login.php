<?php
session_start();
include 'config/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['user'] = mysqli_fetch_assoc($query);
        header("Location: index.php");
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Quicksand', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-sky-500 rounded-2xl shadow-xl shadow-sky-200 mb-4">
                <span class="text-white text-3xl font-bold">S</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Smart<span class="text-sky-500">Billing</span></h1>
            <p class="text-slate-500 text-sm mt-1">Silakan masuk untuk mengelola tagihan.</p>
        </div>

        <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
            <?php if(isset($error)): ?>
                <div class="bg-rose-50 text-rose-600 text-xs p-3 rounded-xl mb-6 text-center font-bold border border-rose-100">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" 
                           class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-sky-400 focus:outline-none transition bg-slate-50" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••" 
                           class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-sky-400 focus:outline-none transition bg-slate-50" required>
                </div>
                <button type="submit" name="login" 
                        class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-sky-100 transition duration-300">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
        <p class="text-center text-slate-400 text-xs mt-10 italic">&copy; 2026 Smart Billing Assistant</p>
    </div>
</body>
</html>