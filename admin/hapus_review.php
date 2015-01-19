<?php
include('koneksi.php');

//cek dahulu, apakah benar URL sudah ada GET id -> hapus.php?id=siswa_id
if (isset($_GET['id']))
{
    //membuat variabel $id yg bernilai dari URL GET id -> hapus.php?id=siswa_id
    $id = $_GET['id'];

    //cek ke database apakah ada data siswa dengan siswa_id=$id
    $cek = mysql_query("SELECT *FROM review WHERE id_review=$id") or die(mysql_error());

    //jika data siswa tidak ada
    if (mysql_num_rows($cek) == 0)
    {
        //jika data tidak ada, maka redirect atau dikembalikan ke halaman beranda
        echo '<script>window.history.back()</script>';
    }
    else
    {
        $del = mysql_query("DELETE FROM review WHERE id_review=$id");

        if ($del)
        {
            redirect('detail_tempat.php?id=' . $id . '&tab=review&hapus=1');
        }
        else
        {
            redirect('detail_tempat.php?id=' . $id . '&tab=review&hapus=0');
        }
    }
}
else
{
    //redirect atau dikembalikan ke halaman beranda
    redirect('tempat_wisata.php');
}
?>