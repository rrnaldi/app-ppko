<?php
include "../koneksi.php";


if ($_GET['action'] == 'update_approve') {

  $tampil = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_pengajuan= $_GET[id] ");
  $data = mysqli_fetch_array($tampil);

  $tgl_saatini = date("Y-m-d");

  $sql = "UPDATE pengajuan SET status = 'Disetujui Manager', tgl_PManager = '$tgl_saatini' WHERE id_pengajuan=$_GET[id]";
  mysqli_query($koneksi, $sql);


  //jika simpan sukses
  if ($sql) {
    echo "<script>alert('Form Telah Disetujui');
                document.location='dashboard.php';
              </script>";
  } else {
    echo "<script>alert('Form Tidak Disetujui');
                document.location='dashboard.php';
              </script>";
  }
} elseif ($_GET['action'] == 'tolak_approve') {
  $tampil = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_pengajuan= $_GET[id] ");
  $data = mysqli_fetch_array($tampil);

  $sql = "UPDATE pengajuan SET status = 'Tidak Disetujui Manager' WHERE id_pengajuan=$_GET[id]";
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


?>





