<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) session_start();

require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

// Query data kesehatan sesuai role
if ($role == 'admin') {
    $query = "
        SELECT k.*, s.kode_sapi, s.nama_sapi, s.kategori_sapi, s.jenis_kelamin, s.status_sapi, u.username
        FROM kesehatan_sapi k
        JOIN sapi s ON k.id_sapi = s.id_sapi
        JOIN user u ON k.id_user = u.id_user
        ORDER BY k.tanggal DESC
    ";
} else {
    $query = "
        SELECT k.*, s.kode_sapi, s.nama_sapi, s.kategori_sapi, s.jenis_kelamin, s.status_sapi
        FROM kesehatan_sapi k
        JOIN sapi s ON k.id_sapi = s.id_sapi
        WHERE k.id_user = '$id_user'
        ORDER BY k.tanggal DESC
    ";
}

$data = mysqli_query($koneksi, $query);
if (!$data) {
    die("Query data kesehatan gagal: " . mysqli_error($koneksi));
}

// Data untuk grafik status kesehatan
$qGrafik = mysqli_query($koneksi, "
    SELECT status_kesehatan, COUNT(*) total
    FROM kesehatan_sapi
    ".($role==='user' ? "WHERE id_user='$id_user'" : "")."
    GROUP BY status_kesehatan
");

$status = [];
$total = [];
while ($row = mysqli_fetch_assoc($qGrafik)) {
    $status[] = $row['status_kesehatan'];
    $total[] = $row['total'];
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Kesehatan Sapi</h1>
        <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
            <i class="fa fa-plus"></i> Tambah Data
        </a>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Kode</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Kategori</th>
                        <th class="border p-2">Kelamin</th>
                        <th class="border p-2">Status</th>
                        <?php if($role == 'admin'): ?>
                        <th class="border p-2">Pemilik</th>
                        <?php endif; ?>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($data)) : ?>
                    <tr>
                        <td class="border p-2"><?= $row['kode_sapi'] ?></td>
                        <td class="border p-2"><?= $row['nama_sapi'] ?></td>
                        <td class="border p-2"><?= ucfirst($row['kategori_sapi']) ?></td>
                        <td class="border p-2"><?= ucfirst($row['jenis_kelamin']) ?></td>
                        <td class="border p-2"><?= $row['status_sapi'] ?></td>
                        <?php if($role == 'admin'): ?>
                        <td class="border p-2"><?= $row['username'] ?></td>
                        <?php endif; ?>
                        <td class="border p-2 text-center">
                            <a href="edit.php?id=<?= $row['id_kesehatan'] ?>" class="text-blue-600">
                                <i class="fa fa-edit"></i>
                            </a>
                            <?php if($role == 'admin'): ?>
                            <a href="hapus.php?id=<?= $row['id_kesehatan'] ?>" onclick="return confirm('Yakin hapus?')"
                                class="text-red-600 ml-2">
                                <i class="fa fa-trash"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Grafik Chart.js -->
        <div class="bg-white p-4 rounded shadow mt-6">
            <h2 class="font-semibold mb-4">Grafik Status Kesehatan</h2>
            <canvas id="grafikKesehatan"></canvas>
        </div>
    </main>
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

<?php include '../includes/footer.php'; ?>