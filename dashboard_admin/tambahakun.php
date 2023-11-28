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
                            Form Penambahan Data User
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                Tambah User
                            </button>
                            <table id="datatablesSimple" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Password</th>
                                        <th>Divisi</th>
                                        <th>Level</th>
                                        <th>Status User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <?php
                                //menampilkan data
                                $no = 1;
                                $sql = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user DESC");
                                while ($data = mysqli_fetch_array($sql)) :
                                ?>

                                    <tr id="row<?= $no ?>">
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['nik'] ?></td>
                                        <td><?= $data['password'] ?></td>
                                        <td><?= $data['nama_divisi'] ?></td>
                                        <td><?= $data['level'] ?></td>
                                        <td><?= $data['status_user'] ?></td>
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
                                                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama">Nama:</label>
                                                                    <input type="text" id="nama" name="nama" value="<?= $data['nama'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="nik">Nik:</label>
                                                                    <input type="text" id="nik" name="nik" value="<?= $data['nik'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="password">Password:</label>
                                                                    <input type="password" id="password" name="password" value="<?= $data['password'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="level">Level:</label>
                                                                    <input type="text" id="level" name="level" value="<?= $data['level'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="nama_divisi">Nama Divisi:</label>
                                                                    <input type="text" id="nama_divisi" name="nama_divisi" value="<?= $data['nama_divisi'] ?>" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status_kendaraan">Status User:</label>
                                                                    <select type="text" id="status_kendaraan" name="status_user" class="form-control">
                                                                        <option value="">--Ubah Status User--</option>
                                                                        <option>Aktif</option>
                                                                        <option>Tidak Aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="bubah_user">Ubah</button>
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
                                                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                                                    <div class="modal-body">
                                                        <h5>Apakah Anda Yakin Ingin Menghapus Data Ini <br>
                                                            <span class="text-danger"><?= $data['nama'] ?> Dengan Nim: <?= $data['nik'] ?></span>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="bhapus_user">Hapus</button>
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
                                        <label for="nama">Nama:</label>
                                        <input type="text" id="nama" name="nama" class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nik">NIK:</label>
                                        <input type="text" id="nik" name="nik" class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_divisi">Nama Divisi:</label>
                                        <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="level">Level:</label>
                                        <select type="text" id="level" name="level" class="form-control">
                                            <option value="">--pilih level--</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Staff">Staff</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Umum">Umum</option>
                                            <option value="Asman">Asman</option>
                                            <option value="ManagerGA">ManagerGA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="bsimpan_user">Kirim</button>
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

    <script>
        // Fungsi untuk melakukan pencarian
        function searchTable() {
            // Mendapatkan nilai pencarian
            const searchText = document.getElementById("search").value.toLowerCase();

            // Mengakses tabel
            const table = document.querySelector("table");

            // Mengakses semua baris dalam tabel, kecuali baris header
            const rows = table.querySelectorAll("tr:not(:first-child)");

            // Loop melalui setiap baris
            rows.forEach((row) => {
                // Mengakses kolom NIK dan Divisi pada setiap baris
                const nik = row.cells[2].textContent.toLowerCase(); // Ganti 2 dengan indeks kolom NIK
                const divisi = row.cells[4].textContent.toLowerCase(); // Ganti 4 dengan indeks kolom Divisi

                // Mengecek apakah teks pencarian cocok dengan NIK atau Divisi
                if (nik.includes(searchText) || divisi.includes(searchText)) {
                    // Jika cocok, tampilkan baris
                    row.style.display = "";
                } else {
                    // Jika tidak cocok, sembunyikan baris
                    row.style.display = "none";
                }
            });
        }

        // Panggil fungsi searchTable() saat input pencarian berubah atau tombol Enter ditekan
        document.getElementById("search").addEventListener("input", searchTable);
    </script>


</html>