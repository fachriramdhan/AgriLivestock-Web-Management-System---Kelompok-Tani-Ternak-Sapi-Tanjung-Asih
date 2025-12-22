<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

$id = $_GET['id'];
$qData = mysqli_query($koneksi,"SELECT * FROM jadwal_kegiatan WHERE id_jadwal='$id'");
$data = mysqli_fetch_assoc($qData);
if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Edit Jadwal Kegiatan</h1>

    <form action="update.php" method="POST" class="space-y-4 max-w-xl">
        <input type="hidden" name="id_jadwal" value="<?= $data['id_jadwal'] ?>">

        <div>
            <label>Jenis Kegiatan</label>
            <select name="jenis_kegiatan" class="w-full border p-2" required>
                <?php
$jenis=['pemerahan','pakan','vaksinasi','pemeriksaan','rapat'];
foreach($jenis as $j):
?>
                <option value="<?= $j ?>" <?= $data['jenis_kegiatan']==$j?'selected':'' ?>><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2" value="<?= $data['tanggal'] ?>" required>
        </div>

        <div>
            <label>Waktu</label>
            <input type="time" name="waktu" class="w-full border p-2" value="<?= $data['waktu'] ?>" required>
        </div>

        <div>
            <label>Keterangan</label>
            <textarea name="keterangan" class="w-full border p-2"><?= $data['keterangan'] ?></textarea>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>