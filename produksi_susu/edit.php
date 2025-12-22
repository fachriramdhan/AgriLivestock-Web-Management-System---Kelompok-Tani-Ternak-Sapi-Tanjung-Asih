<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_user_session = $_SESSION['id_user'];
$role = $_SESSION['role'];

$id_produksi = $_GET['id'] ?? 0;
$id_produksi = (int) $id_produksi;

if ($id_produksi <= 0) {
    $_SESSION['error'] = "ID tidak valid!";
    header("Location: index.php");
    exit;
}

// Ambil data produksi susu
$q = mysqli_query($koneksi, "
    SELECT ps.*, s.kode_sapi, s.nama_sapi, s.kategori_sapi, s.status_laktasi
    FROM produksi_susu ps
    JOIN sapi s ON ps.id_sapi = s.id_sapi
    WHERE ps.id_produksi='$id_produksi'
");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    $_SESSION['error'] = "Data tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Cek role user
if ($role==='user' && $data['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk mengedit data ini!";
    header("Location: index.php");
    exit;
}

// User hanya bisa edit draft
if ($role==='user' && $data['status_data'] !== 'draft') {
    $_SESSION['error'] = "Hanya data draft yang bisa diedit!";
    header("Location: index.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Edit Produksi Susu</h1>

    <form action="update.php" method="POST" class="space-y-4 max-w-xl">
        <input type="hidden" name="id_produksi" value="<?= $data['id_produksi'] ?>">

        <div>
            <label>Sapi</label>
            <input type="text" value="<?= $data['kode_sapi'].' - '.$data['nama_sapi'] ?>" class="w-full border p-2"
                disabled>
        </div>

        <div>
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2" value="<?= $data['tanggal'] ?>" required>
        </div>

        <div>
            <label>Waktu Pemerahan</label>
            <select name="waktu_pemerahan" class="w-full border p-2" required>
                <option value="pagi" <?= $data['waktu_pemerahan']=='pagi'?'selected':'' ?>>Pagi</option>
                <option value="sore" <?= $data['waktu_pemerahan']=='sore'?'selected':'' ?>>Sore</option>
            </select>
        </div>

        <div>
            <label>Jumlah (Liter)</label>
            <input type="number" step="0.01" name="jumlah_liter" class="w-full border p-2"
                value="<?= $data['jumlah_liter'] ?>" required>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan" class="w-full border p-2"><?= $data['keterangan'] ?></textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>