<?php
include '../koneksi.php';

if ( ! is_login())
{
    redirect('login.php');
}

$id_rencana = $_GET['id'];
$username = $_SESSION['username'];

if ( ! $id_rencana) redirect('index.php');

$sql = "SELECT * FROM partisipan WHERE username = '{$username}' AND id_rencana = {$id_rencana}";
$query = mysqli_query($koneksi, $sql);
$ngikut = mysqli_num_rows($query);

if ($ngikut)
{
    $sql = "DELETE FROM partisipan WHERE username = '{$username}' AND id_rencana = {$id_rencana}";
    $query = mysqli_query($koneksi, $sql);
}
else
{
    $sql = "INSERT INTO partisipan (username, id_rencana, created, modified)
            VALUES ('{$username}', {$id_rencana}, NOW(), NOW())";
    $query = mysqli_query($koneksi, $sql);
}

redirect('../detail_rencana.php?id=' . $id_rencana);