<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['login']) || $_SESSION['role']!='admin') header("Location: ../auth/login.php");

$id = $_POST['id_user'];
$username = $_POST['username'];
$role = $_POST['role'];
$status = $_POST['status_akun'];
$id_anggota = $_POST['id_anggota'] ?: NULL;

$password = '';
if(!empty($_POST['password'])){
    $password = ", password='".password_hash($_POST['password'], PASSWORD_DEFAULT)."'";
}

$sql = "UPDATE user SET 
            username='$username',
            role='$role',
            status_akun='$status',
            id_anggota=".($id_anggota?$id_anggota:"NULL")."
            $password
        WHERE id_user='$id'";

if(mysqli_query($koneksi,$sql)){
    $_SESSION['success']="User berhasil diupdate!";
}else{
    $_SESSION['error']="Gagal update: ".mysqli_error($koneksi);
}
header("Location: index.php");