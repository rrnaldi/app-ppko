<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data PPKO</title>
</head>

<body>
    <center>
        <h1>Laporan Form PPPKO</h1>
        <h2>INDOFARMA</h2>
    </center>
    <?php
    include 'koneksi.php';
    session_start();

    // Query database untuk mengambil semua data dari tabel pengajuan
    $query = "SELECT p.*, k.*, u.* FROM pengajuan p JOIN kendaraan k, user u WHERE p.id_author = u.nik AND p.kendaraan_id = k.id_kendaraan AND p.status = 'Peminjaman Selesai'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
    ?>
        <table cellspacing="1" cellpadding="5" border="1">
            <tr>
                <th width="1%">No</th>
                <th>Nama Pengaju</th>
                <th>NIK</th>
                <th>Nama Divisi</th>
                <th>Kode Transaksi</th>
                <th>Tujuan</th>
                <th>Keperluan</th>
                <th>Bukti</th>
                <th>Tanggal Rencana Pergi</th>
                <th>Tanggal Rencana Kembali</th>
                <th>Nomor HP</th>
                <th>Nama Yang Berpergian</th>
                <th>Keterangan</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Disetujui Manager</th>
                <th>Tanggal Diterima Bidang Umum</th>
                <th>Tanggal Dievaluasi Asmen</th>
                <th>Tanggal Disetujui Spv Bidang</th>
                <th>Nama Kendaraan</th>
                <th>Merk Kendaraan</th>
                <th>Plat Nomor</th>
                <th>Supir</th>
                <th>Saldo Awal</th>
                <th>Biaya Perjalanan</th>
                <th>Sisa Saldo</th>
                <th>Status</th>
                <th>Tanggal Pergi</th>
                <th>Tanggal Kembali</th>
            </tr>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['nik'] ?></td>
                    <td><?php echo $data['nama_divisi'] ?></td>
                    <td><?php echo $data['kd_transaksi'] ?></td>
                    <td><?php echo $data['tujuan'] ?></td>
                    <td><?php echo $data['keperluan'] ?></td>
                    <td>
                        <?php if (strpos($data['bukti'], ".jpg") !== false || strpos($data['bukti'], ".jpeg") !== false || strpos($data['bukti'], ".png") !== false) { ?>
                            <a href="/percobaan/assets/img/<?= $data['bukti'] ?>" target="_blank">
                                <img src="/percobaan/assets/img/<?= $data['bukti'] ?>" width="50">
                            </a>
                        <?php } else {
                            echo "Tidak Ada Bukti";
                        }
                        ?>
                    </td>
                    <td><?php echo $data['waktu_pergi'] ?></td>
                    <td><?php echo $data['waktu_kembali'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['nama_bp'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td><?php echo $data['tgl_pengajuan'] ?></td>
                    <td><?php echo $data['tgl_PManager'] ?></td>
                    <td><?php echo $data['tgl_PUmum'] ?></td>
                    <td><?php echo $data['tgl_PAsmen'] ?></td>
                    <td><?php echo $data['tgl_PSpv'] ?></td>
                    <td><?php echo $data['nama_kendaraan'] ?></td>
                    <td><?php echo $data['merk_kendaraan'] ?></td>
                    <td><?php echo $data['plat_nomor'] ?></td>
                    <td><?php echo $data['supir'] ?></td>
                    <td><?php echo 'Rp ' . number_format($data['uang_jalan'], 2, ',', '.'); ?></td>
                    <td><?php echo 'Rp ' . number_format($data['total_biaya'], 2, ',', '.'); ?></td>
                    <td><?php echo 'Rp ' . number_format($data['sisa_saldo'], 2, ',', '.'); ?></td>
                    <td><?php echo $data['status'] ?></td>
                    <td><?php echo $data['tgl_pergi'] ?></td>
                    <td><?php echo $data['tgl_kembali'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    <?php
    } else {
        echo "Data tidak ditemukan.";
    }
    ?>
    <script>
        window.print();
    </script>
</body>

</html>