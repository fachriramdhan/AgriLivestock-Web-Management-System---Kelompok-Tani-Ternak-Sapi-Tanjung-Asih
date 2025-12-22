<?php
session_start();
require_once '../config/database.php';

// Proteksi akses
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user_session = $_SESSION['id_user'];

// Ambil data POST
$kode_sapi      = trim($_POST['kode_sapi']);
$nama_sapi      = trim($_POST['nama_sapi']);
$jenis_kelamin  = $_POST['jenis_kelamin'];
$kategori_sapi  = $_POST['kategori_sapi'];
$umur_bulan     = (int) $_POST['umur_bulan'];

// Tentukan id_user sesuai role
if ($role === 'admin') {
    $id_user = $_POST['id_user'];
} else {
    $id_user = $id_user_session;
}

// Validasi sederhana
if (empty($kode_sapi) || empty($jenis_kelamin) || empty($kategori_sapi) || $umur_bulan <= 0) {
    $_SESSION['error'] = "Semua field wajib diisi!";
    header("Location: tambah.php");
    exit;
}

// Cek kode sapi unik
$qCek = mysqli_query($koneksi, "SELECT * FROM sapi WHERE kode_sapi = '$kode_sapi'");
if (mysqli_num_rows($qCek) > 0) {
    $_SESSION['error'] = "Kode sapi sudah digunakan!";
    header("Location: tambah.php");
    exit;
}

// Insert ke database
$sql = "INSERT INTO sapi 
        (id_user, kode_sapi, nama_sapi, jenis_kelamin, kategori_sapi, umur_bulan) 
        VALUES
        ('$id_user', '$kode_sapi', '$nama_sapi', '$jenis_kelamin', '$kategori_sapi', '$umur_bulan')";

if (mysqli_query($koneksi, $sql)) {
    $_SESSION['success'] = "Data sapi berhasil disimpan!";
    header("Location: index.php");
    exit;
} else {
    $_SESSION['error'] = "Gagal menyimpan data: " . mysqli_error($koneksi);
    header("Location: tambah.php");
    exit;
}