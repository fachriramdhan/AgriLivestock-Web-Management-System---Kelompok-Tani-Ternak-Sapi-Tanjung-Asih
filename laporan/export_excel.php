<?php
session_start();
require_once '../config/database.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(!isset($_SESSION['login'])) header("Location: ../auth/login.php");

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

$jenis = $_GET['jenis'];
$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];

// Query sesuai jenis laporan
switch($jenis){
    case 'produksi_susu':
        $sql = ($role==='admin') ?
            "SELECT p.*, s.nama_sapi, u.username FROM produksi_susu p 
             JOIN sapi s ON p.id_sapi=s.id_sapi 
             JOIN user u ON p.id_user=u.id_user
             WHERE p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.tanggal" :
            "SELECT p.*, s.nama_sapi FROM produksi_susu p 
             JOIN sapi s ON p.id_sapi=s.id_sapi
             WHERE p.id_user='$id_user' AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY p.tanggal";
        $judul = "Laporan Produksi Susu";
        break;
    case 'pakan_sapi':
        $sql = ($role==='admin') ?
            "SELECT p.*, s.nama_sapi, u.username FROM pakan_sapi p
             JOIN sapi s ON p.id_sapi=s.id_sapi
             JOIN user u ON p.id_user=u.id_user
             WHERE p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.tanggal" :
            "SELECT p.*, s.nama_sapi FROM pakan_sapi p
             JOIN sapi s ON p.id_sapi=s.id_sapi
             WHERE p.id_user='$id_user' AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY p.tanggal";
        $judul = "Laporan Pakan Sapi";
        break;
    case 'kesehatan_sapi':
        $sql = ($role==='admin') ?
            "SELECT k.*, s.nama_sapi, u.username FROM kesehatan_sapi k
             JOIN sapi s ON k.id_sapi=s.id_sapi
             JOIN user u ON k.id_user=u.id_user
             WHERE k.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY k.tanggal" :
            "SELECT k.*, s.nama_sapi FROM kesehatan_sapi k
             JOIN sapi s ON k.id_sapi=s.id_sapi
             WHERE k.id_user='$id_user' AND k.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
             ORDER BY k.tanggal";
        $judul = "Laporan Kesehatan Sapi";
        break;
    case 'populasi_sapi':
        $sql = ($role==='admin') ?
            "SELECT s.*, u.username FROM sapi s
             JOIN user u ON s.id_user=u.id_user
             ORDER BY s.kode_sapi" :
            "SELECT * FROM sapi WHERE id_user='$id_user' ORDER BY kode_sapi";
        $judul = "Laporan Populasi Sapi";
        break;
    case 'produksi_olahan':
        $sql = ($role==='admin') ?
            "SELECT o.*, u.username FROM produksi_olahan o
             JOIN user u ON o.id_user=u.id_user
             WHERE o.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY o.tanggal" :
            "SELECT * FROM produksi_olahan
             WHERE id_user='$id_user' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal";
        $judul = "Laporan Produksi Olahan";
        break;
    default:
        die("Jenis laporan tidak valid.");
}

$qData = mysqli_query($koneksi,$sql);

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle($judul);

// Header
$header = [];
switch($jenis){
    case 'produksi_susu': $header = ['Tanggal', 'Peternak', 'Nama Sapi', 'Jumlah Liter', 'Waktu', 'Status']; break;
    case 'pakan_sapi': $header = ['Tanggal', 'Peternak', 'Nama Sapi', 'Jenis Pakan', 'Waktu', 'Jumlah Kg']; break;
    case 'kesehatan_sapi': $header = ['Tanggal', 'Peternak', 'Nama Sapi', 'Jenis Pemeriksaan', 'Gejala', 'Tindakan', 'Status']; break;
    case 'populasi_sapi': $header = ['Peternak', 'Kode Sapi', 'Nama Sapi', 'Jenis Kelamin', 'Kategori', 'Umur', 'Status']; break;
    case 'produksi_olahan': $header = ['Tanggal', 'Peternak', 'Jenis Olahan', 'Bahan Baku', 'Jumlah Hasil', 'Status']; break;
}

$sheet->fromArray($header,NULL,'A1');

// Data
$rowNum = 2;
while($row=mysqli_fetch_assoc($qData)){
    $dataRow = [];
    switch($jenis){
        case 'produksi_susu':
            $dataRow = [
                $row['tanggal'],
                $row['username'] ?? '',
                $row['nama_sapi'],
                $row['jumlah_liter'],
                $row['waktu_pemerahan'],
                $row['status_data']
            ];
            break;
        case 'pakan_sapi':
            $dataRow = [
                $row['tanggal'],
                $row['username'] ?? '',
                $row['nama_sapi'],
                $row['jenis_pakan'],
                $row['waktu_pemberian'],
                $row['jumlah_kg']
            ];
            break;
        case 'kesehatan_sapi':
            $dataRow = [
                $row['tanggal'],
                $row['username'] ?? '',
                $row['nama_sapi'],
                $row['jenis_pemeriksaan'],
                $row['gejala'],
                $row['tindakan'],
                $row['status_kesehatan']
            ];
            break;
        case 'populasi_sapi':
            $dataRow = [
                $row['username'] ?? '',
                $row['kode_sapi'],
                $row['nama_sapi'],
                $row['jenis_kelamin'],
                $row['kategori_sapi'],
                $row['umur_bulan'],
                $row['status_sapi']
            ];
            break;
        case 'produksi_olahan':
            $dataRow = [
                $row['tanggal'],
                $row['username'] ?? '',
                $row['jenis_olahan'],
                $row['bahan_baku_liter'],
                $row['jumlah_hasil'],
                $row['status_produksi']
            ];
            break;
    }
    $sheet->fromArray($dataRow,NULL,'A'.$rowNum);
    $rowNum++;
}

// Output Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$judul.'.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;