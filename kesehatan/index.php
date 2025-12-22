<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil data sesuai role
$qData = ($role==='admin') ? 
    mysqli_query($koneksi, "SELECT k.*, s.kode_sapi, s.nama_sapi, u.username 
                             FROM kesehatan_sapi k
                             JOIN sapi s ON k.id_sapi=s.id_sapi
                             JOIN user u ON k.id_user=u.id_user
                             ORDER BY k.tanggal DESC")
    :
    mysqli_query($koneksi, "SELECT k.*, s.kode_sapi, s.nama_sapi
                             FROM kesehatan_sapi k
                             JOIN sapi s ON k.id_sapi=s.id_sapi
                             WHERE k.id_user='$id_user_session'
                             ORDER BY k.tanggal DESC");

// Grafik status kesehatan
$qGrafik = mysqli_query($koneksi, "
    SELECT status_kesehatan, COUNT(*) total
    FROM kesehatan_sapi
    ".($role==='user'?"WHERE id_user='$id_user_session'":"")."
    GROUP BY status_kesehatan
");
$status=[]; $total=[];
while($row=mysqli_fetch_assoc($qGrafik)){
    $status[]=$row['status_kesehatan'];
    $total[]=$row['total'];
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Data Kesehatan Sapi</h1>
    <a href="tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Input Kesehatan</a>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Sapi</th>
                    <?php if($role==='admin') echo '<th class="border px-2 py-1">Pemilik</th>'; ?>
                    <th class="border px-2 py-1">Jenis Pemeriksaan</th>
                    <th class="border px-2 py-1">Gejala</th>
                    <th class="border px-2 py-1">Tindakan</th>
                    <th class="border px-2 py-1">Status</th>
                    <th class="border px-2 py-1">Catatan</th>
                    <th class="border px-2 py-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=mysqli_fetch_assoc($qData)): ?>
                <tr>
                    <td class="border px-2 py-1"><?= $row['tanggal'] ?></td>
                    <td class="border px-2 py-1"><?= $row['kode_sapi'].' - '.$row['nama_sapi'] ?></td>
                    <?php if($role==='admin') echo '<td class="border px-2 py-1">'.$row['username'].'</td>'; ?>
                    <td class="border px-2 py-1"><?= $row['jenis_pemeriksaan'] ?></td>
                    <td class="border px-2 py-1"><?= $row['gejala'] ?></td>
                    <td class="border px-2 py-1"><?= $row['tindakan'] ?></td>
                    <td class="border px-2 py-1"><?= $row['status_kesehatan'] ?></td>
                    <td class="border px-2 py-1"><?= $row['catatan'] ?></td>
                    <td class="border px-2 py-1">
                        <?php if($role==='admin' || ($role==='user' && $row['id_user']==$id_user_session)): ?>
                        <a href="edit.php?id=<?= $row['id_kesehatan'] ?>" class="text-blue-600">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_kesehatan'] ?>" onclick="return confirm('Yakin hapus?')"
                            class="text-red-600 ml-2">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="bg-white p-4 rounded shadow mt-6">
        <h2 class="font-semibold mb-4">Grafik Status Kesehatan</h2>
        <canvas id="grafikKesehatan"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('grafikKesehatan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($status) ?>,
            datasets: [{
                label: 'Jumlah Sapi',
                data: <?= json_encode($total) ?>,
                backgroundColor: 'rgb(34,197,94)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</main>

<?php include '../includes/footer.php'; ?>