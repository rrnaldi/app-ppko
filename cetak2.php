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
    // Ambil ID pengajuan dari URL
    if (isset($_GET['id'])) {
        $id_pengajuan = $_GET['id'];

        $tampil = mysqli_query($koneksi, "SELECT p.*, k.*, u.* FROM pengajuan p JOIN kendaraan k, user u WHERE p.id_author = u.nik AND p.kendaraan_id = k.id_kendaraan AND p.id_pengajuan = $id_pengajuan ORDER BY id_pengajuan");

        if ($tampil && mysqli_num_rows($tampil) > 0) {
            $data = mysqli_fetch_assoc($tampil);
    ?>
            <ul>
                <p>Pengajuan:<span><?= $data['tgl_pengajuan'] ?></span> &#8594;
                    Disetujui Manager: <span><?= $data['tgl_PManager'] ?></span> &#8594;
                    Diterima Departemen GA: <span><?= $data['tgl_PUmum'] ?></span>
                </p>
                <i class="fa-solid fa-arrow-down"></i>
                <p> Disetujui Asman: <span><?= $data['tgl_PAsmen'] ?></span> &#8594;
                    Disetujui Manager GA: <span><?= $data['tgl_PSpv'] ?></span> &#8594;
                    Peminjaman Selesai: <span><?= $data['tgl_selesai'] ?></span></p>
                <li class="list-group-item"><strong>Nama Pengaju:</strong> <?= $data['nama'] ?></li>
                <li class="list-group-item"><strong>NIK:</strong> <?= $data['id_author'] ?></li>
                <li class="list-group-item"><strong>Nama Divisi:</strong> <?= $data['nama_divisi'] ?></li>
                <li class="list-group-item"><strong>Kode Transaksi:</strong> <?= $data['kd_transaksi'] ?></li>
                <li class="list-group-item"><strong>Tujuan:</strong> <?= $data['tujuan'] ?></li>
                <li class="list-group-item"><strong>Bukti:</strong>
                    <?php if (strpos($data['bukti'], ".jpg") !== false || strpos($data['bukti'], ".jpeg") !== false || strpos($data['bukti'], ".png") !== false) { ?>
                        <a href="/percobaan/assets/img/<?= $data['bukti'] ?>" target="_blank">
                            <img src="/percobaan/assets/img/<?= $data['bukti'] ?>" width="50">
                        </a>
                    <?php } else {
                        echo "Tidak Ada Bukti";
                    }
                    ?>
                </li>
                <li class="list-group-item"><strong>Keperluan:</strong> <?= $data['keperluan'] ?></li>
                <li class="list-group-item"><strong>Tanggal Berangkat:</strong> <?= $data['waktu_pergi'] ?></li>
                <li class="list-group-item"><strong>Tanggal Kembali:</strong> <?= $data['waktu_kembali'] ?></li>
                <li class="list-group-item"><strong>Nomor HP:</strong> <?= $data['no_hp'] ?></li>
                <li class="list-group-item"><strong>Nama yang Berpergian:</strong> <?= $data['nama_bp'] ?></li>
                <li class="list-group-item"><strong>Keterangan:</strong> <?= $data['keterangan'] ?></li>
                <li class="list-group-item"><strong>Nama Kendaraan:</strong> <?= $data['nama_kendaraan'] ?></li>
                <li class="list-group-item"><strong>Merk Kendaraan:</strong> <?= $data['merk_kendaraan'] ?></li>
                <li class="list-group-item"><strong>Plat Nomor:</strong> <?= $data['plat_nomor'] ?></li>
                <li class="list-group-item"><strong>Nama Dan No HP Supir:</strong> <?= $data['supir'] ?></li>
                <li class="list-group-item"><strong>Saldo Awal:</strong> Rp. <?= number_format($data['uang_jalan'], 0, ',', '.') ?></li>
                <li class="list-group-item"><strong>Biaya Perjalanan:</strong> Rp. <?= number_format($data['total_biaya'], 0, ',', '.') ?></li>
                <li class="list-group-item"><strong>Sisa Saldo:</strong> Rp. <?= number_format($data['sisa_saldo'], 0, ',', '.') ?></li>
            </ul>
    <?php
        } else {
            echo "Data tidak ditemukan.";
        }
    } else {
        echo "ID pengajuan tidak ditemukan.";
    }
    ?>
    <script>
        window.print();
    </script>
</body>

</html>