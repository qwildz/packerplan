<?php
include 'koneksi.php';

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
        GROUP BY rute_rencana.id_rencana
        ORDER BY rencana.created DESC";

$query = mysqli_query($koneksi, $sql);

$rencana = array();
while ($row = mysqli_fetch_assoc($query))
{
    $rencana[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daftar Rencana - PackerPlan</title>

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
            <div class="col-md-12">
                <div class="plans-small-container">
                    <?php foreach($rencana as $row)
                    { ?>
                        <div class="plan-small col-md-6">
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
                                            <img class="media-object plan-avatar"
                                                 src="<?php echo get_gravatar($row['email']); ?>">
                                        </a>

                                        <div class="media-body">
                                            <h5 class="media-heading"><a
                                                    href="detail_rencana.php?id=<?php echo $row['id_rencana']; ?>"><?php echo $row['nama_rencana']; ?></a></h5>
                                            <span><?php echo $row['tempat']; ?> tempat | <?php echo (int) $row['pengikut']; ?>
                                                barengers</span>
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