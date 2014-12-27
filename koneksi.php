<?php

$hostname = "localhost";
$username = "root";
$password = "02624701363";
$database = "sbd_tubes";

$koneksi = mysqli_connect($hostname, $username, $password, $database);

if(mysqli_connect_errno())
{
    die('Gagal Koneksi ke Database!');
}