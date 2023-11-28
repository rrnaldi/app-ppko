<?php
include "../koneksi.php";

if (isset($_POST['bsimpan'])) {
    $id_pengajuan = $_POST['id_pengajuan'];
    $id_author = $_POST['id_author'];
    $kd_transaksi = $_POST['kd_transaksi'];
    $tujuan = $_POST['tujuan'];
    $keperluan = $_POST['keperluan'];
    $waktu_pergi = $_POST['waktu_pergi'];
    $waktu_kembali = $_POST['waktu_kembali'];
    $no_hp = $_POST['no_hp'];
    $nama_bp = $_POST['nama_bp'];
    $keterangan = $_POST['keterangan'];
    $supir = $_POST['supir'];
    $uang_jalan = $_POST['uang_jalan'];
    $kendaraan_id = $_POST['id_kendaraan'];
    $tgl_PSpv = $_POST['tgl_PSpv'];


    $sql = "UPDATE pengajuan SET 
             kd_transaksi = '$kd_transaksi', 
             tujuan = '$tujuan', 
             keperluan = '$keperluan', 
             waktu_pergi = '$waktu_pergi', 
             waktu_kembali = '$waktu_kembali', 
             no_hp = '$no_hp', 
             nama_bp = '$nama_bp', 
             keterangan = '$keterangan', 
             kendaraan_id = '$kendaraan_id',
             supir = '$supir', 
             uang_jalan = '$uang_jalan', 
             status = 'Disetujui Asman',
             tgl_PSpv = '$tgl_PSpv'
         WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($koneksi, $sql);

    $sqlkendaraan = "UPDATE kendaraan SET status_kendaraan = 'Tidak Tersedia' WHERE id_kendaraan = '$kendaraan_id'";
    $resultkendaraan = mysqli_query($koneksi, $sqlkendaraan);

    if ($resultkendaraan) {
        echo "<script>alert('Data Telah Diterima');
            document.location='dashboard.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['bselesai'])) {
    $id_pengajuan = $_POST['id_pengajuan'];
    $kendaraan_id = $_POST['id_kendaraan'];
    $biayaBensin = $_POST['biayaBensin'];
    $biayaTol = $_POST['biayaTol'];
    $biayaLain = $_POST['biayaLain'];
    $uang_jalan = $_POST['uang_jalan'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $total_biaya = $biayaBensin + $biayaTol + $biayaLain;
    $sisa_uang_jalan = $uang_jalan - $total_biaya;


    $sql = "UPDATE pengajuan SET 
               total_biaya = '$total_biaya', 
               sisa_saldo = '$sisa_uang_jalan', 
               tgl_selesai = '$tgl_selesai',
               status = 'Peminjaman Selesai' 
           WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($koneksi, $sql);

    $sqlkendaraan = "UPDATE kendaraan SET status_kendaraan = 'Tersedia' WHERE id_kendaraan = '$kendaraan_id'";
    $resultkendaraan = mysqli_query($koneksi, $sqlkendaraan);

    if ($resultkendaraan) {
        echo "<script>alert('Data Telah Diterima');
              document.location='dashboard.php';
          </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
