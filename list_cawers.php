<?php
include 'koneksi.php';

$sql = "SELECT user.*,
          (SELECT COUNT(*) FROM rencana WHERE rencana.username = user.username) AS rencana,
          (SELECT COUNT(*) FROM partisipan WHERE partisipan.username = user.username) AS bareng
        FROM USER
        ORDER BY user.created DESC";

$query = mysqli_query($koneksi, $sql);

$cawers = array();
while ($row = mysqli_fetch_assoc($query))
{
    $cawers[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daftar Cawers - PackerPlan</title>

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
                <div class="plans-small-container reviews-container">
                    <?php foreach ($cawers as $k)
                    { ?>
                        <div class="media review col-md-6" style="margin-top: 0; margin-bottom: 10px">
                            <a class="pull-left" href="#">
                                <img class="media-object review-avatar"
                                     src="<?php echo get_gravatar($k['email']); ?>">
                            </a>

                            <div class="media-body review-body">
                                <h4 class="media-heading review-author"><a
                                        href="profile.php?id=<?php echo $k['username']; ?>"><?php echo $k['nama']; ?></a>
                                </h4>

                                <div class="review-metas-container">
                                <span class="review-meta review-date">
                                    <i class="fa fa-th-list"></i> <?php echo $k['rencana']; ?> Rencana
                                </span>
                                <span class="review-meta review-time">
                                    <i class="fa fa-group"></i> <?php echo $k['bareng']; ?>x Ngikut
                                </span>
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
</body>
</html>