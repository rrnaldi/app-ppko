<?php
//panggil koneksi php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] !== "Staff") {
    header("location:../index.php?pesan=gagal");
}
include "../koneksi.php";


$query = "SELECT MAX(kd_transaksi) AS max_kd_transaksi FROM pengajuan";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $last_running_number = $row['max_kd_transaksi'];
} else {
    $last_running_number = 0;
}

$year_month = date('m/Y');
@$new_running_number = $last_running_number + 1;
$new_running_number_formatted = sprintf('%04d', $new_running_number);
$running_number = $new_running_number_formatted . '/PPKO/' . $year_month;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Staff</title>
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
            Dashboard Staff
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
                        <a class="nav-link text-white" href="index.php">
                            <div class="sb-nav-link-icon text-white"><i class="fas fa-archive "></i></div>
                            Form Pengajuan
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
                            Form Pengajuan Peminjaman Kendaraan
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                Isi Form Pengajuan
                            </button>
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
                                            <th>Tanggal Rencana Pergi</th>
                                            <th>Tanggal Rencana Kembali</th>
                                            <th>No HP</th>
                                            <th>Nama Yang Berpergian</th>
                                            <th>Keterangan</th>
                                            <th>Tanggal Diterima</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    //menampilkan data
                                    $no = 1;
                                    $nik = $_SESSION['nik'];
                                    $getdivisi = mysqli_query($koneksi, "select nama_divisi, nama from user where nik='$nik' ");
                                    // menghitung jumlah data yang ditemukan
                                    $datadivisi = mysqli_fetch_array($getdivisi);
                                    $tampil = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_author='$nik' ORDER BY id_pengajuan DESC");
                                    while ($data = mysqli_fetch_array($tampil)) :
                                    ?>



                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['tgl_pengajuan'] ?></td>
                                            <td><?= $datadivisi['nama'] ?></td>
                                            <td><?= $_SESSION['nik'] ?></td>
                                            <td><?= $datadivisi['nama_divisi'] ?></td>
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
                                            <td><?php if ($data['status'] == 'Disetujui Manager') {
                                                    echo $data['tgl_PManager'];
                                                } elseif ($data['status'] == 'Diterima Departemen GA') {
                                                    echo $data['tgl_PUmum'] ?>
                                                <?php } elseif ($data['status'] == 'Disetujui Asmen') {
                                                    echo $data['tgl_PSpv'] ?>
                                                <?php } elseif ($data['status'] == 'Disetujui Manager GA') {
                                                    echo $data['tgl_PAsmen'] ?>
                                                <?php } elseif ($data['status'] == 'Peminjaman Selesai') {
                                                    echo $data['tgl_selesai'] ?>
                                                <?php } elseif ($data['status'] == 'Disetujui Security') {
                                                    echo $data['tgl_pergi'] ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($data['status'] == 'Telah Diajukan') {
                                                    echo $data['status'];
                                                } elseif ($data['status'] == 'Disetujui Manager GA') {
                                                    echo $data['status'] ?>
                                                    <a href="#" style="text-decoration: none;" class="badge text-bg-primary" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $no ?>">Detail</a>
                                                <?php } elseif ($data['status'] == 'Peminjaman Selesai') {
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
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><strong>Nama Pengaju:</strong> <?= $datadivisi['nama'] ?></li>
                                                                        <li class="list-group-item"><strong>NIK:</strong> <?= $_SESSION['nik'] ?></li>
                                                                        <li class="list-group-item"><strong>Nama Divisi:</strong> <?= $datadivisi['nama_divisi'] ?></li>
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
                                                                        <li class="list-group-item"><strong>Tgl Rencana Pergi:</strong> <?= $data['waktu_pergi'] ?></li>

                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item"><strong>Tgl Rencana Kembali:</strong> <?= $data['waktu_kembali'] ?></li>
                                                                        <li class="list-group-item"><strong>Nomor HP:</strong> <?= $data['no_hp'] ?></li>
                                                                        <li class="list-group-item"><strong>Nama yang Berpergian:</strong> <?= $data['nama_bp'] ?></li>
                                                                        <li class="list-group-item"><strong>Keterangan:</strong> <?= $data['keterangan'] ?></li>
                                                                        <li class="list-group-item"><strong>Nama Kendaraan:</strong> <?= $data_sql['nama_kendaraan']; ?></li>
                                                                        <li class="list-group-item"><strong>Merk Kendaraan:</strong> <?= $data_sql['merk_kendaraan']; ?></li>
                                                                        <li class="list-group-item"><strong>Plat Nomor:</strong> <?= $data_sql['plat_nomor']; ?></li>
                                                                        <li class="list-group-item"><strong>Nama Dan No HP Supir:</strong> <?= $data['supir'] ?></li>
                                                                        <li class="list-group-item"><?php
                                                                                                    if ($data['status'] == 'Disetujui Manager GA') {
                                                                                                        echo 'Saldo: Rp. ' . number_format($data['uang_jalan'], 0, ',', '.');
                                                                                                    } elseif ($data['status'] == 'Peminjaman Selesai') {
                                                                                                        echo 'Biaya Perjalanan: Rp. ' . number_format($data['total_biaya'], 0, ',', '.');
                                                                                                    } else {
                                                                                                        echo 'Status tidak dikenali';
                                                                                                    }
                                                                                                    ?></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <!-- <button type="button" class="btn btn-primary" onclick="printModalContent()">Cetak</button> -->
                                                                    <a href="../cetak2.php?id=<?php echo $data['id_pengajuan']; ?>" target="_blank">Cetak PDF</a>
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
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-primary" onclick="printModalContent()">Cetak</button> -->
                                    <a href="../cetakstaff/cetakU.php?id=<?php echo $data['id_pengajuan']; ?>" target="_blank">Cetak PDF</a>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-primary" onclick="printModalContent()">Cetak</button> -->
                                    <a href="../cetakstaff/cetakExU.php" target="_blank">Cetak Excel</a>
                                </div>
                            </div>
                            <?php
                            //menampilkan data nama
                            $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE nik='$nik'");
                            $data_sql = mysqli_fetch_array($sql);
                            $nama_divisi = $data_sql['nama_divisi'];
                            $nama = $data_sql['nama'];
                            ?>


                            <!-- Awal Modal Simpan-->
                            <div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Form PPKO</h5> <br>
                                            <p id="currentDate" class="ms-3"></p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form method="POST" action="aksi_crud.php" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tujuan">Tanggal Pengajuan:</label>
                                                            <input type="text" id="" name="nik" class="form-control " value="<?php echo $nik; ?>" hidden readonly />
                                                            <input type="text" id="" name="tgl_pengajuan" class="form-control" value="<?php echo $tgl_pengajuan = date("Y-m-d"); ?>" readonly />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tujuan">Kode Transaksi:</label>
                                                            <input type="text" id="" name="running_number" class="form-control" value="<?php echo $running_number; ?>" readonly />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="NAMA">Nama Pengaju:</label>
                                                            <input type="text" id="" name="nama" class="form-control" value="<?php echo $nama; ?>" readonly />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="NIK">NIK:</label>
                                                            <input type="text" id="" name="nik" class="form-control" value="<?php echo $nik; ?>" readonly />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama_divisi">Divisi:</label>
                                                            <input type="text" id="" name="nama_divisi" class="form-control" value="<?php echo $nama_divisi; ?>" readonly required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tujuan">Tujuan:</label>
                                                            <input type="text" id="tujuan" name="tujuan" class="form-control" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keperluan">Keperluan:</label>
                                                            <textarea id="keperluan" name="keperluan" class="form-control" rows="4"></textarea required>
                                                        </div>
                                                        <div class="mb-3">
                                                                <label for="bukti">Upload Bukti (Opsional):</label>
                                                                <input type="file" id="bukti" name="bukti" class="form-control" accept="image/*">
                                                         </div>
                                                       
                                                    </div>
                                                    <!--grid kiri -->
                                                    <div class="col-md-6">
                                                       
                                                        <div class="mb-3">
                                                            <label for="nohp">Nomor HP:</label>
                                                            <input type="text" id="no_hp" name="no_hp" class="form-control" required/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama">Nama yang Berpergian:</label>
                                                            <textarea id="nama_bp" name="nama_bp" class="form-control" rows="4" required></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keterangan">Keterangan:</label>
                                                            <textarea id="keterangan" name="keterangan" class="form-control" rows="4"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jam">Tanggal Berangkat:</label>
                                                            <input type="date" class="form-control" name="dari" required />
                                                            <input type="time" id="darijam" name="darijam" class="form-control" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jam">Tanggal Kembali:</label>
                                                            <input type="date" class="form-control" name="sampai" required />
                                                            <input type="time" id="sampaijam" name="sampaijam" class="form-control" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" name="bsimpan">Kirim</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- AKhir Modal -->
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

        updateCurrentDate();

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