<?php
include 'koneksi.php';

$sql = "SELECT tempat_wisata.*, AVG(bintang) AS rating, foto
            FROM tempat_wisata
            LEFT JOIN foto_wisata USING (id_tempat)
            LEFT JOIN review USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY rating DESC";

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
<body class="rencana-body">
    <?php include 'includes/header.php'; ?>

    <div class="map-full" id="rencana-map"></div>
    <div class="rencana-full">
        <div class="rencana-height"></div>
        <hr>
        <div class="reviews-container rencana-container">
            <ul class="nav nav-tabs">
                <li role="presentation" class="<?php if ( ! $tab) echo 'active'; ?>"><a
                        href="#">Daftar Tempat</a></li>
                <li role="presentation" class="<?php if ($tab == 'rencana') echo 'active'; ?>"><a
                        href="#">Rute Rencana</a></li>
            </ul>

            <?php if ($tempat)
            {
                foreach ($tempat as $k)
                { ?>
                    <div class="media review rencana" id="tempat-<?php echo $k['id_tempat']; ?>">
                        <a class="pull-left" href="#">
                            <img class="media-object review-avatar rencana-photo" style="background-image: url('media/<?php echo $k['foto']; ?>');">
                        </a>

                        <div class="pull-right">
                            <a class="btn btn-sm btn-primary rencana-add" data-identifier="tempat-<?php echo $k['id_tempat']; ?>" data-lat="<?php echo $k['latitude']; ?>" data-lng="<?php echo $k['longitude']; ?>"><span class="fa fa-plus"></span></a>
                        </div>


                        <div class="media-body review-body rencana-body">
                            <h4 class="media-heading review-author"><?php echo $k['nama_tempat']; ?>
                            </h4>

                            <div class="review-metas-container rencana-metas-container">
                                <span class="review-meta review-date">
                                    <i class="fa fa-map-marker"></i> <?php echo $k['alamat']; ?>
                                </span>
                                <span class="review-meta review-rating">
                                    <i class="fa fa-star-o"></i> <?php echo round($k['rating'], 1); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php }
            }
            else
            { ?>
                <div class="alert alert-warning">Tidak ditemukan tempat wisata.</div>
            <?php } ?>
        </div>
        <div class="rencana-height"></div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
    <script src="assets/js/gmaps.js"></script>
    <script src="assets/js/rencana.js"></script>
</body>
</html>