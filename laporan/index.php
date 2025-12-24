<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex min-h-screen">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Laporan</h1>

        <!-- Form Filter Laporan -->
        <form action="tampil_laporan.php" method="GET" class="space-y-4 max-w-xl">
            <div>
                <label>Jenis Laporan</label>
                <select name="jenis" class="w-full border p-2" required>
                    <option value="produksi_susu">Produksi Susu</option>
                    <option value="pakan_sapi">Pakan Sapi</option>
                    <option value="kesehatan_sapi">Kesehatan Sapi</option>
                    <option value="populasi_sapi">Populasi Sapi</option>
                    <option value="produksi_olahan">Produksi Olahan</option>
                </select>
            </div>

            <div>
                <label>Periode Awal</label>
                <input type="date" name="tgl_awal" class="w-full border p-2" required>
            </div>

            <div>
                <label>Periode Akhir</label>
                <input type="date" name="tgl_akhir" class="w-full border p-2" required>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">Tampilkan Laporan</button>
        </form>
    </main>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const tglAwal = new Date(this.tgl_awal.value);
    const tglAkhir = new Date(this.tgl_akhir.value);
    if (tglAwal > tglAkhir) {
        alert("Periode awal tidak boleh lebih besar dari periode akhir!");
        e.preventDefault();
    }
});
</script>

<?php include '../includes/footer.php'; ?>