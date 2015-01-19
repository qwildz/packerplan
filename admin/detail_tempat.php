<?php
include('koneksi.php');

$id = $_GET['id'];
$tab = $_GET['tab'];

if ( ! $id) redirect('tempat_wisata.php');
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
                    Detail Tempat Wisata
                    <small>Informasi Detail Tempat Wisata</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="tempat_wisata.php"><i class="fa fa-dashboard"></i> Tempat Wisata</a></li>
                    <li class="active">Detail Tempat Wisata</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Detail Tempat Wisata</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <?php
                                //query ke database dg SELECT table tempat wisata diurutkan berdasarkan id paling kecil
                                $query = mysql_query("SELECT id_tempat,nama_tempat,deskripsi,alamat,harga_tiket,jam_buka,jam_tutup,latitude,longitude,created,modified FROM tempat_wisata WHERE id_tempat=$id ORDER BY id_tempat ASC") or die(mysql_error());
                                $data = mysql_fetch_assoc($query);
                                ?>
                                <table class="table">
                                    <tr>
                                        <td class="text-right" width="120px"><strong>Nama Tempat</strong></td>
                                        <td><?php echo $data['nama_tempat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Deskripsi</strong></td>
                                        <td><?php echo $data['deskripsi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Alamat</strong></td>
                                        <td><?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Harga Tiket</strong></td>
                                        <td><?php echo $data['harga_tiket']; ?></td>
                                    <tr>
                                        <td class="text-right"><strong>Jam Buka</strong></td>
                                        <td><?php echo $data['jam_buka']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Jam Tutup</strong></td>
                                        <td><?php echo $data['jam_tutup']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-8">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                                <li <?php if ($tab == 'rencana') { ?>class="active"<?php } ?>><a
                                        href="?id=<?php echo $id; ?>&tab=rencana">Rencana</a></li>
                                <li <?php if ($tab == 'review') { ?>class="active"<?php } ?>><a
                                        href="?id=<?php echo $id; ?>&tab=review">Review</a></li>
                                <li <?php if ( ! $tab) { ?>class="active"<?php } ?>><a href="?id=<?php echo $id; ?>">Foto</a>
                                </li>
                                <li class="pull-left header">
                                    <?php
                                    switch ($tab)
                                    {
                                        case 'review' :
                                            echo '<i class="fa fa-comments"></i> Review';
                                            break;
                                        case 'rencana' :
                                            echo '<i class="fa fa-calendar-o"></i> Rencana';
                                            break;
                                        default :
                                            echo '<i class="fa fa-picture-o"></i> Foto';
                                            break;
                                    }
                                    ?>
                                </li>
                            </ul>
                            <div class="tab-content no-padding">
                                <div class="tab-pane active" id="tab_1">
                                    <?php
                                    switch ($tab)
                                    {
                                        case 'review' :
                                            include_once 'tab_contents/detail_tempat_review.php';
                                            break;
                                        case 'rencana' :
                                            include_once 'tab_contents/detail_tempat_rencana.php';
                                            break;
                                        default :
                                            include_once 'tab_contents/detail_tempat_foto.php';
                                            break;
                                    }
                                    ?>
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