<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

// Query sesuai role
if ($role == 'admin') {
    $query = "
        SELECT sapi.*, user.username
        FROM sapi
        JOIN user ON sapi.id_user = user.id_user
        ORDER BY sapi.created_at DESC
    ";
} else {
    $query = "
        SELECT *
        FROM sapi
        WHERE id_user = '$id_user'
        ORDER BY created_at DESC
    ";
}

$data = mysqli_query($koneksi, $query);
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
            <h1 class="text-xl font-bold">Data Sapi</h1>
            <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded">
                <i class="fa fa-plus"></i> Tambah Sapi
            </a>
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Kode</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Kategori</th>
                    <th class="border p-2">Kelamin</th>
                    <th class="border p-2">Status</th>
                    <?php if ($role == 'admin'): ?>
                    <th class="border p-2">Pemilik</th>
                    <?php endif; ?>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td class="border p-2"><?= $row['kode_sapi'] ?></td>
                    <td class="border p-2"><?= $row['nama_sapi'] ?></td>
                    <td class="border p-2"><?= ucfirst($row['kategori_sapi']) ?></td>
                    <td class="border p-2"><?= ucfirst($row['jenis_kelamin']) ?></td>
                    <td class="border p-2"><?= $row['status_sapi'] ?></td>

                    <?php if ($role == 'admin'): ?>
                    <td class="border p-2"><?= $row['username'] ?></td>
                    <?php endif; ?>

                    <td class="border p-2 text-center">
                        <a href="edit.php?id=<?= $row['id_sapi'] ?>" class="text-blue-600">
                            <i class="fa fa-edit"></i>
                        </a>

                        <?php if ($role == 'admin'): ?>
                        <a href="hapus.php?id=<?= $row['id_sapi'] ?>"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus sapi ini?')"
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