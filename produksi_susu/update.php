<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id_user_session = $_SESSION['id_user'];
$role = $_SESSION['role'];

$id_produksi = (int) $_POST['id_produksi'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu_pemerahan'];
$jumlah = $_POST['jumlah_liter'];
$keterangan = trim($_POST['keterangan']);

// Ambil data produksi susu
$q = mysqli_query($koneksi, "SELECT * FROM produksi_susu WHERE id_produksi='$id_produksi'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    $_SESSION['error'] = "Data tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Cek role
if ($role==='user' && $data['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk mengedit data ini!";
    header("Location: index.php");
    exit;
}

// User hanya edit draft
if ($role==='user' && $data['status_data'] !== 'draft') {
    $_SESSION['error'] = "Hanya data draft yang bisa diedit!";
    header("Location: index.php");
    exit;
}

// Update data
$sql = "UPDATE produksi_susu SET tanggal='$tanggal', waktu_pemerahan='$waktu', jumlah_liter='$jumlah', keterangan='$keterangan' 
        WHERE id_produksi='$id_produksi'";

if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Data produksi susu berhasil diupdate!";
} else {
    $_SESSION['error'] = "Gagal update: ".mysqli_error($koneksi);
}

header("Location: index.php");
exit;