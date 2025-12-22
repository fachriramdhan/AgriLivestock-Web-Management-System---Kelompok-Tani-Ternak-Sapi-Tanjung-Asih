<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id = $_GET['id'];
$qData = mysqli_query($koneksi,"SELECT * FROM produksi_olahan WHERE id_olahan='$id'");
$data = mysqli_fetch_assoc($qData);
if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}
if($role==='user' && $data['id_user']!=$id_user_session){
    $_SESSION['error']="Anda tidak berhak edit data ini!";
    header("Location: index.php"); exit;
}

if($role==='admin'){
    $qUser = mysqli_query($koneksi,"SELECT id_user, username FROM user WHERE status_akun='aktif'");
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Edit Produksi Olahan</h1>

    <form action="update.php" method="POST" class="space-y-4 max-w-xl">
        <input type="hidden" name="id_olahan" value="<?= $data['id_olahan'] ?>">

        <?php if($role==='admin'): ?>
        <div>
            <label>Peternak</label>
            <select name="id_user" class="w-full border p-2" required>
                <option value="">-- Pilih Peternak --</option>
                <?php while($u=mysqli_fetch_assoc($qUser)): ?>
                <option value="<?= $u['id_user'] ?>" <?= $data['id_user']==$u['id_user']?'selected':'' ?>>
                    <?= $u['username'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <?php endif; ?>

        <div>
            <label>Tanggal Produksi</label>
            <input type="date" name="tanggal" class="w-full border p-2" value="<?= $data['tanggal'] ?>" required>
        </div>

        <div>
            <label>Jenis Olahan</label>
            <select name="jenis_olahan" class="w-full border p-2" required>
                <?php
$jenis=['pasteurisasi','yogurt','keju','mentega'];
foreach($jenis as $j):
?>
                <option value="<?= $j ?>" <?= $data['jenis_olahan']==$j?'selected':'' ?>><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Bahan Baku (Liter)</label>
            <input type="number" name="bahan_baku_liter" class="w-full border p-2" step="0.01"
                value="<?= $data['bahan_baku_liter'] ?>" required>
        </div>

        <div>
            <label>Jumlah Hasil</label>
            <input type="number" name="jumlah_hasil" class="w-full border p-2" step="0.01"
                value="<?= $data['jumlah_hasil'] ?>" required>
        </div>

        <div>
            <label>Status Produksi</label>
            <select name="status_produksi" class="w-full border p-2" required>
                <option value="proses" <?= $data['status_produksi']=='proses'?'selected':'' ?>>Proses</option>
                <option value="selesai" <?= $data['status_produksi']=='selesai'?'selected':'' ?>>Selesai</option>
            </select>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan" class="w-full border p-2"><?= $data['keterangan'] ?></textarea>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>