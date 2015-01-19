<div class="padding">
    <div class="row">
        <form action="upload_foto.php" method="post" enctype="multipart/form-data">
            <strong class="col-md-2" style="padding-top: 6px">Tambah Foto:</strong>
            <input class="col-md-4" type="file" name="foto" style="padding-top: 6px">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="upload" value="Upload" class="btn btn-primary col-md-2">
        </form>
    </div>
</div>
<table class="table table-hover">
    <tr>
        <th width="15px">No.</th>
        <th>Foto</th>
        <th width="100px">Opsi</th>
    </tr>
    <?php
    //query ke database dg SELECT table tempat wisata diurutkan berdasarkan id paling kecil
    $query = mysql_query("SELECT * FROM foto_wisata WHERE id_tempat=$id ORDER BY id_foto DESC") or die(mysql_error());

    //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
    if (mysql_num_rows($query) == 0)
    {    //ini artinya jika data hasil query di atas kosong

        //jika data kosong, maka akan menampilkan row kosong
        echo '<tr><td colspan="3">Tidak ada data!</td></tr>';

    }
    else
    {    //else ini artinya jika data hasil query ada (data diu database tidak kosong)

        //jika data tidak kosong, maka akan melakukan perulangan while
        $no = 1;    //membuat variabel $no untuk membuat nomor urut
        while ($data = mysql_fetch_assoc($query))
        {
            //perulangan while dg membuat variabel $data yang akan mengambil data di database
            //menampilkan row dengan data di database
            echo '<tr>';
            echo '<td>' . $no . '</td>';    //menampilkan nomor urut
            echo '<td><img src="' . $url . 'media/' . $data['foto'] . '" height="70" ></td>';    //menampilkan data nis dari database
            echo '<td><a href="delete_foto.php?id=' . $data['id_foto'] . '&id_tempat=' . $id . '"><button class="btn btn-danger">Delete Foto</button></a></td>';
            echo '</tr>';

            $no++;    //menambah jumlah nomor urut setiap row
        }
    }
    ?>
</table>