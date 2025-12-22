<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

// Ambil daftar sapi sesuai role
if ($role === 'admin') {
    $qSapi = mysqli_query($koneksi, "
        SELECT s.id_sapi, s.kode_sapi, s.nama_sapi, u.username
        FROM sapi s
        JOIN user u ON s.id_user = u.id_user
        WHERE s.kategori_sapi='induk' 
          AND s.status_laktasi='laktasi' 
          AND s.status_sapi='aktif'
        ORDER BY s.kode_sapi ASC
    ");
} else {
    $qSapi = mysqli_query($koneksi, "
        SELECT id_sapi, kode_sapi, nama_sapi
        FROM sapi
        WHERE id_user='$id_user' 
          AND kategori_sapi='induk' 
          AND status_laktasi='laktasi' 
          AND status_sapi='aktif'
        ORDER BY kode_sapi ASC
    ");
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Input Produksi Susu</h1>

        <?php if(isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <form action="simpan.php" method="POST" class="space-y-4 max-w-xl bg-white p-4 rounded shadow">
            <div>
                <label for="id_sapi" class="block font-medium mb-1">Sapi</label>
                <select name="id_sapi" id="id_sapi" class="w-full border p-2" required>
                    <option value="">-- Pilih Sapi --</option>
                    <?php while($s = mysqli_fetch_assoc($qSapi)): ?>
                    <option value="<?= $s['id_sapi'] ?>">
                        <?= $s['kode_sapi'] ?> - <?= $s['nama_sapi'] ?>
                        <?= $role==='admin' ? '(' . $s['username'] . ')' : '' ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="tanggal" class="block font-medium mb-1">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="w-full border p-2" value="<?= date('Y-m-d') ?>"
                    required>
            </div>

            <div>
                <label for="waktu_pemerahan" class="block font-medium mb-1">Waktu Pemerahan</label>
                <select name="waktu_pemerahan" id="waktu_pemerahan" class="w-full border p-2" required>
                    <option value="pagi">Pagi</option>
                    <option value="sore">Sore</option>
                </select>
            </div>

            <div>
                <label for="jumlah_liter" class="block font-medium mb-1">Jumlah (Liter)</label>
                <input type="number" id="jumlah_liter" name="jumlah_liter" step="0.01" class="w-full border p-2"
                    required>
            </div>

            <div>
                <label for="keterangan" class="block font-medium mb-1">Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="w-full border p-2" rows="3"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>