<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil data pakan sesuai role
if ($role === 'admin') {
    $qData = mysqli_query($koneksi, "
        SELECT p.*, s.kode_sapi, s.nama_sapi, u.username
        FROM pakan_sapi p
        JOIN sapi s ON p.id_sapi=s.id_sapi
        JOIN user u ON p.id_user=u.id_user
        ORDER BY p.tanggal DESC
    ");
} else {
    $qData = mysqli_query($koneksi, "
        SELECT p.*, s.kode_sapi, s.nama_sapi
        FROM pakan_sapi p
        JOIN sapi s ON p.id_sapi=s.id_sapi
        WHERE p.id_user='$id_user_session'
        ORDER BY p.tanggal DESC
    ");
}

// Grafik konsumsi pakan per tanggal
$qGrafik = mysqli_query($koneksi, "
    SELECT tanggal, SUM(jumlah_kg) total
    FROM pakan_sapi
    ".($role==='user' ? "WHERE id_user='$id_user_session'" : "")."
    GROUP BY tanggal
    ORDER BY tanggal
");

$tanggal = [];
$total = [];
while($row=mysqli_fetch_assoc($qGrafik)){
    $tanggal[] = $row['tanggal'];
    $total[] = $row['total'];
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="flex-1 p-6">
    <h1 class="text-xl font-bold mb-4">Data Pakan Sapi</h1>

    <?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded"><?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <a href="tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Input Pakan</a>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Sapi</th>
                    <?php if($role==='admin') echo '<th class="border px-2 py-1">Pemilik</th>'; ?>
                    <th class="border px-2 py-1">Jenis Pakan</th>
                    <th class="border px-2 py-1">Waktu</th>
                    <th class="border px-2 py-1">Jumlah (Kg)</th>
                    <th class="border px-2 py-1">Keterangan</th>
                    <th class="border px-2 py-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row=mysqli_fetch_assoc($qData)): ?>
                <tr>
                    <td class="border px-2 py-1"><?= $row['tanggal'] ?></td>
                    <td class="border px-2 py-1"><?= $row['kode_sapi'].' - '.$row['nama_sapi'] ?></td>
                    <?php if($role==='admin') echo '<td class="border px-2 py-1">'.$row['username'].'</td>'; ?>
                    <td class="border px-2 py-1"><?= ucfirst($row['jenis_pakan']) ?></td>
                    <td class="border px-2 py-1"><?= ucfirst($row['waktu_pemberian']) ?></td>
                    <td class="border px-2 py-1"><?= number_format($row['jumlah_kg'],2) ?></td>
                    <td class="border px-2 py-1"><?= $row['keterangan'] ?></td>
                    <td class="border px-2 py-1">
                        <?php if($role==='admin' || ($role==='user' && $row['id_user']==$id_user_session)): ?>
                        <a href="edit.php?id=<?= $row['id_pakan'] ?>" class="text-blue-600">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_pakan'] ?>" onclick="return confirm('Yakin hapus?')"
                            class="text-red-600 ml-2">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Grafik Chart.js -->
    <div class="bg-white p-4 rounded shadow mt-6">
        <h2 class="font-semibold mb-4">Grafik Konsumsi Pakan (Kg)</h2>
        <canvas id="grafikPakan"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('grafikPakan').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($tanggal) ?>,
            datasets: [{
                label: 'Jumlah Pakan (Kg)',
                data: <?= json_encode($total) ?>,
                borderColor: 'rgb(34,197,94)',
                backgroundColor: 'rgba(34,197,94,0.2)',
                fill: true,
                tension: 0.3
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