<?php
// Tampilkan semua error (untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek session, jika belum aktif, mulai session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi database
require_once '../config/database.php';

// Cek login
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil daftar sapi untuk dropdown
if ($role === 'admin') {
    $qSapi = mysqli_query($koneksi, "SELECT sapi.id_sapi, sapi.kode_sapi, sapi.nama_sapi FROM sapi ORDER BY kode_sapi ASC");
} else {
    $qSapi = mysqli_query($koneksi, "SELECT id_sapi, kode_sapi, nama_sapi FROM sapi WHERE id_user='$id_user_session' ORDER BY kode_sapi ASC");
}

// Proses submit form
if (isset($_POST['submit'])) {
    $id_sapi = $_POST['id_sapi'];
    $tanggal = $_POST['tanggal'];
    $jenis_pakan = $_POST['jenis_pakan'];
    $waktu_pemberian = $_POST['waktu_pemberian'];
    $jumlah_kg = $_POST['jumlah_kg'];
    $keterangan = $_POST['keterangan'];

    // Jika user, id_user ambil dari session
    $id_user = ($role === 'admin') ? $_POST['id_user'] : $id_user_session;

    $insert = mysqli_query($koneksi, "
        INSERT INTO pakan_sapi (id_sapi, id_user, tanggal, jenis_pakan, waktu_pemberian, jumlah_kg, keterangan)
        VALUES ('$id_sapi', '$id_user', '$tanggal', '$jenis_pakan', '$waktu_pemberian', '$jumlah_kg', '$keterangan')
    ");

    if ($insert) {
        $_SESSION['success'] = "Data pakan berhasil ditambahkan.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal menambahkan data: ".mysqli_error($koneksi);
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Tambah Data Pakan Sapi</h1>

        <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-6 rounded shadow max-w-lg">
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Sapi</label>
                <select name="id_sapi" required class="w-full border p-2 rounded">
                    <option value="">-- Pilih Sapi --</option>
                    <?php while($sapi = mysqli_fetch_assoc($qSapi)): ?>
                    <option value="<?= $sapi['id_sapi'] ?>"><?= $sapi['kode_sapi'].' - '.$sapi['nama_sapi'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <?php if($role==='admin'): ?>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Pemilik (ID User)</label>
                <input type="number" name="id_user" placeholder="ID User" class="w-full border p-2 rounded">
                <small class="text-gray-500">Masukkan ID User pemilik sapi</small>
            </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Tanggal</label>
                <input type="date" name="tanggal" required class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Jenis Pakan</label>
                <select name="jenis_pakan" required class="w-full border p-2 rounded">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="rumput">Rumput</option>
                    <option value="konsentrat">Konsentrat</option>
                    <option value="jerami">Jerami</option>
                    <option value="ampas_tahu">Ampas Tahu</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Waktu Pemberian</label>
                <select name="waktu_pemberian" required class="w-full border p-2 rounded">
                    <option value="">-- Pilih Waktu --</option>
                    <option value="pagi">Pagi</option>
                    <option value="siang">Siang</option>
                    <option value="sore">Sore</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Jumlah (Kg)</label>
                <input type="number" step="0.01" name="jumlah_kg" required class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Keterangan</label>
                <textarea name="keterangan" class="w-full border p-2 rounded"></textarea>
            </div>

            <button type="submit" name="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>