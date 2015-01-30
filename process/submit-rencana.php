<?php
include '../koneksi.php';

if ( ! is_login())
{
    redirect();
}

$username = 'qwildz';
$nama_rencana = $_POST['nama_rencana'];
$waktu = $_POST['waktu'];
$rute = explode(',', trim($_POST['rute']));



$sql = "INSERT INTO rencana (username, nama_rencana, waktu, created, modified)
        VALUE ('{$username}', '{$nama_rencana}', '{$waktu}', NOW(), NOW()) ";

$query = mysqli_query($koneksi, $sql);

if ($query)
{
    $id = mysqli_insert_id($koneksi);

    $i = 1;
    foreach ($rute as $r)
    {
        $sql = "INSERT INTO rute_rencana (id_tempat, id_rencana, urutan)
        VALUE ({$r}, {$id}, {$i}) ";

        $query = mysqli_query($koneksi, $sql);

        $i++;
    }

    var_dump($_POST);
    die();

    header("Location:../tempat.php?id_tempat={$id_tempat}&sukses=1");
}
else
{
    header("Location:../tempat.php?id_tempat={$id_tempat}&sukses=0");
}