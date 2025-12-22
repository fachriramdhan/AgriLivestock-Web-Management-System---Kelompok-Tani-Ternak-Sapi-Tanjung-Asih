<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id_pakan = (int) $_GET['id'];

// Ambil data pakan
$q = mysqli_query($koneksi, "SELECT * FROM pakan_sapi WHERE id_pakan='$id_pakan'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    $_SESSION['error'] = "Data tidak ditemukan!";
    header("Location: index.php");
    exit;
}

// Cek hak akses
if($role==='user' && $data['id_user'] != $id_user_session){
    $_SESSION['error'] = "Anda tidak memiliki akses untuk hapus data ini!";
    header("Location: index.php");
    exit;
}

// Hapus
$sql = "DELETE FROM pakan_sapi WHERE id_pakan='$id_pakan'";
if(mysqli_query($koneksi, $sql)){
    $_SESSION['success'] = "Data pakan berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal hapus: ".mysqli_error($koneksi);
}

header("Location: index.php");