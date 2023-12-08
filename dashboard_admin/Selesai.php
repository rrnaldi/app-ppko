<?php
//panggil koneksi php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] !== "Admin") {
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
                            Form Pengajuan Peminjaman Kendaraan
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
                                        </tr>
                                    </thead>

                                    <?php
                                    //menampilkan data
                                    $no = 1;
                                    $nik = $_SESSION['nik'];
                                    $getdivisi = mysqli_query($koneksi, "select nik, nama_divisi, nama from user WHERE nik='$nik' ");
                                    // menghitung jumlah data yang ditemukan
                                    $datadivisi = mysqli_fetch_array($getdivisi);
                                    $tampil = mysqli_query($koneksi, "SELECT p.*, u.* FROM pengajuan p  JOIN user u on u.nik= p.id_author  WHERE p.status='Disetujui Security' ORDER BY id_pengajuan DESC");
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
                                                <?php if ($data['status'] == 'Disetujui Security') {
                                                    echo $data['status'] ?>
                                                    <a href="#" style="text-decoration: none;" class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalSelesai<?= $no ?>">Selesai</a>
                                                <?php } else {
                                                    echo $data['status'];
                                                } ?>

                                            </td>
                                        </tr>
                                        <?php
                                        //menampilkan data nama
                                        $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE nik='$nik'");
                                        $data_sql = mysqli_fetch_array($sql);
                                        $nama = $data_sql['nama'];
                                        $nama_divisi = $data_sql['nama_divisi'];
                                        ?>

                                        <!-- Awal Modal Selesai -->
                                        <div class="modal fade modal-lg" id="modalSelesai<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Form PPKO</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="aksi_crud.php" data-no="<?= $no ?>">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <div class="mb-3">
                                                                        <label for="kendaraan">Pilih Kendaraan:</label>
                                                                        <select name="id_kendaraan" class="form-control">
                                                                            <?php
                                                                            $query = "SELECT id_kendaraan, nama_kendaraan, merk_kendaraan FROM kendaraan WHERE id_kendaraan = '$data[kendaraan_id]'";
                                                                            $result = mysqli_query($koneksi, $query);
                                                                            // Loop through the available vehicles and populate the dropdown options
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                                echo "<option value='{$row['id_kendaraan']}'>{$row['nama_kendaraan']} ({$row['merk_kendaraan']})</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jam">Saldo:</label>
                                                                        <input type="text" id="uangJalan<?= $no ?>" name="uang_jalan" value="<?= $data['uang_jalan'] ?>" class="form-control" readonly>
                                                                    </div>
                                                                    <p>Biaya Perjalanan =</p>
                                                                    <div class="mb-3">
                                                                        <label for="tujuan">Biaya Bensin:</label>
                                                                        <input type="text" id="" name="id_pengajuan" class="form-control " value="<?= $data['id_pengajuan'] ?>" hidden readonly />
                                                                        <input type="number" name="biayaBensin" id="biayaBensin<?= $no ?>" class="form-control">
                                                                        <input type="text" id="" name="tgl_selesai" class="form-control" value="<?php echo $tgl_PSpv = date("Y-m-d"); ?>" hidden readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tujuan">Biaya Tol:</label>
                                                                    <input type="number" id="biayaTol<?= $no ?>" name="biayaTol" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="NAMA">Biaya Lain-Lain:</label>
                                                                    <input type="number" id="biayaLain<?= $no ?>" name="biayaLain" class="form-control" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <p>Total Biaya <span id="totalBiaya<?= $no ?>">0</span></p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <p>Sisa Saldo <span id="sisaSaldo<?= $no ?>">0</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="bselesai">Kirim</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- AKhir Modal Selesai-->
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <!-- Script Total Biaya -->
    <script>
        // Ambil elemen-elemen dalam setiap modal dengan ID yang sesuai
        const biayaBensinInputs = document.querySelectorAll("[id^='biayaBensin']");
        const biayaTolInputs = document.querySelectorAll("[id^='biayaTol']");
        const biayaLainInputs = document.querySelectorAll("[id^='biayaLain']");
        const uangJalanInputs = document.querySelectorAll("[id^='uangJalan']");
        const totalBiayaSpans = document.querySelectorAll("[id^='totalBiaya']");
        const sisaSaldoSpans = document.querySelectorAll("[id^='sisaSaldo']");

        // Tambahkan event listener untuk setiap elemen input
        biayaBensinInputs.forEach((input, index) => {
            input.addEventListener("input", () => updateTotalBiaya(index));
        });
        biayaTolInputs.forEach((input, index) => {
            input.addEventListener("input", () => updateTotalBiaya(index));
        });
        biayaLainInputs.forEach((input, index) => {
            input.addEventListener("input", () => updateTotalBiaya(index));
        });


        function updateTotalBiaya(index) {
            const biayaBensin = parseFloat(biayaBensinInputs[index].value) || 0;
            const biayaTol = parseFloat(biayaTolInputs[index].value) || 0;
            const biayaLain = parseFloat(biayaLainInputs[index].value) || 0;
            const uangJalan = parseFloat(uangJalanInputs[index].value) || 0;

            const totalBiaya = biayaBensin + biayaTol + biayaLain;
            const sisaSaldo = uangJalan - totalBiaya;

            totalBiayaSpans[index].textContent = " " + totalBiaya.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
            sisaSaldoSpans[index].textContent = " " + sisaSaldo.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
        }
    </script>

    <!-- Akhir Script Total Biaya -->



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