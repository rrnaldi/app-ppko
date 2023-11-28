<?php
session_start();
include 'koneksi.php';

$nik = $_POST['nik'];
$password = $_POST['password'];

$login = mysqli_query($koneksi, "select * from user where nik='$nik' and password='$password'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
	$data = mysqli_fetch_assoc($login);
	$status = $data['status_user'];

	if ($status == "Aktif") {
		$_SESSION['nik'] = $nik;

		switch ($data['level']) {
			case "Admin":
				$_SESSION['level'] = "Admin";
				header("location:dashboard_admin/dashboard.php");
				break;
			case "Staff":
				$_SESSION['level'] = "Staff";
				header("location:dashboard_staff/dashboard.php");
				break;
			case "Manager":
				$_SESSION['level'] = "Manager";
				header("location:dashboard_manager/dashboard.php");
				break;
			case "Umum":
				$_SESSION['level'] = "Umum";
				header("location:dashboard_umum/dashboard.php");
				break;
			case "Asman":
				$_SESSION['level'] = "Asman";
				header("location:dashboard_asman/dashboard.php");
				break;
			case "ManagerGA":
				$_SESSION['level'] = "ManagerGA";
				header("location:dashboard_MGA/dashboard.php");
				break;
			default:
				header("location:index.php?pesan=gagal");
				break;
		}
	} else {
		header("location:index.php?pesan=nonaktif");
	}
} else {
	header("location:index.php?pesan=gagal");
}
