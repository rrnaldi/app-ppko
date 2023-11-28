<!DOCTYPE html>
<html>

<head>
    <title>Export Data Ke Excel Dengan PHP - www.malasngoding.com</title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>

    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Pegawai.xls");
    ?>

    <center>
        <h1>Export Data Ke Excel Dengan PHP <br /> www.malasngoding.com</h1>
    </center>

    <?php
    include 'koneksi.php';
    session_start();

    // Query database untuk mengambil semua data dari tabel pengajuan
    $query = "SELECT p.*, k.*, u.* FROM pengajuan p JOIN kendaraan k, user u WHERE p.id_author = u.nik AND p.kendaraan_id = k.id_kendaraan";
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
                <th>Tanggal Berangkat</th>
                <th>Tanggal Kembali</th>
                <th>Nomor HP</th>
                <th>Nama Yang Berpergian</th>
                <th>Keterangan</th>
                <th>Tanggal Disetujui Manager</th>
                <th>Tanggal Diterima Bidang Umum</th>
                <th>Tanggal Dievaluasi Asmen</th>
                <th>Tanggal Disetujui Spv Bidang</th>
                <th>Nama Kendaraan</th>
                <th>Merk Kendaraan</th>
                <th>Plat Nomor</th>
                <th>Supir</th>
                <th>Biaya Perjalanan</th>
                <th>Status</th>
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
                    <td><?php echo $data['tgl_PManager'] ?></td>
                    <td><?php echo $data['tgl_PUmum'] ?></td>
                    <td><?php echo $data['tgl_PAsmen'] ?></td>
                    <td><?php echo $data['tgl_PSpv'] ?></td>
                    <td><?php echo $data['nama_kendaraan'] ?></td>
                    <td><?php echo $data['merk_kendaraan'] ?></td>
                    <td><?php echo $data['plat_nomor'] ?></td>
                    <td><?php echo $data['supir'] ?></td>
                    <td><?php echo $data['total_biaya'] ?></td>
                    <td><?php echo $data['status'] ?></td>
                </tr>
        <?php
            }
        }
        ?>
        </table>
</body>

</html>