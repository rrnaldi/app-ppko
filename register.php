<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - User</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Buat Akun</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="aksi_crud.php">
                                        <div class="mb-3">
                                            <label for="nama">Nama:</label>
                                            <input type="text" id="nama" name="nama" class="form-control" required="required" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="nik">NIK:</label>
                                            <input type="text" id="nik" name="nik" class="form-control" required="required" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="password">Password:</label>
                                            <input type="password" id="password" name="password" class="form-control" required="required" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_divisi">Nama Divisi:</label>
                                            <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" required="required" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="level">Level:</label>
                                            <select type="text" id="level" name="level" class="form-control" required="required">
                                                <option value="">--pilih level--</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Umum">Umum</option>
                                                <option value="Asman">Asman</option>
                                                <option value="ManagerGA">ManagerGA</option>
                                                <option value="Security">Security</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer d-flex align-items-center justify-content-center small">
                                            <button type="submit" class="btn btn-primary" name="bsimpan_register">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted ">Copyright &copy; Renaldi 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>