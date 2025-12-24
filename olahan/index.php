<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['login'])){
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil data sesuai role
$qData = ($role==='admin') ?
    mysqli_query($koneksi, "SELECT o.*, u.username 
                             FROM produksi_olahan o 
                             JOIN user u ON o.id_user=u.id_user 
                             ORDER BY tanggal DESC")
    :
    mysqli_query($koneksi, "SELECT * FROM produksi_olahan 
                             WHERE id_user='$id_user_session' 
                             ORDER BY tanggal DESC");

// Grafik produksi olahan per jenis
$qGrafik = mysqli_query($koneksi, "
    SELECT jenis_olahan, SUM(jumlah_hasil) total
    FROM produksi_olahan
    ".($role==='user'?"WHERE id_user='$id_user_session'":"")."
    GROUP BY jenis_olahan
");
$jenis=[]; $total=[];
while($row=mysqli_fetch_assoc($qGrafik)){
    $jenis[]=$row['jenis_olahan'];
    $total[]=$row['total'];
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Produksi Olahan</h1>
        <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Input Produksi Olahan
        </a>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Tanggal</th>
                        <?php if($role==='admin') echo '<th class="border p-2">Peternak</th>'; ?>
                        <th class="border p-2">Jenis Olahan</th>
                        <th class="border p-2">Bahan Baku (Liter)</th>
                        <th class="border p-2">Jumlah Hasil</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Keterangan</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row=mysqli_fetch_assoc($qData)): ?>
                    <tr>
                        <td class="border p-2"><?= $row['tanggal'] ?></td>
                        <?php if($role==='admin') echo '<td class="border p-2">'.$row['username'].'</td>'; ?>
                        <td class="border p-2"><?= ucfirst($row['jenis_olahan']) ?></td>
                        <td class="border p-2"><?= number_format($row['bahan_baku_liter'],2) ?></td>
                        <td class="border p-2"><?= number_format($row['jumlah_hasil'],2) ?></td>
                        <td class="border p-2"><?= ucfirst($row['status_produksi']) ?></td>
                        <td class="border p-2"><?= $row['keterangan'] ?></td>
                        <td class="border p-2 text-center">
                            <?php if($role==='admin' || ($role==='user' && $row['id_user']==$id_user_session)): ?>
                            <a href="edit.php?id=<?= $row['id_olahan'] ?>" class="text-blue-600">Edit</a>
                            <a href="hapus.php?id=<?= $row['id_olahan'] ?>" onclick="return confirm('Yakin hapus?')"
                                class="text-red-600 ml-2">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white p-4 rounded shadow mt-6">
            <h2 class="font-semibold mb-4">Grafik Produksi Olahan</h2>
            <canvas id="grafikOlahan"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const ctx = document.getElementById('grafikOlahan').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($jenis) ?>,
                datasets: [{
                    label: 'Jumlah Hasil (Liter/Kg)',
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
</div>

<?php include '../includes/footer.php'; ?>