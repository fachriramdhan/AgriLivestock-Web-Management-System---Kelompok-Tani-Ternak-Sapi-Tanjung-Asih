<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['login']) || $_SESSION['role']!='admin'){
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Tambah Jadwal Kegiatan</h1>

        <form action="simpan.php" method="POST" class="space-y-4 max-w-xl bg-white p-6 rounded shadow">
            <div>
                <label class="block mb-1 font-semibold">Jenis Kegiatan</label>
                <select name="jenis_kegiatan" class="w-full border p-2 rounded" required>
                    <option value="pemerahan">Pemerahan</option>
                    <option value="pakan">Pemberian Pakan</option>
                    <option value="vaksinasi">Vaksinasi</option>
                    <option value="pemeriksaan">Pemeriksaan Kesehatan</option>
                    <option value="rapat">Rapat Kelompok</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Waktu</label>
                <input type="time" name="waktu" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Keterangan</label>
                <textarea name="keterangan" class="w-full border p-2 rounded"></textarea>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>