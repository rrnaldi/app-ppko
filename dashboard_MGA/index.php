<?php
//panggil koneksi php
session_start();
if ($_SESSION['level'] !== "ManagerGA") {
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
    <title>Dashboard - Manager GA</title>
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
            Dashboard Manager GA
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
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Permintaan Pelayanan Kendaraan Operasional</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">PPKO</li>
                    </ol>
                    <!-- Form Pengajuan Peminjaman Kendaraan -->
                    <div class="card">
                        <div class="card-header">
                            Form Persetujuan Peminjaman Kendaraan
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <div style="overflow-x: auto;">
                                <table id="datatablesSimple" class="table table-bordered table-striped table-hover">
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
                                            <th>Status</th>
                                            <th>Approval</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    //menampilkan data
                                    $no = 1;
                                    $nik = $_SESSION['nik'];
                                    $getdivisi = mysqli_query($koneksi, "select nik, nama_divisi, nama from user WHERE nik='$nik' ");
                                    // menghitung jumlah data yang ditemukan
                                    $datadivisi = mysqli_fetch_array($getdivisi);
                                    $tampil = mysqli_query($koneksi, "SELECT p.*, u.* FROM pengajuan p  JOIN user u on u.nik= p.id_author  WHERE p.status='Disetujui Asman' ORDER BY id_pengajuan DESC");
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
                                            <td> <?php if ($data['status'] == 'Disetujui Asman') {
                                                        echo $data['status'] ?>
                                                    <a href="#" style="text-decoration: none;" class="badge text-bg-primary" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $no ?>">Detail</a>
                                                <?php } else {
                                                        echo $data['status'];
                                                    } ?>
                                            </td>
                                            <td>
                                                <!-- Tombol Persetujuan -->
                                                <a class="btn btn-primary mb-3" href="aksi_crud.php?action=dievaluasi_asmen&id=<?= $data['id_pengajuan'] ?>">Setuju</a>
                                                <a class="btn btn-primary mb-3" href="aksi_crud.php?action=tolak_approve&id=<?= $data['id_pengajuan'] ?>">Tidak Setuju</a>
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
                                                        <div class="modal-body">
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
                                                                        <li class="list-group-item"><strong>Nama Kendaraan:</strong> <?= $data_sql['nama_kendaraan']; ?></li>
                                                                        <li class="list-group-item"><strong>Merk Kendaraan:</strong> <?= $data_sql['merk_kendaraan']; ?></li>
                                                                        <li class="list-group-item"><strong>Plat Nomor:</strong> <?= $data_sql['plat_nomor']; ?></li>
                                                                        <li class="list-group-item"><strong>Nama Dan No HP Supir:</strong> <?= $data['supir'] ?></li>
                                                                        <li class="list-group-item"><strong>Saldo:</strong> Rp. <?= number_format($data['uang_jalan'], 0, ',', '.') ?></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- AKhir Modal Detail-->
                                    <?php endwhile ?>
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


</html>