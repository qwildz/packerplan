<table class="table table-hover">
    <tr>
        <th>No.</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Nama Tempat Wisata</th>
        <th>Bintang</th>
        <th>Review</th>
        <th>Opsi</th>
    </tr>

    <?php
    //query ke database dg SELECT table tempat wisata diurutkan berdasarkan id paling kecil
    $query = mysql_query("SELECT a.username,a.nama,b.nama_tempat,c.bintang,c.teks,c.id_review FROM user a,tempat_wisata b,review c WHERE (a.username=c.username) AND (b.id_tempat=c.id_tempat) AND c.id_tempat = {$id}") or die(mysql_error());

    //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
    if (mysql_num_rows($query) == 0)
    {
        //ini artinya jika data hasil query di atas kosong
        echo '<tr><td colspan="6">Tidak ada data!</td></tr>';
    }
    else
    {
        $no = 1;
        while ($data = mysql_fetch_assoc($query))
        {
            //perulangan while dg membuat variabel $data yang akan mengambil data di database
            //menampilkan row dengan data di database
            echo '<tr>';
            echo '<td>' . $no . '</td>';    //menampilkan nomor urut
            echo '<td>' . $data['username'] . '</td>';    //menampilkan data nis dari database
            echo '<td>' . $data['nama'] . '</td>';    //menampilkan data nama lengkap dari database
            echo '<td>' . $data['nama_tempat'] . '</td>';    //menampilkan data kelas dari database
            echo '<td>' . $data['bintang'] . '</td>';    //menampilkan data jurusan dari database
            echo '<td>' . $data['teks'] . '</td>';    //menampilkan data jurusan dari database
            echo '<td><a href="hapus_review.php?id=' . $data['id_review'] . '" onclick="return confirm(\'Yakin?\')"><button class="btn btn-danger">Hapus</button></a></td>';
            echo '</tr>';

            $no++;    //menambah jumlah nomor urut setiap row
        }
    }
    ?>
</table>