<?php
//panggil koneksi php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] !== "Asman") {
    header("location:../index.php?pesan=gagal");
}
include "../koneksi.php";

// Query untuk mengambil jumlah pengajuan per bulan dengan label bulan dalam format nama bulan
$query = "SELECT DATE_FORMAT(tgl_pengajuan, '%M') AS bulan, COUNT(*) AS jumlah_pengajuan, SUM(total_biaya) AS total_biaya FROM pengajuan WHERE status = 'Peminjaman Selesai' GROUP BY bulan ORDER BY tgl_pengajuan ASC";
$result = mysqli_query($koneksi, $query);


$data_bulan = [];
$data_jumlah_pengajuan = [];
$data_total_biaya = [];


while ($row = mysqli_fetch_assoc($result)) {
    $data_bulan[] = $row['bulan'];
    $data_jumlah_pengajuan[] = $row['jumlah_pengajuan'];
    $data_total_biaya[] = $row['total_biaya'];
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Asman</title>
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
            Dashboard Asman
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
                    </div>
                </div>

            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard PPKO</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary fw-bold text-white mb-4">
                                <div class="card-body">Approval Manager Bidang</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    <p class="card-text">
                                        <?php
                                        $query_manager = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status = 'Telah Diajukan'");
                                        $jumlah_manager = mysqli_num_rows($query_manager);
                                        echo "<h5 class='card-text'>" . $jumlah_manager . "</h5>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger fw-bold text-white mb-4">
                                <div class="card-body">Menunggu Diterima Bidang Umum</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    <p class="card-text">
                                        <?php
                                        $query_manager = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status = 'Disetujui Manager'");
                                        $jumlah_manager = mysqli_num_rows($query_manager);
                                        echo "<h5 class='card-text'>" . $jumlah_manager . "</h5>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success fw-bold text-white mb-4">
                                <div class="card-body">Approval Asmen</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="index.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    <p class="card-text">
                                        <?php
                                        $query_manager = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status = 'Diterima Departemen GA'");
                                        $jumlah_manager = mysqli_num_rows($query_manager);
                                        echo "<h5 class='card-text'>" . $jumlah_manager . "</h5>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-secondary fw-bold text-white mb-4">
                                <div class="card-body">Approval Manager GA</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    <p class="card-text">
                                        <?php
                                        $query_manager = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status = 'Disetujui Asman'");
                                        $jumlah_manager = mysqli_num_rows($query_manager);
                                        echo "<h5 class='card-text'>" . $jumlah_manager . "</h5>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary fw-bold text-white mb-4">
                                <div class="card-body">Data Selesai Peminjaman</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="PSelesai.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    <p class="card-text">
                                        <?php
                                        $query_manager = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status = 'Disetujui Manager GA'");
                                        $jumlah_manager = mysqli_num_rows($query_manager);
                                        echo "<h5 class='card-text'>" . $jumlah_manager . "</h5>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger fw-bold text-white mb-4">
                                <div class="card-body">Data Transaksi</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="transaksi.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    <p class="card-text">
                                        <?php
                                        $query_manager = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE status = 'Peminjaman Selesai'");
                                        $jumlah_manager = mysqli_num_rows($query_manager);
                                        echo "<h5 class='card-text'>" . $jumlah_manager . "</h5>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Pengeluaran Biaya PPKO
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Data Status Pengajuan PPKO
                                </div>
                                <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid px-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Data Jumlah Pengajuan PPKO
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
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
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="chart-bar-demo1.js"></script>
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

<script>
    var bulanFromDatabase = <?php echo json_encode($data_bulan); ?>;
    var jumlahPengajuan = <?php echo json_encode($data_jumlah_pengajuan); ?>;

    var ctx = document.getElementById("myBarChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: bulanFromDatabase,
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: jumlahPengajuan,
                backgroundColor: [
                    "red",
                    "#00FF00",
                    "blue",
                    "yellow",
                    "orange",
                    "purple"
                ],
                borderColor: [
                    "rgba(2,117,216,1)",
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 5
                    }
                }]
            }
        }
    });
</script>
<?php
$query = "SELECT DATE_FORMAT(tgl_pengajuan, '%M') AS bulan1, COUNT(*) AS jumlah_pengajuan, 
SUM(CASE WHEN status = 'Telah Diajukan' THEN 1 ELSE 0 END) AS diajukan,
SUM(CASE WHEN status = 'Disetujui Manager' THEN 1 ELSE 0 END) AS disetujui,
SUM(CASE WHEN status = 'Diterima Departemen GA' THEN 1 ELSE 0 END) AS diterima,
SUM(CASE WHEN status = 'Disetujui Asman' THEN 1 ELSE 0 END) AS disetujuiAsm,
SUM(CASE WHEN status = 'Disetujui Manager GA' THEN 1 ELSE 0 END) AS disetujuiMGA,
SUM(CASE WHEN status = 'Peminjaman Selesai' THEN 1 ELSE 0 END) AS selesai FROM pengajuan GROUP BY bulan1 ORDER BY tgl_pengajuan ASC";
$result = mysqli_query($koneksi, $query);
$data_status = [
    'diajukan' => 0,
    'disetujui' => 0,
    'diterima' => 0,
    'disetujuiAsm' => 0,
    'disetujuiMGA' => 0,
    'selesai' => 0,
];

while ($row = mysqli_fetch_assoc($result)) {
    $data_bulan1[] = $row['bulan1'];
    $data_status['diajukan'] += $row['diajukan'];
    $data_status['disetujui'] += $row['disetujui'];
    $data_status['diterima'] += $row['diterima'];
    $data_status['disetujuiAsm'] += $row['disetujuiAsm'];
    $data_status['disetujuiMGA'] += $row['disetujuiMGA'];
    $data_status['selesai'] += $row['selesai'];
}

$data_diajukan[] = $data_status['diajukan'];
$data_disetujui[] = $data_status['disetujui'];
$data_diterima[] = $data_status['diterima'];
$data_dievaluasi[] = $data_status['disetujuiAsm'];
$data_disetujuispv[] = $data_status['disetujuiMGA'];
$data_selesai[] = $data_status['selesai'];


?>

<script>
    var bulanFromDatabase = <?php echo json_encode($data_bulan1); ?>;
    var jumlahDiajukan = <?php echo json_encode($data_diajukan); ?>;
    var jumlahDisetujui = <?php echo json_encode($data_disetujui); ?>;
    var jumlahDiterima = <?php echo json_encode($data_diterima); ?>;
    var jumlahDievaluasi = <?php echo json_encode($data_dievaluasi); ?>;
    var jumlahDisetujuispv = <?php echo json_encode($data_disetujuispv); ?>;
    var jumlahSelesai = <?php echo json_encode($data_selesai); ?>;
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Diajukan", "Disetujui Manager", "Diterima Departemen GA", "Disetujui Asman", "Disetujui Manager GA", "Selesai"],
            datasets: [{
                data: [jumlahDiajukan[0], jumlahDisetujui[0], jumlahDiterima[0], jumlahDievaluasi[0], jumlahDisetujuispv[0], jumlahSelesai[0]],
                backgroundColor: [
                    "red",
                    "#00FF00",
                    "blue",
                    "yellow",
                    "orange",
                    "purple"
                ]
            }],
        },
    });
</script>

<script>
    var bulanFromDatabase = <?php echo json_encode($data_bulan); ?>;
    var jumlahBiaya = <?php echo json_encode($data_total_biaya); ?>;

    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: bulanFromDatabase,
            datasets: [{
                label: 'Total Biaya', // Label untuk dataset
                data: jumlahBiaya, // Data total biaya
                borderColor: 'blue', // Warna garis
                fill: false // Tanpa mengisi area di bawah garis
            }],
        },
        options: {
            // Konfigurasi opsional
        }
    });
</script>







</html>