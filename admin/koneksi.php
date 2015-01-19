<?php
$host = "localhost";    //nama host
$user = "root";    //username phpMyAdmin
$pass = "02624701363";    //password phpMyAdmin
$name = "sbd_tubes";    //nama database
$url = "http://localhost/_project/sbd/";

$koneksi = mysql_connect($host, $user, $pass) or die("Koneksi ke database gagal!");
mysql_select_db($name, $koneksi) or die("Tidak ada database yang dipilih!");

function mysql_injection(&$v, $k)
{
    $v = mysql_real_escape_string(htmlentities($v));
}

array_walk_recursive($_GET, 'mysql_injection');
array_walk_recursive($_POST, 'mysql_injection');
array_walk_recursive($_FILES, 'mysql_injection');

include '../session.php';

if ( ! is_login() || ! is_admin())
{
    redirect($url . 'login.php');
}