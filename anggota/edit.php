<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if(!$id){
    $_SESSION['error'] = "ID anggota tidak ditemukan.";
    header("Location: index.php");
    exit;
}

$qData = mysqli_query($koneksi,"SELECT * FROM anggota WHERE id_anggota='$id'");
$anggota = mysqli_fetch_assoc($qData);
if(!$anggota){
    $_SESSION['error'] = "Data anggota tidak ditemukan.";
    header("Location: index.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Edit Anggota</h1>

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

        <form action="update.php" method="POST" class="space-y-4 max-w-xl">
            <input type="hidden" name="id_anggota" value="<?= $anggota['id_anggota'] ?>">

            <div>
                <label>Nama</label>
                <input type="text" name="nama_anggota" class="w-full border p-2" value="<?= $anggota['nama_anggota'] ?>"
                    required>
            </div>

            <div>
                <label>Alamat</label>
                <textarea name="alamat" class="w-full border p-2"><?= $anggota['alamat'] ?></textarea>
            </div>

            <div>
                <label>No HP</label>
                <input type="text" name="no_hp" class="w-full border p-2" value="<?= $anggota['no_hp'] ?>">
            </div>

            <div>
                <label>Tanggal Gabung</label>
                <input type="date" name="tanggal_gabung" class="w-full border p-2"
                    value="<?= $anggota['tanggal_gabung'] ?>">
            </div>

            <div>
                <label>Status</label>
                <select name="status_anggota" class="w-full border p-2">
                    <option value="aktif" <?= $anggota['status_anggota']=='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $anggota['status_anggota']=='nonaktif'?'selected':'' ?>>Nonaktif
                    </option>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>