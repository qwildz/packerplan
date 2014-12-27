<?php
include '../koneksi.php';

$username = 'resna';
$id_tempat = $_POST['id_tempat'];
$bintang = 5;
$teks = trim($_POST['teks']);

$sql = "INSERT INTO review (username, id_tempat, bintang, teks, created, modified)
        VALUE ('{$username}', {$id_tempat}, {$bintang}, '{$teks}', NOW(), NOW()) ";

$query = mysqli_query($koneksi, $sql);

if($query) {
    header("Location:../tempat.php?id_tempat={$id_tempat}&sukses=1");
} else {
    header("Location:../tempat.php?id_tempat={$id_tempat}&sukses=0");
}