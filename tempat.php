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
while($row = mysqli_fetch_assoc($review)) {
    $rating += $row['bintang'];
    $komentar[] = $row;
}
$rating /= $jumlah_review;
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

<div class="jumbotron lkmm">
    <div class="container">

    </div>

    <div class="jumbotron-bottom">
        <div class="container">
            <div class="place-metas-container place-metas-jumbotron pull-left">
                <h1 class="place-meta place-name"><?php echo $tempat['nama_tempat']; ?></h1>
                <div class="place-meta place-address"><i class="fa fa-map-marker"></i> <span><?php echo $tempat['alamat']; ?></span></div>
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
                    <i class="fa fa-clock-o"></i> <span>07:00 - 16:00</span>
                </div>
                <div class="col-xs-6 place-meta place-ticket-price">
                    <i class="fa fa-ticket"></i> <span>Rp 28.000,00</span>
                </div>
            </div>

            <h2 class="title-line"><span>Ulasan Cawers</span></h2>

            <div class="media review-form">
                <a class="pull-left" href="#">
                    <img class="media-object review-avatar" src="media/ava.jpg">
                </a>
                <div class="media-body review-body">
                    <form method="post" action="process/submit-review.php">
                        <div class="form-group">
                            <textarea class="form-control" rows="3" id="textArea" name="teks" placeholder="Tulis ulasan kamu di sini..."></textarea>
                            <input type="hidden" name="id_tempat" value="<?php echo $_GET['id_tempat']; ?>">
                        </div>
                        <div class="form-group">
                            <div class="pull-left">
                                Rating
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="reviews-container">
                <?php foreach($komentar as $k) { ?>
                <div class="media review">
                    <a class="pull-left" href="#">
                        <img class="media-object review-avatar" src="media/ava.jpg">
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
                <?php } ?>
            </div>
        </div>
        <div class="col-xs-4 col col-xs-offset-1">
            <div id="map-canvas"></div>
            <a class="btn btn-primary btn-block btn-lg">Buat Rencana</a>

            <h2 class="title-line"><span>Rencana Cawers</span></h2>

            <div class="plans-small-container">
                <div class="plan-small">
                    <div id="map-plan-1" class="map"></div>
                    <div class="plan-details-container">
                        <div class="plan-detail pull-left">
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object plan-avatar" src="media/ava.jpg">
                                </a>
                                <div class="media-body">
                                    <h5 class="media-heading">Muhammad Resna Rizki Pratama</h5>
                                    <span>7 tempat | 10 pengikut</span>
                                </div>
                            </div>
                        </div>
                        <div class="plan-date pull-right">
                            <span>10 Nov 2014</span>
                        </div>
                    </div>
                </div>
                <div class="plan-small">
                    <div id="map-plan-2" class="map"></div>
                    <div class="plan-details-container">
                        <div class="plan-detail pull-left">
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object plan-avatar" src="media/ava.jpg">
                                </a>
                                <div class="media-body">
                                    <h5 class="media-heading">Muhammad Resna Rizki Pratama</h5>
                                    <span>7 tempat | 10 pengikut</span>
                                </div>
                            </div>
                        </div>
                        <div class="plan-date pull-right">
                            <span>10 Nov 2014</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>