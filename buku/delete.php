<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM t_buku WHERE f_id=$id ORDER BY f_id DESC LIMIT 1";

    $db->runSQL($sql);
    echo "<script>window.location.assign('?f=buku&m=select');</script>";
}
