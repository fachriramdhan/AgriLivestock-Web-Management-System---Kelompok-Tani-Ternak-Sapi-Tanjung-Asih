<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php"); exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

$jenis = $_GET['jenis'] ?? '';
$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

if(!$jenis || !$tgl_awal || !$tgl_akhir){
    $_SESSION['error'] = "Parameter laporan tidak lengkap!";
    header("Location: index.php"); exit;
}

// Query sesuai jenis laporan
switch($jenis){
    case 'produksi_susu':
        $sql = ($role==='admin') ?
            "SELECT p.*, s.nama_sapi, u.username FROM produksi_susu p 
             JOIN sapi s ON p.id_sapi=s.id_sapi 
             JOIN user u ON p.id_user=u.id_user
             WHERE p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.tanggal" :
            "SELECT p.*, s.nama_sapi FROM produksi_susu p 
             JOIN sapi s ON p.id_sapi=s.id_sapi
             WHERE p.id_user='$id_user' AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY p.tanggal";
        $judul = "Laporan Produksi Susu";
        break;

    case 'pakan_sapi':
        $sql = ($role==='admin') ?
            "SELECT p.*, s.nama_sapi, u.username FROM pakan_sapi p
             JOIN sapi s ON p.id_sapi=s.id_sapi
             JOIN user u ON p.id_user=u.id_user
             WHERE p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.tanggal" :
            "SELECT p.*, s.nama_sapi FROM pakan_sapi p
             JOIN sapi s ON p.id_sapi=s.id_sapi
             WHERE p.id_user='$id_user' AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY p.tanggal";
        $judul = "Laporan Pakan Sapi";
        break;

    case 'kesehatan_sapi':
        $sql = ($role==='admin') ?
            "SELECT k.*, s.nama_sapi, u.username FROM kesehatan_sapi k
             JOIN sapi s ON k.id_sapi=s.id_sapi
             JOIN user u ON k.id_user=u.id_user
             WHERE k.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY k.tanggal" :
            "SELECT k.*, s.nama_sapi FROM kesehatan_sapi k
             JOIN sapi s ON k.id_sapi=s.id_sapi
             WHERE k.id_user='$id_user' AND k.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY k.tanggal";
        $judul = "Laporan Kesehatan Sapi";
        break;

    case 'populasi_sapi':
        $sql = ($role==='admin') ?
            "SELECT s.*, u.username FROM sapi s
             JOIN user u ON s.id_user=u.id_user
             ORDER BY s.kode_sapi" :
            "SELECT * FROM sapi WHERE id_user='$id_user' ORDER BY kode_sapi";
        $judul = "Laporan Populasi Sapi";
        break;

    case 'produksi_olahan':
        $sql = ($role==='admin') ?
            "SELECT o.*, u.username FROM produksi_olahan o
             JOIN user u ON o.id_user=u.id_user
             WHERE o.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY o.tanggal" :
            "SELECT * FROM produksi_olahan
             WHERE id_user='$id_user' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal";
        $judul = "Laporan Produksi Olahan";
        break;

    default:
        die("Jenis laporan tidak valid.");
}

$qData = mysqli_query($koneksi, $sql);
if(!$qData){
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex min-h-screen">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4"><?= $judul ?></h1>

        <div class="flex justify-end gap-2 mb-4">
            <a href="export_excel.php?jenis=<?= $jenis ?>&tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Export Excel</a>
            <a href="export_pdf.php?jenis=<?= $jenis ?>&tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>"
                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Export PDF</a>
        </div>

        <p class="mb-4">Periode: <?= $tgl_awal ?> s/d <?= $tgl_akhir ?></p>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <?php
                        // Header tabel
                        switch($jenis){
                            case 'produksi_susu':
                                echo "<th class='border px-2 py-1'>Tanggal</th>";
                                if($role==='admin') echo "<th class='border px-2 py-1'>Peternak</th>";
                                echo "<th class='border px-2 py-1'>Nama Sapi</th>
                                      <th class='border px-2 py-1'>Jumlah (Liter)</th>
                                      <th class='border px-2 py-1'>Waktu</th>
                                      <th class='border px-2 py-1'>Status</th>";
                                break;
                            case 'pakan_sapi':
                                echo "<th class='border px-2 py-1'>Tanggal</th>";
                                if($role==='admin') echo "<th class='border px-2 py-1'>Peternak</th>";
                                echo "<th class='border px-2 py-1'>Nama Sapi</th>
                                      <th class='border px-2 py-1'>Jenis Pakan</th>
                                      <th class='border px-2 py-1'>Waktu</th>
                                      <th class='border px-2 py-1'>Jumlah (Kg)</th>";
                                break;
                            case 'kesehatan_sapi':
                                echo "<th class='border px-2 py-1'>Tanggal</th>";
                                if($role==='admin') echo "<th class='border px-2 py-1'>Peternak</th>";
                                echo "<th class='border px-2 py-1'>Nama Sapi</th>
                                      <th class='border px-2 py-1'>Jenis Pemeriksaan</th>
                                      <th class='border px-2 py-1'>Gejala</th>
                                      <th class='border px-2 py-1'>Tindakan</th>
                                      <th class='border px-2 py-1'>Status</th>";
                                break;
                            case 'populasi_sapi':
                                if($role==='admin') echo "<th class='border px-2 py-1'>Peternak</th>";
                                echo "<th class='border px-2 py-1'>Kode Sapi</th>
                                      <th class='border px-2 py-1'>Nama Sapi</th>
                                      <th class='border px-2 py-1'>Jenis Kelamin</th>
                                      <th class='border px-2 py-1'>Kategori</th>
                                      <th class='border px-2 py-1'>Umur (Bulan)</th>
                                      <th class='border px-2 py-1'>Status</th>";
                                break;
                            case 'produksi_olahan':
                                echo "<th class='border px-2 py-1'>Tanggal</th>";
                                if($role==='admin') echo "<th class='border px-2 py-1'>Peternak</th>";
                                echo "<th class='border px-2 py-1'>Jenis Olahan</th>
                                      <th class='border px-2 py-1'>Bahan Baku</th>
                                      <th class='border px-2 py-1'>Jumlah Hasil</th>
                                      <th class='border px-2 py-1'>Status</th>";
                                break;
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row=mysqli_fetch_assoc($qData)): ?>
                    <tr>
                        <?php
                            // Data tabel
                            switch($jenis){
                                case 'produksi_susu':
                                    echo "<td class='border px-2 py-1'>{$row['tanggal']}</td>";
                                    if($role==='admin') echo "<td class='border px-2 py-1'>{$row['username']}</td>";
                                    echo "<td class='border px-2 py-1'>{$row['nama_sapi']}</td>
                                          <td class='border px-2 py-1'>{$row['jumlah_liter']}</td>
                                          <td class='border px-2 py-1'>{$row['waktu_pemerahan']}</td>
                                          <td class='border px-2 py-1'>{$row['status_data']}</td>";
                                    break;
                                case 'pakan_sapi':
                                    echo "<td class='border px-2 py-1'>{$row['tanggal']}</td>";
                                    if($role==='admin') echo "<td class='border px-2 py-1'>{$row['username']}</td>";
                                    echo "<td class='border px-2 py-1'>{$row['nama_sapi']}</td>
                                          <td class='border px-2 py-1'>{$row['jenis_pakan']}</td>
                                          <td class='border px-2 py-1'>{$row['waktu_pemberian']}</td>
                                          <td class='border px-2 py-1'>{$row['jumlah_kg']}</td>";
                                    break;
                                case 'kesehatan_sapi':
                                    echo "<td class='border px-2 py-1'>{$row['tanggal']}</td>";
                                    if($role==='admin') echo "<td class='border px-2 py-1'>{$row['username']}</td>";
                                    echo "<td class='border px-2 py-1'>{$row['nama_sapi']}</td>
                                          <td class='border px-2 py-1'>{$row['jenis_pemeriksaan']}</td>
                                          <td class='border px-2 py-1'>{$row['gejala']}</td>
                                          <td class='border px-2 py-1'>{$row['tindakan']}</td>
                                          <td class='border px-2 py-1'>{$row['status_kesehatan']}</td>";
                                    break;
                                case 'populasi_sapi':
                                    if($role==='admin') echo "<td class='border px-2 py-1'>{$row['username']}</td>";
                                    echo "<td class='border px-2 py-1'>{$row['kode_sapi']}</td>
                                          <td class='border px-2 py-1'>{$row['nama_sapi']}</td>
                                          <td class='border px-2 py-1'>{$row['jenis_kelamin']}</td>
                                          <td class='border px-2 py-1'>{$row['kategori_sapi']}</td>
                                          <td class='border px-2 py-1'>{$row['umur_bulan']}</td>
                                          <td class='border px-2 py-1'>{$row['status_sapi']}</td>";
                                    break;
                                case 'produksi_olahan':
                                    echo "<td class='border px-2 py-1'>{$row['tanggal']}</td>";
                                    if($role==='admin') echo "<td class='border px-2 py-1'>{$row['username']}</td>";
                                    echo "<td class='border px-2 py-1'>{$row['jenis_olahan']}</td>
                                          <td class='border px-2 py-1'>{$row['bahan_baku_liter']}</td>
                                          <td class='border px-2 py-1'>{$row['jumlah_hasil']}</td>
                                          <td class='border px-2 py-1'>{$row['status_produksi']}</td>";
                                    break;
                            }
                            ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>