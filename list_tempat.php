<?php
include 'koneksi.php';

$urut = $_GET['urut'];

if ($urut == 'bintang')
{
    $sql = "SELECT tempat_wisata.*, AVG(bintang) AS rating, foto
            FROM tempat_wisata
            LEFT JOIN foto_wisata USING (id_tempat)
            LEFT JOIN review USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY rating DESC";

    $bg = 'jumbo-bintang.jpg';
    $fa = 'fa-star';
    $title = 'Tempat Paling Bintang';
}
else if ($urut == 'gosip')
{
    $sql = "SELECT tempat_wisata.*, COUNT(bintang) AS jumlah_komentar, AVG(bintang) AS rating, foto
            FROM tempat_wisata
            LEFT JOIN foto_wisata USING (id_tempat)
            LEFT JOIN review USING (id_tempat)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY jumlah_komentar DESC";

    $bg = 'jumbo-gosip.jpg';
    $fa = 'fa-comments';
    $title = 'Tempat Tergosip';
}
else if ($urut == 'heboh')
{
    $sql = "SELECT tempat_wisata.*, COUNT(id_partisipan)+1 AS jumlah_pengunjung, foto,
                (SELECT AVG(bintang)
                FROM review
                WHERE review.id_tempat = tempat_wisata.id_tempat) AS rating
            FROM tempat_wisata
            LEFT JOIN foto_wisata USING (id_tempat)
            LEFT JOIN rute_rencana USING (id_tempat)
            LEFT JOIN partisipan USING (id_rencana)
            GROUP BY tempat_wisata.id_tempat
            ORDER BY jumlah_pengunjung DESC";

    $bg = 'jumbo-heboh.jpg';
    $fa = 'fa-group';
    $title = 'Tempat Paling Heboh';
}
else
{
    $sql = "SELECT tempat_wisata.*, foto FROM tempat_wisata LEFT JOIN foto_wisata USING (id_tempat) ORDER BY created DESC";

    $bg = 'jumbo-general.jpg';
    $fa = 'fa-picture-o';
    $title = 'Tempat Wisata';
}
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

    <div class="bg-parallax" style="background-image:url('media/<?php echo $bg; ?>');"></div>
    <div class="jumbotron small">
        <h2 class="icon"><span class="fa <?php echo $fa; ?>"></span><span> <?php echo $title; ?> </span><span
                class="fa <?php echo $fa; ?>"></span></h2>

        <ul class="nav nav-tabs">
            <li role="presentation" class="<?php if(!$urut) echo 'active'; ?>">
                <a href="list_tempat.php" role="button">
                    <span class="fa fa-clock-o"></span> Terbaru
                </a>
            </li>
            <li role="presentation" class="<?php if($urut=='bintang') echo 'active'; ?>">
                <a href="list_tempat.php?urut=bintang" role="button">
                    <span class="fa fa-star"></span> Terbintang
                </a>
            </li>
            <li role="presentation" class="<?php if($urut=='gosip') echo 'active'; ?>">
                <a href="list_tempat.php?urut=gosip" role="button">
                    <span class="fa fa-comments"></span> Tergosip
                </a>
            </li>
            <li role="presentation" class="<?php if($urut=='heboh') echo 'active'; ?>">
                <a href="list_tempat.php?urut=heboh" role="button">
                    <span class="fa fa-group"></span> Terheboh
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <?php foreach ($tempat as $t)
                    { ?>
                        <div class="col-xs-4 place-small-container">
                            <a href="tempat.php?id_tempat=<?php echo $t['id_tempat']; ?>">
                                <div class="place-small">
                                    <div class="photo"
                                         style="background-image:url('media/<?php echo $t['foto']; ?>');"></div>
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
            <script src="assets/js/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="assets/js/bootstrap.min.js"></script>
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