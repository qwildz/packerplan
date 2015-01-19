<?php
include('koneksi.php');

//cek dahulu, jika tombol tambah di klik
if (isset($_POST['submit']))
{
    //jika tombol tambah benar di klik maka lanjut prosesnya
    $id = $_POST['id'];
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $pass_baru_conf = $_POST['pass_baru_conf'];

    $query = mysql_query("SELECT password FROM user WHERE username= $id") or die(mysql_error());
    $password = mysql_fetch_assoc($query);

    if (sha1($pass_lama) == $password[ password ])
    {
        echo 'Password sama !';
        if ($pass_baru_conf == $pass_baru)
        {
            echo 'Password sama !';
            $update = mysql_query("UPDATE user SET password=SHA1('$pass_baru'),modified='modified()'WHERE username= $id") or die(mysql_error());

            //jika query update sukses
            if ($update)
            {

                echo 'Data berhasil di simpan! ';        //Pesan jika proses simpan sukses
                echo '<a href="user.php">Kembali</a>';    //membuat Link untuk kembali ke halaman edit

            }
            else
            {

                echo 'Gagal menyimpan data! ';        //Pesan jika proses simpan gagal
                echo '<a href="ubah_pass.php?id=' . $id . '">Kembali</a>';    //membuat Link untuk kembali ke halaman edit

            }
        }
        else
        {
            echo 'Password tidak sama !';
            echo 'Gagal menyimpan data! ';        //Pesan jika proses simpan gagal
            echo '<a href="ubah_pass.php?id=' . $id . '">Kembali</a>';    //membuat Link untuk kembali ke halaman edit
        }
    }
    else
    {
        echo 'Password tidak sama !';
        echo 'Gagal menyimpan data! ';        //Pesan jika proses simpan gagal
        echo '<a href="ubah_pass.php?id=' . $id . '">Kembali</a>';    //membuat Link untuk kembali ke halaman edit
    }

}
else
{    //jika tidak terdeteksi tombol simpan di klik

    //redirect atau dikembalikan ke halaman edit
    echo '<script>window.history.back()</script>';

}