<?php
include 'koneksi.php';

$urut = $_GET['urut'];

if($urut == 'bintang') {
    $sql = "SELECT tempat_wisata.*, AVG(bintang) AS rating
            FROM tempat_wisata
            LEFT JOIN review USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY rating DESC";
} else if ($urut == 'gosip') {
    $sql = "SELECT tempat_wisata.*, COUNT(bintang) AS jumlah_komentar, AVG(bintang) AS rating
            FROM tempat_wisata
            JOIN review USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY jumlah_komentar DESC";
} else if ($urut == 'heboh') {
    $sql = "SELECT tempat_wisata.*, COUNT(id_partisipan)+1 AS jumlah_pengunjung,
                (SELECT AVG(bintang)
                FROM review
                WHERE review.id_tempat = tempat_wisata.id_tempat) AS rating
            FROM tempat_wisata
            LEFT JOIN rute_rencana USING (id_tempat)
            LEFT JOIN partisipan USING (id_rencana)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY jumlah_pengunjung DESC";
} else {
    $sql = "SELECT * FROM tempat_wisata ORDER BY created DESC";
}
$query = mysqli_query($koneksi, $sql);

$tempat = array();
while($row = mysqli_fetch_assoc($query)) {
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

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvG5hU-RANSe9b2FjFJxlYOPfzl9iLcVU&libraries=places">
    </script>
    <script type="text/javascript">
        var map;
        var infowindow;

        function initialize() {
            var bandung = new google.maps.LatLng(-7.164362, 107.357881);

            var mapOptions = {
                center: bandung,
                zoom: 18
            };

            var request = {
                location: bandung,
                radius: 1000,
                types: ['all']
            };

            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            map1 = new google.maps.Map(document.getElementById('map-plan-1'), mapOptions);
            map2 = new google.maps.Map(document.getElementById('map-plan-2'), mapOptions);
            infowindow = new google.maps.InfoWindow();

            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, callback);
        }

        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });

            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(place.name);
                infowindow.open(map, this);
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top big" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img src="assets/images/logo-navbar.png">
            </a>

        </div>
        <div class="">
            <ul class="nav navbar-nav navbar-left">
                <!--<li class="active"><a href="#">Home</a></li>-->
                <li><a href="#about"><i class="fa fa-2x fa-map-marker"></i> Wisata</a></li>
                <li><a href="#contact"><i class="fa fa-2x fa-male"></i> Cawers</a></li>
            </ul>
            <!--<ul class="nav navbar-nav navbar-right">-->
            <!--<li><a href="../navbar/">Default</a></li>-->
            <!--<li><a href="../navbar-static-top/">Static top</a></li>-->
            <!--<li class="active"><a href="./">Fixed top</a></li>-->
            <!--</ul>-->
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="blank-jumbotron"></div>

<div class="container">
    <div class="row">
        <h2 class="title-line icon"><span class="fa fa-star"></span><span>Tempat Paling Bintang</span><span class="fa fa-star"></span></h2>
        <?php foreach ($tempat as $t) { ?>
        <div class="col-xs-4 place-small-container">
            <div class="place-small">
                <div class="photo" style="background-image:url('media/banner.jpg');"></div>
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