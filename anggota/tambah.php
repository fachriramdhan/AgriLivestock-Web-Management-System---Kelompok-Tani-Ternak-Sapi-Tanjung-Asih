<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Tambah Anggota</h1>

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
                <label>Nama</label>
                <input type="text" name="nama_anggota" class="w-full border p-2" required>
            </div>

            <div>
                <label>Alamat</label>
                <textarea name="alamat" class="w-full border p-2"></textarea>
            </div>

            <div>
                <label>No HP</label>
                <input type="text" name="no_hp" class="w-full border p-2">
            </div>

            <div>
                <label>Tanggal Gabung</label>
                <input type="date" name="tanggal_gabung" class="w-full border p-2">
            </div>

            <div>
                <label>Status</label>
                <select name="status_anggota" class="w-full border p-2">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>