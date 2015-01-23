<?php
include 'koneksi.php';

$sql = "SELECT tempat_wisata.*, AVG(bintang) AS rating, foto
            FROM tempat_wisata
            LEFT JOIN review USING (id_tempat)
            LEFT JOIN foto_wisata USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY rating DESC
            LIMIT 3";
$query = mysqli_query($koneksi, $sql);
$terbintang = array();
while ($row = mysqli_fetch_assoc($query))
{
    $terbintang[] = $row;
}

$sql = "SELECT tempat_wisata.*, COUNT(bintang) AS jumlah_komentar, AVG(bintang) AS rating, foto
            FROM tempat_wisata
            LEFT JOIN review USING (id_tempat)
            LEFT JOIN foto_wisata USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY jumlah_komentar DESC
            LIMIT 3";
$query = mysqli_query($koneksi, $sql);
$tergosip = array();
while ($row = mysqli_fetch_assoc($query))
{
    $tergosip[] = $row;
}

$sql = "SELECT tempat_wisata.*, COUNT(id_partisipan)+1 AS jumlah_pengunjung, foto,
                (SELECT AVG(bintang)
                FROM review
                WHERE review.id_tempat = tempat_wisata.id_tempat) AS rating
            FROM tempat_wisata
            LEFT JOIN rute_rencana USING (id_tempat)
            LEFT JOIN partisipan USING (id_rencana)
            LEFT JOIN foto_wisata USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY jumlah_pengunjung DESC
            LIMIT 3";
$query = mysqli_query($koneksi, $sql);
$terheboh = array();
while ($row = mysqli_fetch_assoc($query))
{
    $terheboh[] = $row;
}

$sql = "SELECT tempat_wisata.*, foto FROM tempat_wisata LEFT JOIN foto_wisata USING (id_tempat) GROUP BY tempat_wisata.id_tempat ORDER BY created DESC LIMIT 6";
$query = mysqli_query($koneksi, $sql);
$tempat = array();
while ($row = mysqli_fetch_assoc($query))
{
    $tempat[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PackerPlan</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-nonresponsive.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="blank-jumbotron"></div>

    <div class="container">
        <div class="row">
            <h2 class="title-line icon"><span class="fa fa-picture-o"></span><span>Tempat Wisata</span><span
                    class="fa fa-picture-o"></span></h2>
            <?php foreach ($tempat as $t)
            { ?>
                <div class="col-xs-4 place-small-container">
                    <a href="tempat.php?id_tempat=<?php echo $t['id_tempat']; ?>">
                        <div class="place-small">
                            <div class="photo" style="background-image:url('media/<?php echo $t['foto']; ?>');"></div>
                            <div class="place-details-container">
                                <div class="place-detail pull-left">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?php echo $t['nama_tempat']; ?></h5>
                                            <span><?php echo $t['alamat']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="place-rating pull-right">
                                    <span><span class="fa fa-star"></span> <?php echo round($t['rating'], 1); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <h2 class="title-line icon"><span class="fa fa-star"></span><span>Tempat Paling Bintang</span><span
                    class="fa fa-star"></span></h2>
            <?php foreach ($terbintang as $t)
            { ?>
                <div class="col-xs-4 place-small-container">
                    <a href="tempat.php?id_tempat=<?php echo $t['id_tempat']; ?>">
                        <div class="place-small">
                            <div class="photo" style="background-image:url('media/<?php echo $t['foto']; ?>');"></div>
                            <div class="place-details-container">
                                <div class="place-detail pull-left">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?php echo $t['nama_tempat']; ?></h5>
                                            <span><?php echo $t['alamat']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="place-rating pull-right">
                                    <span><span class="fa fa-star"></span> <?php echo round($t['rating'], 1); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <h2 class="title-line icon"><span class="fa fa-comments"></span><span>Tempat Tergosip</span><span
                    class="fa fa-comments"></span></h2>
            <?php foreach ($tergosip as $t)
            { ?>
                <div class="col-xs-4 place-small-container">
                    <a href="tempat.php?id_tempat=<?php echo $t['id_tempat']; ?>">
                        <div class="place-small">
                            <div class="photo" style="background-image:url('media/<?php echo $t['foto']; ?>');"></div>
                            <div class="place-details-container">
                                <div class="place-detail pull-left">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?php echo $t['nama_tempat']; ?></h5>
                                            <span><?php echo $t['alamat']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="place-rating pull-right">
                                    <span><span class="fa fa-star"></span> <?php echo round($t['rating'], 1); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <h2 class="title-line icon"><span class="fa fa-group"></span><span>Tempat Paling Heboh</span><span
                    class="fa fa-group"></span></h2>
            <?php foreach ($terheboh as $t)
            { ?>
                <div class="col-xs-4 place-small-container">
                    <a href="tempat.php?id_tempat=<?php echo $t['id_tempat']; ?>">
                        <div class="place-small">
                            <div class="photo" style="background-image:url('media/<?php echo $t['foto']; ?>');"></div>
                            <div class="place-details-container">
                                <div class="place-detail pull-left">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?php echo $t['nama_tempat']; ?></h5>
                                            <span><?php echo $t['alamat']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="place-rating pull-right">
                                    <span><span class="fa fa-star"></span> <?php echo round($t['rating'], 1); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>