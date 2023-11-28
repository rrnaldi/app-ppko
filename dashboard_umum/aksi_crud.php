<?php
include "../koneksi.php";


if ($_GET['action'] == 'diterima_umum') {

  $tampil = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_pengajuan= $_GET[id] ");
  $data = mysqli_fetch_array($tampil);

  $tgl_saatini = date("Y-m-d");

  $sql = "UPDATE pengajuan SET status = 'Diterima Departemen GA', tgl_PUmum = '$tgl_saatini' WHERE id_pengajuan=$_GET[id]";
  mysqli_query($koneksi, $sql);


  //jika simpan sukses
  if ($sql) {
    echo "<script>alert('Form Telah Diterima');
                document.location='dashboard.php';
              </script>";
  } else {
    echo "<script>alert('Form Tidak Diterima');
                document.location='dashboard.php';
              </script>";
  }
} elseif ($_GET['action'] == 'tolak_approve') {
  $tampil = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_pengajuan= $_GET[id] ");
  $data = mysqli_fetch_array($tampil);

  $sql = "UPDATE pengajuan SET status = 'Tidak Diterima Departemen GA' WHERE id_pengajuan=$_GET[id]";
  $result = mysqli_query($koneksi, $sql);

  if ($result) {
    echo "<script>alert('Form Telah Ditolak');
                  document.location='dashboard.php';
                </script>";
  } else {
    echo "<script>alert('Gagal Menolak Form');
                  document.location='dashboard.php';
                </script>";
  }
}
