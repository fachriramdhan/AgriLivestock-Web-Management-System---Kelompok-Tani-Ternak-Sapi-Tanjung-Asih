<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

$id_sapi = $_POST['id_sapi'];
$tanggal = $_POST['tanggal'];
$jenis_pakan = $_POST['jenis_pakan'];
$waktu = $_POST['waktu_pemberian'];
$jumlah = $_POST['jumlah_kg'];
$keterangan = trim($_POST['keterangan']);

// Ambil data sapi
$qSapi = mysqli_query($koneksi, "SELECT * FROM sapi WHERE id_sapi='$id_sapi'");
$sapi = mysqli_fetch_assoc($qSapi);

if (!$sapi) {
    $_SESSION['error'] = "Sapi tidak ditemukan!";
    header("Location: tambah.php");
    exit;
}

// Validasi role user
if ($role==='user' && $sapi['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses input pakan untuk sapi ini!";
    header("Location: tambah.php");
    exit;
}

// Hanya sapi aktif
if ($sapi['status_sapi'] != 'aktif') {
    $_SESSION['error'] = "Hanya sapi aktif yang bisa diberi pakan!";
    header("Location: tambah.php");
    exit;
}

$id_user = ($role==='admin') ? $sapi['id_user'] : $id_user_session;

// Insert data
$sql = "INSERT INTO pakan_sapi (id_sapi, id_user, tanggal, jenis_pakan, waktu_pemberian, jumlah_kg, keterangan)
        VALUES ('$id_sapi', '$id_user', '$tanggal', '$jenis_pakan', '$waktu', '$jumlah', '$keterangan')";

if(mysqli_query($koneksi, $sql)){
    $_SESSION['success'] = "Data pakan berhasil disimpan!";
    header("Location: index.php");
} else {
    $_SESSION['error'] = "Gagal menyimpan data: ".mysqli_error($koneksi);
    header("Location: tambah.php");
}