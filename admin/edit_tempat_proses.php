<?php
include('koneksi.php');
//mulai proses tambah data

//cek dahulu, jika tombol tambah di klik
if (isset($_POST['edit']))
{
    //jika tombol tambah benar di klik maka lanjut prosesnya
    $id = $_POST['id'];
    $namaTempat = $_POST['nama_tempat_wisata'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $hrgTiket = $_POST['harga_tiket'];
    $jBuka = $_POST['jam_buka'];
    $jtutup = $_POST['jam_tutup'];
    $lg = $_POST['lg'];
    $lt = $_POST['lt'];

    $update = mysql_query("UPDATE tempat_wisata SET nama_tempat='$namaTempat', alamat='$alamat',harga_tiket=$hrgTiket,jam_buka='$jBuka',jam_tutup='$jtutup',latitude='$lt',longitude='$lg',modified=NOW(),deskripsi='$deskripsi' WHERE id_tempat= $id") or die(mysql_error());
    //jika query update sukses
    if ($update)
    {

        echo 'Data berhasil di simpan! ';        //Pesan jika proses simpan sukses
        echo '<a href="tempat_wisata.php">Kembali</a>';    //membuat Link untuk kembali ke halaman edit

    }
    else
    {

        echo 'Gagal menyimpan data! ';        //Pesan jika proses simpan gagal
        echo '<a href="edit.php?id=' . $id . '">Kembali</a>';    //membuat Link untuk kembali ke halaman edit

    }

}
else
{    //jika tidak terdeteksi tombol simpan di klik

    //redirect atau dikembalikan ke halaman edit
    echo '<script>window.history.back()</script>';

}





?>