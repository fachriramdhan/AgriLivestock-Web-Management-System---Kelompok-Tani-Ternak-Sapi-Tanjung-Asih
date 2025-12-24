<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php"); 
    exit;
}

$id = $_GET['id'] ?? null;
if(!$id){
    $_SESSION['error'] = "ID data tidak valid!";
    header("Location: index.php"); exit;
}

$qData = mysqli_query($koneksi,"SELECT * FROM jadwal_kegiatan WHERE id_jadwal='$id'");
$data = mysqli_fetch_assoc($qData);
if(!$data){
    $_SESSION['error']="Data tidak ditemukan!";
    header("Location: index.php"); exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex min-h-screen">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Jadwal Kegiatan</h1>

        <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <form action="update.php" method="POST" class="space-y-4 max-w-xl bg-white p-6 rounded shadow">
            <input type="hidden" name="id_jadwal" value="<?= $data['id_jadwal'] ?>">

            <div>
                <label class="block font-semibold mb-1">Jenis Kegiatan</label>
                <select name="jenis_kegiatan" class="w-full border p-2 rounded" required>
                    <?php
                    $jenis=['pemerahan','pakan','vaksinasi','pemeriksaan','rapat'];
                    foreach($jenis as $j):
                    ?>
                    <option value="<?= $j ?>" <?= $data['jenis_kegiatan']==$j?'selected':'' ?>><?= ucfirst($j) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" value="<?= $data['tanggal'] ?>"
                    required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Waktu</label>
                <input type="time" name="waktu" class="w-full border p-2 rounded" value="<?= $data['waktu'] ?>"
                    required>
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