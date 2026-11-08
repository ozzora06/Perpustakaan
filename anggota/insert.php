<div class="mt-3">
    <div class="container">
        <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">INSERT ANGGOTA</h3>
        <hr>

        <form action="" method="post">
            <div class="form-group w-50 mt-3">
                <label>Nama</label>
                <input type="text" name="nama" required class="form-control">
            </div>

            <div class="form-group w-50 mt-3">
                <label>Username</label>
                <input type="text" name="username" required class="form-control">
            </div>

            <div class="form-group w-50 mt-3">
                <label>Password</label>
                <input type="password" name="password" required class="form-control">
            </div>

            <div class="form-group w-50 mt-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tmptlhr" required class="form-control">
            </div>

            <div class="form-group w-50 mt-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgllhr" required class="form-control">
            </div>

            <br>
            <div class="w-50 d-flex gap-2">
                <a href="?f=anggota&m=select" class="btn btn-secondary flex-fill">
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

<?php
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $tmptlhr = $_POST['tmptlhr'];
    $tgllhr = $_POST['tgllhr'];

    $sql = "INSERT INTO t_anggota
    (f_nama, f_username, f_password, f_tempatlahir, f_tangallahir)
    VALUES
    ('$nama', '$username', '$password', '$tmptlhr', '$tgllhr')";

    $db->runSQL($sql);

    echo "<script>
    window.location.assign('?f=anggota&m=select');
    </script>";
}
?>