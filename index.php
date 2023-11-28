<!DOCTYPE html>
<html>

<head>
	<title>Login PPKO</title>
	<link rel="stylesheet" type="text/css" href="stylelogin.css">
	<style>
		.container {
			display: flex;
			align-items: center;
			justify-content: space-around;
			height: 100vh;
		}

		.left-side {
			width: 45%;
			padding: 20px;
			color: white;
			font-weight: 100;
		}

		.right-side {
			width: 45%;
			padding: 20px;
		}

		.form-container {
			max-width: 300px;
			margin: 0 auto;
		}
	</style>
</head>

<body>
	<?php
	$pesan = $_GET['pesan'] ?? '';

	if ($pesan === 'gagal') {
		echo "<script>alert('NIK atau kata sandi salah. Coba lagi')</script>";
	} else if ($pesan === 'nonaktif') {
		echo "<script>alert('Status akun belum aktif. Silakan hubungi admin')</script>";
	}
	?>

	<div class="container">
		<div class="right-side">
			<div class="kotak_login">
				<img id="profile-img" class="profile-img-card" src="assets/img/logoinf.png" />
				<h2 class="tittle">Sistem Peminjaman Kendaraan</h2>

				<form action="cek_login.php" method="post">
					<label>NIK</label>
					<input type="text" name="nik" class="form_login" placeholder="NIK" required="required">

					<label>Password</label>
					<input type="password" name="password" class="form_login" placeholder="Password" required="required">

					<input type="submit" class="tombol_login" value="LOGIN">
					<br />
					<br />
					<p>Belum punya akun? <a href="register.php">Register</a></p>
				</form>
			</div>
		</div>
		<div class="left-side">
			<div class="kotak_login1">
				<h1>Selamat Datang Di Aplikasi PPKO</h1>
				<h2 text-white>Tata Cara Pengajuan PPKO</h2>
				<ul>
					<li>Langkah 1: Register Akun Dan Hubungi Admin Untuk Mengaktifkan Akun.</li>
					<li>Langkah 2: Login.</li>
					<li>Langkah 3: Klik Form Pengajuan.</li>
					<li>Langkah 4: Klik Isi Form Pengajuan.</li>
					<li>Langkah 5: Isi Form Pengajuan Sesuai Dengan Kebutuhan.</li>
					<li>Langkah 6: Setelah Itu Tunggu Sampai Status Disetujui Manager GA.</li>
					<li>Langkah 7: Logout Bila Sudah Menggunakan Aplikasi.</li>
				</ul>
			</div>
		</div>


	</div>
</body>

</html>