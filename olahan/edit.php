<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id = $_GET['id'] ?? null;
if(!$id){
    $_SESSION['error'] = "ID data tidak valid!";
    header("Location: index.php"); exit;
}

$qData = mysqli_query($koneksi,"SELECT * FROM produksi_olahan WHERE id_olahan='$id'");
$data = mysqli_fetch_assoc($qData);

if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}

if($role==='user' && $data['id_user'] != $id_user_session){
    $_SESSION['error']="Anda tidak berhak edit data ini!";
    header("Location: index.php"); exit;
}

if($role==='admin'){
    $qUser = mysqli_query($koneksi,"SELECT id_user, username FROM user WHERE status_akun='aktif'");
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex min-h-screen">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Produksi Olahan</h1>

        <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <form action="update.php" method="POST" class="space-y-4 max-w-xl bg-white p-6 rounded shadow">
            <input type="hidden" name="id_olahan" value="<?= $data['id_olahan'] ?>">

            <?php if($role==='admin'): ?>
            <div>
                <label class="block font-semibold mb-1">Peternak</label>
                <select name="id_user" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Peternak --</option>
                    <?php while($u=mysqli_fetch_assoc($qUser)): ?>
                    <option value="<?= $u['id_user'] ?>" <?= $data['id_user']==$u['id_user']?'selected':'' ?>>
                        <?= $u['username'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>

            <div>
                <label class="block font-semibold mb-1">Tanggal Produksi</label>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" value="<?= $data['tanggal'] ?>"
                    required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Jenis Olahan</label>
                <select name="jenis_olahan" class="w-full border p-2 rounded" required>
                    <?php
                    $jenis=['pasteurisasi','yogurt','keju','mentega'];
                    foreach($jenis as $j):
                    ?>
                    <option value="<?= $j ?>" <?= $data['jenis_olahan']==$j?'selected':'' ?>><?= ucfirst($j) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Bahan Baku (Liter)</label>
                <input type="number" name="bahan_baku_liter" class="w-full border p-2 rounded" step="0.01"
                    value="<?= $data['bahan_baku_liter'] ?>" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Jumlah Hasil</label>
                <input type="number" name="jumlah_hasil" class="w-full border p-2 rounded" step="0.01"
                    value="<?= $data['jumlah_hasil'] ?>" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Status Produksi</label>
                <select name="status_produksi" class="w-full border p-2 rounded" required>
                    <option value="proses" <?= $data['status_produksi']=='proses'?'selected':'' ?>>Proses</option>
                    <option value="selesai" <?= $data['status_produksi']=='selesai'?'selected':'' ?>>Selesai</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Keterangan</label>
                <textarea name="keterangan" class="w-full border p-2 rounded"><?= $data['keterangan'] ?></textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update
            </button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>