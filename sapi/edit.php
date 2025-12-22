<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil ID sapi
$id_sapi = $_GET['id'] ?? 0;

if ($id_sapi <= 0) {
    header("Location: index.php");
    exit;
}

// Ambil data sapi
$query = "SELECT * FROM sapi WHERE id_sapi = '$id_sapi'";
$result = mysqli_query($koneksi, $query);
$sapi = mysqli_fetch_assoc($result);

if (!$sapi) {
    $_SESSION['error'] = "Data sapi tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Validasi role user: hanya bisa edit sapi miliknya
if ($role === 'user' && $sapi['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk mengedit sapi ini!";
    header("Location: index.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Edit Data Sapi</h1>

        <form action="update.php" method="POST" class="space-y-4 max-w-xl">

            <input type="hidden" name="id_sapi" value="<?= $sapi['id_sapi'] ?>">

            <?php if ($role == 'admin'): ?>
            <div>
                <label>Pemilik</label>
                <select name="id_user" class="w-full border p-2" required>
                    <?php
        $users = mysqli_query($koneksi, "SELECT id_user, username FROM user WHERE role='user'");
        while ($u = mysqli_fetch_assoc($users)):
        ?>
                    <option value="<?= $u['id_user'] ?>" <?= $u['id_user'] == $sapi['id_user'] ? 'selected' : '' ?>>
                        <?= $u['username'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>

            <div>
                <label>Kode Sapi</label>
                <input type="text" name="kode_sapi" class="w-full border p-2" value="<?= $sapi['kode_sapi'] ?>"
                    required>
            </div>

            <div>
                <label>Nama Sapi</label>
                <input type="text" name="nama_sapi" class="w-full border p-2" value="<?= $sapi['nama_sapi'] ?>">
            </div>

            <div>
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border p-2" required>
                    <option value="jantan" <?= $sapi['jenis_kelamin'] == 'jantan' ? 'selected' : '' ?>>Jantan</option>
                    <option value="betina" <?= $sapi['jenis_kelamin'] == 'betina' ? 'selected' : '' ?>>Betina</option>
                </select>
            </div>

            <div>
                <label>Kategori</label>
                <select name="kategori_sapi" class="w-full border p-2" required>
                    <?php
        $kategori = ['pedet','dara','induk','pejantan'];
        foreach ($kategori as $k) {
            $sel = $sapi['kategori_sapi'] == $k ? 'selected' : '';
            echo "<option value='$k' $sel>".ucfirst($k)."</option>";
        }
        ?>
                </select>
            </div>

            <div>
                <label>Umur (bulan)</label>
                <input type="number" name="umur_bulan" class="w-full border p-2" value="<?= $sapi['umur_bulan'] ?>"
                    required>
            </div>

            <div>
                <label>Status Sapi</label>
                <select name="status_sapi" class="w-full border p-2" required>
                    <?php
        $status = ['aktif','dijual','mati'];
        foreach ($status as $s) {
            $sel = $sapi['status_sapi'] == $s ? 'selected' : '';
            echo "<option value='$s' $sel>".ucfirst($s)."</option>";
        }
        ?>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>

        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>