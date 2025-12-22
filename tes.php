<?php
// Debug & Error Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// =======================
// Koneksi Database
// =======================
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "db_kelompok_tani";
$port = 3306;

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);
if(!$koneksi){
    die("Koneksi gagal: ".mysqli_connect_error());
}

// =======================
// Ambil Data Produksi Susu
// =======================
$bulan = date('m');
$tahun = date('Y');

$sqlData = "
    SELECT ps.*, s.kode_sapi, s.nama_sapi
    FROM produksi_susu ps
    LEFT JOIN sapi s ON ps.id_sapi = s.id_sapi
    WHERE MONTH(ps.tanggal)='$bulan' AND YEAR(ps.tanggal)='$tahun'
    ORDER BY ps.tanggal DESC
";

$qData = mysqli_query($koneksi, $sqlData);
if(!$qData){
    die("Query Error: ".mysqli_error($koneksi));
}

// Data untuk grafik
$sqlGrafik = "
    SELECT tanggal, SUM(jumlah_liter) total
    FROM produksi_susu
    GROUP BY tanggal
    ORDER BY tanggal
";
$qGrafik = mysqli_query($koneksi, $sqlGrafik);
if(!$qGrafik){
    die("Query Error Grafik: ".mysqli_error($koneksi));
}

$tanggal = [];
$total = [];
while($row = mysqli_fetch_assoc($qGrafik)){
    $tanggal[] = $row['tanggal'];
    $total[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Test Produksi Susu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Data Produksi Susu Bulan <?= $bulan ?>/<?= $tahun ?></h1>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Tanggal</th>
            <th>Sapi</th>
            <th>Jumlah (Liter)</th>
        </tr>
        <?php if(mysqli_num_rows($qData) == 0): ?>
        <tr>
            <td colspan="3">Belum ada data</td>
        </tr>
        <?php else: ?>
        <?php while($row = mysqli_fetch_assoc($qData)): ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= ($row['kode_sapi'] ?? '-') .' - '. ($row['nama_sapi'] ?? '-') ?></td>
            <td><?= number_format($row['jumlah_liter'],2) ?></td>
        </tr>
        <?php endwhile; ?>
        <?php endif; ?>
    </table>

    <h2>Grafik Produksi Susu</h2>
    <canvas id="grafikSusu" width="600" height="300"></canvas>
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>

</html>