<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

// Filter bulan/tahun
$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

// =======================
// Query Data Produksi Susu
// =======================
if ($role === 'admin') {
    $sql = "
        SELECT ps.*, s.kode_sapi, s.nama_sapi, u.username
        FROM produksi_susu ps
        LEFT JOIN sapi s ON ps.id_sapi = s.id_sapi
        LEFT JOIN user u ON ps.id_user = u.id_user
        WHERE MONTH(ps.tanggal)='$bulan' AND YEAR(ps.tanggal)='$tahun'
        ORDER BY ps.tanggal DESC
    ";
} else {
    $sql = "
        SELECT ps.*, s.kode_sapi, s.nama_sapi
        FROM produksi_susu ps
        LEFT JOIN sapi s ON ps.id_sapi = s.id_sapi
        WHERE ps.id_user='$id_user' AND MONTH(ps.tanggal)='$bulan' AND YEAR(ps.tanggal)='$tahun'
        ORDER BY ps.tanggal DESC
    ";
}

$data = mysqli_query($koneksi, $sql);
if (!$data) {
    die("Query Error: " . mysqli_error($koneksi));
}

// =======================
// Query Data Grafik
// =======================
$sqlGrafik = "
    SELECT tanggal, SUM(jumlah_liter) total
    FROM produksi_susu
    " . ($role==='user' ? "WHERE id_user='$id_user'" : "") . "
    GROUP BY tanggal
    ORDER BY tanggal
";
$qGrafik = mysqli_query($koneksi, $sqlGrafik);
$tanggal = $total = [];
while ($row = mysqli_fetch_assoc($qGrafik)) {
    $tanggal[] = $row['tanggal'];
    $total[] = $row['total'];
}

// =======================
// Include Layout
// =======================
$includes_path = realpath(__DIR__ . '/../includes/');
include $includes_path . '/header.php';
include $includes_path . '/navbar.php';
?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>
    <main class="flex-1 p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-bold">Produksi Susu</h1>
            <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded">
                <i class="fa fa-plus"></i> Input Produksi Susu
            </a>
        </div>

        <!-- Notifikasi -->
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

        <!-- Filter Bulan/Tahun -->
        <form method="GET" class="mb-4 flex gap-2 items-center">
            <input type="month" name="bulan_tahun" value="<?= $tahun.'-'.str_pad($bulan,2,'0',STR_PAD_LEFT) ?>"
                onchange="this.form.submit()">
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Sapi</th>
                        <?php if ($role === 'admin'): ?>
                        <th class="border p-2">Pemilik</th>
                        <?php endif; ?>
                        <th class="border p-2">Waktu</th>
                        <th class="border p-2">Jumlah (L)</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($data) == 0): ?>
                    <tr>
                        <td colspan="<?= $role==='admin'?7:6 ?>" class="text-center py-2">Belum ada data</td>
                    </tr>
                    <?php else: ?>
                    <?php while($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="border p-2"><?= $row['tanggal'] ?></td>
                        <td class="border p-2"><?= ($row['kode_sapi']??'-') .' - '. ($row['nama_sapi']??'-') ?></td>
                        <?php if ($role === 'admin'): ?>
                        <td class="border p-2"><?= ($row['username']??'-') ?></td>
                        <?php endif; ?>
                        <td class="border p-2"><?= ucfirst($row['waktu_pemerahan']??'-') ?></td>
                        <td class="border p-2"><?= number_format($row['jumlah_liter']??0,2) ?></td>
                        <td class="border p-2"><?= ucfirst($row['status_data']??'-') ?></td>
                        <td class="border p-2 text-center">
                            <a href="edit.php?id=<?= $row['id_produksi'] ?>" class="text-blue-600">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id_produksi'] ?>"
                                onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 ml-2">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Grafik -->
        <div class="bg-white p-4 rounded shadow mt-6">
            <h2 class="font-semibold mb-4">Grafik Produksi Susu</h2>
            <canvas id="grafikSusu"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const ctx = document.getElementById('grafikSusu').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($tanggal) ?>,
                datasets: [{
                    label: 'Produksi Susu (Liter)',
                    data: <?= json_encode($total) ?>,
                    borderColor: 'rgb(34,197,94)',
                    backgroundColor: 'rgba(34,197,94,0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
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

<?php include $includes_path.'/footer.php'; ?>