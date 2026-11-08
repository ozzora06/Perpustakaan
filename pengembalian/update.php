<?php
if (isset($_GET['id'], $_GET['iddetailbuku'])) {
    $id = $_GET['id'];
    $iddetailbuku = $_GET['iddetailbuku'];
}

$sql = "UPDATE t_detailbuku SET f_status='Tersedia' WHERE f_id=$iddetailbuku";

$db->runSQL($sql);

$tanggal = date('y-m-d');

$sql = "UPDATE t_detailpeminjaman SET f_tanggalkembali='$tanggal' WHERE f_id=$id";
$db->runSQL($sql);
echo "<script> window.location.assign('?f=pengembalian&m=select'); </script>";
