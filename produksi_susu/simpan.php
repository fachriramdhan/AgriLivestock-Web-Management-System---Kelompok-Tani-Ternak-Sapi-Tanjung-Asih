<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil POST
$id_sapi = $_POST['id_sapi'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu_pemerahan'];
$jumlah = $_POST['jumlah_liter'];
$keterangan = trim($_POST['keterangan']);

// Ambil data sapi
$qSapi = mysqli_query($koneksi, "SELECT * FROM sapi WHERE id_sapi='$id_sapi'");
$sapi = mysqli_fetch_assoc($qSapi);

if (!$sapi) {
    $_SESSION['error'] = "Sapi tidak ditemukan!";
    header("Location: tambah.php");
    exit;
}

// Validasi role user: hanya bisa input sapi miliknya
if ($role === 'user' && $sapi['id_user'] != $id_user_session) {
    $_SESSION['error'] = "Anda tidak memiliki akses untuk input produksi susu pada sapi ini!";
    header("Location: tambah.php");
    exit;
}

// Validasi kategori & laktasi
if ($sapi['kategori_sapi'] != 'induk' || $sapi['status_laktasi'] != 'laktasi') {
    $_SESSION['error'] = "Hanya sapi induk yang sedang laktasi yang dapat diinput!";
    header("Location: tambah.php");
    exit;
}

// Tentukan id_user
$id_user = ($role==='admin') ? $sapi['id_user'] : $id_user_session;

// Insert data
$sql = "INSERT INTO produksi_susu (id_sapi, id_user, tanggal, waktu_pemerahan, jumlah_liter, status_data, keterangan)
        VALUES ('$id_sapi', '$id_user', '$tanggal', '$waktu', '$jumlah', 'draft', '$keterangan')";

if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Data produksi susu berhasil disimpan!";
    header("Location: index.php");
} else {
    $_SESSION['error'] = "Gagal menyimpan data: " . mysqli_error($koneksi);
    header("Location: tambah.php");
}