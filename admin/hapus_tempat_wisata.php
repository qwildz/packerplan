<?php
include('koneksi.php');

//cek dahulu, apakah benar URL sudah ada GET id -> hapus.php?id=siswa_id
if (isset($_GET['id']))
{
    //membuat variabel $id yg bernilai dari URL GET id -> hapus.php?id=siswa_id
    $id = $_GET['id'];

    //cek ke database apakah ada data siswa dengan siswa_id=$id
    $cek = mysql_query("SELECT *FROM tempat_wisata WHERE id_tempat=$id") or die(mysql_error());

    //jika data siswa tidak ada
    if (mysql_num_rows($cek) == 0)
    {
        //jika data tidak ada, maka redirect atau dikembalikan ke halaman beranda
        echo '<script>window.history.back()</script>';
    }
    else
    {
        $del = mysql_query("DELETE FROM tempat_wisata WHERE id_tempat=$id");

        if ($del)
        {
            echo 'Data wisata berhasil di hapus! ';        //Pesan jika proses hapus berhasil
            echo '<a href="tempat_wisata.php">Kembali</a>';    //membuat Link untuk kembali ke halaman beranda
        }
        else
        {
            echo 'Gagal menghapus data! ';        //Pesan jika proses hapus gagal
            echo '<a href="tempat_wisata.php">Kembali</a>';    //membuat Link untuk kembali ke halaman beranda
        }
    }
}
else
{
    //redirect atau dikembalikan ke halaman beranda
    echo '<script>window.history.back()</script>';
}
?>