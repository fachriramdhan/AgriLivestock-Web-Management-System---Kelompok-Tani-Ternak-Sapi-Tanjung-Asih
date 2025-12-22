<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
?>

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


<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Tambah Data Sapi</h1>

        <form action="simpan.php" method="POST" class="space-y-4 max-w-xl">

            <?php if ($role == 'admin'): ?>
            <div>
                <label>Pemilik</label>
                <select name="id_user" class="w-full border p-2" required>
                    <option value="">-- Pilih User --</option>
                    <?php
        $user = mysqli_query($koneksi, "SELECT id_user, username FROM user WHERE role='user'");
        while ($u = mysqli_fetch_assoc($user)):
        ?>
                    <option value="<?= $u['id_user'] ?>"><?= $u['username'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>

            <div>
                <label>Kode Sapi</label>
                <input type="text" name="kode_sapi" class="w-full border p-2" required>
            </div>

            <div>
                <label>Nama Sapi</label>
                <input type="text" name="nama_sapi" class="w-full border p-2">
            </div>

            <div>
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border p-2" required>
                    <option value="jantan">Jantan</option>
                    <option value="betina">Betina</option>
                </select>
            </div>

            <div>
                <label>Kategori</label>
                <select name="kategori_sapi" class="w-full border p-2" required>
                    <option value="pedet">Pedet</option>
                    <option value="dara">Dara</option>
                    <option value="induk">Induk</option>
                    <option value="pejantan">Pejantan</option>
                </select>
            </div>

            <div>
                <label>Umur (bulan)</label>
                <input type="number" name="umur_bulan" class="w-full border p-2" required>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Simpan
            </button>

        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>