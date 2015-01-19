<?php
include '../koneksi.php';

if ( ! is_login())
{
    redirect();
}

$username = $_SESSION['username'];
$id_tempat = $_POST['id_tempat'];
$bintang = $_POST['bintang'];
$teks = trim($_POST['teks']);

$sql = "INSERT INTO review (username, id_tempat, bintang, teks, created, modified)
        VALUE ('{$username}', {$id_tempat}, {$bintang}, '{$teks}', NOW(), NOW()) ";

$query = mysqli_query($koneksi, $sql);

if ($query)
{
    header("Location:../tempat.php?id_tempat={$id_tempat}&sukses=1");
}
else
{
    header("Location:../tempat.php?id_tempat={$id_tempat}&sukses=0");
}