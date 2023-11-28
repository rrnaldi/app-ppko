<?php
include "../koneksi.php";


// uji jika tombol simpan di klik
if (isset($_POST['bsimpan'])) {

  $dari = $_POST['dari'];
  $darijam = $_POST['darijam'];

  // Gabungkan tanggal dan waktu keberangkatan menjadi satu string
  $waktu_pergi = $dari . ' ' . $darijam;

  $sampai = $_POST['sampai'];
  $sampaijam = $_POST['sampaijam'];

  $waktu_kembali = $sampai . ' ' . $sampaijam;
  // -----------------------------------------//

  $namaFile = $_FILES['bukti'] ['name'];
  $ukuranFile = $_FILES['bukti']['size'];
  $error = $_FILES['bukti']['error'];
  $tmpName = $_FILES['bukti']['tmp_name'];

  //cek gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  if( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
              alert('Yang Anda Upload Bukan Gambar');    
              </script>";
  } 
 
  $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
  $upload_directory = $_SERVER['DOCUMENT_ROOT'] . '/percobaan/assets/img/';
  move_uploaded_file($tmpName, $upload_directory . $namaFileBaru);


  
  //persiapan simpan data baru
  $simpan = mysqli_query($koneksi, "INSERT INTO pengajuan(id_author, tgl_pengajuan, kd_transaksi, tujuan, keperluan, bukti, waktu_pergi, waktu_kembali, no_hp, nama_bp, keterangan, status)
                                       VALUES ( '$_POST[nik]',
                                        '$_POST[tgl_pengajuan]',
                                        '$_POST[running_number]',
                                        '$_POST[tujuan]',
                                       '$_POST[keperluan]',
                                       '$namaFileBaru',
                                       '$waktu_pergi',
                                       '$waktu_kembali',
                                       '$_POST[no_hp]',
                                       '$_POST[nama_bp]',
                                       '$_POST[keterangan]',
                                       'Telah Diajukan'
                                       )");
                                      
  //jika simpan sukses
  if ($simpan) {
    echo "<script>alert('Simpan Data Sukses');
                document.location='index.php';
              </script>";
} else {
    // Mengambil pesan kesalahan MySQL
    echo "<script>alert('Simpan Data Gagal');
                document.location='index.php';
              </script>";
}
}

if (isset($_POST['bselesai'])) {
  $id_author = $_POST['nik'];
  $kendaraan_id = $_POST['id_kendaraan'];
  
  $biayaBensin = $_POST['biayaBensin'];
  $biayaTol = $_POST['biayaTol'];
  $biayaLain = $_POST['biayaLain'];
  $total_biaya = $biayaBensin + $biayaTol + $biayaLain;

  $sql = "UPDATE pengajuan SET 
             total_biaya = '$total_biaya', 
             status = 'Peminjaman Selesai' 
         WHERE id_author = '$id_author'";
  $result = mysqli_query($koneksi, $sql);

  $sqlkendaraan = "UPDATE kendaraan SET status_kendaraan = 'Tersedia' WHERE id_kendaraan = '$kendaraan_id'";
  $resultkendaraan = mysqli_query($koneksi, $sqlkendaraan);

  if ($resultkendaraan) {
      echo "<script>alert('Data Telah Diterima');
            document.location='index.php';
        </script>";
  } else {
      echo "Error: " . mysqli_error($koneksi);
  }
  var_dump($_POST);
}






