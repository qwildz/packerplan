<?php
include 'koneksi.php';

$id_tempat = $_GET['id_tempat'];
$sql = "SELECT * FROM tempat_wisata WHERE id_tempat = {$id_tempat}";
$query = mysqli_query($koneksi, $sql);

$tempat = mysqli_fetch_assoc($query);

$sql = "SELECT COUNT(*)+1 AS jumlah_pengunjung
        FROM partisipan
        JOIN rencana USING (id_rencana)
        JOIN rute_rencana USING (id_rencana)
        WHERE id_tempat = {$id_tempat}";
$query = mysqli_query($koneksi, $sql);

$jumlah_pengunjung = mysqli_fetch_row($query)[0];

$sql = "SELECT review.*, user.nama, user.email FROM review JOIN user USING (username) where id_tempat = {$id_tempat} ORDER BY created DESC";
$query = mysqli_query($koneksi, $sql);

$review = $query;

$jumlah_review = mysqli_num_rows($review);

$rating = 0;
$komentar = array();
while ($row = mysqli_fetch_assoc($review))
{
    $rating += $row['bintang'];
    $komentar[] = $row;
}
$rating /= $jumlah_review;

$sql = "SELECT rencana.*, GROUP_CONCAT(id_tempat) ids_tempat, COUNT(id_tempat) AS tempat, pengikut,
            GROUP_CONCAT(latitude) AS latitude, GROUP_CONCAT(longitude) AS longitude
        FROM rute_rencana
        JOIN rencana USING (id_rencana)
        JOIN tempat_wisata USING (id_tempat)
        JOIN (
            SELECT p.id_rencana, COUNT(p.id_partisipan) AS pengikut
            FROM partisipan p
            GROUP BY p.id_rencana
        ) pen ON (pen.id_rencana = rute_rencana.id_rencana)
        GROUP BY rute_rencana.id_rencana
        HAVING ids_tempat LIKE '%{$id_tempat}%'
        ORDER BY pengikut DESC
        LIMIT 2";
$rencana = mysqli_query($koneksi, $sql);

$sql = "SELECT IF(m.id_tempat,1,0) AS has_match, t.*, foto,
            ( 6371 *
                ACOS(
                    COS(RADIANS({$tempat['latitude']})) *
                    COS(RADIANS(t.latitude)) *
                    COS(RADIANS(t.longitude) - RADIANS({$tempat['longitude']})) + SIN(RADIANS({$tempat['latitude']})) *
                    SIN(RADIANS(t.latitude))
                )
            ) AS distance
        FROM tempat_wisata t
        LEFT JOIN foto_wisata USING (id_tempat)
        LEFT JOIN (
            SELECT tempat_wisata.*, COUNT(id_tempat) AS hit,
                ( 6371 *
                    ACOS(
                        COS(RADIANS({$tempat['latitude']})) *
                        COS(RADIANS(latitude)) *
                        COS(RADIANS(longitude) - RADIANS({$tempat['longitude']})) + SIN(RADIANS({$tempat['latitude']})) *
                        SIN(RADIANS(latitude))
                    )
                ) AS distance
            FROM rute_rencana a
            JOIN tempat_wisata USING (id_tempat)
            WHERE a.urutan >
                (SELECT b.urutan FROM rute_rencana b WHERE b.id_tempat = {$id_tempat} AND b.id_rencana = a.id_rencana)
            GROUP BY id_tempat
            ORDER BY hit DESC, distance ASC
        ) m ON m.id_tempat = t.id_tempat
        WHERE t.id_tempat <> {$id_tempat}
        GROUP BY t.id_tempat
        ORDER BY has_match DESC, hit DESC, distance ASC
        LIMIT 4";
$rekomendasi = mysqli_query($koneksi, $sql);

$sql = "SELECT * FROM foto_wisata WHERE id_tempat={$id_tempat}";
$foto = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $tempat['nama_tempat']; ?> - PackerPlan</title>

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
    <div class="jumbotron">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!--<ol class="carousel-indicators">-->
            <!--    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>-->
            <!--    <li data-target="#carousel-example-generic" data-slide-to="1"></li>-->
            <!--    <li data-target="#carousel-example-generic" data-slide-to="2"></li>-->
            <!--</ol>-->
            <div class="carousel-inner" role="listbox">
                <?php
                $active = "active";
                while ($row = mysqli_fetch_assoc($foto))
                {
                    ?>
                    <div class="item <?php echo $active; ?>">
                        <div class="jumbotron-carrousel"
                             style="background-image:url('media/<?php echo $row['foto']; ?>');"></div>
                    </div>
                    <?php
                    $active = "";
                }
                ?>
            </div>
        </div>

        <div class="jumbotron-bottom">
            <div class="container">
                <div class="place-metas-container place-metas-jumbotron pull-left">
                    <h1 class="place-meta place-name"><?php echo $tempat['nama_tempat']; ?></h1>

                    <div class="place-meta place-address"><i class="fa fa-map-marker"></i>
                        <span><?php echo $tempat['alamat']; ?></span></div>
                </div>
                <div class="place-stats-container pull-right bitter">
                    <div class="place-stat stat-people pull-left">
                        <i class="fa fa-male"></i> <span><?php echo $jumlah_pengunjung; ?></span>
                    </div>
                    <div class="place-stat stat-comments pull-left">
                        <i class="fa fa-comments"></i> <span><?php echo $jumlah_review; ?></span>
                    </div>
                    <div class="place-stat stat-ratings pull-left">
                        <i class="fa fa-star"></i> <span><?php echo round($rating, 1); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-7">
                <div class="row place-metas-container place-metas-body">
                    <div class="col-xs-6 place-meta place-time">
                        <i class="fa fa-clock-o"></i>
                        <span><?php echo date('H:i', strtotime($tempat['jam_buka'])) . ' - ' . date('H:i', strtotime($tempat['jam_tutup'])); ?></span>
                    </div>
                    <div class="col-xs-6 place-meta place-ticket-price">
                        <i class="fa fa-ticket"></i>
                        <?php if ($tempat['harga_tiket'] > 0)
                        { ?>
                            <span>Rp <?php echo number_format($tempat['harga_tiket'], 2, ',', '.'); ?></span>
                        <?php }
                        else
                        { ?>
                            <span>Gratis</span>
                        <?php } ?>
                    </div>
                </div>

                <h2 class="title-line"><span>Ulasan Cawers</span></h2>
                <?php if (is_login())
                { ?>
                    <div class="media review-form">
                        <span class="pull-left">
                            <img class="media-object review-avatar" src="<?php echo get_gravatar($_SESSION['email']); ?>">
                        </span>

                        <div class="media-body review-body">
                            <form method="post" action="process/submit-review.php">
                                <div class="form-group">
                                <textarea class="form-control" rows="3" id="textArea" name="teks"
                                          placeholder="Tulis ulasan kamu di sini..."></textarea>
                                    <input type="hidden" name="id_tempat" value="<?php echo $_GET['id_tempat']; ?>">
                                </div>
                                <div class="form-group">
                                    <div class="pull-left rating">
                                        <span class="fa fa-star"></span>
                                        <select name="bintang">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <div class="reviews-container">
                    <?php if ($komentar)
                    {
                        foreach ($komentar as $k)
                        { ?>
                            <div class="media review">
                                <a class="pull-left" href="#">
                                    <img class="media-object review-avatar" src="<?php echo get_gravatar($k['email']); ?>">
                                </a>

                                <div class="media-body review-body">
                                    <h4 class="media-heading review-author"><?php echo $k['nama']; ?></h4>

                                    <div class="review-metas-container">
                                <span class="review-meta review-date">
                                    <i class="fa fa-calendar-o"></i> <?php echo date('d F y', strtotime($k['created'])); ?>
                                </span>
                                <span class="review-meta review-time">
                                    <i class="fa fa-clock-o"></i> <?php echo date('H:i', strtotime($k['created'])); ?>
                                </span>
                                <span class="review-meta review-rating">
                                    <i class="fa fa-star-o"></i> <?php echo $k['bintang']; ?>
                                </span>
                                    </div>
                                    <div class="review-paragraph">
                                        <p><?php echo nl2br($k['teks']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    else
                    { ?>
                        <div class="alert alert-warning">Belum ada ulasan.</div>
                    <?php } ?>
                </div>

                <h2 class="title-line icon"><span>Sugesti Wisata</span></h2>

                <div class="row">
                    <?php
                    foreach ($rekomendasi as $t)
                    { ?>
                        <div class="col-xs-6 place-small-container">
                            <a href="tempat.php?id_tempat=<?php echo $t['id_tempat']; ?>">
                                <div class="place-small">
                                    <div class="photo"
                                         style="background-image:url('media/<?php echo $t['foto']; ?>');"></div>
                                    <div class="place-details-container">
                                        <div class="place-detail">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="media-heading">
                                                        <?php echo $t['nama_tempat']; ?>
                                                    </h5>
                                                        <span><?php echo number_format($t['distance'], 2, ',', '.'); ?>
                                                            km dari sini</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="col-xs-4 col col-xs-offset-1">
                <div id="place-main-map" class="maps" data-latitude="<?php echo $tempat['latitude']; ?>"
                     data-longitude="<?php echo $tempat['longitude']; ?>"></div>
                <a class="btn btn-primary btn-block btn-lg"> Buat Rencana </a>

                <h2 class="title-line"><span> Rencana Cawers </span></h2>

                <div class="plans-small-container">
                    <?php while ($row = mysqli_fetch_assoc($rencana))
                    { ?>
                        <div class="plan-small">
                            <?php
                            $lat = explode(',', $row['latitude']);
                            $lng = explode(',', $row['longitude']);
                            $loc = array();
                            foreach ($lat as $k => $v)
                            {
                                $loc[] = array("lat" => $v, "lng" => $lng[ $k ]);
                            }
                            ?>
                            <div id="plan-map-<?php echo $row['id_rencana']; ?>" class="maps-static locations"
                                 data-locations='<?php echo json_encode($loc); ?>'></div>
                            <div class="plan-details-container">
                                <div class="plan-detail pull-left">
                                    <div class="media">
                                        <a class="pull-left" href="#">
                                            <img class="media-object plan-avatar" src="<?php echo get_gravatar($_SESSION['email']); ?>">
                                        </a>

                                        <div class="media-body">
                                            <h5 class="media-heading"><?php echo $row['nama_rencana']; ?></h5>
                                            <span><?php echo $row['tempat']; ?> tempat | <?php echo $row['pengikut']; ?>
                                                pengikut</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="plan-date pull-right">
                                    <span><?php echo date('j M Y', strtotime($row['waktu'])); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
    <script src="assets/js/gmaps.js"></script>
    <script src="assets/js/tempat.js"></script>
</body>
</html>