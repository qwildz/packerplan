<?php
include 'koneksi.php';

if ( ! is_login())
{
    redirect('login.php');
}

$id_rencana = $_GET['id'];

if ( ! $id_rencana) redirect('index.php');

$sql = "SELECT rencana.*, user.*, GROUP_CONCAT(id_tempat) ids_tempat, COUNT(id_tempat) AS tempat, pengikut,
            GROUP_CONCAT(latitude) AS latitude, GROUP_CONCAT(longitude) AS longitude
        FROM rute_rencana
        JOIN rencana USING (id_rencana)
        JOIN user USING (username)
        JOIN tempat_wisata USING (id_tempat)
        LEFT JOIN (
            SELECT p.id_rencana, COUNT(p.id_partisipan) AS pengikut
            FROM partisipan p
            GROUP BY p.id_rencana
        ) pen ON (pen.id_rencana = rute_rencana.id_rencana)
        WHERE rencana.id_rencana = {$id_rencana}
        LIMIT 1";

$query = mysqli_query($koneksi, $sql);
$rencana = mysqli_fetch_assoc($query);

$sql = "SELECT tempat_wisata.*, rute_rencana.*, foto_wisata.foto
        FROM rute_rencana
        JOIN tempat_wisata USING (id_tempat)
        JOIN foto_wisata USING (id_tempat)
        WHERE id_rencana = {$id_rencana}
        GROUP BY tempat_wisata.id_tempat
        ORDER BY urutan";

$query = mysqli_query($koneksi, $sql);
$rute = array();
while ($row = mysqli_fetch_assoc($query))
{
    $rute[] = $row;
}

$sql = "SELECT user.*, partisipan.*
        FROM partisipan
        JOIN user USING (username)
        WHERE id_rencana = {$id_rencana}
        ORDER BY partisipan.created DESC";

$query = mysqli_query($koneksi, $sql);
$partisipan = array();
while ($row = mysqli_fetch_assoc($query))
{
    $partisipan[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $rencana['nama_rencana']; ?> - PackerPlan</title>

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
            <div class="col-md-12 reviews-container">
                <div class="media review">

                    <a class="pull-left" href="#">
                        <img class="media-object review-avatar"
                             src="<?php echo get_gravatar($rencana['email'], 50); ?>">
                    </a>

                    <div class="media-body review-body" style="margin-bottom: 10px">
                        <h4 class="media-heading review-author"><a
                                href="profile.php?id=<?php echo $rencana['username']; ?>"><?php echo $rencana['nama']; ?></a>
                        </h4>

                        <div class="review-metas-container">
                            <span class="review-meta review-date">
                                <i class="fa fa-calendar-o"></i> <?php echo date('d F y', strtotime($rencana['created'])); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="reviews-container">
                    <div class="plans-small-container">
                        <div class="plan-small">
                            <?php
                            $lat = explode(',', $rencana['latitude']);
                            $lng = explode(',', $rencana['longitude']);
                            $loc = array();
                            foreach ($lat as $k => $v)
                            {
                                $loc[] = array("lat" => $v, "lng" => $lng[ $k ]);
                            }
                            ?>
                            <div id="plan-map-<?php echo $rencana['id_rencana']; ?>" class="maps-static locations"
                                 data-locations='<?php echo json_encode($loc); ?>'></div>
                            <div class="plan-details-container">
                                <div class="plan-detail pull-left">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="media-heading"><?php echo $rencana['nama_rencana']; ?></h5>
                                            <span><?php echo $rencana['tempat']; ?>
                                                tempat | <?php echo (int) $rencana['pengikut']; ?>
                                                barengers</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="plan-date pull-right">
                                    <span><?php echo date('j M Y', strtotime($rencana['waktu'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-6 reviews-container">
                <h2 class="title-line"><span>Rute</span></h2>

                <?php
                foreach ($rute as $k)
                { ?>
                    <div class="media review">
                        <span class="pull-left">
                            <?php echo $k['urutan']; ?>
                        </span>
                        <a class="pull-left" href="#">
                            <img class="media-object review-avatar" src="media/<?php echo $k['foto']; ?>">
                        </a>

                        <div class="media-body review-body">
                            <h4 class=""><a
                                    href="tempat.php?id_tempat=<?php echo $k['id_tempat']; ?>"><?php echo $k['nama_tempat']; ?></a>
                            </h4>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
            <div class="col-md-6 reviews-container">
                <h2 class="title-line"><span>Barengers</span></h2>

                <?php
                foreach ($partisipan as $k)
                { ?>
                    <div class="media review">
                        <span class="pull-left">
                            <?php echo $k['urutan']; ?>
                        </span>
                        <a class="pull-left" href="#">
                            <img class="media-object review-avatar"
                                 src="<?php echo get_gravatar($k['email'], 50); ?>">
                        </a>

                        <div class="media-body review-body">
                            <h4 class=""><a
                                    href="profile.php?id=<?php echo $k['username']; ?>"><?php echo $k['nama']; ?></a>
                            </h4>
                        </div>
                    </div>
                <?php }
                ?>
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
    <script>
        $(function () {
            var jumboHeight = $('.jumbotron').outerHeight();

            function parallax() {
                var scrolled = $(window).scrollTop();
                $('.bg-parallax').css('height', (jumboHeight - scrolled) + 'px');
            }

            $(window).scroll(function (e) {
                parallax();
            });
        })
    </script>
</body>
</html>
