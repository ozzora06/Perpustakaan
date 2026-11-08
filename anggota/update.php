<?php

if (!isset($_GET['id'])) {
    echo "ID anggota tidak ditemukan.";
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM t_anggota WHERE f_id=$id";
$row = $db->getITEM($sql);

if (!$row) {
    echo "Data anggota tidak ditemukan.";
    exit;
}

?>

<div class="mt-3">
    <div class="container">
        <h2 style="font-family:Georgia, 'Times New Roman', Times, serif;">
            UPDATE ANGGOTA
        </h2>
        <hr>
        <form action="" method="post">
            <div class="form-group w-50 mt-3">
                <label>Nama</label>
                <input type="text" name="nama" required value="<?php echo htmlspecialchars($row['f_nama']); ?>"
                    class="form-control">
            </div>
            <div class="form-group w-50 mt-3">
                <label>Username</label>
                <input type="text" name="username" required value="<?php echo htmlspecialchars($row['f_username']); ?>"
                    class="form-control">
            </div>
            <div class="form-group w-50 mt-3">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password"
                    class="form-control">
            </div>

            <div class="form-group w-50 mt-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tempatlahir" required
                    value="<?php echo htmlspecialchars($row['f_tempatlahir']); ?>" class="form-control">
            </div>
            <div class="form-group w-50 mt-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggallahir" required
                    value="<?php echo htmlspecialchars($row['f_tangallahir']); ?>" class="form-control">
            </div>
            <br>
            <div class="w-50 d-flex gap-2">
                <a href="?f=anggota&m=select" class="btn btn-secondary flex-fill">
                    Kembali
                </a>
                <button type="submit" name="simpan" value="simpan" class="btn btn-warning flex-fill">
                    <i class="bi bi-save me-1"></i>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<?php

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $tempatlahir = $_POST['tempatlahir'];
    $tanggallahir = $_POST['tanggallahir'];

    if (!empty($_POST['password'])) {

        $password = md5($_POST['password']);

        $sql = "UPDATE t_anggota SET
            f_nama='$nama',
            f_username='$username',
            f_password='$password',
            f_tempatlahir='$tempatlahir',
            f_tangallahir='$tanggallahir'
            WHERE f_id=$id";

    } else {

        $sql = "UPDATE t_anggota SET
            f_nama='$nama',
            f_username='$username',
            f_tempatlahir='$tempatlahir',
            f_tangallahir='$tanggallahir'
            WHERE f_id=$id";
    }

    $db->runSQL($sql);

    echo "<script>
    window.location.assign('?f=anggota&m=select');
    </script>";
}

?>