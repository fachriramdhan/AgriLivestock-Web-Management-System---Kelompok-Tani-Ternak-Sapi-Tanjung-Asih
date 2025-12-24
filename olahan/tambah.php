<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['login'])){
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil list user jika admin
if($role==='admin'){
    $qUser = mysqli_query($koneksi, "SELECT id_user, username FROM user WHERE status_akun='aktif'");
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Input Produksi Olahan</h1>

        <form action="simpan.php" method="POST" class="space-y-4 max-w-xl bg-white p-6 rounded shadow">
            <?php if($role==='admin'): ?>
            <div>
                <label class="block mb-1 font-semibold">Peternak</label>
                <select name="id_user" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Peternak --</option>
                    <?php while($u=mysqli_fetch_assoc($qUser)): ?>
                    <option value="<?= $u['id_user'] ?>"><?= $u['username'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>

            <div>
                <label class="block mb-1 font-semibold">Tanggal Produksi</label>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Jenis Olahan</label>
                <select name="jenis_olahan" class="w-full border p-2 rounded" required>
                    <option value="pasteurisasi">Susu Pasteurisasi</option>
                    <option value="yogurt">Yogurt</option>
                    <option value="keju">Keju</option>
                    <option value="mentega">Mentega</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Bahan Baku (Liter)</label>
                <input type="number" name="bahan_baku_liter" class="w-full border p-2 rounded" step="0.01" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Jumlah Hasil</label>
                <input type="number" name="jumlah_hasil" class="w-full border p-2 rounded" step="0.01" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Status Produksi</label>
                <select name="status_produksi" class="w-full border p-2 rounded" required>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Keterangan</label>
                <textarea name="keterangan" class="w-full border p-2 rounded"></textarea>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>