<?php
include('koneksi.php');

//cek dahulu, jika tombol tambah di klik
if (isset($_POST['tambah']))
{
    //jika tombol tambah benar di klik maka lanjut prosesnya
    $namaTempat = $_POST['nama_tempat_wisata'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $hrgTiket = $_POST['harga_tiket'];
    $jBuka = $_POST['jam_buka'];
    $jtutup = $_POST['jam_tutup'];
    $lg = $_POST['lg'];
    $lt = $_POST['lt'];

    // if (($jBuka<$jtutup) or ($jBuka=$jtutup))
    // {
    // echo 'Gagal menambahkan data, Jam buka harus lebih kecil dari jam tutup! ';		//Pesan jika proses tambah gagal
    // echo '<a href="tambah.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
    // }
    // else
    // {
    //melakukan query dengan perintah INSERT INTO untuk memasukkan data ke database
    $input = mysql_query("INSERT INTO tempat_wisata VALUES(NULL, '$namaTempat', '$alamat', '$deskripsi', '$hrgTiket', '$jBuka', '$jtutup', '$lt', '$lg', NOW(), NOW()) ") or die(mysql_error());
    //jika query input sukses
    if ($input)
    {
        $id = mysql_insert_id();
        //echo 'Data berhasil di tambahkan! ';        //Pesan jika proses tambah sukses
        //echo '<a href="tempat_wisata.php">Kembali</a>';    //membuat Link untuk kembali ke halaman tambah
        redirect('detail_tempat.php?id=' . $id);
    }
    else
    {
        echo 'Gagal menambahkan data! ';        //Pesan jika proses tambah gagal
        echo '<a href="tambah.php">Kembali</a>';    //membuat Link untuk kembali ke halaman tambah
    }


}
else
{    //jika tidak terdeteksi tombol tambah di klik

    //redirect atau dikembalikan ke halaman tambah
    echo '<script>window.history.back()</script>';

}
?>