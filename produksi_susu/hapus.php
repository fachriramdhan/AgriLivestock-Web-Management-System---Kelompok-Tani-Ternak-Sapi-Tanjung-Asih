<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_user_session = $_SESSION['id_user'];
$role = $_SESSION['role'];

$id_produksi = (int) $_GET['id'];

// Ambil data
$q = mysqli_query($koneksi, "SELECT * FROM produksi_susu WHERE id_produksi='$id_produksi'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    $_SESSION['error'] = "Data tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Cek role
if ($role==='user' && $data['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk menghapus data ini!";
    header("Location: index.php");
    exit;
}

// User hanya bisa hapus draft
if ($role==='user' && $data['status_data'] !== 'draft') {
    $_SESSION['error'] = "Hanya data draft yang bisa dihapus!";
    header("Location: index.php");
    exit;
}

// Hapus
$sql = "DELETE FROM produksi_susu WHERE id_produksi='$id_produksi'";
if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Data produksi susu berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal hapus: ".mysqli_error($koneksi);
}

header("Location: index.php");
exit;