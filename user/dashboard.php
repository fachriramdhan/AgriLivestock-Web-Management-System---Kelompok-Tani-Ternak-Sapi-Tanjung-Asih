<?php
session_start();

/* PROTEKSI RBAC */
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';
$id_user = $_SESSION['id_user'];

/* ======================
   QUERY STATISTIK USER
   ====================== */

// Jumlah sapi milik user
$qSapi = mysqli_query($koneksi, "
    SELECT COUNT(*) total 
    FROM sapi 
    WHERE id_user='$id_user' 
    AND status_sapi='aktif'
");
$sapi = mysqli_fetch_assoc($qSapi)['total'] ?? 0;

// Produksi susu bulan ini
$qSusu = mysqli_query($koneksi, "
    SELECT SUM(jumlah_liter) total
    FROM produksi_susu
    WHERE id_user='$id_user'
    AND MONTH(tanggal)=MONTH(CURDATE())
");
$susu = 0;

// cek tabel produksi_susu
$cekSusuTable = mysqli_query($koneksi, "
    SELECT COUNT(*) total
    FROM information_schema.tables
    WHERE table_schema = DATABASE()
    AND table_name = 'produksi_susu'
");

$cekSusu = mysqli_fetch_assoc($cekSusuTable)['total'];

if ($cekSusu > 0) {
    $qSusu = mysqli_query($koneksi, "
        SELECT SUM(jumlah_liter) total
        FROM produksi_susu
        WHERE id_user = '$id_user'
        AND MONTH(tanggal) = MONTH(CURDATE())
        AND YEAR(tanggal) = YEAR(CURDATE())
    ");

    $susu = mysqli_fetch_assoc($qSusu)['total'] ?? 0;
}


// Grafik produksi susu per tanggal
$qGrafik = mysqli_query($koneksi, "
    SELECT tanggal, SUM(jumlah_liter) total
    FROM produksi_susu
    WHERE id_user='$id_user'
    GROUP BY tanggal
    ORDER BY tanggal ASC
");

$tanggal = [];
$total = [];
while ($row = mysqli_fetch_assoc($qGrafik)) {
    $tanggal[] = $row['tanggal'];
    $total[] = $row['total'];
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-6">Dashboard Peternak</h1>

        <!-- CARD STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <i class="fa-solid fa-cow text-green-600 text-xl"></i>
                <h2 class="text-sm text-gray-500">Jumlah Sapi Saya</h2>
                <p class="text-2xl font-bold"><?= $sapi ?></p>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <i class="fa-solid fa-mug-hot text-green-600 text-xl"></i>
                <h2 class="text-sm text-gray-500">Produksi Bulan Ini (Liter)</h2>
                <p class="text-2xl font-bold"><?= number_format($susu, 2) ?></p>
            </div>
        </div>

        <!-- GRAFIK -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="font-semibold mb-4">Grafik Produksi Susu Saya</h2>
            <canvas id="grafikUser"></canvas>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxUser = document.getElementById('grafikUser');

new Chart(ctxUser, {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Produksi Susu (Liter)',
            data: <?= json_encode($total) ?>
        }]
    }
});
</script>