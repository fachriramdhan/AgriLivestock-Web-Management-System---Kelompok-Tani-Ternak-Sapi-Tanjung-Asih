<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id_pakan = (int) $_POST['id_pakan'];
$id_sapi = $_POST['id_sapi'];
$tanggal = $_POST['tanggal'];
$jenis_pakan = $_POST['jenis_pakan'];
$waktu = $_POST['waktu_pemberian'];
$jumlah = $_POST['jumlah_kg'];
$keterangan = trim($_POST['keterangan']);

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
    $_SESSION['error'] = "Anda tidak memiliki akses untuk update data ini!";
    header("Location: index.php");
    exit;
}

// Update data
$sql = "UPDATE pakan_sapi SET id_sapi='$id_sapi', tanggal='$tanggal', jenis_pakan='$jenis_pakan', waktu_pemberian='$waktu', jumlah_kg='$jumlah', keterangan='$keterangan'
        WHERE id_pakan='$id_pakan'";

if(mysqli_query($koneksi, $sql)){
    $_SESSION['success'] = "Data pakan berhasil diupdate!";
} else {
    $_SESSION['error'] = "Gagal update: ".mysqli_error($koneksi);
}

header("Location: index.php");