<?php
include "../koneksi.php";
if (isset($_POST['bsimpan'])) {
    $dari = $_POST['dari'];
    $darijam = $_POST['darijam'];

    // Gabungkan tanggal dan waktu keberangkatan menjadi satu string
    $tgl_pergi = $dari . ' ' . $darijam;

    $sampai = $_POST['sampai'];
    $sampaijam = $_POST['sampaijam'];

    $tgl_kembali = $sampai . ' ' . $sampaijam;
    // -----------------------------------------//
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
tgl_pergi = '$tgl_pergi',
tgl_kembali = '$tgl_kembali',
status = CASE WHEN '$tgl_kembali' <> '' THEN 'Disetujui Security' ELSE status END
WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($koneksi, $sql);

    echo "<script>
    alert('Data Telah Diterima');
    document.location = 'dashboard.php';
</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
