<?php
include 'koneksi.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();

// Query database untuk mengambil semua data dari tabel pengajuan
$query = "SELECT p.*, k.*, u.* FROM pengajuan p JOIN kendaraan k, user u WHERE p.id_author = u.nik AND p.kendaraan_id = k.id_kendaraan AND p.status = 'Peminjaman Selesai'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Create a new Excel spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers to the Excel file
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Pengaju');
    $sheet->setCellValue('C1', 'NIK');
    $sheet->setCellValue('D1', 'Nama Divisi');
    $sheet->setCellValue('E1', 'Kode Transaksi');
    $sheet->setCellValue('F1', 'Tujuan');
    $sheet->setCellValue('G1', 'Keperluan');
    $sheet->setCellValue('H1', 'Bukti');
    $sheet->setCellValue('I1', 'Tanggal Berangkat');
    $sheet->setCellValue('J1', 'Tanggal Kembali');
    $sheet->setCellValue('K1', 'Nomor Hp');
    $sheet->setCellValue('L1', 'Nama Yang Pergi');
    $sheet->setCellValue('M1', 'Keterangan');
    $sheet->setCellValue('N1', 'Tanggal Pengajuan');
    $sheet->setCellValue('O1', 'Tanggal Disetujui Manager');
    $sheet->setCellValue('P1', 'Tanggal Diterima Bidang Umum');
    $sheet->setCellValue('Q1', 'Tanggal Dievaluasi Asmen');
    $sheet->setCellValue('R1', 'Tanggal Disetujui Spv Bidang');
    $sheet->setCellValue('S1', 'Nama Kendaraan');
    $sheet->setCellValue('T1', 'Merk Kendaraan');
    $sheet->setCellValue('U1', 'Plat Nomor');
    $sheet->setCellValue('V1', 'Supir');
    $sheet->setCellValue('W1', 'Biaya Perjalanan');
    $sheet->setCellValue('X1', 'Status');


    $row = 2;
    $no = 1;

    while ($data = mysqli_fetch_assoc($result)) {
        // Add data to the Excel file
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $data['nama']);
        $sheet->setCellValue('C' . $row, $data['nik']);
        $sheet->setCellValue('D' . $row, $data['nama_divisi']);
        $sheet->setCellValue('E' . $row, $data['kd_transaksi']);
        $sheet->setCellValue('F' . $row, $data['tujuan']);
        $sheet->setCellValue('G' . $row, $data['keperluan']);
        $sheet->setCellValue('H' . $row, $data['bukti']);
        $sheet->setCellValue('I' . $row, $data['tgl_pergi']);
        $sheet->setCellValue('J' . $row, $data['tgl_kembali']);
        $sheet->setCellValue('K' . $row, $data['no_hp']);
        $sheet->setCellValue('L' . $row, $data['nama_bp']);
        $sheet->setCellValue('M' . $row, $data['keterangan']);
        $sheet->setCellValue('N' . $row, $data['tgl_pengajuan']);
        $sheet->setCellValue('O' . $row, $data['tgl_PManager']);
        $sheet->setCellValue('P' . $row, $data['tgl_PUmum']);
        $sheet->setCellValue('Q' . $row, $data['tgl_PAsmen']);
        $sheet->setCellValue('R' . $row, $data['tgl_PSpv']);
        $sheet->setCellValue('S' . $row, $data['nama_kendaraan']);
        $sheet->setCellValue('T' . $row, $data['merk_kendaraan']);
        $sheet->setCellValue('U' . $row, $data['plat_nomor']);
        $sheet->setCellValue('V' . $row, $data['supir']);
        $sheet->setCellValue('W' . $row, $data['total_biaya']);
        $sheet->setCellValue('X' . $row, $data['status']);
        // ... (Add other data accordingly)

        $row++;
    }

    // Save Excel file
    $writer = new Xlsx($spreadsheet);
    $excelFileName = 'Laporan-PPKO_excel.xlsx';
    $writer->save($excelFileName);

    // Output download link for Excel file
    echo "<a href='{$excelFileName}' download>Download Excel</a>";
} else {
    echo "Data tidak ditemukan.";
}
