<?php
include '../koneksi.php';

if (is_login())
{
    redirect();
}

if (isset($_POST['nama']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm']))
{
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password == $password_confirm)
    {
        $password = sha1($password);
    }
    else
    {
        redirect('../register.php?password_beda=1');
        exit;
    }

    $sql = "INSERT INTO user(nama, username, password, created, modified) VALUES ('{$nama}', '{$username}', '{$password}', NOW(), NOW())";
    $input = mysqli_query($koneksi, $sql);

    if ($input)
    {
        $user = mysqli_fetch_assoc($cek);

        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $nama;
        $_SESSION['login'] = true;

        redirect('../index.php');
    }
    else
    {
        redirect('../register.php?sukses=0');
    }
}
else
{
    redirect('../register.php');
}
