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
                    Ubah Password
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="user.php">User</a></li>
                    <li class="active">Ubah Password</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Form Ubah Password</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <?php
                                    //proses mengambil data ke database untuk ditampilkan di form edit berdasarkan siswa_id yg didapatkan dari GET id -> edit.php?id=siswa_id

                                    //membuat variabel $id yg nilainya adalah dari URL GET id -> edit.php?id=siswa_id
                                    $id = $_GET['id'];

                                    //melakukan query ke database dg SELECT table siswa dengan kondisi WHERE siswa_id = $id


                                    $show = mysql_query("SELECT password FROM user ORDER BY userName ASC") or die(mysql_error());
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

                                    <form action="ubah_password_proses.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Masukkan Password
                                                            Lama</label>
                                                        <input name="pass_lama" type="password" class="form-control"
                                                               id="exampleInputPassword1" placeholder="Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Masukkan Password
                                                            Baru</label>
                                                        <input name="pass_baru" type="password" class="form-control"
                                                               id="exampleInputPassword1" placeholder="Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Konfirmasi Password
                                                            Baru</label>
                                                        <input name="pass_baru_conf" type="password"
                                                               class="form-control" id="exampleInputPassword1"
                                                               placeholder="Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" name="submit" value="Submit">
                                        </div>
                                        <!-- /.box-body -->


                                    </form>
                                </div>

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

				