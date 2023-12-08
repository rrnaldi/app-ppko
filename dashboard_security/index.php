<?php
//panggil koneksi php
session_start();
if ($_SESSION['level'] !== "Security") {
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
    <title>Dashboard - Security </title>
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
            Dashboard Security
        </a>
        <?php
        $nik = $_SESSION['nik'];
        $getnama = mysqli_query($koneksi, "select nama, nama_divisi from user where nik='$nik' ");
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
                                            <th>Tgl Rencana Pergi</th>
                                            <th>Tgl Rencana Kembali</th>
                                            <th>No HP</th>
                                            <th>Nama Yang Berpergian</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    //menampilkan data
                                    $no = 1;
                                    $nik = $_SESSION['nik'];
                                    $getdivisi = mysqli_query($koneksi, "select nik, nama_divisi, nama from user WHERE nik='$nik' ");
                                    // menghitung jumlah data yang ditemukan
                                    $datadivisi = mysqli_fetch_array($getdivisi);
                                    $tampil = mysqli_query($koneksi, "SELECT p.*, u.* FROM pengajuan p  JOIN user u on u.nik= p.id_author  WHERE p.status='Disetujui Manager GA' ORDER BY id_pengajuan DESC");
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
                                            <td> <?php if ($data['status'] == 'Disetujui Manager GA') {
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
                                                        <h5 class="modal-title" id="staticBackdropLabel">Form PPKO</h5> <br>
                                                        <p id="currentDate" class="ms-3"></p>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <form method="POST" action="aksi_crud.php">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="tujuan">Tanggal Pengajuan:</label>
                                                                        <input type="text" id="" name="id_pengajuan" class="form-control " value="<?= $data['id_pengajuan'] ?>" hidden readonly />
                                                                        <input type="text" id="" name="id_author" class="form-control " value="<?= $data['id_author'] ?>" hidden readonly />
                                                                        <input type="text" id="" name="tgl_pengajuan" class="form-control" value="<?= $data['tgl_pengajuan'] ?>" readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tujuan">Kode Transaksi:</label>
                                                                        <input type="text" id="" name="kd_transaksi" class="form-control" value="<?= $data['kd_transaksi'] ?>" readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="NAMA">Nama Pengaju:</label>
                                                                        <input type="text" id="" name="nama" class="form-control" value="<?= $data['nama'] ?>" readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="NIK">NIK:</label>
                                                                        <input type="text" id="" name="nik" class="form-control" value="<?= $data['nik'] ?>" readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nama_divisi">Divisi:</label>
                                                                        <input type="text" id="" name="nama_divisi" class="form-control" value="<?= $data['nama_divisi'] ?>" readonly required />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tujuan">Tujuan:</label>
                                                                        <input type="text" id="tujuan" name="tujuan" value="<?= $data['tujuan'] ?>" class="form-control" required readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="keperluan">Keperluan:</label>
                                                                        <textarea id="keperluan" name="keperluan" class="form-control" rows="4"><?= $data['keperluan'] ?></textarea required readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                    <li class="list-group-item" name="bukti"><strong>Bukti:</strong>
                                                                        <?php if (strpos($data['bukti'], ".jpg") !== false || strpos($data['bukti'], ".jpeg") !== false || strpos($data['bukti'], ".png") !== false) { ?>
                                                                                <a href="/percobaan/assets/img/<?= $data['bukti'] ?>" target="_blank">
                                                                                    <img src="/percobaan/assets/img/<?= $data['bukti'] ?>" width="50">
                                                                                </a>
                                                                            <?php } else {
                                                                            echo "Tidak Ada Bukti";
                                                                        }
                                                                            ?>
                                                                        </li>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                           <label for="nohp">Nomor HP:</label>
                                                                           <input type="text" id="no_hp" name="no_hp"  value="<?= $data['no_hp'] ?>" class="form-control" required readonly/>
                                                                    </div>
                                                                      <div class="mb-3">
                                                                             <label for="nama">Nama yang Berpergian:</label>
                                                                             <textarea id="nama_bp" name="nama_bp"  class="form-control" rows="4" required readonly><?= $data['nama_bp'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <!--grid kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="keterangan">Keterangan:</label>
                                                                        <textarea id="keterangan" name="keterangan" class="form-control" readonly rows="4"><?= $data['keterangan']  ?></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jam">Tgl Rencana Pergi:</label>
                                                                        <input type="text" id="" name="waktu_pergi" value="<?= $data['waktu_pergi'] ?>" class="form-control" required readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jam">Tgl Rencana Kembali:</label>
                                                                        <input type="text" id="" name="waktu_kembali" value="<?= $data['waktu_kembali'] ?>" class="form-control" required readonly />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kendaraan">Kendaraan:</label>
                                                                        <select name="id_kendaraan" class="form-control">
                                                                            <?php
                                                                            $query = "SELECT id_kendaraan, nama_kendaraan, merk_kendaraan, plat_nomor FROM kendaraan WHERE id_kendaraan = '$data[kendaraan_id]'";
                                                                            $result = mysqli_query($koneksi, $query);
                                                                            // Loop through the available vehicles and populate the dropdown options
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                                echo "<option value='{$row['id_kendaraan']}'>{$row['nama_kendaraan']} ({$row['merk_kendaraan']}) ({$row['plat_nomor']})</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="keterangan">Nama Dan No HP Supir:</label>
                                                                        <input type="text" id="" name="supir" value="<?= $data['supir'] ?>" class="form-control" />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tujuan">Saldo:</label>
                                                                        <input type="number" id="uang-jalan" name="uang_jalan" value="<?= $data['uang_jalan'] ?>" class=" form-control" oninput="formatCurrency(this)" />
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jam">Waktu Berangkat:</label>
                                                                        <?php
                                                                        // Split datetime value into date and time
                                                                        $datetime_parts = explode(" ", $data['tgl_pergi']);
                                                                        $date_part = $datetime_parts[0];
                                                                        $time_part = $datetime_parts[1];
                                                                        ?>
                                                                        <input type="date" class="form-control" name="dari" value="<?= $date_part ?>" />
                                                                        <input type="time" id="darijam" name="darijam" class="form-control" value="<?= $time_part ?>" />
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="jam">Waktu Kembali:</label>
                                                                        <input type="date" class="form-control" name="sampai" />
                                                                        <input type="time" id="darijam" name="sampaijam" class="form-control" />
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
                                        <!-- Akhir Modal Detail -->
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