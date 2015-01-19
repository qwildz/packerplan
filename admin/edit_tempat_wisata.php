<?php
include('koneksi.php');
?>
<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
<link href="css/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
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
                    Edit Data Tempat Wisata
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
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Form Edit Tempat Wisata</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <?php
                            //proses mengambil data ke database untuk ditampilkan di form edit berdasarkan siswa_id yg didapatkan dari GET id -> edit.php?id=siswa_id

                            //membuat variabel $id yg nilainya adalah dari URL GET id -> edit.php?id=siswa_id
                            $id = $_GET['id'];

                            //melakukan query ke database dg SELECT table siswa dengan kondisi WHERE siswa_id = $id
                            $show = mysql_query("SELECT id_tempat,nama_tempat,alamat,harga_tiket,jam_buka,jam_tutup,latitude,longitude, deskripsi FROM tempat_wisata Where id_tempat=$id");

                            //cek apakah data dari hasil query ada atau tidak
                            if (mysql_num_rows($show) == 0)
                            {

                                //jika tidak ada data yg sesuai maka akan langsung di arahkan ke halaman depan atau beranda -> index.php
                                echo '<script>window.history.back()</script>';

                            }
                            else
                            {

                                //jika data ditemukan, maka membuat variabel $data
                                $data = mysql_fetch_assoc($show);    //mengambil data ke database yang nantinya akan ditampilkan di form edit di bawah

                            }
                            ?>

                            <form action="edit_tempat_proses.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="tempatid">Nama Tempat</label>
                                        <input name="nama_tempat_wisata" class="form-control" id="tempatid"
                                               value="<?php echo $data['nama_tempat']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control"
                                                  rows="3"><?php echo $data['alamat']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Tempat</label>
                                        <textarea name="deskripsi" class="form-control"
                                                  rows="3"><?php echo $data['deskripsi']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="laid">Latitude</label>
                                        <input name="lt" class="form-control" id="lgid"
                                               value="<?php echo $data['latitude']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lgid">Longitude</label>
                                        <input name="lg" class="form-control" id="latid"
                                               value="<?php echo $data['longitude']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="hargatiketid">Harga Tiket</label>
                                        <input name="harga_tiket" class="form-control" id="hargatiketid"
                                               value="<?php echo $data['harga_tiket']; ?>">
                                    </div>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Jam Buka</label>
                                            <input type="text" class="form-control timepicker" name="jam_buka"
                                                   value="<?php echo $data['jam_buka']; ?>">
                                        </div>
                                    </div>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Jam Tutup</label>
                                            <input type="text" class="form-control timepicker" name="jam_tutup"
                                                   value="<?php echo $data['jam_tutup']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" name="edit" value="Submit">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </aside>
        <!-- /.right-side -->
    </div>
    <!-- ./wrapper -->

    <?php include 'includes/footer.php'; ?>
    <script src="js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $(".timepicker").timepicker({
                showInputs: false,
                showMeridian: false
            });
        });
    </script>
</body>
</html>

				