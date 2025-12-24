<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if(!$id){
    $_SESSION['error'] = "ID user tidak ditemukan.";
    header("Location: index.php");
    exit;
}

$qUser = mysqli_query($koneksi,"SELECT * FROM user WHERE id_user='$id'");
$user = mysqli_fetch_assoc($qUser);
if(!$user){
    $_SESSION['error'] = "Data user tidak ditemukan.";
    header("Location: index.php");
    exit;
}

$qAnggota = mysqli_query($koneksi,"SELECT * FROM anggota WHERE status_anggota='aktif'");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="flex">
    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-1 p-6">
        <h1 class="text-xl font-bold mb-4">Edit User</h1>

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

        <form action="update.php" method="POST" class="space-y-4 max-w-xl">
            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

            <div>
                <label>Username</label>
                <input type="text" name="username" class="w-full border p-2" value="<?= $user['username'] ?>" required>
            </div>

            <div>
                <label>Password <small>(biarkan kosong jika tidak diganti)</small></label>
                <input type="password" name="password" class="w-full border p-2">
            </div>

            <div>
                <label>Role</label>
                <select name="role" class="w-full border p-2" required>
                    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                    <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
                </select>
            </div>

            <div>
                <label>Status Akun</label>
                <select name="status_akun" class="w-full border p-2">
                    <option value="aktif" <?= $user['status_akun']=='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $user['status_akun']=='nonaktif'?'selected':'' ?>>Nonaktif</option>
                </select>
            </div>

            <div>
                <label>Link ke Anggota</label>
                <select name="id_anggota" class="w-full border p-2">
                    <option value="">-- Pilih Anggota --</option>
                    <?php while($a=mysqli_fetch_assoc($qAnggota)): ?>
                    <option value="<?= $a['id_anggota'] ?>" <?= $user['id_anggota']==$a['id_anggota']?'selected':'' ?>>
                        <?= $a['nama_anggota'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </main>
</div>

<?php include '../includes/footer.php'; ?>