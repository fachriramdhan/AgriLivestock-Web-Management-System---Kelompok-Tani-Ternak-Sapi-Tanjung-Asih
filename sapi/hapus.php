<?php
session_start();
require_once '../config/database.php';

// Proteksi login
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Cek role
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk menghapus data!";
    header("Location: index.php");
    exit;
}

// Ambil id_sapi
$id_sapi = $_GET['id'] ?? 0;
$id_sapi = (int) $id_sapi;

if ($id_sapi <= 0) {
    $_SESSION['error'] = "ID tidak valid!";
    header("Location: index.php");
    exit;
}

// Hapus data
$sql = "DELETE FROM sapi WHERE id_sapi='$id_sapi'";
if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Data sapi berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal hapus: ".mysqli_error($koneksi);
}

header("Location: index.php");
exit;