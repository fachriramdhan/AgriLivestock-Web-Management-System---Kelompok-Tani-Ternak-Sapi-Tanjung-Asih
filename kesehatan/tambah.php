<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil daftar sapi aktif
$qSapi = ($role==='admin') ? 
    mysqli_query($koneksi, "SELECT s.id_sapi, s.kode_sapi, s.nama_sapi, u.username 
                             FROM sapi s 
                             JOIN user u ON s.id_user = u.id_user
                             WHERE s.status_sapi='aktif'")
    :
    mysqli_query($koneksi, "SELECT id_sapi, kode_sapi, nama_sapi 
                             FROM sapi WHERE id_user='$id_user_session' AND status_sapi='aktif'");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Input Kesehatan Sapi</h1>

    <form action="simpan.php" method="POST" class="space-y-4 max-w-xl">
        <div>
            <label>Sapi</label>
            <select name="id_sapi" class="w-full border p-2" required>
                <option value="">-- Pilih Sapi --</option>
                <?php while($s=mysqli_fetch_assoc($qSapi)): ?>
                <option value="<?= $s['id_sapi'] ?>"><?= $s['kode_sapi'].' - '.$s['nama_sapi'] ?>
                    <?= $role==='admin'? '('.$s['username'].')':'' ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label>Tanggal Pemeriksaan</label>
            <input type="date" name="tanggal" class="w-full border p-2" required>
        </div>

        <div>
            <label>Jenis Pemeriksaan</label>
            <select name="jenis_pemeriksaan" class="w-full border p-2" required>
                <option value="rutin">Rutin</option>
                <option value="sakit">Sakit</option>
                <option value="vaksinasi">Vaksinasi</option>
                <option value="kebuntingan">Kebuntingan</option>
            </select>
        </div>

        <div>
            <label>Gejala</label>
            <input type="text" name="gejala" class="w-full border p-2">
        </div>

        <div>
            <label>Tindakan</label>
            <select name="tindakan" class="w-full border p-2" required>
                <option value="observasi">Observasi</option>
                <option value="obat">Obat</option>
                <option value="vitamin">Vitamin</option>
                <option value="suntik">Suntik</option>
            </select>
        </div>

        <div>
            <label>Status Kesehatan</label>
            <select name="status_kesehatan" class="w-full border p-2" required>
                <option value="sehat">Sehat</option>
                <option value="perawatan">Perawatan</option>
                <option value="sakit">Sakit</option>
            </select>
        </div>

        <div>
            <label>Catatan</label>
            <textarea name="catatan" class="w-full border p-2"></textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>