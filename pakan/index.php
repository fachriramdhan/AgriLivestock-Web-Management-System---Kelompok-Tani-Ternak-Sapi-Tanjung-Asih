<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

// Query data pakan sesuai role
if ($role == 'admin') {
    $query = "
        SELECT pakan_sapi.*, sapi.kode_sapi, sapi.nama_sapi, user.username
        FROM pakan_sapi
        JOIN sapi ON pakan_sapi.id_sapi = sapi.id_sapi
        JOIN user ON pakan_sapi.id_user = user.id_user
        ORDER BY pakan_sapi.tanggal DESC
    ";
} else {
    $query = "
        SELECT pakan_sapi.*, sapi.kode_sapi, sapi.nama_sapi
        FROM pakan_sapi
        JOIN sapi ON pakan_sapi.id_sapi = sapi.id_sapi
        WHERE pakan_sapi.id_user = '$id_user'
        ORDER BY pakan_sapi.tanggal DESC
    ";
}

$data = mysqli_query($koneksi, $query);
if (!$data) {
    die("Query data pakan gagal: " . mysqli_error($koneksi));
}
?>

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

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-bold">Data Pakan Sapi</h1>
            <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded">
                <i class="fa fa-plus"></i> Input Pakan
            </a>
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Sapi</th>
                    <?php if($role == 'admin'): ?>
                    <th class="border p-2">Pemilik</th>
                    <?php endif; ?>
                    <th class="border p-2">Jenis Pakan</th>
                    <th class="border p-2">Waktu</th>
                    <th class="border p-2">Jumlah (Kg)</th>
                    <th class="border p-2">Keterangan</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td class="border p-2"><?= $row['tanggal'] ?></td>
                    <td class="border p-2"><?= $row['kode_sapi'] . ' - ' . $row['nama_sapi'] ?></td>
                    <?php if($role == 'admin'): ?>
                    <td class="border p-2"><?= $row['username'] ?></td>
                    <?php endif; ?>
                    <td class="border p-2"><?= ucfirst($row['jenis_pakan']) ?></td>
                    <td class="border p-2"><?= ucfirst($row['waktu_pemberian']) ?></td>
                    <td class="border p-2"><?= number_format($row['jumlah_kg'],2) ?></td>
                    <td class="border p-2"><?= $row['keterangan'] ?></td>
                    <td class="border p-2 text-center">
                        <a href="edit.php?id=<?= $row['id_pakan'] ?>" class="text-blue-600">
                            <i class="fa fa-edit"></i>
                        </a>
                        <?php if($role == 'admin'): ?>
                        <a href="hapus.php?id=<?= $row['id_pakan'] ?>"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                            class="text-red-600 ml-2">
                            <i class="fa fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>

<?php include '../includes/footer.php'; ?>