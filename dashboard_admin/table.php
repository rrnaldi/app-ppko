<?php
//panggil koneksi php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] !== "Admin") {
    header("location:../index.php?pesan=gagal");
}
include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        #currentDate {
            text-align: center;
            /* Pusatkan teks secara horizontal */
            margin: 0;
            /* Hapus margin bawaan yang mungkin memengaruhi tata letak */
        }

        .modal-header {
            text-align: center;
            /* Pusatkan konten dalam modal-header */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">
            Dashboard Admin
        </a>
        <?php
        $nik = $_SESSION['nik'];
        $getnama = mysqli_query($koneksi, "select nama from user where nik='$nik' ");
        // menghitung jumlah data yang ditemukan
        $datanama = mysqli_fetch_array($getnama);
        ?>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <img src="../assets/img/logoinf.png" class="user-image" alt="User Image"> -->
                    <span class="hidden-xs"><?php echo $datanama['nama'] ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu bg-primary">
                    <div class="nav">
                        <a class="nav-link text-white" href="dashboard.php">
                            <div class="sb-nav-link-icon text-white"><i class="fas fa-tachometer-alt "></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link text-white" href="datakendaraan.php">
                            <div class="sb-nav-link-icon text-white"><i class="fas fa-automobile"></i></div>
                            Data Kendaraan
                        </a>
                        <a class="nav-link text-white" href="tambahakun.php">
                            <div class="sb-nav-link-icon text-white"><i class="fas fa-user-circle"></i></div>
                            Data User
                        </a>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                            <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                            .
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Nama Pengaju</th>
                                        <th>NIK</th>
                                        <th>Divisi</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Bukti</th>
                                        <th>Waktu Pergi</th>
                                        <th>Waktu Kembali</th>
                                        <th>No HP</th>
                                        <th>Nama Yang Berpergian</th>
                                        <th>Keterangan</th>
                                        <th>Status </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Nama Pengaju</th>
                                        <th>NIK</th>
                                        <th>Divisi</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Bukti</th>
                                        <th>Waktu Pergi</th>
                                        <th>Waktu Kembali</th>
                                        <th>No HP</th>
                                        <th>Nama Yang Berpergian</th>
                                        <th>Keterangan</th>
                                        <th>Status </th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php
                                    //menampilkan data
                                    $no = 1;
                                    $nik = $_SESSION['nik'];
                                    $getdivisi = mysqli_query($koneksi, "select nik, nama_divisi, nama from user WHERE nik='$nik' ");
                                    // menghitung jumlah data yang ditemukan
                                    $datadivisi = mysqli_fetch_array($getdivisi);
                                    $tampil = mysqli_query($koneksi, "SELECT p.*, u.* FROM pengajuan p  JOIN user u on u.nik= p.id_author  ORDER BY id_pengajuan DESC");
                                    while ($data = mysqli_fetch_array($tampil)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['tgl_pengajuan'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['nik'] ?></td>
                                            <td><?= $data['nama_divisi'] ?></td>
                                            <td><?= $data['kd_transaksi'] ?></td>
                                            <td><?= $data['tujuan'] ?></td>
                                            <td><?= $data['keperluan'] ?></td>
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
                                            <td><?= $data['waktu_pergi'] ?></td>
                                            <td><?= $data['waktu_kembali'] ?></td>
                                            <td><?= $data['no_hp'] ?></td>
                                            <td><?= $data['nama_bp'] ?></td>
                                            <td><?= $data['keterangan'] ?></td>
                                            <td>
                                                <?php if ($data['status'] == 'Telah Diajukan') {
                                                    echo $data['status'];
                                                } elseif ($data['status'] == 'Peminjaman Selesai') {
                                                    echo $data['status'] ?>
                                                    <a href="#" style="text-decoration: none;" class="badge text-bg-primary" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $no ?>">Detail</a>
                                                <?php } else {
                                                    echo $data['status'];
                                                } ?>

                                            </td>
                                        </tr>

                                        <?php
                                        //menampilkan data nama
                                        $sql = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE id_kendaraan = '$data[kendaraan_id]' ORDER BY id_kendaraan ");
                                        $data_sql = mysqli_fetch_array($sql);
                                        @$nama_kendaraan = $data_sql['nama_kendaraan'];
                                        @$merk_kendaraan = $data_sql['merk_kendaraan'];
                                        @$plat_nomor = $data_sql['plat_nomor'];
                                        ?>
                                        <!-- Awal Modal Detail -->
                                        <div class="modal fade modal-lg" id="modalDetail<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Form PPKO</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="aksi_crud.php">
                                                        <div class="modal-body text-center">
                                                            <p>Pengajuan: <span><?= $data['tgl_pengajuan'] ?></span> &#8594;
                                                                Disetujui Manager: <span><?= $data['tgl_PManager'] ?></span> &#8594;
                                                                Diterima Bidang Umum: <span><?= $data['tgl_PUmum'] ?></span>
                                                            </p>
                                                            <i class="fa-solid fa-arrow-down"></i>
                                                            <p> Dievaluasi Asmen: <span><?= $data['tgl_PAsmen'] ?></span> &#8594;
                                                                Disetujui Spv Bidang: <span><?= $data['tgl_PSpv'] ?></span></p>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="list-group list-group-flush">
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

                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><strong>Tanggal Kembali:</strong> <?= $data['waktu_kembali'] ?></li>
                                                                        <li class="list-group-item"><strong>Nomor HP:</strong> <?= $data['no_hp'] ?></li>
                                                                        <li class="list-group-item"><strong>Nama yang Berpergian:</strong> <?= $data['nama_bp'] ?></li>
                                                                        <li class="list-group-item"><strong>Keterangan:</strong> <?= $data['keterangan'] ?></li>
                                                                        <li class="list-group-item"><strong>Nama Kendaraan:</strong> <?php echo $nama_kendaraan; ?></li>
                                                                        <li class="list-group-item"><strong>Merk Kendaraan:</strong> <?php echo $merk_kendaraan; ?></li>
                                                                        <li class="list-group-item"><strong>Plat Nomor:</strong> <?php echo $plat_nomor; ?></li>
                                                                        <li class="list-group-item"><strong>Nama Dan No HP Supir:</strong> <?= $data['supir'] ?></li>
                                                                        <li class="list-group-item"><strong>Biaya Perjalanan:</strong> Rp. <?= number_format($data['total_biaya'], 0, ',', '.') ?></li>

                                                                        <li class="list-group-item"></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- <button type="button" class="btn btn-primary" onclick="printModalContent()">Cetak</button> -->
                                                            <a href="../cetak.php?id=<?php echo $data['id_pengajuan']; ?>" target="_blank">Cetak</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- AKhir Modal Detail-->
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; Renaldi 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        // Fungsi untuk mengupdate tanggal secara real-time
        function updateCurrentDate() {
            const currentDateElement = document.getElementById("currentDate");
            const currentDate = new Date();
            const options = {
                year: "numeric",
                month: "long",
                day: "numeric"
            };
            currentDateElement.textContent = currentDate.toLocaleDateString(undefined, options);
        }

        // Panggil fungsi pertama kali saat halaman dimuat
        updateCurrentDate();

        // Fungsi untuk mengupdate tanggal setiap detik
        setInterval(updateCurrentDate, 1000);
    </script>

    <script>
        function printModalContent() {
            var printContents = document.getElementById('modalDetail<?= $no ?>').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>



</html>