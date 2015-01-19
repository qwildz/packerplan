<?php
include('koneksi.php');

if (isset($_GET['id']) && isset($_GET['id_tempat']))
{
    $id = $_GET['id'];
    $id_tempat = $_GET['id_tempat'];

    $nama_file = mysql_query("SELECT * FROM foto_wisata WHERE id_foto=$id");
    $nama_file = mysql_fetch_row($nama_file);
    $nama_file = $nama_file[2];

    $del = mysql_query("DELETE FROM foto_wisata WHERE id_foto=$id");
    if ($del)
    {
        unlink('../media/' . $nama_file);
        //echo 'Foto berhasil diupload! ';		//Pesan jika proses tambah sukses
        //echo '<a href="detail_tempat.php='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
        redirect('detail_tempat.php?id=' . $id_tempat . '&delete=1');
    }
    else
    {
        //echo 'Foto gagal diupload! ';		//Pesan jika proses tambah sukses
        //echo '<a href="detail_tempat.php?id='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
        redirect('detail_tempat.php?id=' . $id_tempat . '&delete=0');
    }
}
else
{    //jika tidak terdeteksi tombol tambah di klik

    //redirect atau dikembalikan ke halaman tambah
    //echo '<script>window.history.back()</script>';
    //redirect('tempat_wisata.php');
}