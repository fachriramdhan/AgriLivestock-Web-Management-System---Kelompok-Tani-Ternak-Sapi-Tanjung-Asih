<?php
session_start();

/* =========================
   PROTEKSI RBAC ADMIN
   ========================= */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

/* =========================
   TOTAL ANGGOTA
   ========================= */
$qAnggota = mysqli_query($koneksi, "SELECT COUNT(*) total FROM anggota");
$anggota  = mysqli_fetch_assoc($qAnggota)['total'] ?? 0;

/* =========================
   TOTAL SAPI AKTIF
   (AMAN JIKA TABEL BELUM ADA)
   ========================= */
$sapi = 0;

// cek tabel sapi
$cekSapiTable = mysqli_query($koneksi, "
    SELECT COUNT(*) total
    FROM information_schema.tables
    WHERE table_schema = DATABASE()
    AND table_name = 'sapi'
");

$cekSapi = mysqli_fetch_assoc($cekSapiTable)['total'];

if ($cekSapi > 0) {
    $qSapiAktif = mysqli_query($koneksi, "
        SELECT COUNT(*) total
        FROM sapi
        WHERE status_sapi = 'aktif'
    ");
    $sapi = mysqli_fetch_assoc($qSapiAktif)['total'] ?? 0;
}

/* =========================
   PRODUKSI SUSU BULAN INI
   ========================= */
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
        WHERE MONTH(tanggal) = MONTH(CURDATE())
        AND YEAR(tanggal) = YEAR(CURDATE())
    ");
    $susu = mysqli_fetch_assoc($qSusu)['total'] ?? 0;
}

/* =========================
   GRAFIK PRODUKSI SUSU
   ========================= */
$bulan = [];
$totalSusu = [];

if ($cekSusu > 0) {
    $qGrafik = mysqli_query($koneksi, "
        SELECT MONTH(tanggal) bulan, SUM(jumlah_liter) total
        FROM produksi_susu
        GROUP BY MONTH(tanggal)
        ORDER BY MONTH(tanggal)
    ");

    while ($row = mysqli_fetch_assoc($qGrafik)) {
        $bulan[] = $row['bulan'];
        $totalSusu[] = $row['total'];
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex h-screen overflow-hidden">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6 overflow-auto">
        <h1 class="text-xl font-bold mb-6">Dashboard Admin</h1>

        <!-- STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center">
                <i class="fa-solid fa-users text-green-600 text-2xl mb-2"></i>
                <h2 class="text-sm text-gray-500">Total Anggota</h2>
                <p class="text-2xl font-bold"><?= $anggota ?></p>
            </div>

            <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center">
                <i class="fa-solid fa-cow text-green-600 text-2xl mb-2"></i>
                <h2 class="text-sm text-gray-500">Sapi Aktif</h2>
                <p class="text-2xl font-bold"><?= $sapi ?></p>
            </div>

            <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center">
                <i class="fa-solid fa-mug-hot text-green-600 text-2xl mb-2"></i>
                <h2 class="text-sm text-gray-500">Produksi Bulan Ini (Liter)</h2>
                <p class="text-2xl font-bold"><?= number_format($susu, 2) ?></p>
            </div>
        </div>

        <!-- GRAFIK -->
        <div class="bg-white p-6 rounded shadow" style="height: 50vh;">
            <h2 class="font-semibold mb-4">Grafik Produksi Susu</h2>
            <canvas id="grafikSusu" class="h-full w-full"></canvas>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikSusu').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: 'Produksi Susu (Liter)',
            data: <?= json_encode($totalSusu) ?>,
            backgroundColor: 'rgb(34,197,94)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>