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
                    <h1 class="mt-4">Permintaan Pelayanan Kendaraan Operasional</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">PPKO</li>
                    </ol>
                    <!-- Form Pengajuan Peminjaman Kendaraan -->
                    <div class="card">
                        <div class="card-header">
                            Form Penambahan Data Kendaraan
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                Tambah Kendaraan
                            </button>
                            <table id="datatablesSimple" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kendaraan</th>
                                        <th>Merk Kendaraan</th>
                                        <th>Plat Nomor</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <?php
                                //menampilkan data
                                $no = 1;
                                $sql = mysqli_query($koneksi, "SELECT * FROM kendaraan ORDER BY id_kendaraan DESC");
                                while ($data = mysqli_fetch_array($sql)) :
                                ?>

                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['nama_kendaraan'] ?></td>
                                        <td><?= $data['merk_kendaraan'] ?></td>
                                        <td><?= $data['plat_nomor'] ?></td>
                                        <td><?= $data['status_kendaraan'] ?></td>
                                        <td>
                                            <a href="#" style="text-decoration: none;" class="badge text-bg-primary" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $no ?>">Ubah</a>
                                            <a href="#" style="text-decoration: none;" class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $no ?>">Hapus</a>
                                        </td>
                                    </tr>
                                    <!-- Awal Modal Ubah -->
                                    <div class="modal fade modal-lg" id="modalUbah<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Form PPKO</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="aksi_crud.php">
                                                    <input type="hidden" name="id_kendaraan" value="<?= $data['id_kendaraan'] ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama_kendaraan">Nama Kendaraan:</label>
                                                                    <input type="text" id="nama_kendaraan" name="nama_kendaraan" value="<?= $data['nama_kendaraan'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="merk_kendaraan">Merk Kendaraan:</label>
                                                                    <input type="text" id="merk_kendaraan" name="merk_kendaraan" value="<?= $data['merk_kendaraan'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="plat_nomor">Plat Nomor:</label>
                                                                    <input type="text" id="plat_nomor" name="plat_nomor" value="<?= $data['plat_nomor'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status_kendaraan">Status Kendaraan:</label>
                                                                    <select type="text" id="status_kendaraan" name="status_kendaraan" class="form-control">
                                                                        <option value="">--pilih status kendaraan--</option>
                                                                        <option>Tersedia</option>
                                                                        <option>Tidak Tersedia</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="bubah_kendaraan">Ubah</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- AKhir Modal Ubah-->

                                    <!-- Awal Modal Hapus -->
                                    <div class="modal fade modal-lg" id="modalHapus<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Hapus Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="aksi_crud.php">
                                                    <input type="hidden" name="id_kendaraan" value="<?= $data['id_kendaraan'] ?>">
                                                    <div class="modal-body">
                                                        <h5>Apakah Anda Yakin Ingin Menghapus Data Ini <br>
                                                            <span class="text-danger"><?= $data['nama_kendaraan'] ?>-<?= $data['merk_kendaraan'] ?></span>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="bhapus_kendaraan">Hapus</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                                    </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                        </div>
                    </div>
                    <!-- AKhir Modal Hapus-->
                <?php endwhile ?>
                </table>


                <!-- Awal Modal Simpan-->
                <div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Form PPKO</h5> <br>
                                <p id="currentDate" class="ms-3"></p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form method="POST" action="aksi_crud.php">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama_kendaraan">Nama Kendaraan:</label>
                                        <input type="text" id="nama_kendaraan" name="nama_kendaraan" class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="merk_kendaraan">Merk Kendaraan:</label>
                                        <input type="text" id="merk_kendaraan" name="merk_kendaraan" class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="plat_nomor">Plat Nomor:</label>
                                        <input type="text" id="plat_nomor" name="plat_nomor" class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="bsimpan_kendaraan">Kirim</button>
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