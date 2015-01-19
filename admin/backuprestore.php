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
                    Backup & Restore
                    <small>Tool Backup dan Restore Database</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Backup & Restore</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <?php if (isset($_GET['sukses']))
                    { ?>
                        <div class="col-xs-12">
                            <div class="alert alert-success">Berhasil merestore database</div>
                        </div>
                    <?php } ?>
                    <div class="col-xs-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Backup</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form action="process_backup.php" method="post">
                                            <input type="submit" name="download" value="Download"
                                                   class="btn btn-primary col-md-2">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Restore</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <form action="process_restore.php" method="post" enctype="multipart/form-data">
                                        <input class="col-md-4" type="file" name="data" style="padding-top: 6px">
                                        <input type="submit" name="upload" value="Upload"
                                               class="btn btn-primary col-md-2">
                                    </form>
                                </div>
                            </div>
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
</body>
</html>