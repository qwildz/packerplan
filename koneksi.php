<?php
$hostname = "localhost";
$username = "root";
$password = "02624701363";
$database = "sbd_tubes";
$url = "http://localhost/_project/sbd/";

$koneksi = mysqli_connect($hostname, $username, $password, $database);

if(mysqli_connect_errno())
{
    die('Gagal Koneksi ke Database!');
}

function mysql_injection(&$v, $k) {
    global $koneksi;

    $v = mysqli_real_escape_string($koneksi, htmlentities($v));
}

array_walk_recursive($_GET, 'mysql_injection');
array_walk_recursive($_POST, 'mysql_injection');
array_walk_recursive($_FILES, 'mysql_injection');

include 'session.php';
include 'helper.php';