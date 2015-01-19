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
                    Edit Data User
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="user.php">User</a></li>
                    <li class="active">Edit User</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Form Edit User</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <?php
                            //proses mengambil data ke database untuk ditampilkan di form edit berdasarkan siswa_id yg didapatkan dari GET id -> edit.php?id=siswa_id

                            //membuat variabel $id yg nilainya adalah dari URL GET id -> edit.php?id=siswa_id
                            $id = $_GET['id'];

                            //melakukan query ke database dg SELECT table siswa dengan kondisi WHERE siswa_id = $id


                            $show = mysql_query("SELECT *FROM user ORDER BY userName ASC") or die(mysql_error());
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

                            <form action="edit_user_proses.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control"
                                                       value=<?php echo $data['username']; ?> disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_id">Nama</label>
                                                <input name="nama" class="form-control" id="nama_id"
                                                       value=<?php echo $data['nama']; ?> required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_lahir_id">Tanggal Lahir</label>
                                                <input name="tanggal_lahir" class="form-control" id="tanggal_lahir_id"
                                                       value=<?php echo $data['tgl_lahir']; ?> required
                                                       data-inputmask="'alias': 'yyyy-mm-dd'" data-mask>
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea name="alamat" class="form-control"
                                                          rows="3"><?php echo $data['alamat']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control" required>
                                                    <option value="L"
                                                            <?php if ($data['jenis_kelamin'] == 'L') { ?>selected<?php } ?>>
                                                        Laki-laki
                                                    </option>
                                                    <option value="P"
                                                            <?php if ($data['jenis_kelamin'] == 'P') { ?>selected<?php } ?>>
                                                        Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="email_id">E-mail</label>
                                                <input name="email" class="form-control" id="email_id"
                                                       value="<?php echo $data['email']; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" name="edit" value="Ubah">
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
    <script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $("[data-mask]").inputmask();
        });
    </script>
</html>

				