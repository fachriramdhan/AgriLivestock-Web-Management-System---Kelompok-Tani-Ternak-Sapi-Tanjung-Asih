<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil jadwal
$qJadwal = ($role==='admin') ?
    mysqli_query($koneksi, "SELECT j.*, u.username FROM jadwal_kegiatan j JOIN user u ON j.dibuat_oleh=u.id_user ORDER BY tanggal, waktu")
    :
    mysqli_query($koneksi, "SELECT j.*, u.username FROM jadwal_kegiatan j JOIN user u ON j.dibuat_oleh=u.id_user ORDER BY tanggal, waktu");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Jadwal Kegiatan</h1>

    <?php if($role==='admin'): ?>
    <a href="tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Jadwal</a>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Waktu</th>
                    <th class="border px-2 py-1">Jenis Kegiatan</th>
                    <th class="border px-2 py-1">Dibuat Oleh</th>
                    <?php if($role==='admin') echo '<th class="border px-2 py-1">Aksi</th>'; ?>
                </tr>
            </thead>
            <tbody>
                <?php while($row=mysqli_fetch_assoc($qJadwal)): ?>
                <tr>
                    <td class="border px-2 py-1"><?= $row['tanggal'] ?></td>
                    <td class="border px-2 py-1"><?= $row['waktu'] ?></td>
                    <td class="border px-2 py-1"><?= ucfirst($row['jenis_kegiatan']) ?></td>
                    <td class="border px-2 py-1"><?= $row['username'] ?></td>
                    <?php if($role==='admin'): ?>
                    <td class="border px-2 py-1">
                        <a href="edit.php?id=<?= $row['id_jadwal'] ?>" class="text-blue-600">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_jadwal'] ?>" onclick="return confirm('Yakin hapus?')"
                            class="text-red-600 ml-2">Hapus</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../includes/footer.php'; ?>