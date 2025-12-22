<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil daftar sapi sesuai role
if ($role === 'admin') {
    $qSapi = mysqli_query($koneksi, "SELECT s.id_sapi, s.kode_sapi, s.nama_sapi, u.username 
                                     FROM sapi s 
                                     JOIN user u ON s.id_user = u.id_user
                                     WHERE s.status_sapi='aktif'");
} else {
    $qSapi = mysqli_query($koneksi, "SELECT id_sapi, kode_sapi, nama_sapi 
                                     FROM sapi 
                                     WHERE id_user='$id_user_session' AND status_sapi='aktif'");
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Input Pakan Sapi</h1>

    <form action="simpan.php" method="POST" class="space-y-4 max-w-xl">
        <div>
            <label>Sapi</label>
            <select name="id_sapi" class="w-full border p-2" required>
                <option value="">-- Pilih Sapi --</option>
                <?php while($s = mysqli_fetch_assoc($qSapi)): ?>
                <option value="<?= $s['id_sapi'] ?>">
                    <?= $s['kode_sapi'].' - '.$s['nama_sapi'] ?> <?= $role==='admin'? '(' . $s['username'] . ')' : '' ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2" required>
        </div>

        <div>
            <label>Jenis Pakan</label>
            <select name="jenis_pakan" class="w-full border p-2" required>
                <option value="rumput">Rumput</option>
                <option value="konsentrat">Konsentrat</option>
                <option value="jerami">Jerami</option>
                <option value="ampas_tahu">Ampas Tahu</option>
            </select>
        </div>

        <div>
            <label>Waktu Pemberian</label>
            <select name="waktu_pemberian" class="w-full border p-2" required>
                <option value="pagi">Pagi</option>
                <option value="siang">Siang</option>
                <option value="sore">Sore</option>
            </select>
        </div>

        <div>
            <label>Jumlah (Kg)</label>
            <input type="number" step="0.01" name="jumlah_kg" class="w-full border p-2" required>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan" class="w-full border p-2"></textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>