<?php
include '../koneksi.php';

if (is_login())
{
    redirect();
}

if (isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    $sql = "SELECT username, nama, email FROM user WHERE username = '{$username}' AND password = '{$password}'";
    $cek = mysqli_query($koneksi, $sql);
    if (mysqli_num_rows($cek) > 0)
    {
        $user = mysqli_fetch_assoc($cek);

        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['login'] = true;

        if(is_admin())
        {
            redirect('../admin/index.php');
        }
        else
        {
            redirect('../index.php');
        }
    }
    else
    {
        redirect('../login.php?sukses=0');
    }
}
else
{
    redirect('../login.php');
}
