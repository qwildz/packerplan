<?php
include('koneksi.php');
?>
<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <?php include 'includes/header.php'; ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include 'includes/menu.php'; ?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Tempat Wisata
                    <small>Hasil Pencarian</small>

                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Tempat Wisata</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <div class="box-tools">
                                    <div class="input-group">
                                        <a href="tambah_tempat_wisata.php" class="btn btn-primary" align=left><font
                                                color="white">Tambah Data</a></font>
                                        <form name="fcari_tempat" action="hcari_tempat.php" method="post"
                                              class="sidebar-form">
                                            <div class="input-group">
                                                <input type="text" name="cari" class="form-control input-sm pull-right"
                                                       placeholder="Masukkan nama tempat">
													<span class="input-group-btn">
														<button type="submit" name="submit" id="search-btn"
                                                                class="btn btn-flat"><i class="fa fa-search"></i>
                                                        </button>
													</span>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Tempat</th>
                                        <th>Deskripsi</th>
                                        <th>Alamat</th>
                                        <th>Harga Tiket</th>
                                        <th>Jam Buka</th>
                                        <th>Jam Tutup</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Opsi</th>
                                    </tr>
                                    <?php
                                    $cari = trim($_POST['cari']);
                                    //query ke database dg SELECT table tempat wisata diurutkan berdasarkan id paling kecil
                                    $query = mysql_query("SELECT id_tempat,nama_tempat,deskripsi,alamat,harga_tiket,jam_buka,jam_tutup,latitude,longitude,created,modified FROM tempat_wisata WHERE nama_tempat LIKE '%$cari%' ORDER BY id_tempat ASC") or die(mysql_error());

                                    //cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
                                    if (mysql_num_rows($query) == 0)
                                    {    //ini artinya jika data hasil query di atas kosong

                                        //jika data kosong, maka akan menampilkan row kosong
                                        echo '<tr><td colspan="6">Tidak ada data!</td></tr>';


                                    }
                                    else
                                    {    //else ini artinya jika data hasil query ada (data diu database tidak kosong)

                                        //jika data tidak kosong, maka akan melakukan perulangan while
                                        $no = 1;    //membuat variabel $no untuk membuat nomor urut
                                        while ($data = mysql_fetch_assoc($query))
                                        {    //perulangan while dg membuat variabel $data yang akan mengambil data di database

                                            //menampilkan row dengan data di database
                                            echo '<tr>';
                                            echo '<td>' . $no . '</td>';    //menampilkan nomor urut
                                            echo '<td>' . $data['nama_tempat'] . '</td>';    //menampilkan data nis dari database
                                            echo '<td>' . $data['deskripsi'] . '</td>';    //menampilkan data nis dari database
                                            echo '<td>' . $data['alamat'] . '</td>';    //menampilkan data nama lengkap dari database
                                            echo '<td>' . $data['harga_tiket'] . '</td>';    //menampilkan data kelas dari database
                                            echo '<td>' . $data['jam_buka'] . '</td>';    //menampilkan data jurusan dari database
                                            echo '<td>' . $data['jam_tutup'] . '</td>';    //menampilkan data jurusan dari database
                                            echo '<td>' . $data['latitude'] . '</td>';    //menampilkan data jurusan dari database
                                            echo '<td>' . $data['longitude'] . '</td>';    //menampilkan data jurusan dari database

                                            echo '<td><a href="edit_tempat_wisata.php?id=' . $data['id_tempat'] . '"><button class="btn btn-info">Edit</button></a><a href="hapus_tempat_wisata.php?id=' . $data['id_tempat'] . '" onclick="return confirm(\'Yakin?\')"><button class="btn btn-danger">Hapus</button></a></td>';
                                            echo '</tr>';

                                            $no++;    //menambah jumlah nomor urut setiap row
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </aside>
        <!-- /.right-side -->
    </div>
    <!-- ./wrapper -->

    <?php include 'includes/footer.php'; ?>
</body>
</html>