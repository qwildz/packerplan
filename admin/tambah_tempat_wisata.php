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
                    Tambah Data Tempat Wisata
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
                                <h3 class="box-title">Form Tambah Tempat Wisata</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form action="tambah_tempat_proses.php" method="post" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="tempatid">Nama Tempat</label>
                                        <input name="nama_tempat_wisata" class="form-control" id="tempatid"
                                               placeholder="Masukkan nama tempat" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="3"
                                                  placeholder="Masukkan alamat" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Tempat</label>
                                        <textarea name="deskripsi" class="form-control" rows="3"
                                                  placeholder="Masukkan deskripsi singkat tempat" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="laid">Latitude</label>
                                        <input name="lt" class="form-control" id="lgid"
                                               placeholder="Masukkan koordinat latitude" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lgid">Longitude</label>
                                        <input name="lg" class="form-control" id="latid"
                                               placeholder="Masukkan koordinat longitude" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="hargatiketid">Harga Tiket</label>
                                        <input name="harga_tiket" class="form-control" id="hargatiketid"
                                               placeholder="Masukkan harga tiket" required>
                                    </div>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Jam Buka</label>
                                            <input type="text" class="form-control timepicker" name="jam_buka">
                                        </div>
                                    </div>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Jam Tutup</label>
                                            <input type="text" class="form-control timepicker" name="jam_tutup">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
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

				