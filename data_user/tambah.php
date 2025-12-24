<?php
session_start();
require_once '../config/database.php';

// Pastikan hanya admin
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil daftar anggota untuk di-link ke user
$qAnggota = mysqli_query($koneksi,"SELECT * FROM anggota WHERE status_anggota='aktif'");
if(!$qAnggota){
    die("Query gagal: ".mysqli_error($koneksi));
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Tambah User</h1>

        <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <form action="simpan.php" method="POST" class="space-y-4 max-w-xl">
            <div>
                <label>Username</label>
                <input type="text" name="username" class="w-full border p-2" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" class="w-full border p-2" required>
            </div>

            <div>
                <label>Role</label>
                <select name="role" class="w-full border p-2" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div>
                <label>Status Akun</label>
                <select name="status_akun" class="w-full border p-2">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div>
                <label>Link ke Anggota</label>
                <select name="id_anggota" class="w-full border p-2">
                    <option value="">-- Pilih Anggota --</option>
                    <?php while($a=mysqli_fetch_assoc($qAnggota)): ?>
                    <option value="<?= $a['id_anggota'] ?>"><?= htmlspecialchars($a['nama_anggota']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>