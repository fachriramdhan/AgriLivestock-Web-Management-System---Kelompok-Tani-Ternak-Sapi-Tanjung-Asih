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

$qData = mysqli_query($koneksi, "SELECT * FROM kesehatan_sapi WHERE id_kesehatan='$id'");
$data = mysqli_fetch_assoc($qData);

if(!$data){
    $_SESSION['error'] = "Data tidak ditemukan!";
    header("Location: index.php"); exit;
}

if($role==='user' && $data['id_user'] != $id_user_session){
    $_SESSION['error'] = "Anda tidak berhak mengedit data ini!";
    header("Location: index.php"); exit;
}

// Ambil daftar sapi aktif
$qSapi = ($role==='admin') ? 
    mysqli_query($koneksi, "SELECT s.id_sapi, s.kode_sapi, s.nama_sapi, u.username 
                             FROM sapi s 
                             JOIN user u ON s.id_user = u.id_user
                             WHERE s.status_sapi='aktif'")
    :
    mysqli_query($koneksi, "SELECT id_sapi, kode_sapi, nama_sapi 
                             FROM sapi 
                             WHERE id_user='$id_user_session' AND status_sapi='aktif'");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex min-h-screen">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Kesehatan Sapi</h1>

        <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <form action="update.php" method="POST" class="space-y-4 max-w-xl bg-white p-6 rounded shadow">
            <input type="hidden" name="id_kesehatan" value="<?= $data['id_kesehatan'] ?>">

            <div>
                <label class="block font-semibold mb-1">Sapi</label>
                <select name="id_sapi" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Sapi --</option>
                    <?php while($s = mysqli_fetch_assoc($qSapi)): ?>
                    <option value="<?= $s['id_sapi'] ?>" <?= $s['id_sapi'] == $data['id_sapi'] ? 'selected' : '' ?>>
                        <?= $s['kode_sapi'].' - '.$s['nama_sapi'] ?> <?= $role==='admin'? '('.$s['username'].')':'' ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" value="<?= $data['tanggal'] ?>"
                    required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Jenis Pemeriksaan</label>
                <select name="jenis_pemeriksaan" class="w-full border p-2 rounded" required>
                    <?php
                    $jenis = ['rutin','sakit','vaksinasi','kebuntingan'];
                    foreach($jenis as $j):
                    ?>
                    <option value="<?= $j ?>" <?= $data['jenis_pemeriksaan']==$j ? 'selected' : '' ?>>
                        <?= ucfirst($j) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Gejala</label>
                <input type="text" name="gejala" class="w-full border p-2 rounded" value="<?= $data['gejala'] ?>">
            </div>

            <div>
                <label class="block font-semibold mb-1">Tindakan</label>
                <select name="tindakan" class="w-full border p-2 rounded" required>
                    <?php
                    $tindakan = ['observasi','obat','vitamin','suntik'];
                    foreach($tindakan as $t):
                    ?>
                    <option value="<?= $t ?>" <?= $data['tindakan']==$t ? 'selected' : '' ?>>
                        <?= ucfirst($t) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Status Kesehatan</label>
                <select name="status_kesehatan" class="w-full border p-2 rounded" required>
                    <?php
                    $status = ['sehat','perawatan','sakit'];
                    foreach($status as $s):
                    ?>
                    <option value="<?= $s ?>" <?= $data['status_kesehatan']==$s ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Catatan</label>
                <textarea name="catatan" class="w-full border p-2 rounded"><?= $data['catatan'] ?></textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update
            </button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>