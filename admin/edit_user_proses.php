<?php
include('koneksi.php');

//cek dahulu, jika tombol tambah di klik
if (isset($_POST['edit']))
{
    //jika tombol tambah benar di klik maka lanjut prosesnya
    $id = $_POST['id'];
    //$usernmae		= $_POST['username'];
    //$password		= $_POST['password'];
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $email = $_POST['email'];


    $update = mysql_query("UPDATE user SET nama='$nama',tgl_lahir='$tgl_lahir',alamat='$alamat',jenis_kelamin='$jk',email='$email',modified=NOW() WHERE username= $id") or die(mysql_error());
    //jika query update sukses
    if ($update)
    {
        echo 'Data berhasil di simpan! ';        //Pesan jika proses simpan sukses
        echo '<a href="user.php">Kembali</a>';    //membuat Link untuk kembali ke halaman edit
    }
    else
    {
        echo 'Gagal menyimpan data! ';        //Pesan jika proses simpan gagal
        echo '<a href="edit_user.php?id=' . $id . '">Kembali</a>';    //membuat Link untuk kembali ke halaman edit
    }
}
else
{    //jika tidak terdeteksi tombol simpan di klik

    //redirect atau dikembalikan ke halaman edit
    echo '<script>window.history.back()</script>';
}





?>