<?php

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];
    $status = $_POST['status'];

    if (
        empty($nama) ||
        empty($username) ||
        empty($_POST['password']) ||
        $level == 'Pilih' ||
        $status == 'Pilih'
    ) {

        echo "<script>
            alert('Semua data wajib diisi!');
        </script>";

    } else {

        $sql = "INSERT INTO t_admin
                (f_nama, f_username, f_password, f_level, f_status)
                VALUES
                ('$nama', '$username', '$password', '$level', '$status')";

        $result = $db->runSQL($sql);

        if ($result) {

            echo "<script>
                alert('Data admin berhasil ditambahkan!');
                window.location.href = '?f=admin&m=select';
            </script>";

            exit;

        } else {

            echo "<div class='alert alert-danger mt-3'>
                <strong>Gagal menambahkan admin!</strong><br>
                " . htmlspecialchars($db->getError()) . "
            </div>";

        }
    }
}

?>

<div class="mt-3">
    <div class="container">

        <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">
            Insert Admin
        </h3>

        <hr>

        <form action="" method="post">

            <div class="form-group w-50 mt-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama admin" required>
            </div>

            <div class="form-group w-50 mt-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="form-group w-50 mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <div class="form-group w-50 mt-3">
                <label>Level</label>
                <select name="level" class="form-control" required>
                    <option value="Pilih">Pilih...</option>
                    <option value="Admin">Admin</option>
                    <option value="Pustakawan">Pustakawan</option>
                </select>
            </div>

            <div class="form-group w-50 mt-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Pilih">Pilih...</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <br>
            <div class="w-50 d-flex gap-2">
                <a href="?f=admin&m=select" class="btn btn-secondary flex-fill">
                    Kembali
                </a>
                <button type="submit" name="simpan" value="simpan" class="btn btn-success flex-fill">
                    <i class="bi bi-save me-1"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>