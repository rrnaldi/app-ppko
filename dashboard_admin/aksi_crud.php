<?php
include "../koneksi.php";
// uji jika tombol simpan di klik
if (isset($_POST['bsimpan_kendaraan'])) {
  //persiapan simpan data baru
  $simpan = mysqli_query($koneksi, "INSERT INTO kendaraan(nama_kendaraan, merk_kendaraan, plat_nomor, status_kendaraan)
                                       VALUES ('$_POST[nama_kendaraan]',
                                       '$_POST[merk_kendaraan]',
                                       '$_POST[plat_nomor]',                                   
                                       'Tersedia'                         
                                       )");

  //jika simpan sukses
  if ($simpan) {
    echo "<script>alert('Simpan Data Sukses');
                document.location='datakendaraan.php';
              </script>";
  } else {
    echo "<script>alert('Simpan Data Gagal');
                document.location='datakendaraan.php';
              </script>";
  }
}

// uji jika tombol ubah di klik
if (isset($_POST['bubah_kendaraan'])) {

  //persiapan ubah data baru
  $ubah = mysqli_query($koneksi, "UPDATE kendaraan SET
                                                    nama_kendaraan = '$_POST[nama_kendaraan]',
                                                    merk_kendaraan = '$_POST[merk_kendaraan]',
                                                    plat_nomor = '$_POST[plat_nomor]',                 
                                                    status_kendaraan = '$_POST[status_kendaraan]'                 
                                                    WHERE id_kendaraan = '$_POST[id_kendaraan]'
                                                    ");


  //jika ubah sukses
  if ($ubah) {
    echo "<script>alert('Ubah Data Sukses');
              document.location='datakendaraan.php';
            </script>";
  } else {
    echo "<script>alert('Ubah Data Gagal');
              document.location='datakendaraan.php';
            </script>";
  }
}

// uji jika tombol hapus di klik
if (isset($_POST['bhapus_kendaraan'])) {

  //persiapan hapus data baru
  $hapus = mysqli_query($koneksi, "DELETE FROM kendaraan WHERE id_kendaraan = '$_POST[id_kendaraan]';");


  //jika hapus sukses
  if ($hapus) {
    echo "<script>alert('Hapus Data Sukses');
              document.location='datakendaraan.php';
            </script>";
  } else {
    echo "<script>alert('Hapus Data Gagal');
              document.location='datakendaraan.php';
            </script>";
  }
}

if (isset($_POST['bsimpan_user'])) {
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
  if ($simpan) {
    echo "<script>alert('Simpan Data Sukses');
              document.location='tambahakun.php';
            </script>";
  } else {
    echo "<script>alert('Simpan Data Gagal');
              document.location='tambahakun.php';
            </script>";
  }
}



if (isset($_POST['bubah_user'])) {

  //persiapan ubah data baru
  $ubah = mysqli_query($koneksi, "UPDATE user SET
                                                    nama = '$_POST[nama]',
                                                    nik = '$_POST[nik]',
                                                    password = '$_POST[password]',
                                                    level = '$_POST[level]',
                                                    nama_divisi = '$_POST[nama_divisi]',
                                                    status_user = '$_POST[status_user]'
                                                    WHERE id_user = '$_POST[id_user]'
                                                    ");


  //jika ubah sukses
  if ($ubah) {
    echo "<script>alert('Ubah Data Sukses');
              document.location='tambahakun.php';
            </script>";
  } else {
    echo "<script>alert('Ubah Data Gagal');
              document.location='tambahakun.php';
            </script>";
  }
}

// uji jika tombol hapus di klik
if (isset($_POST['bhapus_user'])) {

  //persiapan hapus data baru
  $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$_POST[id_user]';");


  //jika hapus sukses
  if ($hapus) {
    echo "<script>alert('Hapus Data Sukses');
              document.location='tambahakun.php';
            </script>";
  } else {
    echo "<script>alert('Hapus Data Gagal');
              document.location='tambahakun.php';
            </script>";
  }
}

//Approval Spv
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
