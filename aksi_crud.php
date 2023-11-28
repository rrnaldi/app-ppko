<?php
include "koneksi.php";
if(isset($_POST['bsimpan_register'])) {
  //persiapan simpan data baru
  $simpan = mysqli_query($koneksi, "INSERT INTO user(nama, nik, password, nama_divisi, level, status_user)
                                     VALUES ('$_POST[nama]',
                                     '$_POST[nik]',
                                     '$_POST[password]',                                   
                                     '$_POST[nama_divisi]',                         
                                     '$_POST[level]',
                                     'Tidak Aktif'
                                     )");

  //jika simpan sukses
  if($simpan) {
      echo "<script>alert('Register Berhasil, Silahkan Mengubungi Admin Untuk Mengaktifkan Akun');
              document.location='index.php';
            </script>";
  } else {
      echo "<script>alert('Simpan Data Gagal');
              document.location='index.php';
            </script>";
  }

}
?>