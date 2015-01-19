<?php
include('koneksi.php');

if (isset($_POST['upload']))
{
    $id = $_POST['id'];

    $nama_file = $id . '-' . preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9.]+/', '-', $_FILES['foto']['name'])));

    move_uploaded_file($_FILES['foto']['tmp_name'], '../media/' . $nama_file);

    $input = mysql_query("INSERT INTO foto_wisata VALUES(NULL, $id, '$nama_file') ");
    if ($input)
    {
        //echo 'Foto berhasil diupload! ';		//Pesan jika proses tambah sukses
        //echo '<a href="detail_tempat.php='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
        redirect('detail_tempat.php?id=' . $id . '&sukses=1');
    }
    else
    {
        //echo 'Foto gagal diupload! ';		//Pesan jika proses tambah sukses
        //echo '<a href="detail_tempat.php?id='.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
        redirect('detail_tempat.php?id=' . $id . '&sukses=0');
    }
}
else
{    //jika tidak terdeteksi tombol tambah di klik

    //redirect atau dikembalikan ke halaman tambah
    //echo '<script>window.history.back()</script>';
    redirect('tempat_wisata.php');

}