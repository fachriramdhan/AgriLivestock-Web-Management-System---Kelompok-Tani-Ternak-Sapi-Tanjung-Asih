<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

// Ambil semua user beserta nama anggota
$qData = mysqli_query($koneksi, "
    SELECT u.*, a.nama_anggota 
    FROM user u 
    LEFT JOIN anggota a ON u.id_anggota = a.id_anggota
    ORDER BY u.username
");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Data User</h1>
        <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah User</a>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Username</th>
                    <th class="border p-2">Nama Anggota</th>
                    <th class="border p-2">Role</th>
                    <th class="border p-2">Status Akun</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=mysqli_fetch_assoc($qData)): ?>
                <tr>
                    <td class="border p-2"><?= $row['username'] ?></td>
                    <td class="border p-2"><?= $row['nama_anggota'] ?? '-' ?></td>
                    <td class="border p-2"><?= ucfirst($row['role']) ?></td>
                    <td class="border p-2"><?= ucfirst($row['status_akun']) ?></td>
                    <td class="border p-2 text-center">
                        <a href="edit.php?id=<?= $row['id_user'] ?>" class="text-blue-600">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_user'] ?>" onclick="return confirm('Yakin hapus?')"
                            class="text-red-600 ml-2">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>
<?php include '../includes/footer.php'; ?>