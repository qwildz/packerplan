<?php
include '../koneksi.php';

if ( ! is_login())
{
    redirect('login.php');
}

//$usernmae		= $_POST['username'];
//$password		= $_POST['password'];
$nama = $_POST['nama'];
$tgl_lahir = $_POST['tgl_lahir'];
$alamat = $_POST['alamat'];
$jk = $_POST['jenis_kelamin'];
$email = $_POST['email'];

$update = mysqli_query($koneksi, "UPDATE user SET nama='$nama',tgl_lahir='$tgl_lahir',alamat='$alamat',jenis_kelamin='$jk',email='$email',modified=NOW() WHERE username='$_SESSION[username]'") or die(mysql_error());

//jika query update sukses
if ($update)
{
    redirect('../profile.php');
}
else
{
    redirect('../edit_profile.php');
}