<?php

if (isset($_GET['id'])) {
     $id = (int) $_GET['id'];

     $sql = "SELECT * FROM t_admin WHERE f_id=$id";
     $row = $db->getITEM($sql);
}

if (!$row) {
     echo "<div class='alert alert-danger'>Data admin tidak ditemukan!</div>";
     return;
}

?>

<div class="mt-3">
     <div class="container">

          <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;">
               Update Admin
          </h3>

          <hr>

          <div class="form-group">

               <form action="" method="post">

                    <!-- NAMA -->
                    <div class="form-group w-50 mt-3">
                         <label>Nama</label>

                         <input type="text" name="nama" required value="<?= htmlspecialchars($row['f_nama']) ?>"
                              class="form-control">
                    </div>

                    <!-- USERNAME -->
                    <div class="form-group w-50 mt-3">
                         <label>Username</label>

                         <input type="text" name="username" required value="<?= htmlspecialchars($row['f_username']) ?>"
                              class="form-control">
                    </div>

                    <!-- PASSWORD -->
                    <div class="form-group w-50 mt-3">
                         <label>Password</label>

                         <input type="password" name="password"
                              placeholder="Kosongkan jika tidak ingin mengganti password" class="form-control">
                    </div>

                    <!-- LEVEL -->
                    <div class="form-group w-50 mt-3">
                         <label>Level</label>

                         <select name="level" class="form-control" required>

                              <option value="Admin" <?= $row['f_level'] == 'Admin' ? 'selected' : '' ?>>
                                   Admin
                              </option>

                              <option value="Pustakawan" <?= $row['f_level'] == 'Pustakawan' ? 'selected' : '' ?>>
                                   Pustakawan
                              </option>

                         </select>
                    </div>

                    <!-- STATUS -->
                    <div class="form-group w-50 mt-3">
                         <label>Status</label>

                         <select name="status" class="form-control" required>

                              <option value="Aktif" <?= $row['f_status'] == 'Aktif' ? 'selected' : '' ?>>
                                   Aktif
                              </option>

                              <option value="Tidak Aktif" <?= $row['f_status'] == 'Tidak Aktif' ? 'selected' : '' ?>>
                                   Tidak Aktif
                              </option>

                         </select>
                    </div>
                    <br>
                    <div class="w-50 d-flex gap-2">
                         <a href="?f=admin&m=select" class="btn btn-secondary flex-fill">
                              Batal
                         </a>
                         <button type="submit" name="simpan" value="simpan" class="btn btn-warning flex-fill">
                              <i class="bi bi-save me-1"></i>
                              Simpan
                         </button>
                    </div>
               </form>
          </div>
     </div>
</div>

<?php

if (isset($_POST['simpan'])) {

     $nama = trim($_POST['nama']);
     $username = trim($_POST['username']);

     // Password lama tetap digunakan jika input kosong
     if (!empty($_POST['password'])) {
          $password = md5($_POST['password']);
     } else {
          $password = $row['f_password'];
     }

     // Level langsung mengambil pilihan dropdown
     $level = $_POST['level'];

     // Status langsung mengambil pilihan dropdown
     $status = $_POST['status'];

     $sql = "UPDATE t_admin SET
                f_nama='$nama',
                f_username='$username',
                f_password='$password',
                f_level='$level',
                f_status='$status'
            WHERE f_id=$id";

     $db->runSQL($sql);

     echo "<script>
        alert('Data admin berhasil diperbarui!');
        window.location.assign('?f=admin&m=select');
    </script>";
}

?>