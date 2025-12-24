<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];

// Ambil data anggota
$qData = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY tanggal_gabung DESC");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Data Anggota</h1>
        <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Anggota</a>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Alamat</th>
                    <th class="border p-2">No HP</th>
                    <th class="border p-2">Tanggal Gabung</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=mysqli_fetch_assoc($qData)): ?>
                <tr>
                    <td class="border p-2"><?= $row['nama_anggota'] ?></td>
                    <td class="border p-2"><?= $row['alamat'] ?></td>
                    <td class="border p-2"><?= $row['no_hp'] ?></td>
                    <td class="border p-2"><?= $row['tanggal_gabung'] ?></td>
                    <td class="border p-2"><?= ucfirst($row['status_anggota']) ?></td>
                    <td class="border p-2 text-center">
                        <a href="edit.php?id=<?= $row['id_anggota'] ?>" class="text-blue-600">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_anggota'] ?>" onclick="return confirm('Yakin hapus?')"
                            class="text-red-600 ml-2">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>
<?php include '../includes/footer.php'; ?>