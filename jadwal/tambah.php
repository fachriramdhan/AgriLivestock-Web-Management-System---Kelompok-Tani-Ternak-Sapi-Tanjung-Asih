<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Tambah Jadwal Kegiatan</h1>

    <form action="simpan.php" method="POST" class="space-y-4 max-w-xl">
        <div>
            <label>Jenis Kegiatan</label>
            <select name="jenis_kegiatan" class="w-full border p-2" required>
                <option value="pemerahan">Pemerahan</option>
                <option value="pakan">Pemberian Pakan</option>
                <option value="vaksinasi">Vaksinasi</option>
                <option value="pemeriksaan">Pemeriksaan Kesehatan</option>
                <option value="rapat">Rapat Kelompok</option>
            </select>
        </div>

        <div>
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2" required>
        </div>

        <div>
            <label>Waktu</label>
            <input type="time" name="waktu" class="w-full border p-2" required>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan" class="w-full border p-2"></textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>